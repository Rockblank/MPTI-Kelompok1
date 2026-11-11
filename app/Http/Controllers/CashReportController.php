<?php

namespace App\Http\Controllers;

use App\Models\CashPayment;
use App\Models\CashTransaction;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CashReportController extends Controller
{
    public function dashboard(Request $request): View
    {
        $transactions = CashTransaction::query()
            ->with('member:id,name,nim')
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->limit(5)
            ->get();
        $pemasukan = (int) CashTransaction::query()->where('type', 'masuk')->sum('amount');
        $pengeluaran = (int) CashTransaction::query()->where('type', 'keluar')->sum('amount');

        return view($request->user()->role === 'presbem' ? 'presbem.dashboard' : 'bendahara.dashboard', [
            'saldo' => $pemasukan - $pengeluaran,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'anggotaCount' => User::query()
                ->whereIn('role', ['anggota', 'bendahara', 'adkeu', 'psdi', 'presbem'])
                ->count(),
            'pendingPaymentsCount' => CashPayment::query()
                ->where('status', CashPayment::STATUS_PENDING)
                ->count(),
            'transaksiTerbaru' => $transactions,
            'kegiatanAktif' => Kegiatan::query()
                ->whereIn('status', [Kegiatan::STATUS_AKAN_DATANG, Kegiatan::STATUS_BERLANGSUNG])
                ->whereDate('tanggal', '>=', now('Asia/Jakarta')->toDateString())
                ->orderBy('tanggal')
                ->limit(5)
                ->get(),
        ]);
    }

    public function index(Request $request): View
    {
        return view('presbem.rekap-kas', $this->reportData() + [
            'layout' => $request->routeIs('presbem.*') ? 'layouts.presbem' : 'layouts.bendahara',
            'exportRoute' => $request->routeIs('presbem.*')
                ? 'presbem.rekap-kas.export'
                : 'bendahara.rekap-kas.export',
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $report = $this->reportData();

        $filename = 'rekap-kas-bem-'.now()->timezone('Asia/Jakarta')->format('Ymd-His').'.csv';

        return Response::streamDownload(function () use ($report): void {
            $output = fopen('php://output', 'w');
            if ($output === false) {
                throw new \RuntimeException('Gagal membuka aliran berkas rekap kas.');
            }

            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['Ringkasan Kas']);
            fputcsv($output, ['Total Pemasukan', (string) $report['pemasukan']]);
            fputcsv($output, ['Total Pengeluaran', (string) $report['pengeluaran']]);
            fputcsv($output, ['Saldo Akhir', (string) $report['saldo']]);
            fputcsv($output, []);
            fputcsv($output, ['Arus Kas Bulanan']);
            fputcsv($output, ['Periode', 'Pemasukan', 'Pengeluaran']);
            foreach ($report['bulan'] as $month) {
                fputcsv($output, array_map($this->csvSafeValue(...), [
                    $month['label'],
                    (string) $month['masuk'],
                    (string) $month['keluar'],
                ]));
            }

            fputcsv($output, []);
            fputcsv($output, ['Rincian Transaksi']);
            fputcsv($output, ['Tanggal', 'Jenis', 'Keterangan', 'Anggota', 'NIM', 'Nominal', 'Saldo Berjalan']);

            $balance = 0;
            foreach ($report['transaksi'] as $transaction) {
                $balance += $transaction->type === 'masuk'
                    ? $transaction->amount
                    : -$transaction->amount;

                fputcsv($output, array_map($this->csvSafeValue(...), [
                    $transaction->transaction_date->format('Y-m-d'),
                    $transaction->type === 'masuk' ? 'Pemasukan' : 'Pengeluaran',
                    $transaction->description,
                    $transaction->member?->name ?? '',
                    $transaction->member?->nim ?? '',
                    (string) $transaction->amount,
                    (string) $balance,
                ]));
            }

            fputcsv($output, []);
            fputcsv($output, ['Status Pembayaran Kas']);
            fputcsv($output, array_merge(
                ['Nama', 'NIM'],
                array_column($report['periode'], 'label'),
                ['Total Lunas']
            ));

            foreach ($report['anggota'] as $member) {
                $paidCount = 0;
                $statuses = [];
                foreach ($report['periode'] as $period) {
                    $paid = $report['pembayaran']->has($member->id.'|'.$period['key']);
                    $statuses[] = $paid ? 'Lunas' : 'Belum lunas';
                    $paidCount += $paid ? 1 : 0;
                }

                fputcsv($output, array_map($this->csvSafeValue(...), array_merge(
                    [$member->name, $member->nim ?? ''],
                    $statuses,
                    [$paidCount.'/'.count($report['periode'])]
                )));
            }

            fclose($output);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * @return array{
     *     pemasukan: int,
     *     pengeluaran: int,
     *     saldo: int,
     *     transaksi: Collection<int, CashTransaction>,
     *     bulan: array<int, array{label: string, masuk: int, keluar: int}>,
     *     anggota: Collection<int, User>,
     *     periode: array<int, array{key: string, label: string}>,
     *     pembayaran: Collection<int, CashPayment>
     * }
     */
    private function reportData(): array
    {
        $transactions = CashTransaction::query()
            ->with('member:id,name,nim')
            ->orderBy('transaction_date')
            ->orderBy('id')
            ->get(['id', 'user_id', 'type', 'transaction_date', 'description', 'amount']);
        $pemasukan = (int) $transactions->where('type', 'masuk')->sum('amount');
        $pengeluaran = (int) $transactions->where('type', 'keluar')->sum('amount');

        $periode = collect(range(6, 0))
            ->map(fn (int $offset): array => [
                'key' => now()->startOfMonth()->subMonths($offset)->format('Y-m'),
                'label' => now()->startOfMonth()->subMonths($offset)->locale('id')->isoFormat('MMM Y'),
            ])
            ->values()
            ->all();

        $byMonth = $transactions->groupBy(
            fn (CashTransaction $transaction): string => $transaction->transaction_date->format('Y-m')
        );
        $bulan = array_map(fn (array $period): array => [
            'label' => $period['label'],
            'masuk' => (int) $byMonth->get($period['key'], collect())->where('type', 'masuk')->sum('amount'),
            'keluar' => (int) $byMonth->get($period['key'], collect())->where('type', 'keluar')->sum('amount'),
        ], $periode);

        $firstPeriod = $periode[0]['key'].'-01';
        $lastPeriod = $periode[count($periode) - 1]['key'].'-'.now()->endOfMonth()->format('d');
        $anggota = User::query()
            ->whereIn('role', ['anggota', 'presbem'])
            ->orderBy('name')
            ->get(['id', 'name', 'nim']);
        $pembayaran = CashPayment::query()
            ->where('status', CashPayment::STATUS_APPROVED)
            ->whereBetween('period', [$firstPeriod, $lastPeriod])
            ->get(['user_id', 'period'])
            ->groupBy(fn (CashPayment $payment): string => $payment->user_id.'|'.$payment->period->format('Y-m'));

        return [
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'saldo' => $pemasukan - $pengeluaran,
            'transaksi' => $transactions,
            'bulan' => $bulan,
            'anggota' => $anggota,
            'periode' => $periode,
            'pembayaran' => $pembayaran,
        ];
    }

    private function csvSafeValue(string $value): string
    {
        return preg_match('/^[=+\-@\t\r]/', $value) === 1 ? "'".$value : $value;
    }
}
