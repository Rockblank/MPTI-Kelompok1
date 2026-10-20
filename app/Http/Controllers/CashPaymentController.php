<?php

namespace App\Http\Controllers;

use App\Models\CashPayment;
use App\Models\CashTransaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class CashPaymentController extends Controller
{
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

        return view('anggota.bayar-kas', [
            'payments' => $payments,
            'currentPayment' => $currentPayment,
            'currentPeriod' => now()->startOfMonth(),
            'currentDeadline' => CashPayment::deadlineFor(now()),
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
                ->sum('amount'),
        ]);
    }

    public function submit(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'period' => ['required', 'date_format:Y-m'],
            'proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ], [
            'proof.required' => 'Pilih bukti transfer untuk diunggah.',
            'proof.mimes' => 'Bukti harus berupa JPG, PNG, atau PDF.',
            'proof.max' => 'Ukuran bukti maksimal 2 MB.',
        ]);

        $period = Carbon::createFromFormat('!Y-m', $data['period'])->startOfMonth();
        if ($period->greaterThan(now()->startOfMonth())) {
            throw ValidationException::withMessages([
                'period' => 'Periode pembayaran tidak boleh di masa depan.',
            ]);
        }

        $payment = CashPayment::query()
            ->where('user_id', $request->user()->id)
            ->whereDate('period', $period->toDateString())
            ->first();

        if ($payment?->status === CashPayment::STATUS_APPROVED) {
            throw ValidationException::withMessages([
                'period' => 'Pembayaran periode ini sudah disetujui.',
            ]);
        }

        if ($payment?->status === CashPayment::STATUS_PENDING) {
            throw ValidationException::withMessages([
                'period' => 'Bukti periode ini sedang menunggu verifikasi.',
            ]);
        }

        $disk = Storage::disk('local');
        $proofPath = $request->file('proof')->store('cash-payment-proofs', 'local');

        if (! $proofPath) {
            throw new RuntimeException('Bukti pembayaran gagal disimpan.');
        }

        $oldProofPath = $payment?->proof_path;

        try {
            DB::transaction(function () use ($payment, $request, $period, $proofPath): void {
                if ($payment) {
                    $payment->update([
                        'amount' => CashPayment::AMOUNT,
                        'proof_path' => $proofPath,
                        'submitted_at' => now(),
                        'status' => CashPayment::STATUS_PENDING,
                        'reviewed_by' => null,
                        'reviewed_at' => null,
                        'rejection_reason' => null,
                    ]);

                    return;
                }

                CashPayment::create([
                    'user_id' => $request->user()->id,
                    'period' => $period->toDateString(),
                    'amount' => CashPayment::AMOUNT,
                    'proof_path' => $proofPath,
                    'submitted_at' => now(),
                    'status' => CashPayment::STATUS_PENDING,
                ]);
            });
        } catch (Throwable $exception) {
            $disk->delete($proofPath);
            throw $exception;
        }

        if ($oldProofPath) {
            $disk->delete($oldProofPath);
        }

        return redirect()->route($this->paymentPageRoute($request))
            ->with('success', 'Bukti pembayaran berhasil dikirim untuk diverifikasi ADKEU.');
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
        $disk = Storage::disk('local');
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

            CashTransaction::create([
                'user_id' => $lockedPayment->user_id,
                'created_by' => $request->user()->id,
                'type' => 'masuk',
                'transaction_date' => now()->toDateString(),
                'description' => 'Kas Bulanan - '.$lockedPayment->period->locale('id')->translatedFormat('F Y'),
                'amount' => $lockedPayment->amount,
                'notes' => 'Pembayaran disetujui dari bukti transfer.',
            ]);

            $lockedPayment->update([
                'status' => CashPayment::STATUS_APPROVED,
                'reviewed_by' => $request->user()->id,
                'reviewed_at' => now(),
                'rejection_reason' => null,
            ]);
        });

        return redirect()->route('bendahara.validasi-pembayaran')
            ->with('success', 'Pembayaran berhasil disetujui dan dicatat sebagai kas masuk.');
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
}
