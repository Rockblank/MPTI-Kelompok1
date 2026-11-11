<?php

namespace App\Http\Controllers;

use App\Models\CashPayment;
use App\Models\CashTransaction;
use App\Models\Kegiatan;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class CashPaymentController extends Controller
{
    public function memberDashboard(Request $request): View
    {
        $penalties = $this->memberLateFees($request);
        $currentPayment = CashPayment::query()
            ->where('user_id', $request->user()->id)
            ->whereDate('period', now()->startOfMonth()->toDateString())
            ->first();

        return view('anggota.dashboard', [
            'outstandingLateFees' => $penalties->where('status', '!=', 'paid')->sum('amount'),
            'activeLateFeeCount' => $penalties->where('status', '!=', 'paid')->count(),
            'currentPayment' => $currentPayment,
            'upcomingActivities' => Kegiatan::query()
                ->whereIn('status', [
                    Kegiatan::STATUS_AKAN_DATANG,
                    Kegiatan::STATUS_BERLANGSUNG,
                ])
                ->whereDate('tanggal', '>=', now('Asia/Jakarta')->toDateString())
                ->orderBy('tanggal')
                ->orderBy('jam_mulai')
                ->limit(5)
                ->get(),
        ]);
    }

    public function memberProfile(Request $request): View
    {
        $penalties = $this->memberLateFees($request);

        return view('anggota.profile', [
            'outstandingLateFees' => $penalties->where('status', '!=', 'paid')->sum('amount'),
            'activeLateFeeCount' => $penalties->where('status', '!=', 'paid')->count(),
            'currentPayment' => CashPayment::query()
                ->where('user_id', $request->user()->id)
                ->whereDate('period', now()->startOfMonth()->toDateString())
                ->first(),
            'totalCashPaid' => CashPayment::query()
                ->where('user_id', $request->user()->id)
                ->where('status', CashPayment::STATUS_APPROVED)
                ->sum('amount'),
        ]);
    }

    public function memberFines(Request $request): View
    {
        $penalties = $this->memberLateFees($request);
        $viewName = $request->user()->role === 'presbem'
            ? 'presbem.denda'
            : 'anggota.denda';

        return view($viewName, [
            'penalties' => $penalties,
            'outstandingLateFees' => $penalties->where('status', '!=', 'paid')->sum('amount'),
            'paidLateFees' => $penalties->where('status', 'paid')->sum('amount'),
            'lateFeePerMonth' => (int) config('cash.late_fee_per_month', 10000),
        ]);
    }

    public function memberIndex(Request $request): View
    {
        $payments = CashPayment::query()
            ->where('user_id', $request->user()->id)
            ->orderByDesc('period')
            ->get();

        $currentPayment = CashPayment::query()
            ->where('user_id', $request->user()->id)
            ->whereDate('period', now()->startOfMonth()->toDateString())
            ->first();
        $currentFeeDate = $currentPayment && $currentPayment->status !== CashPayment::STATUS_REJECTED
            ? $currentPayment->submissionDate()
            : now();
        $accountLateFee = CashPayment::accountLateFeeSummaryFor($request->user()->id, now());
        $currentLateFee = $currentPayment && $currentPayment->status !== CashPayment::STATUS_REJECTED
            ? $currentPayment->late_fee_amount
            : $accountLateFee['fee_amount'];
        $lateFeePerMonth = max(1, (int) config('cash.late_fee_per_month', 10000));

        return view('anggota.bayar-kas', [
            'payments' => $payments,
            'currentPayment' => $currentPayment,
            'currentPeriod' => now()->startOfMonth(),
            'currentDeadline' => CashPayment::deadlineFor(now()),
            'currentLateMonths' => $currentLateFee > 0
                ? (int) ceil($currentLateFee / $lateFeePerMonth)
                : ($accountLateFee['late_months'] ?: CashPayment::lateMonthsFor(now(), $currentFeeDate)),
            'currentLateFee' => $currentLateFee,
            'currentIsOverdue' => $currentPayment?->isOverdue()
                ?? now()->greaterThan(CashPayment::deadlineFor(now())),
        ]);
    }

    public function memberHistory(Request $request): View
    {
        $yearStart = now()->startOfYear();
        $currentPeriod = now()->startOfMonth();
        $payments = CashPayment::query()
            ->with('reviewer')
            ->where('user_id', $request->user()->id)
            ->orderByDesc('period')
            ->orderByDesc('created_at')
            ->get();

        $paymentsByPeriod = $payments->keyBy(fn (CashPayment $payment): string => $payment->period->format('Y-m'));
        $monthlyStatuses = collect(CarbonPeriod::create($yearStart, '1 month', $currentPeriod))
            ->map(function (Carbon $period) use ($paymentsByPeriod): array {
                $payment = $paymentsByPeriod->get($period->format('Y-m'));

                return [
                    'period' => $period->copy(),
                    'payment' => $payment,
                    'isPaid' => $payment?->status === CashPayment::STATUS_APPROVED,
                    'isLate' => $payment?->isLate() ?? false,
                    'isOverdue' => $payment?->isOverdue()
                        ?? now()->greaterThan(CashPayment::deadlineFor($period)),
                ];
            })
            ->reverse()
            ->values();

        return view('anggota.riwayat-pembayaran', [
            'payments' => $payments,
            'monthlyStatuses' => $monthlyStatuses,
            'year' => $yearStart->year,
            'totalPaid' => $payments
                ->where('status', CashPayment::STATUS_APPROVED)
                ->sum(fn (CashPayment $payment): int => $payment->amount + $payment->late_fee_amount),
        ]);
    }

    public function submit(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'periods' => ['required', 'array', 'min:1'],
            'periods.*' => ['required', 'date_format:Y-m', 'distinct'],
            'proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ], [
            'periods.required' => 'Pilih minimal satu periode pembayaran.',
            'periods.min' => 'Pilih minimal satu periode pembayaran.',
            'periods.*.distinct' => 'Setiap periode hanya boleh dipilih sekali.',
            'proof.required' => 'Pilih bukti transfer untuk diunggah.',
            'proof.mimes' => 'Bukti harus berupa JPG, PNG, atau PDF.',
            'proof.max' => 'Ukuran bukti maksimal 2 MB.',
        ]);

        $periods = collect($data['periods'])
            ->map(fn (string $period): Carbon => Carbon::createFromFormat('!Y-m', $period)->startOfMonth())
            ->sortBy(fn (Carbon $period): string => $period->toDateString())
            ->values();

        if ($periods->contains(fn (Carbon $period): bool => $period->greaterThan(now()->startOfMonth()))) {
            throw ValidationException::withMessages([
                'periods' => 'Periode pembayaran tidak boleh di masa depan.',
            ]);
        }

        $proofDisk = (string) config('cash.proof_disk', 'local');
        $disk = Storage::disk($proofDisk);
        $proofPath = $request->file('proof')->store('cash-payment-proofs', $proofDisk);

        if (! $proofPath) {
            throw new RuntimeException('Bukti pembayaran gagal disimpan.');
        }

        $oldProofPaths = [];
        $submittedAt = now();

        try {
            DB::transaction(function () use ($periods, $request, $proofPath, $submittedAt, &$oldProofPaths): void {
                $request->user()->newQuery()->lockForUpdate()->findOrFail($request->user()->id);

                $payments = CashPayment::query()
                    ->where('user_id', $request->user()->id)
                    ->where(function ($query) use ($periods): void {
                        foreach ($periods as $period) {
                            $query->orWhereDate('period', $period->toDateString());
                        }
                    })
                    ->orderBy('period')
                    ->lockForUpdate()
                    ->get()
                    ->keyBy(fn (CashPayment $payment): string => $payment->period->format('Y-m'));

                foreach ($periods as $period) {
                    $payment = $payments->get($period->format('Y-m'));

                    if (in_array($payment?->status, [
                        CashPayment::STATUS_APPROVED,
                        CashPayment::STATUS_PENDING,
                    ], true)) {
                        throw ValidationException::withMessages([
                            'periods' => 'Salah satu periode sudah lunas atau sedang menunggu verifikasi.',
                        ]);
                    }
                }

                $accountLateFee = CashPayment::accountLateFeeSummaryFor($request->user()->id, $submittedAt)['fee_amount'];

                foreach ($periods as $index => $period) {
                    $payment = $payments->get($period->format('Y-m'));
                    $oldProofPaths[] = $payment?->proof_path;
                    $attributes = [
                        'amount' => CashPayment::AMOUNT,
                        'late_fee_amount' => $index === 0 ? $accountLateFee : 0,
                        'proof_path' => $proofPath,
                        'submitted_at' => $submittedAt,
                        'status' => CashPayment::STATUS_PENDING,
                        'reviewed_by' => null,
                        'reviewed_at' => null,
                        'rejection_reason' => null,
                    ];

                    if ($payment) {
                        $payment->update($attributes);
                    } else {
                        CashPayment::create($attributes + [
                            'user_id' => $request->user()->id,
                            'period' => $period->toDateString(),
                        ]);
                    }
                }
            });
        } catch (Throwable $exception) {
            $disk->delete($proofPath);
            throw $exception;
        }

        foreach (array_unique(array_filter($oldProofPaths)) as $oldProofPath) {
            $stillReferenced = CashPayment::query()
                ->where('proof_path', $oldProofPath)
                ->exists();

            if (! $stillReferenced) {
                $disk->delete($oldProofPath);
            }
        }

        return redirect()->route($this->paymentPageRoute($request))
            ->with('success', 'Bukti pembayaran untuk '.$periods->count().' periode berhasil dikirim untuk diverifikasi ADKEU.');
    }

    public function reviewIndex(Request $request): View
    {
        $status = $request->query('status', CashPayment::STATUS_PENDING);
        if (! in_array($status, ['all', 'pending', 'approved', 'rejected'], true)) {
            $status = CashPayment::STATUS_PENDING;
        }

        $query = CashPayment::with('member')->orderByDesc('created_at');
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        return view('bendahara.validasi-pembayaran', [
            'payments' => $query->get(),
            'status' => $status,
            'counts' => CashPayment::query()
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status'),
        ]);
    }

    public function evidence(CashPayment $payment)
    {
        $disk = Storage::disk((string) config('cash.proof_disk', 'local'));
        abort_unless($disk->exists($payment->proof_path), 404);

        return $disk->response($payment->proof_path);
    }

    public function approve(Request $request, CashPayment $payment): RedirectResponse
    {
        DB::transaction(function () use ($request, $payment): void {
            $lockedPayment = CashPayment::query()->lockForUpdate()->findOrFail($payment->id);

            if ($lockedPayment->status !== CashPayment::STATUS_PENDING) {
                throw ValidationException::withMessages([
                    'payment' => 'Pembayaran ini sudah diproses.',
                ]);
            }

            $this->recordApproval($lockedPayment, $request->user()->id, now());
        });

        return redirect()->route('bendahara.validasi-pembayaran')
            ->with('success', 'Pembayaran berhasil disetujui dan dicatat sebagai kas masuk.');
    }

    public function approveMultiple(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'payments' => ['required', 'array', 'min:1'],
            'payments.*' => ['required', 'integer', 'distinct', 'exists:cash_payments,id'],
        ], [
            'payments.required' => 'Pilih minimal satu pembayaran untuk disetujui.',
            'payments.min' => 'Pilih minimal satu pembayaran untuk disetujui.',
            'payments.*.distinct' => 'Pembayaran yang sama tidak boleh dipilih lebih dari sekali.',
        ]);

        $approvedCount = count($data['payments']);

        DB::transaction(function () use ($data, $request): void {
            $payments = CashPayment::query()
                ->whereIn('id', $data['payments'])
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            if ($payments->count() !== count($data['payments']) ||
                $payments->contains(fn (CashPayment $payment): bool => $payment->status !== CashPayment::STATUS_PENDING)) {
                throw ValidationException::withMessages([
                    'payments' => 'Semua pembayaran yang dipilih harus masih menunggu validasi.',
                ]);
            }

            $reviewedAt = now();
            foreach ($payments as $payment) {
                $this->recordApproval($payment, $request->user()->id, $reviewedAt);
            }
        });

        return redirect()->route('bendahara.validasi-pembayaran')
            ->with('success', $approvedCount.' pembayaran berhasil disetujui dan dicatat sebagai kas masuk.');
    }

    private function recordApproval(CashPayment $payment, int $reviewerId, Carbon $reviewedAt): void
    {
        CashTransaction::create([
            'user_id' => $payment->user_id,
            'created_by' => $reviewerId,
            'type' => 'masuk',
            'transaction_date' => $reviewedAt->toDateString(),
            'description' => 'Kas Bulanan - '.$payment->period->locale('id')->translatedFormat('F Y'),
            'amount' => $payment->amount + $payment->late_fee_amount,
            'notes' => $payment->late_fee_amount > 0
                ? 'Kas bulanan Rp'.number_format($payment->amount, 0, ',', '.')
                    .' dan denda keterlambatan Rp'.number_format($payment->late_fee_amount, 0, ',', '.').'.'
                : 'Pembayaran disetujui dari bukti transfer.',
        ]);

        $payment->update([
            'status' => CashPayment::STATUS_APPROVED,
            'reviewed_by' => $reviewerId,
            'reviewed_at' => $reviewedAt,
            'rejection_reason' => null,
        ]);
    }

    public function reject(Request $request, CashPayment $payment): RedirectResponse
    {
        $data = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $updated = CashPayment::query()
            ->whereKey($payment->id)
            ->where('status', CashPayment::STATUS_PENDING)
            ->update([
                'status' => CashPayment::STATUS_REJECTED,
                'reviewed_by' => $request->user()->id,
                'reviewed_at' => now(),
                'rejection_reason' => $data['rejection_reason'],
                'updated_at' => now(),
            ]);

        if ($updated === 0) {
            throw ValidationException::withMessages([
                'payment' => 'Pembayaran ini sudah diproses.',
            ]);
        }

        return redirect()->route('bendahara.validasi-pembayaran')
            ->with('success', 'Pembayaran ditolak. Anggota dapat mengirim bukti pengganti.');
    }

    private function paymentPageRoute(Request $request): string
    {
        return $request->user()->role === 'presbem'
            ? 'presbem.bayar-kas'
            : 'anggota.bayar-kas';
    }

    private function memberLateFees(Request $request): Collection
    {
        $currentPeriod = now()->startOfMonth();
        $payments = CashPayment::query()
            ->where('user_id', $request->user()->id)
            ->whereBetween('period', [now()->startOfYear()->toDateString(), $currentPeriod->copy()->endOfMonth()->toDateString()])
            ->get()
            ->keyBy(fn (CashPayment $payment): string => $payment->period->format('Y-m'));

        $penalties = $payments
            ->filter(fn (CashPayment $payment): bool => $payment->late_fee_amount > 0
                && in_array($payment->status, [CashPayment::STATUS_APPROVED, CashPayment::STATUS_PENDING], true))
            ->map(function (CashPayment $payment): array {
                $feePerMonth = max(1, (int) config('cash.late_fee_per_month', 10000));

                return [
                    'period' => $payment->period->copy(),
                    'amount' => $payment->late_fee_amount,
                    'late_days' => 0,
                    'late_months' => (int) ceil($payment->late_fee_amount / $feePerMonth),
                    'status' => $payment->status === CashPayment::STATUS_APPROVED ? 'paid' : 'pending',
                ];
            })
            ->values();

        $accountLateFee = CashPayment::accountLateFeeSummaryFor($request->user()->id, now());

        if ($accountLateFee['fee_amount'] > 0 && $accountLateFee['period']) {
            $penalties->push([
                'period' => $accountLateFee['period'],
                'amount' => $accountLateFee['fee_amount'],
                'late_days' => $accountLateFee['late_days'],
                'late_months' => $accountLateFee['late_months'],
                'status' => 'unpaid',
            ]);
        }

        return $penalties;
    }
}
