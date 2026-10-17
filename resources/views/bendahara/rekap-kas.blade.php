@extends('layouts.bendahara')

@section('title', 'Rekap Kas')
@section('page-title', 'Rekap Kas')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Rekap Kas</h2>
        <p class="text-sm text-gray-500 mt-1">Ringkasan keuangan per bulan dan per anggota</p>
    </div>
    <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 text-xs font-bold rounded-xl shadow-sm transition">
        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
        </svg>
        Export PDF
    </button>
</div>

{{-- 3 Top Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Total Pemasukan</div>
        <div class="text-3xl font-black text-emerald-600 tracking-tight">Rp36.500.000</div>
        <div class="text-xs text-gray-400 mt-1">Mar – Sep 2025</div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Total Pengeluaran</div>
        <div class="text-3xl font-black text-red-600 tracking-tight">Rp15.100.000</div>
        <div class="text-xs text-gray-400 mt-1">Mar – Sep 2025</div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Saldo Akhir</div>
        <div class="text-3xl font-black text-[#1A6B6B] tracking-tight">Rp21.400.000</div>
        <div class="text-xs text-gray-400 mt-1">Per 24 Sep 2025</div>
    </div>
</div>

{{-- Grafik Kas Bulanan --}}
<div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm mb-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-base font-bold text-gray-900">Grafik Kas Bulanan</h3>
        <div class="flex items-center gap-4 text-xs font-medium text-gray-600">
            <div class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-[#1A6B6B]"></span>
                <span>Masuk</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-[#E5A00D]"></span>
                <span>Keluar</span>
            </div>
        </div>
    </div>
    <div class="h-64 relative">
        <canvas id="chartKasBulanan"></canvas>
    </div>
</div>

{{-- Status Pembayaran Kas per Anggota --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-base font-bold text-gray-900">Status Pembayaran Kas per Anggota</h3>
        <p class="text-xs text-gray-400 mt-0.5">Periode Mar – Sep 2025 · Rp50.000/bulan</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-center text-xs">
            <thead class="bg-gray-50/70 text-gray-400 font-semibold uppercase tracking-wider border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3.5 text-left">Anggota</th>
                    <th class="px-4 py-3.5">Mar</th>
                    <th class="px-4 py-3.5">Apr</th>
                    <th class="px-4 py-3.5">Mei</th>
                    <th class="px-4 py-3.5">Jun</th>
                    <th class="px-4 py-3.5">Jul</th>
                    <th class="px-4 py-3.5">Agu</th>
                    <th class="px-4 py-3.5">Sep</th>
                    <th class="px-6 py-3.5 text-center">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100/70 text-gray-700">
                {{-- Row 1 --}}
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4 text-left">
                        <div class="font-bold text-gray-900 text-sm">Budi Santoso</div>
                        <div class="text-[11px] text-gray-400">215150700111001</div>
                    </td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-full border border-emerald-200">
                            7/7
                        </span>
                    </td>
                </tr>

                {{-- Row 2 --}}
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4 text-left">
                        <div class="font-bold text-gray-900 text-sm">Dewi Lestari</div>
                        <div class="text-[11px] text-gray-400">215150700111002</div>
                    </td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-gray-300 font-bold">—</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-amber-50 text-amber-700 font-bold text-xs rounded-full border border-amber-200">
                            6/7
                        </span>
                    </td>
                </tr>

                {{-- Row 3 --}}
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4 text-left">
                        <div class="font-bold text-gray-900 text-sm">Rizky Aditya</div>
                        <div class="text-[11px] text-gray-400">215150700111003</div>
                    </td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-gray-300 font-bold">—</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-amber-50 text-amber-700 font-bold text-xs rounded-full border border-amber-200">
                            6/7
                        </span>
                    </td>
                </tr>

                {{-- Row 4 --}}
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4 text-left">
                        <div class="font-bold text-gray-900 text-sm">Ahmad Reza</div>
                        <div class="text-[11px] text-gray-400">215150700111005</div>
                    </td>
                    <td class="px-4 py-4 text-gray-300 font-bold">—</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-gray-300 font-bold">—</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-gray-300 font-bold">—</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-red-50 text-red-600 font-bold text-xs rounded-full border border-red-200">
                            4/7
                        </span>
                    </td>
                </tr>

                {{-- Row 5 --}}
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4 text-left">
                        <div class="font-bold text-gray-900 text-sm">Siti Rahayu</div>
                        <div class="text-[11px] text-gray-400">215150700111004</div>
                    </td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-full border border-emerald-200">
                            7/7
                        </span>
                    </td>
                </tr>

                {{-- Row 6 --}}
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4 text-left">
                        <div class="font-bold text-gray-900 text-sm">Maya Putri</div>
                        <div class="text-[11px] text-gray-400">215150700111006</div>
                    </td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-gray-300 font-bold">—</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-4 py-4 text-gray-300 font-bold">—</td>
                    <td class="px-4 py-4 text-emerald-600 font-black text-sm">✓</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-amber-50 text-amber-700 font-bold text-xs rounded-full border border-amber-200">
                            5/7
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('chartKasBulanan').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep'],
            datasets: [
                {
                    label: 'Masuk',
                    data: [4.8, 5.2, 4.3, 6.2, 5.0, 5.8, 6.4],
                    backgroundColor: '#1A6B6B',
                    borderRadius: 4,
                    barPercentage: 0.65,
                    categoryPercentage: 0.65
                },
                {
                    label: 'Keluar',
                    data: [1.2, 2.0, 1.8, 2.4, 1.6, 2.9, 3.1],
                    backgroundColor: '#E5A00D',
                    borderRadius: 4,
                    barPercentage: 0.65,
                    categoryPercentage: 0.65
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(c) {
                            return c.dataset.label + ': Rp' + c.raw + ' Juta';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#9CA3AF', font: { size: 11 } }
                },
                y: {
                    min: 0,
                    max: 8,
                    ticks: {
                        stepSize: 2,
                        callback: function(v) { return 'Rp' + v.toFixed(1) + 'jt'; },
                        color: '#9CA3AF',
                        font: { size: 10 }
                    },
                    grid: { color: 'rgba(243, 244, 246, 0.8)' }
                }
            }
        }
    });
</script>
@endpush
