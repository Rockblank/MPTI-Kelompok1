@extends('layouts.anggota')

@section('title', 'Presensi Kegiatan')
@section('page-title', 'Presensi Kegiatan')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-xl font-bold text-gray-900">Presensi Kegiatan</h2>
        <p class="text-sm text-gray-500 mt-0.5">Scan QR code dan sertakan foto selfie bukti kehadiran</p>
    </div>
    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white rounded-xl border border-gray-200/80 shadow-sm text-xs text-gray-600 font-medium self-start sm:self-auto">
        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        <span id="live-clock">{{ $currentTime }}</span>
    </div>
</div>

{{-- Flash & Error Alerts --}}
@if(session('success'))
<div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start gap-3 shadow-sm animate-in fade-in">
    <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0 text-emerald-600">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
        </svg>
    </div>
    <div class="flex-1">
        <h4 class="text-sm font-bold text-emerald-900">Presensi Berhasil Dicatat!</h4>
        <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
    </div>
</div>
@endif

@if($errors->any())
<div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 flex items-start gap-3 shadow-sm animate-in fade-in">
    <div class="w-8 h-8 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0 text-red-600">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.834-1.964-.834-2.732 0L3.07 16.5c-.77.833.193 2.5 1.732 2.5z" />
        </svg>
    </div>
    <div class="flex-1">
        <h4 class="text-sm font-bold text-red-900">Presensi Tidak Berhasil</h4>
        <ul class="text-xs text-red-700 mt-1 list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

{{-- Tabs --}}
<div class="flex gap-0 border-b border-gray-200 mb-6">
    <button id="tab-scan" onclick="switchTab('scan')"
        class="tab-btn px-5 py-2.5 text-sm font-medium border-b-2 transition-all -mb-px
               {{ $activeTab === 'scan' ? 'border-[#1A8A8A] text-[#1A8A8A]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
        Scan QR
    </button>
    <button id="tab-riwayat" onclick="switchTab('riwayat')"
        class="tab-btn px-5 py-2.5 text-sm font-medium border-b-2 transition-all -mb-px
               {{ $activeTab === 'riwayat' ? 'border-[#1A8A8A] text-[#1A8A8A]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
        Riwayat Presensi ({{ $riwayatPresensi->count() }})
    </button>
</div>

{{-- Scan QR & Upload Selfie Panel --}}
<div id="panel-scan" class="{{ $activeTab === 'scan' ? '' : 'hidden' }}">
    <form action="{{ route('anggota.presensi-kegiatan.store') }}" method="POST" enctype="multipart/form-data" id="form-presensi">
        @csrf
        <input type="hidden" name="bukti_foto_base64" id="bukti_foto_base64">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Left Column: QR Code Scanning --}}
            <div class="lg:col-span-7 bg-white rounded-2xl border border-gray-100 p-6 flex flex-col justify-between shadow-sm">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-bold text-gray-800">1. Scan QR Code Kegiatan</h3>
                            <p class="text-xs text-gray-400 mt-0.5">Arahkan kamera ke proyektor / masukkan kode kegiatan</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-teal-50 text-[#1A6B6B] border border-teal-200">
                            Langkah 1
                        </span>
                    </div>

                    {{-- QR Scanner Viewport --}}
                    <div class="relative w-full max-w-sm h-64 mx-auto mb-5 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center overflow-hidden">
                        {{-- Corner brackets --}}
                        <div class="absolute top-3 left-3 w-7 h-7 border-t-4 border-l-4 border-[#1A8A8A] rounded-tl-lg z-10"></div>
                        <div class="absolute top-3 right-3 w-7 h-7 border-t-4 border-r-4 border-[#1A8A8A] rounded-tr-lg z-10"></div>
                        <div class="absolute bottom-3 left-3 w-7 h-7 border-b-4 border-l-4 border-[#1A8A8A] rounded-bl-lg z-10"></div>
                        <div class="absolute bottom-3 right-3 w-7 h-7 border-b-4 border-r-4 border-[#1A8A8A] rounded-br-lg z-10"></div>

                        {{-- Video element for camera stream --}}
                        <video id="qr-camera-video" class="hidden w-full h-full object-cover rounded-xl" playsinline></video>

                        {{-- Scan placeholder --}}
                        <div id="qr-placeholder" class="text-center p-4">
                            <div class="w-14 h-14 bg-teal-50 text-[#1A8A8A] rounded-2xl flex items-center justify-center mx-auto mb-2">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold text-gray-700">Arahkan Kamera ke QR Code</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">atau ketik kode QR kegiatan di bawah</p>
                        </div>
                    </div>

                    {{-- Camera Toggle Button --}}
                    <div class="flex items-center justify-center gap-3 mb-5">
                        <button type="button" id="btn-toggle-camera" onclick="toggleQrCamera()"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition">
                            <svg class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span id="btn-camera-text">Aktifkan Kamera Scan</span>
                        </button>
                    </div>
                    <p id="qr-scan-status" class="text-center text-xs text-gray-500 -mt-3 mb-4" aria-live="polite"></p>

                    {{-- Manual / Scanned QR Input --}}
                    <div class="space-y-2">
                        <label for="input-qr-code" class="block text-xs font-semibold text-gray-700">
                            Kode QR Kegiatan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="qr_code" id="input-qr-code" required
                                   value="{{ old('qr_code') }}"
                                   placeholder="Contoh: SEMINAR-KPM-2025"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm font-mono tracking-wider focus:ring-2 focus:ring-[#1A8A8A] focus:border-[#1A8A8A] uppercase">
                            <div class="absolute right-3 top-3 text-xs text-gray-400 font-medium">QR Token</div>
                        </div>
                    </div>

                    {{-- Quick Select for Active Events --}}
                    @if($kegiatanAktif->isNotEmpty())
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <div class="text-[11px] font-semibold text-gray-500 mb-2">Pilih Cepat Kegiatan Aktif:</div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($kegiatanAktif as $keg)
                            <button type="button" onclick="selectQrCode('{{ $keg->qr_code }}', '{{ $keg->nama }}')"
                                    class="px-2.5 py-1 rounded-lg bg-teal-50 hover:bg-teal-100 text-[#1A6B6B] border border-teal-200 text-xs font-medium transition flex items-center gap-1.5">
                                <span>📌 {{ $keg->nama }}</span>
                                <span class="font-mono text-[10px] text-teal-800 bg-teal-200/60 px-1 rounded">({{ $keg->qr_code }})</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Right Column: Selfie Photo Proof & Submit --}}
            <div class="lg:col-span-5 bg-white rounded-2xl border border-gray-100 p-6 flex flex-col justify-between shadow-sm">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-bold text-gray-800">2. Foto Selfie Bukti Kehadiran</h3>
                            <p class="text-xs text-gray-400 mt-0.5">Ambil foto selfie di lokasi kegiatan</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-teal-50 text-[#1A6B6B] border border-teal-200">
                            Langkah 2
                        </span>
                    </div>

                    {{-- Selfie Viewport / Preview --}}
                    <div class="relative w-full h-56 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center overflow-hidden mb-4">
                        <video id="selfie-video" class="hidden w-full h-full object-cover rounded-xl" playsinline></video>
                        <canvas id="selfie-canvas" class="hidden"></canvas>
                        <img id="selfie-preview" class="hidden w-full h-full object-cover rounded-xl" alt="Preview Foto Selfie">

                        <div id="selfie-placeholder" class="text-center p-4">
                            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold text-gray-700">Belum Ada Foto Selfie</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">Wajib menyertakan bukti foto wajah di lokasi</p>
                        </div>
                    </div>

                    {{-- Capture / Upload Action Buttons --}}
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <button type="button" id="btn-selfie-cam" onclick="startSelfieCamera()"
                                class="py-2.5 px-3 bg-teal-50 hover:bg-teal-100 text-[#1A6B6B] border border-teal-200 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            </svg>
                            <span id="btn-selfie-cam-text">Kamera Selfie</span>
                        </button>

                        <label for="bukti_foto_file" class="py-2.5 px-3 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 cursor-pointer text-center">
                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Pilih Berkas</span>
                        </label>
                        <input type="file" id="bukti_foto_file" name="bukti_foto" accept="image/*" capture="user" class="hidden" onchange="handleFileSelect(event)">
                    </div>

                    <div id="selfie-status-indicator" class="hidden mb-4 p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span id="selfie-status-text">Foto selfie siap dikirim.</span>
                    </div>

                    {{-- Snapshot button when camera is active --}}
                    <div id="snapshot-action" class="hidden mb-4">
                        <button type="button" onclick="takeSnapshot()"
                                class="w-full py-2.5 px-4 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                            <span class="w-2.5 h-2.5 rounded-full bg-white animate-ping"></span>
                            Jepret Foto Selfie Sekarang
                        </button>
                    </div>

                    <div class="p-3 bg-gray-50 rounded-xl text-[11px] text-gray-500 flex items-start gap-2 mb-6">
                        <span class="text-teal-600">ℹ️</span>
                        <span>Waktu kehadiran akan dicatat secara <strong>real-time</strong> sesuai jam sistem saat Anda menekan tombol Simpan Presensi.</span>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" id="btn-submit-presensi"
                        class="w-full bg-[#1A6B6B] hover:bg-[#155757] text-white font-bold py-3.5 px-6 rounded-xl transition duration-200 shadow-lg shadow-[#1A6B6B]/20 text-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Simpan Presensi Kehadiran
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Riwayat Presensi Panel --}}
<div id="panel-riwayat" class="{{ $activeTab === 'riwayat' ? '' : 'hidden' }}">
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-gray-800">Riwayat Presensi Kegiatan</h3>
                <p class="text-xs text-gray-400 mt-0.5">Daftar kehadiran acara yang berhasil dicatat ke sistem</p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                Total: {{ $riwayatPresensi->count() }} Hadir
            </span>
        </div>

        @if($riwayatPresensi->isEmpty())
        <div class="p-12 text-center">
            <div class="w-14 h-14 bg-gray-50 text-gray-400 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h4 class="text-sm font-bold text-gray-800">Belum Ada Presensi Kegiatan</h4>
            <p class="text-xs text-gray-400 mt-1 max-w-sm mx-auto">Anda belum melakukan presensi kegiatan. Buka tab Scan QR untuk mencatat kehadiran acara pertama Anda.</p>
            <button type="button" onclick="switchTab('scan')" class="mt-4 px-4 py-2 bg-[#1A6B6B] text-white text-xs font-bold rounded-xl hover:bg-[#155757] transition">
                Buka Scan QR
            </button>
        </div>
        @else
        <div class="divide-y divide-gray-100">
            @foreach($riwayatPresensi as $presensi)
            <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-gray-50/50 transition">
                <div class="flex items-start gap-4">
                    {{-- Status Icon --}}
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 bg-emerald-100 text-emerald-600 mt-0.5">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>

                    {{-- Activity Details --}}
                    <div>
                        <div class="text-sm font-bold text-gray-900">{{ $presensi->kegiatan->nama ?? 'Kegiatan BEM' }}</div>
                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-500 mt-1">
                            <span class="flex items-center gap-1 text-gray-600">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $presensi->waktu_presensi->copy()->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y') }}
                            </span>
                            <span>•</span>
                            <span class="flex items-center gap-1 font-mono text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">
                                🕒 {{ $presensi->waktu_presensi->copy()->timezone('Asia/Jakarta')->format('H:i:s') }} WIB
                            </span>
                            <span>•</span>
                            <span class="text-gray-400">via QR Code</span>
                        </div>
                    </div>
                </div>

                {{-- Right: Selfie Proof Thumbnail & Badge --}}
                <div class="flex items-center gap-3 sm:self-center">
                    @if($presensi->bukti_foto)
                    <button type="button"
                            onclick="previewPhotoModal('{{ $presensi->bukti_foto_url }}', '{{ $presensi->kegiatan->nama ?? 'Presensi Kegiatan' }}', '{{ $presensi->waktu_presensi->copy()->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }} WIB')"
                            class="group relative w-12 h-12 rounded-xl overflow-hidden border border-gray-200 shadow-sm flex-shrink-0 hover:ring-2 hover:ring-[#1A8A8A] transition"
                            title="Klik untuk melihat bukti foto selfie">
                        <img src="{{ $presensi->bukti_foto_url }}" alt="Bukti Selfie" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 flex items-center justify-center transition">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                    </button>
                    @endif

                    <span class="text-xs font-bold rounded-full px-3 py-1 text-emerald-700 bg-emerald-50 border border-emerald-200">
                        Hadir
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- Lightbox Modal for Selfie Proof --}}
<div id="modalPhotoView" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h4 id="modalPhotoTitle" class="text-sm font-bold text-gray-900">Bukti Foto Kehadiran</h4>
                <p id="modalPhotoTime" class="text-xs text-gray-400 mt-0.5">-</p>
            </div>
            <button type="button" onclick="closePhotoModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="p-6 bg-gray-50 flex items-center justify-center">
            <img id="modalPhotoImage" src="" alt="Bukti Foto Selfie" class="max-h-96 w-auto rounded-2xl shadow-sm border border-gray-200 object-contain">
        </div>
        <div class="px-6 py-4 border-t border-gray-100 flex justify-end">
            <button type="button" onclick="closePhotoModal()" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-bold transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
let qrStream = null;
let qrAnimationFrame = null;
let qrCanvas = document.createElement('canvas');
let qrLastScanAt = 0;
let selfieStream = null;

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
        stopAllCameras();
    }
}

function selectQrCode(code, name) {
    const input = document.getElementById('input-qr-code');
    input.value = code;
    input.focus();
}

async function toggleQrCamera() {
    const video = document.getElementById('qr-camera-video');
    const placeholder = document.getElementById('qr-placeholder');
    const btnText = document.getElementById('btn-camera-text');

    if (qrStream) {
        stopQrCamera();
        return;
    }

    if (!navigator.mediaDevices?.getUserMedia || !window.jsQR) {
        alert('Pemindai QR tidak tersedia di browser ini. Silakan masukkan kode QR secara manual.');
        return;
    }

    try {
        qrStream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'environment' }
        });
        video.srcObject = qrStream;
        await video.play();
        video.classList.remove('hidden');
        placeholder.classList.add('hidden');
        btnText.innerText = 'Matikan Kamera';
        document.getElementById('qr-scan-status').innerText = 'Arahkan kamera ke QR Code kegiatan.';
        qrAnimationFrame = requestAnimationFrame(scanQrFrame);
    } catch (error) {
        stopQrCamera();
        alert('Tidak dapat mengakses kamera perangkat. Pastikan izin kamera aktif atau masukkan kode QR secara manual.');
    }
}

function scanQrFrame(timestamp) {
    if (!qrStream) return;

    if (timestamp - qrLastScanAt >= 200) {
        const video = document.getElementById('qr-camera-video');
        if (video.readyState === HTMLMediaElement.HAVE_ENOUGH_DATA) {
            qrCanvas.width = video.videoWidth;
            qrCanvas.height = video.videoHeight;
            const context = qrCanvas.getContext('2d', { willReadFrequently: true });
            context.drawImage(video, 0, 0, qrCanvas.width, qrCanvas.height);

            const image = context.getImageData(0, 0, qrCanvas.width, qrCanvas.height);
            const result = window.jsQR(image.data, image.width, image.height, {
                inversionAttempts: 'attemptBoth'
            });

            if (result?.data) {
                const qrInput = document.getElementById('input-qr-code');
                qrInput.value = result.data.trim();
                qrInput.dispatchEvent(new Event('input', { bubbles: true }));
                document.getElementById('qr-scan-status').innerText = 'QR Code berhasil dipindai. Silakan ambil foto selfie.';
                stopQrCamera();
                return;
            }
        }

        qrLastScanAt = timestamp;
    }

    qrAnimationFrame = requestAnimationFrame(scanQrFrame);
}

function stopQrCamera() {
    if (qrAnimationFrame !== null) {
        cancelAnimationFrame(qrAnimationFrame);
        qrAnimationFrame = null;
    }
    if (qrStream) {
        qrStream.getTracks().forEach(track => track.stop());
        qrStream = null;
    }

    const video = document.getElementById('qr-camera-video');
    video.srcObject = null;
    video.classList.add('hidden');
    document.getElementById('qr-placeholder').classList.remove('hidden');
    document.getElementById('btn-camera-text').innerText = 'Aktifkan Kamera Scan';
}

async function startSelfieCamera() {
    const video = document.getElementById('selfie-video');
    const placeholder = document.getElementById('selfie-placeholder');
    const preview = document.getElementById('selfie-preview');
    const snapshotAction = document.getElementById('snapshot-action');
    const btnText = document.getElementById('btn-selfie-cam-text');

    if (selfieStream) {
        selfieStream.getTracks().forEach(t => t.stop());
        selfieStream = null;
        video.classList.add('hidden');
        snapshotAction.classList.add('hidden');
        btnText.innerText = 'Kamera Selfie';
        if (!preview.src) {
            placeholder.classList.remove('hidden');
        }
    } else {
        try {
            selfieStream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'user' }
            });
            video.srcObject = selfieStream;
            video.play();
            video.classList.remove('hidden');
            preview.classList.add('hidden');
            placeholder.classList.add('hidden');
            snapshotAction.classList.remove('hidden');
            btnText.innerText = 'Tutup Kamera';
        } catch (err) {
            alert('Tidak dapat mengaktifkan kamera selfie. Anda dapat menggunakan opsi "Pilih Berkas" untuk mengunggah foto selfie.');
        }
    }
}

function takeSnapshot() {
    const video = document.getElementById('selfie-video');
    const canvas = document.getElementById('selfie-canvas');
    const preview = document.getElementById('selfie-preview');
    const base64Input = document.getElementById('bukti_foto_base64');
    const statusBox = document.getElementById('selfie-status-indicator');
    const statusText = document.getElementById('selfie-status-text');
    const snapshotAction = document.getElementById('snapshot-action');

    document.getElementById('bukti_foto_file').value = '';
    canvas.width = video.videoWidth || 640;
    canvas.height = video.videoHeight || 480;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    const dataUrl = canvas.toDataURL('image/jpeg', 0.85);
    base64Input.value = dataUrl;
    preview.src = dataUrl;
    preview.classList.remove('hidden');
    video.classList.add('hidden');

    if (selfieStream) {
        selfieStream.getTracks().forEach(t => t.stop());
        selfieStream = null;
    }

    document.getElementById('btn-selfie-cam-text').innerText = 'Ambil Ulang Selfie';
    snapshotAction.classList.add('hidden');

    statusBox.classList.remove('hidden');
    statusText.innerText = 'Foto selfie berhasil dijepret dari kamera webcam!';
}

function handleFileSelect(event) {
    const file = event.target.files[0];
    if (!file) return;

    const preview = document.getElementById('selfie-preview');
    const placeholder = document.getElementById('selfie-placeholder');
    const statusBox = document.getElementById('selfie-status-indicator');
    const statusText = document.getElementById('selfie-status-text');

    document.getElementById('bukti_foto_base64').value = '';
    const reader = new FileReader();
    reader.onload = function(e) {
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
        statusBox.classList.remove('hidden');
        statusText.innerText = `Berkas "${file.name}" siap diunggah sebagai bukti kehadiran.`;
    };
    reader.readAsDataURL(file);
}

function previewPhotoModal(url, title, time) {
    document.getElementById('modalPhotoImage').src = url;
    document.getElementById('modalPhotoTitle').innerText = title;
    document.getElementById('modalPhotoTime').innerText = 'Waktu Absensi: ' + time;
    document.getElementById('modalPhotoView').classList.remove('hidden');
}

function closePhotoModal() {
    document.getElementById('modalPhotoView').classList.add('hidden');
}

function stopAllCameras() {
    stopQrCamera();
    if (selfieStream) {
        selfieStream.getTracks().forEach(t => t.stop());
        selfieStream = null;
    }
}

// Keep live clock updating every second
setInterval(() => {
    const clockEl = document.getElementById('live-clock');
    if (clockEl) {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', timeZone: 'Asia/Jakarta' };
        clockEl.innerText = now.toLocaleDateString('id-ID', options) + ' WIB';
    }
}, 1000);
</script>
@endsection
