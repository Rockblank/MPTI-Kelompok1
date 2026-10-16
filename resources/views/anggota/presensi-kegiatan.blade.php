@extends('layouts.anggota')

@section('title', 'Presensi Kegiatan')
@section('page-title', 'Presensi Kegiatan')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Presensi Kegiatan</h2>
    <p class="text-sm text-gray-500 mt-0.5">Scan QR code untuk presensi kegiatan</p>
</div>

{{-- Tabs --}}
<div class="flex gap-0 border-b border-gray-200 mb-6">
    <button id="tab-scan" onclick="switchTab('scan')"
        class="tab-btn px-5 py-2.5 text-sm font-medium border-b-2 transition-all -mb-px
               border-[#1A8A8A] text-[#1A8A8A]">
        Scan QR
    </button>
    <button id="tab-riwayat" onclick="switchTab('riwayat')"
        class="tab-btn px-5 py-2.5 text-sm font-medium border-b-2 transition-all -mb-px
               border-transparent text-gray-500 hover:text-gray-700">
        Riwayat Presensi
    </button>
</div>

{{-- Scan QR Panel --}}
<div id="panel-scan">
    <div class="bg-white rounded-2xl border border-gray-100 p-8 flex flex-col items-center max-w-lg mx-auto">
        <h3 class="text-base font-bold text-gray-800 mb-1">Scan QR Presensi</h3>
        <p class="text-sm text-gray-400 mb-8 text-center">Minta panitia untuk menampilkan QR code kegiatan</p>

        {{-- QR Scanner Viewport --}}
        <div class="relative w-56 h-56 mb-8">
            {{-- Corner brackets --}}
            <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-[#1A8A8A] rounded-tl-lg"></div>
            <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-[#1A8A8A] rounded-tr-lg"></div>
            <div class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-[#1A8A8A] rounded-bl-lg"></div>
            <div class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-[#1A8A8A] rounded-br-lg"></div>

            {{-- QR Icon placeholder --}}
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <svg class="w-16 h-16 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4H4v8h8V4zM4 12v8h8v-8H4zM12 12h8v8h-8v-8zM12 4h8v8h-8V4z"/>
                </svg>
                <p class="text-xs text-gray-400 text-center px-4">Arahkan kamera ke QR Code</p>
            </div>
        </div>

        <button id="btn-mulai-scan"
            class="bg-[#1A6B6B] hover:bg-[#157070] text-white font-semibold px-10 py-3 rounded-xl transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 shadow-lg shadow-[#1A6B6B]/20 text-sm">
            Mulai Scan
        </button>

        <p class="text-xs text-[#1A8A8A] mt-6 text-center">
            Pastikan Anda berada di lokasi kegiatan saat melakukan presensi
        </p>
    </div>
</div>

{{-- Riwayat Presensi Panel --}}
<div id="panel-riwayat" class="hidden">
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-50">
            <h3 class="text-sm font-semibold text-gray-800">Riwayat Presensi Kegiatan</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @php
            $kegiatanList = [
                ['nama'=>'Seminar Kepemimpinan',  'tanggal'=>'20/09/2025','via'=>'via QR Code','status'=>'hadir'],
                ['nama'=>'Workshop UI/UX Design', 'tanggal'=>'15/09/2025','via'=>'via QR Code','status'=>'hadir'],
                ['nama'=>'Rapat Koordinasi Bulanan','tanggal'=>'10/09/2025','via'=>'via Manual','status'=>'tidak-hadir'],
            ];
            @endphp

            @foreach($kegiatanList as $kegiatan)
            <div class="px-5 py-4 flex items-center gap-4">
                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0
                    {{ $kegiatan['status'] === 'hadir' ? 'bg-emerald-100' : 'bg-red-100' }}">
                    @if($kegiatan['status'] === 'hadir')
                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                    @else
                    <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-gray-800">{{ $kegiatan['nama'] }}</div>
                    <div class="text-xs text-gray-400 mt-0.5">{{ $kegiatan['tanggal'] }} · {{ $kegiatan['via'] }}</div>
                </div>
                <span class="text-xs font-semibold rounded-full px-3 py-1 flex-shrink-0
                    {{ $kegiatan['status'] === 'hadir' ? 'text-emerald-600 bg-emerald-50 border border-emerald-200' : 'text-red-600 bg-red-50 border border-red-200' }}">
                    {{ $kegiatan['status'] === 'hadir' ? 'Hadir' : 'Tidak Hadir' }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
function switchTab(tab) {
    const scanPanel = document.getElementById('panel-scan');
    const riwayatPanel = document.getElementById('panel-riwayat');
    const tabScan = document.getElementById('tab-scan');
    const tabRiwayat = document.getElementById('tab-riwayat');

    if (tab === 'scan') {
        scanPanel.classList.remove('hidden');
        riwayatPanel.classList.add('hidden');
        tabScan.classList.add('border-[#1A8A8A]', 'text-[#1A8A8A]');
        tabScan.classList.remove('border-transparent', 'text-gray-500');
        tabRiwayat.classList.remove('border-[#1A8A8A]', 'text-[#1A8A8A]');
        tabRiwayat.classList.add('border-transparent', 'text-gray-500');
    } else {
        riwayatPanel.classList.remove('hidden');
        scanPanel.classList.add('hidden');
        tabRiwayat.classList.add('border-[#1A8A8A]', 'text-[#1A8A8A]');
        tabRiwayat.classList.remove('border-transparent', 'text-gray-500');
        tabScan.classList.remove('border-[#1A8A8A]', 'text-[#1A8A8A]');
        tabScan.classList.add('border-transparent', 'text-gray-500');
    }
}
</script>
@endsection
