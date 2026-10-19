@extends('layouts.presbem')

@section('title', 'Presensi Kegiatan')
@section('page-title', 'Presensi Kegiatan')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Presensi Kegiatan</h2>
    <p class="text-sm text-gray-500 mt-1">Scan QR code untuk presensi kegiatan</p>
</div>

{{-- Sub Tabs --}}
<div class="flex items-center gap-6 border-b border-gray-200/80 mb-6">
    <button type="button" onclick="switchPresensiTab('scan')" id="tabBtnScan"
            class="pb-3 text-sm font-bold text-[#1A6B6B] border-b-2 border-[#1A6B6B] transition">
        Scan QR
    </button>
    <button type="button" onclick="switchPresensiTab('riwayat')" id="tabBtnRiwayat"
            class="pb-3 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
        Riwayat Presensi
    </button>
</div>

{{-- Tab 1: Scan QR --}}
<div id="contentScanQr" class="bg-white rounded-3xl p-8 sm:p-12 border border-gray-100 shadow-sm text-center">
    <div class="max-w-md mx-auto space-y-6">
        <div>
            <h3 class="text-lg font-bold text-gray-900">Scan QR Presensi</h3>
            <p class="text-xs text-gray-500 mt-1">Minta panitia untuk menampilkan QR code kegiatan</p>
        </div>

        {{-- Camera / Scanner Frame --}}
        <div class="relative w-64 h-64 mx-auto rounded-3xl bg-gray-50/70 border border-gray-200 flex flex-col items-center justify-center p-6 group">
            {{-- 4 Corner Reticles --}}
            <div class="absolute top-4 left-4 w-6 h-6 border-t-2 border-l-2 border-[#1A6B6B] rounded-tl-lg"></div>
            <div class="absolute top-4 right-4 w-6 h-6 border-t-2 border-r-2 border-[#1A6B6B] rounded-tr-lg"></div>
            <div class="absolute bottom-4 left-4 w-6 h-6 border-b-2 border-l-2 border-[#1A6B6B] rounded-bl-lg"></div>
            <div class="absolute bottom-4 right-4 w-6 h-6 border-b-2 border-r-2 border-[#1A6B6B] rounded-br-lg"></div>

            <div class="w-16 h-16 rounded-2xl bg-teal-50 text-[#1A6B6B] flex items-center justify-center mb-3">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
            </div>
            <span class="text-xs text-gray-500 font-medium">Arahkan kamera ke QR Code</span>
        </div>

        <div>
            <button type="button" onclick="mulaiSimulasiScan()"
                    class="px-8 py-3 bg-[#1A6B6B] hover:bg-[#155757] text-white font-bold text-xs rounded-xl transition shadow-sm hover:shadow">
                Mulai Scan
            </button>
        </div>

        <div class="p-3.5 bg-gray-50 rounded-2xl text-[11px] text-gray-500">
            Pastikan Anda berada di lokasi kegiatan saat melakukan presensi
        </div>
    </div>
</div>

{{-- Tab 2: Riwayat Presensi Kegiatan --}}
<div id="contentRiwayat" class="hidden bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h4 class="text-base font-bold text-gray-900">Riwayat Presensi Kegiatan</h4>
    </div>
    <div class="divide-y divide-gray-100">
        {{-- Item 1 --}}
        <div class="p-5 flex items-center justify-between hover:bg-gray-50/50 transition">
            <div class="flex items-center gap-3.5">
                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">
                    ✓
                </div>
                <div>
                    <h5 class="text-sm font-bold text-gray-900">Seminar Kepemimpinan</h5>
                    <p class="text-xs text-gray-400 mt-0.5">20/09/2025 · via QR Code</p>
                </div>
            </div>
            <span class="px-3.5 py-1 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-full border border-emerald-200">
                Hadir
            </span>
        </div>

        {{-- Item 2 --}}
        <div class="p-5 flex items-center justify-between hover:bg-gray-50/50 transition">
            <div class="flex items-center gap-3.5">
                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">
                    ✓
                </div>
                <div>
                    <h5 class="text-sm font-bold text-gray-900">Workshop UI/UX Design</h5>
                    <p class="text-xs text-gray-400 mt-0.5">15/09/2025 · via QR Code</p>
                </div>
            </div>
            <span class="px-3.5 py-1 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-full border border-emerald-200">
                Hadir
            </span>
        </div>

        {{-- Item 3 --}}
        <div class="p-5 flex items-center justify-between hover:bg-gray-50/50 transition">
            <div class="flex items-center gap-3.5">
                <div class="w-8 h-8 rounded-full bg-red-50 text-red-600 flex items-center justify-center font-bold text-sm">
                    ✕
                </div>
                <div>
                    <h5 class="text-sm font-bold text-gray-900">Rapat Koordinasi Bulanan</h5>
                    <p class="text-xs text-gray-400 mt-0.5">10/09/2025 · via Manual</p>
                </div>
            </div>
            <span class="px-3.5 py-1 bg-red-50 text-red-600 font-bold text-xs rounded-full border border-red-200">
                Tidak Hadir
            </span>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function switchPresensiTab(tab) {
        const btnScan = document.getElementById('tabBtnScan');
        const btnRiwayat = document.getElementById('tabBtnRiwayat');
        const contentScan = document.getElementById('contentScanQr');
        const contentRiwayat = document.getElementById('contentRiwayat');

        if (tab === 'scan') {
            btnScan.className = 'pb-3 text-sm font-bold text-[#1A6B6B] border-b-2 border-[#1A6B6B] transition';
            btnRiwayat.className = 'pb-3 text-sm font-medium text-gray-500 hover:text-gray-800 transition';
            contentScan.classList.remove('hidden');
            contentRiwayat.classList.add('hidden');
        } else {
            btnRiwayat.className = 'pb-3 text-sm font-bold text-[#1A6B6B] border-b-2 border-[#1A6B6B] transition';
            btnScan.className = 'pb-3 text-sm font-medium text-gray-500 hover:text-gray-800 transition';
            contentScan.classList.add('hidden');
            contentRiwayat.classList.remove('hidden');
        }
    }

    function mulaiSimulasiScan() {
        alert('Memulai simulasi scan kamera... QR Code Kegiatan terdeteksi!\n\nPresensi Anda di Kegiatan berhasil dicatat.');
        switchPresensiTab('riwayat');
    }
</script>
@endpush
