@extends($layout)

@section('title', 'Rekap Kas')
@section('page-title', 'Rekap Kas')

@section('content')
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between print:hidden">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Rekap Kas Organisasi</h2>
        <p class="mt-1 text-sm text-gray-500">Ringkasan transaksi dan pembayaran kas anggota berdasarkan data tercatat.</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route($exportRoute) }}" class="inline-flex items-center gap-2 rounded-xl bg-[#1A6B6B] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#155757]">
            Unduh CSV
        </a>
        <button type="button" onclick="window.print()" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50">
            Cetak / Simpan PDF
        </button>
    </div>
</div>

<section aria-label="Ringkasan kas" class="mb-6 grid gap-5 md:grid-cols-3">
    @foreach ([
        ['label' => 'Total Pemasukan', 'amount' => $pemasukan, 'color' => 'text-emerald-600'],
        ['label' => 'Total Pengeluaran', 'amount' => $pengeluaran, 'color' => 'text-red-600'],
        ['label' => 'Saldo Akhir', 'amount' => $saldo, 'color' => 'text-[#1A6B6B]'],
    ] as $stat)
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500">{{ $stat['label'] }}</div>
            <div class="text-2xl font-black tracking-tight {{ $stat['color'] }}">Rp{{ number_format($stat['amount'], 0, ',', '.') }}</div>
            <div class="mt-1 text-xs text-gray-400">Akumulasi seluruh transaksi tercatat</div>
        </div>
    @endforeach
</section>

<section class="mb-6 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
    <div class="mb-5">
        <h3 class="text-base font-bold text-gray-900">Arus Kas Bulanan</h3>
        <p class="mt-1 text-xs text-gray-500">Pemasukan dan pengeluaran selama tujuh bulan terakhir.</p>
    </div>
    <div class="relative h-64">
        <canvas id="chartKasBulananPres" aria-label="Grafik pemasukan dan pengeluaran bulanan"></canvas>
    </div>
</section>

<section class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
    <div class="border-b border-gray-100 p-6">
        <h3 class="text-base font-bold text-gray-900">Status Pembayaran Kas per Anggota</h3>
        <p class="mt-1 text-xs text-gray-500">Pembayaran berstatus disetujui dalam tujuh bulan terakhir.</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full min-w-[760px] text-center text-xs">
            <thead class="border-b border-gray-100 bg-gray-50/70 font-semibold uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="px-6 py-3.5 text-left">Anggota</th>
                    @foreach ($periode as $period)
                        <th class="px-4 py-3.5">{{ $period['label'] }}</th>
                    @endforeach
                    <th class="px-6 py-3.5">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100/70 text-gray-700">
                @forelse($anggota as $member)
                    @php
                        $paidCount = collect($periode)->filter(
                            fn ($period) => $pembayaran->has($member->id.'|'.$period['key'])
                        )->count();
                    @endphp
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-6 py-4 text-left">
                            <div class="font-bold text-sm text-gray-900">{{ $member->name }}</div>
                            <div class="text-[11px] text-gray-400">{{ $member->nim ?? 'NIM belum diisi' }}</div>
                        </td>
                        @foreach ($periode as $period)
                            @if ($pembayaran->has($member->id.'|'.$period['key']))
                                <td class="px-4 py-4 font-black text-emerald-600" aria-label="Lunas">Lunas</td>
                            @else
                                <td class="px-4 py-4 font-bold text-gray-300" aria-label="Belum lunas">—</td>
                            @endif
                        @endforeach
                        <td class="px-6 py-4">
                            <span class="rounded-full border px-3 py-1 font-bold {{ $paidCount === count($periode) ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-amber-200 bg-amber-50 text-amber-700' }}">
                                {{ $paidCount }}/{{ count($periode) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="{{ count($periode) + 2 }}" class="px-6 py-8 text-center text-gray-500">Belum ada data anggota.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const cashChart = document.getElementById('chartKasBulananPres');
    new Chart(cashChart, {
        type: 'bar',
        data: {
            labels: @json(array_column($bulan, 'label')),
            datasets: [
                {
                    label: 'Pemasukan',
                    data: @json(array_map(fn ($month) => $month['masuk'] / 1000000, $bulan)),
                    backgroundColor: '#1A6B6B',
                    borderRadius: 4
                },
                {
                    label: 'Pengeluaran',
                    data: @json(array_map(fn ($month) => $month['keluar'] / 1000000, $bulan)),
                    backgroundColor: '#E5A00D',
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: value => `Rp${value} jt` }
                }
            }
        }
    });
</script>
<style>
    @media print {
        body { background: white !important; }
        main { margin: 0 !important; padding: 0 !important; }
        #sidebar, header { display: none !important; }
        #mainContent { margin-left: 0 !important; width: 100% !important; }
        .shadow-sm { box-shadow: none !important; }
    }
</style>
@endpush
