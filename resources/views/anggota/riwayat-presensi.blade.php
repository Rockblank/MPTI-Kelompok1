@extends('layouts.anggota')

@section('title', 'Riwayat Presensi')
@section('page-title', 'Riwayat Presensi')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Riwayat Presensi</h2>
    <p class="text-sm text-gray-500 mt-0.5">Rekaman kehadiran piket dan kegiatan Anda</p>
</div>

{{-- Tabs --}}
<div class="flex gap-0 border-b border-gray-200 mb-6">
    <button id="tab-piket" onclick="switchTab('piket')"
        class="px-5 py-2.5 text-sm font-medium border-b-2 transition-all -mb-px border-[#1A8A8A] text-[#1A8A8A]">
        Piket
    </button>
    <button id="tab-kegiatan" onclick="switchTab('kegiatan')"
        class="px-5 py-2.5 text-sm font-medium border-b-2 transition-all -mb-px border-transparent text-gray-500 hover:text-gray-700">
        Kegiatan
    </button>
</div>

{{-- Piket Panel --}}
<div id="panel-piket">
    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4 mb-5">
        <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center">
            <div class="text-3xl font-extrabold text-emerald-500 mb-1">6</div>
            <div class="text-xs text-gray-500 font-medium">Hadir</div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center">
            <div class="text-3xl font-extrabold text-red-500 mb-1">1</div>
            <div class="text-xs text-gray-500 font-medium">Alpha</div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center">
            <div class="text-3xl font-extrabold text-emerald-500 mb-1">86%</div>
            <div class="text-xs text-gray-500 font-medium">Kehadiran</div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Shift</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Lokasi</th>
                    <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php
                $piketRiwayat = [
                    ['tanggal'=>'22/09/2025','hari'=>'Senin','shift'=>'08:00–10:00','lokasi'=>'Sekretariat','status'=>'hadir'],
                    ['tanggal'=>'18/09/2025','hari'=>'Kamis','shift'=>'08:00–10:00','lokasi'=>'Sekretariat','status'=>'hadir'],
                    ['tanggal'=>'15/09/2025','hari'=>'Senin','shift'=>'08:00–10:00','lokasi'=>'Sekretariat','status'=>'hadir'],
                    ['tanggal'=>'11/09/2025','hari'=>'Kamis','shift'=>'08:00–10:00','lokasi'=>'Sekretariat','status'=>'alpha'],
                    ['tanggal'=>'08/09/2025','hari'=>'Senin','shift'=>'08:00–10:00','lokasi'=>'Sekretariat','status'=>'hadir'],
                    ['tanggal'=>'04/09/2025','hari'=>'Kamis','shift'=>'08:00–10:00','lokasi'=>'Sekretariat','status'=>'hadir'],
                    ['tanggal'=>'01/09/2025','hari'=>'Senin','shift'=>'08:00–10:00','lokasi'=>'Sekretariat','status'=>'hadir'],
                ];
                @endphp
                @foreach($piketRiwayat as $row)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-4">
                        <div class="font-medium text-gray-800">{{ $row['tanggal'] }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $row['hari'] }}</div>
                    </td>
                    <td class="px-5 py-4 text-gray-700">{{ $row['shift'] }}</td>
                    <td class="px-5 py-4 text-gray-700">{{ $row['lokasi'] }}</td>
                    <td class="px-5 py-4 text-right">
                        @if($row['status'] === 'hadir')
                            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-full px-3 py-1">Hadir</span>
                        @else
                            <span class="text-xs font-semibold text-red-600 bg-red-50 border border-red-200 rounded-full px-3 py-1">Alpha</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Kegiatan Panel --}}
<div id="panel-kegiatan" class="hidden">
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/50">
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kegiatan</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu & Metode</th>
                    <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Bukti Selfie</th>
                    <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @if(isset($kegiatanRiwayat) && $kegiatanRiwayat->isNotEmpty())
                    @foreach($kegiatanRiwayat as $presensi)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4">
                            <div class="font-medium text-gray-800">{{ $presensi->kegiatan->nama ?? 'Kegiatan BEM' }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">{{ $presensi->kegiatan->lokasi ?? 'Sekretariat' }}</div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="text-xs font-medium text-gray-700">{{ $presensi->waktu_presensi->copy()->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y') }}</div>
                            <div class="text-[11px] font-mono text-emerald-700 mt-0.5">🕒 {{ $presensi->waktu_presensi->copy()->timezone('Asia/Jakarta')->format('H:i:s') }} WIB · via QR Code</div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($presensi->bukti_foto)
                            <a href="{{ $presensi->bukti_foto_url }}" target="_blank"
                               class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-teal-50 hover:bg-teal-100 text-[#1A6B6B] border border-teal-200 text-xs font-medium transition"
                               title="Lihat Bukti Foto">
                                <span>📷</span>
                                <span>Lihat Foto</span>
                            </a>
                            @else
                            <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-full px-3 py-1">
                                Hadir
                            </span>
                        </td>
                    </tr>
                    @endforeach
                @else
                    @php
                    $sampleKegiatan = [
                        ['nama'=>'Seminar Kepemimpinan',    'tanggal'=>'20/09/2025 · 09:15:00 WIB','via'=>'via QR Code','status'=>'hadir'],
                        ['nama'=>'Workshop UI/UX Design',   'tanggal'=>'15/09/2025 · 13:05:22 WIB','via'=>'via QR Code','status'=>'hadir'],
                        ['nama'=>'Rapat Koordinasi Bulanan','tanggal'=>'10/09/2025 · —','via'=>'via Manual', 'status'=>'tidak-hadir'],
                    ];
                    @endphp
                    @foreach($sampleKegiatan as $row)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4">
                            <div class="font-medium text-gray-800">{{ $row['nama'] }}</div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="text-xs text-gray-500">{{ $row['tanggal'] }} · {{ $row['via'] }}</div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="text-xs text-gray-400">—</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            @if($row['status'] === 'hadir')
                                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-full px-3 py-1">Hadir</span>
                            @else
                                <span class="text-xs font-semibold text-red-600 bg-red-50 border border-red-200 rounded-full px-3 py-1">Tidak Hadir</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<script>
function switchTab(tab) {
    const piketPanel = document.getElementById('panel-piket');
    const kegiatanPanel = document.getElementById('panel-kegiatan');
    const tabPiket = document.getElementById('tab-piket');
    const tabKegiatan = document.getElementById('tab-kegiatan');

    if (tab === 'piket') {
        piketPanel.classList.remove('hidden');
        kegiatanPanel.classList.add('hidden');
        tabPiket.classList.add('border-[#1A8A8A]', 'text-[#1A8A8A]');
        tabPiket.classList.remove('border-transparent', 'text-gray-500');
        tabKegiatan.classList.remove('border-[#1A8A8A]', 'text-[#1A8A8A]');
        tabKegiatan.classList.add('border-transparent', 'text-gray-500');
    } else {
        kegiatanPanel.classList.remove('hidden');
        piketPanel.classList.add('hidden');
        tabKegiatan.classList.add('border-[#1A8A8A]', 'text-[#1A8A8A]');
        tabKegiatan.classList.remove('border-transparent', 'text-gray-500');
        tabPiket.classList.remove('border-[#1A8A8A]', 'text-[#1A8A8A]');
        tabPiket.classList.add('border-transparent', 'text-gray-500');
    }
}
</script>
@endsection
