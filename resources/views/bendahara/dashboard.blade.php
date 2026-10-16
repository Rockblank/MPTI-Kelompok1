@extends('layouts.bendahara')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard ADKEU</h2>
    <p class="text-sm text-gray-500 mt-1">Ringkasan keuangan dan presensi BEM FILKOM UB</p>
</div>

{{-- 4 Metric Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
    {{-- Card 1: Total Saldo Kas --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100/80 shadow-sm relative">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-xl">
                💰
            </div>
            <span class="w-6 h-6 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs font-bold">
                ↑
            </span>
        </div>
        <div class="text-2xl font-extrabold text-gray-900 tracking-tight">Rp28.450.000</div>
        <div class="text-sm font-medium text-gray-600 mt-1">Total Saldo Kas</div>
        <div class="text-xs text-gray-400 mt-0.5">+Rp6.300.000 bulan ini</div>
    </div>

    {{-- Card 2: Anggota Lunas Kas --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100/80 shadow-sm relative">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="w-6 h-6 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs font-bold">
                ↑
            </span>
        </div>
        <div class="text-2xl font-extrabold text-gray-900 tracking-tight">24 / 32</div>
        <div class="text-sm font-medium text-gray-600 mt-1">Anggota Lunas Kas</div>
        <div class="text-xs text-gray-400 mt-0.5">75% tingkat kepatuhan</div>
    </div>

    {{-- Card 3: Denda Belum Bayar --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100/80 shadow-sm relative">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 font-bold text-lg">
                ⚠️
            </div>
            <span class="w-6 h-6 rounded-full bg-red-50 text-red-500 flex items-center justify-center text-xs font-bold">
                ↓
            </span>
        </div>
        <div class="text-2xl font-extrabold text-gray-900 tracking-tight">Rp250.000</div>
        <div class="text-sm font-medium text-gray-600 mt-1">Denda Belum Bayar</div>
        <div class="text-xs text-gray-400 mt-0.5">7 anggota menunggak</div>
    </div>

    {{-- Card 4: Kehadiran Piket --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100/80 shadow-sm relative">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <span class="w-6 h-6 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs font-bold">
                ↑
            </span>
        </div>
        <div class="text-2xl font-extrabold text-gray-900 tracking-tight">91%</div>
        <div class="text-sm font-medium text-gray-600 mt-1">Kehadiran Piket</div>
        <div class="text-xs text-gray-400 mt-0.5">Minggu ini 30/32 hadir</div>
    </div>
</div>

{{-- Middle Row: Tren Kas (Line Chart) + Status Denda (Donut Chart) --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    {{-- Left Chart (Span 2): Tren Kas Masuk & Keluar --}}
    <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-gray-100/80 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-base font-bold text-gray-900">Tren Kas Masuk & Keluar</h3>
                <p class="text-xs text-gray-400 mt-0.5">Mar – Sep 2025</p>
            </div>
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
            <canvas id="chartTrenKas"></canvas>
        </div>
    </div>

    {{-- Right Chart: Status Denda --}}
    <div class="bg-white rounded-2xl p-6 border border-gray-100/80 shadow-sm flex flex-col justify-between">
        <div>
            <h3 class="text-base font-bold text-gray-900">Status Denda</h3>
            <p class="text-xs text-gray-400 mt-0.5">28 anggota total</p>
        </div>
        <div class="my-auto py-4 relative flex items-center justify-center h-48">
            <canvas id="chartStatusDenda"></canvas>
        </div>
        <div class="space-y-2 border-t border-gray-100 pt-4 text-xs">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-gray-600">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#1A6B6B]"></span>
                    <span>Lunas</span>
                </div>
                <span class="font-bold text-gray-800">18 orang</span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-gray-600">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#E5A00D]"></span>
                    <span>Belum Bayar</span>
                </div>
                <span class="font-bold text-gray-800">7 orang</span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-gray-600">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#DC2626]"></span>
                    <span>Menunggak</span>
                </div>
                <span class="font-bold text-gray-800">3 orang</span>
            </div>
        </div>
    </div>
</div>

{{-- Bottom Row: Kehadiran Piket (Bar Chart) + Transaksi Terbaru --}}
<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
    {{-- Left Chart (Span 2): Kehadiran Piket --}}
    <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-gray-100/80 shadow-sm flex flex-col justify-between">
        <div>
            <h3 class="text-base font-bold text-gray-900">Kehadiran Piket</h3>
            <p class="text-xs text-gray-400 mt-0.5">September 2025</p>
        </div>
        <div class="h-64 mt-4 relative">
            <canvas id="chartKehadiranPiket"></canvas>
        </div>
    </div>

    {{-- Right List (Span 3): Transaksi Terbaru --}}
    <div class="lg:col-span-3 bg-white rounded-2xl p-6 border border-gray-100/80 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-gray-900">Transaksi Terbaru</h3>
            <a href="{{ route('bendahara.kas') }}" class="text-xs font-semibold text-[#1A6B6B] hover:underline">
                Lihat semua
            </a>
        </div>
        <div class="divide-y divide-gray-100">
            {{-- Item 1 --}}
            <div class="py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-teal-50 text-[#1A6B6B] font-bold text-xs flex items-center justify-center">
                        BS
                    </div>
                    <div>
                        <div class="text-sm font-bold text-gray-800">Budi Santoso</div>
                        <div class="text-xs text-gray-400">Kas Masuk · 24/09/2025</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm font-bold text-gray-900">Rp50.000</div>
                    <span class="inline-block mt-0.5 text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                        Lunas
                    </span>
                </div>
            </div>

            {{-- Item 2 --}}
            <div class="py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-teal-50 text-[#1A6B6B] font-bold text-xs flex items-center justify-center">
                        RA
                    </div>
                    <div>
                        <div class="text-sm font-bold text-gray-800">Rizky Aditya</div>
                        <div class="text-xs text-gray-400">Denda Piket · 23/09/2025</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm font-bold text-gray-900">Rp25.000</div>
                    <span class="inline-block mt-0.5 text-[11px] font-semibold text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-200">
                        Pending
                    </span>
                </div>
            </div>

            {{-- Item 3 --}}
            <div class="py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-teal-50 text-[#1A6B6B] font-bold text-xs flex items-center justify-center">
                        SR
                    </div>
                    <div>
                        <div class="text-sm font-bold text-gray-800">Siti Rahayu</div>
                        <div class="text-xs text-gray-400">Kas Masuk · 23/09/2025</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm font-bold text-gray-900">Rp50.000</div>
                    <span class="inline-block mt-0.5 text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                        Lunas
                    </span>
                </div>
            </div>

            {{-- Item 4 --}}
            <div class="py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-teal-50 text-[#1A6B6B] font-bold text-xs flex items-center justify-center">
                        AR
                    </div>
                    <div>
                        <div class="text-sm font-bold text-gray-800">Ahmad Reza</div>
                        <div class="text-xs text-gray-400">Kas Masuk · 22/09/2025</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm font-bold text-gray-900">Rp50.000</div>
                    <span class="inline-block mt-0.5 text-[11px] font-semibold text-red-600 bg-red-50 px-2.5 py-0.5 rounded-full border border-red-200">
                        Belum Bayar
                    </span>
                </div>
            </div>

            {{-- Item 5 --}}
            <div class="py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-teal-50 text-[#1A6B6B] font-bold text-xs flex items-center justify-center">
                        DL
                    </div>
                    <div>
                        <div class="text-sm font-bold text-gray-800">Dewi Lestari</div>
                        <div class="text-xs text-gray-400">Denda Piket · 22/09/2025</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm font-bold text-gray-900">Rp25.000</div>
                    <span class="inline-block mt-0.5 text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                        Lunas
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // 1. Line Chart: Tren Kas Masuk & Keluar
    const ctxTren = document.getElementById('chartTrenKas').getContext('2d');
    new Chart(ctxTren, {
        type: 'line',
        data: {
            labels: ['Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep'],
            datasets: [
                {
                    label: 'Masuk',
                    data: [4.7, 5.2, 4.3, 6.2, 5.0, 5.8, 6.4],
                    borderColor: '#1A6B6B',
                    backgroundColor: 'rgba(26, 107, 107, 0.08)',
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 5
                },
                {
                    label: 'Keluar',
                    data: [1.3, 1.8, 1.4, 2.1, 1.2, 2.6, 2.8],
                    borderColor: '#E5A00D',
                    backgroundColor: 'rgba(229, 160, 13, 0.08)',
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 5
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
                        label: function(context) {
                            return context.dataset.label + ': Rp' + context.raw + ' Juta';
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
                        callback: function(val) { return 'Rp' + val.toFixed(1) + 'jt'; },
                        color: '#9CA3AF',
                        font: { size: 10 }
                    },
                    grid: { color: 'rgba(243, 244, 246, 0.8)' }
                }
            }
        }
    });

    // 2. Donut Chart: Status Denda
    const ctxDenda = document.getElementById('chartStatusDenda').getContext('2d');
    new Chart(ctxDenda, {
        type: 'doughnut',
        data: {
            labels: ['Lunas', 'Belum Bayar', 'Menunggak'],
            datasets: [{
                data: [18, 7, 3],
                backgroundColor: ['#1A6B6B', '#E5A00D', '#DC2626'],
                borderWidth: 0,
                cutout: '72%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });

    // 3. Bar Chart: Kehadiran Piket
    const ctxKehadiran = document.getElementById('chartKehadiranPiket').getContext('2d');
    new Chart(ctxKehadiran, {
        type: 'bar',
        data: {
            labels: ['M1', 'M2', 'M3', 'M4'],
            datasets: [
                {
                    label: 'Hadir',
                    data: [28, 30, 26, 30],
                    backgroundColor: '#1A6B6B',
                    borderRadius: 4,
                    barPercentage: 0.6,
                    categoryPercentage: 0.6
                },
                {
                    label: 'Tidak Hadir',
                    data: [3, 2, 5, 1],
                    backgroundColor: '#E5A00D',
                    borderRadius: 4,
                    barPercentage: 0.6,
                    categoryPercentage: 0.6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#9CA3AF', font: { size: 11 } }
                },
                y: {
                    min: 0,
                    max: 32,
                    ticks: {
                        stepSize: 8,
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
