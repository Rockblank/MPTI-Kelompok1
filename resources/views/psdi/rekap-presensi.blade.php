@extends('layouts.psdi')

@section('title', 'Rekap Presensi')
@section('page-title', 'Rekap Presensi')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Rekap Presensi</h2>
    <p class="text-sm text-gray-500 mt-1">Ringkasan kehadiran piket dan kegiatan</p>
</div>

{{-- Sub Header Tabs (Piket / Kegiatan) --}}
<div class="flex items-center gap-6 border-b border-gray-200/80 mb-6">
    <button type="button" onclick="switchTab('piket')" id="tabBtnPiket"
            class="pb-3 text-sm font-bold text-[#1A6B6B] border-b-2 border-[#1A6B6B] transition">
        Piket
    </button>
    <button type="button" onclick="switchTab('kegiatan')" id="tabBtnKegiatan"
            class="pb-3 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
        Kegiatan
    </button>
</div>

{{-- 3 Top Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
        <div id="statRata" class="text-4xl font-black text-emerald-600 tracking-tight">88%</div>
        <div class="text-xs font-semibold text-gray-500 mt-1">Rata-rata Kehadiran</div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
        <div id="statAlpha" class="text-4xl font-black text-red-600 tracking-tight">18</div>
        <div class="text-xs font-semibold text-gray-500 mt-1">Total Alpha</div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
        <div id="statBawah" class="text-4xl font-black text-[#1A6B6B] tracking-tight">4</div>
        <div class="text-xs font-semibold text-gray-500 mt-1">Di Bawah 75%</div>
    </div>
</div>

{{-- Kehadiran Mingguan (Bar Chart) --}}
<div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-base font-bold text-gray-900" id="chartTitle">Kehadiran Mingguan</h3>
        <div class="flex items-center gap-3 text-xs font-semibold text-gray-500">
            <span class="inline-flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#1A6B6B]"></span> Hadir</span>
            <span class="inline-flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#DC2626]"></span> Alpha</span>
            <span class="inline-flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#E5A00D]"></span> Izin</span>
        </div>
    </div>
    <div class="h-64 relative">
        <canvas id="chartKehadiranMingguan"></canvas>
    </div>
</div>

{{-- Kehadiran per Anggota Table --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-base font-bold text-gray-900">Kehadiran per Anggota</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50/70 text-gray-400 font-semibold uppercase tracking-wider border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3.5">Anggota</th>
                    <th class="px-6 py-3.5 text-center">Hadir</th>
                    <th class="px-6 py-3.5 text-center">Alpha</th>
                    <th class="px-6 py-3.5 text-center">Izin</th>
                    <th class="px-6 py-3.5 text-right w-56">%</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100/70 text-gray-700" id="rekapTableBody">
                {{-- Row 1 --}}
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Budi Santoso</div>
                        <div class="text-[11px] text-gray-400">215150700111001</div>
                    </td>
                    <td class="px-6 py-4 text-center font-bold text-emerald-600 text-sm">18</td>
                    <td class="px-6 py-4 text-center font-bold text-red-600 text-sm">0</td>
                    <td class="px-6 py-4 text-center font-bold text-amber-500 text-sm">0</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <div class="w-24 bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-[#1A6B6B] h-2 rounded-full" style="width: 100%"></div>
                            </div>
                            <span class="font-bold text-emerald-600 text-xs w-10 text-right">100%</span>
                        </div>
                    </td>
                </tr>

                {{-- Row 2 --}}
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Dewi Lestari</div>
                        <div class="text-[11px] text-gray-400">215150700111002</div>
                    </td>
                    <td class="px-6 py-4 text-center font-bold text-emerald-600 text-sm">16</td>
                    <td class="px-6 py-4 text-center font-bold text-red-600 text-sm">1</td>
                    <td class="px-6 py-4 text-center font-bold text-amber-500 text-sm">1</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <div class="w-24 bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-[#1A6B6B] h-2 rounded-full" style="width: 89%"></div>
                            </div>
                            <span class="font-bold text-emerald-600 text-xs w-10 text-right">89%</span>
                        </div>
                    </td>
                </tr>

                {{-- Row 3 --}}
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Rizky Aditya</div>
                        <div class="text-[11px] text-gray-400">215150700111003</div>
                    </td>
                    <td class="px-6 py-4 text-center font-bold text-emerald-600 text-sm">14</td>
                    <td class="px-6 py-4 text-center font-bold text-red-600 text-sm">3</td>
                    <td class="px-6 py-4 text-center font-bold text-amber-500 text-sm">1</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <div class="w-24 bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-[#E5A00D] h-2 rounded-full" style="width: 78%"></div>
                            </div>
                            <span class="font-bold text-amber-600 text-xs w-10 text-right">78%</span>
                        </div>
                    </td>
                </tr>

                {{-- Row 4 --}}
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Ahmad Reza</div>
                        <div class="text-[11px] text-gray-400">215150700111005</div>
                    </td>
                    <td class="px-6 py-4 text-center font-bold text-emerald-600 text-sm">12</td>
                    <td class="px-6 py-4 text-center font-bold text-red-600 text-sm">5</td>
                    <td class="px-6 py-4 text-center font-bold text-amber-500 text-sm">1</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <div class="w-24 bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-[#DC2626] h-2 rounded-full" style="width: 67%"></div>
                            </div>
                            <span class="font-bold text-red-600 text-xs w-10 text-right">67%</span>
                        </div>
                    </td>
                </tr>

                {{-- Row 5 --}}
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Siti Rahayu</div>
                        <div class="text-[11px] text-gray-400">215150700111004</div>
                    </td>
                    <td class="px-6 py-4 text-center font-bold text-emerald-600 text-sm">17</td>
                    <td class="px-6 py-4 text-center font-bold text-red-600 text-sm">0</td>
                    <td class="px-6 py-4 text-center font-bold text-amber-500 text-sm">1</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <div class="w-24 bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-[#1A6B6B] h-2 rounded-full" style="width: 94%"></div>
                            </div>
                            <span class="font-bold text-emerald-600 text-xs w-10 text-right">94%</span>
                        </div>
                    </td>
                </tr>

                {{-- Row 6 --}}
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Maya Putri</div>
                        <div class="text-[11px] text-gray-400">215150700111006</div>
                    </td>
                    <td class="px-6 py-4 text-center font-bold text-emerald-600 text-sm">15</td>
                    <td class="px-6 py-4 text-center font-bold text-red-600 text-sm">2</td>
                    <td class="px-6 py-4 text-center font-bold text-amber-500 text-sm">1</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <div class="w-24 bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-[#1A6B6B] h-2 rounded-full" style="width: 83%"></div>
                            </div>
                            <span class="font-bold text-emerald-600 text-xs w-10 text-right">83%</span>
                        </div>
                    </td>
                </tr>

                {{-- Row 7 --}}
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Cici Amelia</div>
                        <div class="text-[11px] text-gray-400">215150700111007</div>
                    </td>
                    <td class="px-6 py-4 text-center font-bold text-emerald-600 text-sm">10</td>
                    <td class="px-6 py-4 text-center font-bold text-red-600 text-sm">7</td>
                    <td class="px-6 py-4 text-center font-bold text-amber-500 text-sm">1</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <div class="w-24 bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-[#DC2626] h-2 rounded-full" style="width: 56%"></div>
                            </div>
                            <span class="font-bold text-red-600 text-xs w-10 text-right">56%</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let myChart;
    const ctx = document.getElementById('chartKehadiranMingguan').getContext('2d');

    const chartDataPiket = {
        labels: ['M1 Sep', 'M2 Sep', 'M3 Sep', 'M4 Sep'],
        datasets: [
            {
                label: 'Hadir',
                data: [28, 30, 26, 31],
                backgroundColor: '#1A6B6B',
                borderRadius: 4,
                barPercentage: 0.65,
                categoryPercentage: 0.65
            },
            {
                label: 'Alpha',
                data: [4, 2, 5, 1],
                backgroundColor: '#DC2626',
                borderRadius: 4,
                barPercentage: 0.65,
                categoryPercentage: 0.65
            },
            {
                label: 'Izin',
                data: [0, 0, 1, 0],
                backgroundColor: '#E5A00D',
                borderRadius: 4,
                barPercentage: 0.65,
                categoryPercentage: 0.65
            }
        ]
    };

    const chartDataKegiatan = {
        labels: ['Seminar Kepemimpinan', 'Workshop UI/UX', 'Pelatihan Public Speaking', 'FGD Roadmap'],
        datasets: [
            {
                label: 'Hadir',
                data: [28, 22, 20, 32],
                backgroundColor: '#1A6B6B',
                borderRadius: 4,
                barPercentage: 0.65,
                categoryPercentage: 0.65
            },
            {
                label: 'Alpha',
                data: [2, 3, 0, 0],
                backgroundColor: '#DC2626',
                borderRadius: 4,
                barPercentage: 0.65,
                categoryPercentage: 0.65
            },
            {
                label: 'Izin',
                data: [0, 0, 0, 0],
                backgroundColor: '#E5A00D',
                borderRadius: 4,
                barPercentage: 0.65,
                categoryPercentage: 0.65
            }
        ]
    };

    function initChart(data) {
        if (myChart) myChart.destroy();
        myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
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
    }

    initChart(chartDataPiket);

    function switchTab(tab) {
        const btnPiket = document.getElementById('tabBtnPiket');
        const btnKegiatan = document.getElementById('tabBtnKegiatan');
        const chartTitle = document.getElementById('chartTitle');

        if (tab === 'piket') {
            btnPiket.className = 'pb-3 text-sm font-bold text-[#1A6B6B] border-b-2 border-[#1A6B6B] transition';
            btnKegiatan.className = 'pb-3 text-sm font-medium text-gray-500 hover:text-gray-800 transition';
            chartTitle.innerText = 'Kehadiran Mingguan (Piket)';
            initChart(chartDataPiket);
            document.getElementById('statRata').innerText = '88%';
            document.getElementById('statAlpha').innerText = '18';
            document.getElementById('statBawah').innerText = '4';
        } else {
            btnKegiatan.className = 'pb-3 text-sm font-bold text-[#1A6B6B] border-b-2 border-[#1A6B6B] transition';
            btnPiket.className = 'pb-3 text-sm font-medium text-gray-500 hover:text-gray-800 transition';
            chartTitle.innerText = 'Kehadiran per Acara (Kegiatan)';
            initChart(chartDataKegiatan);
            document.getElementById('statRata').innerText = '92%';
            document.getElementById('statAlpha').innerText = '5';
            document.getElementById('statBawah').innerText = '1';
        }
    }
</script>
@endpush
