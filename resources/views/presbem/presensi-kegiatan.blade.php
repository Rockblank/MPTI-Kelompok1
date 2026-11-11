@extends('layouts.presbem')

@section('title', 'Presensi Kegiatan')
@section('page-title', 'Presensi Kegiatan')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Presensi Kegiatan</h2>
        <p class="text-sm text-gray-500 mt-1">Scan QR code dan sertakan foto selfie bukti kehadiran</p>
    </div>
    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white rounded-xl border border-gray-200/80 shadow-sm text-xs text-gray-600 font-medium self-start sm:self-auto">
        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        <span>{{ $currentTime }}</span>
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

{{-- Sub Tabs --}}
<div class="flex items-center gap-6 border-b border-gray-200/80 mb-6">
    <button type="button" onclick="switchPresensiTab('scan')" id="tabBtnScan"
            class="pb-3 text-sm font-bold {{ $activeTab === 'scan' ? 'text-[#1A6B6B] border-b-2 border-[#1A6B6B]' : 'text-gray-500 hover:text-gray-800' }} transition">
        Scan QR
    </button>
    <button type="button" onclick="switchPresensiTab('riwayat')" id="tabBtnRiwayat"
            class="pb-3 text-sm font-medium {{ $activeTab === 'riwayat' ? 'text-[#1A6B6B] border-b-2 border-[#1A6B6B]' : 'text-gray-500 hover:text-gray-800' }} transition">
        Riwayat Presensi ({{ $riwayatPresensi->count() }})
    </button>
</div>

{{-- Tab 1: Scan QR & Selfie Form --}}
<div id="contentScanQr" class="{{ $activeTab === 'scan' ? '' : 'hidden' }}">
    <form action="{{ route('presbem.presensi-kegiatan.store') }}" method="POST" enctype="multipart/form-data" id="pres-presensi-form" onsubmit="return validatePresSubmit(event)">
        @csrf
        <input type="hidden" name="bukti_foto_base64" id="pres_bukti_foto_base64">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Left: QR Code --}}
            <div class="lg:col-span-7 bg-white rounded-3xl p-8 border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-900 mb-1">Scan QR Presensi</h3>
                    <p class="text-xs text-gray-400 mb-6">Arahkan kamera ke proyektor kegiatan atau input kode QR</p>

                    <div class="relative w-64 h-64 mx-auto rounded-3xl bg-gray-50/70 border border-gray-200 flex flex-col items-center justify-center p-6 mb-4 overflow-hidden">
                        <div class="absolute top-4 left-4 w-6 h-6 border-t-2 border-l-2 border-[#1A6B6B] rounded-tl-lg"></div>
                        <div class="absolute top-4 right-4 w-6 h-6 border-t-2 border-r-2 border-[#1A6B6B] rounded-tr-lg"></div>
                        <div class="absolute bottom-4 left-4 w-6 h-6 border-b-2 border-l-2 border-[#1A6B6B] rounded-bl-lg"></div>
                        <div class="absolute bottom-4 right-4 w-6 h-6 border-b-2 border-r-2 border-[#1A6B6B] rounded-br-lg"></div>

                        <video id="pres-qr-camera" class="hidden absolute inset-0 w-full h-full object-cover" playsinline></video>
                        <div id="pres-qr-placeholder" class="text-center">
                        <div class="w-16 h-16 rounded-2xl bg-teal-50 text-[#1A6B6B] flex items-center justify-center mb-3 mx-auto">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </div>
                        <span class="text-xs text-gray-500 font-medium">Arahkan kamera ke QR Code</span>
                        </div>
                    </div>
                    <div class="text-center mb-4">
                        <button type="button" id="pres-qr-camera-toggle" onclick="togglePresQrCamera()"
                                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition">
                            Aktifkan Kamera Scan
                        </button>
                        <p id="pres-qr-scan-status" class="text-xs text-gray-500 mt-2" aria-live="polite"></p>
                    </div>

                    <div class="space-y-2">
                        <label for="pres-qr-input" class="block text-xs font-semibold text-gray-700">Kode QR Kegiatan <span class="text-red-500">*</span></label>
                        <input type="text" name="qr_code" id="pres-qr-input" required
                               value="{{ old('qr_code') }}"
                               placeholder="Masukkan kode QR kegiatan"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm font-mono tracking-wider focus:ring-2 focus:ring-[#1A8A8A] focus:border-[#1A8A8A] uppercase">
                    </div>

                    @if($kegiatanAktif->isNotEmpty())
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <div class="text-[11px] font-semibold text-gray-500 mb-2">Pilih Cepat Kegiatan:</div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($kegiatanAktif as $keg)
                            <button type="button" onclick="document.getElementById('pres-qr-input').value = '{{ $keg->qr_code }}'"
                                    class="px-2.5 py-1 rounded-lg bg-teal-50 hover:bg-teal-100 text-[#1A6B6B] border border-teal-200 text-xs font-medium transition">
                                📌 {{ $keg->nama }} ({{ $keg->qr_code }})
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Right: Selfie Proof & Submit --}}
            <div class="lg:col-span-5 bg-white rounded-3xl p-8 border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-bold text-gray-900 mb-0.5">2. Foto Selfie Kehadiran</h3>
                            <p class="text-xs text-gray-400">Ambil foto selfie di lokasi acara sebagai bukti valid</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-teal-50 text-[#1A6B6B] border border-teal-200">
                            Langkah 2
                        </span>
                    </div>

                    {{-- Selfie Viewport / Preview --}}
                    <div class="w-full h-56 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center overflow-hidden mb-4 relative">
                        <video id="pres-selfie-video" class="hidden w-full h-full object-cover rounded-xl" playsinline></video>
                        <canvas id="pres-selfie-canvas" class="hidden"></canvas>
                        <img id="pres-selfie-preview" class="hidden w-full h-full object-cover rounded-xl" alt="Preview Foto Selfie">

                        <div id="pres-placeholder" class="text-center p-4">
                            <div class="w-12 h-12 bg-teal-50 text-[#1A6B6B] rounded-2xl flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold text-gray-700">Belum Ada Foto Selfie</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">Wajib menyertakan bukti foto wajah di lokasi</p>
                        </div>
                    </div>

                    {{-- Capture / Upload Action Buttons --}}
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <button type="button" id="pres-btn-selfie-cam" onclick="startPresSelfieCamera()"
                                class="py-2.5 px-3 bg-teal-50 hover:bg-teal-100 text-[#1A6B6B] border border-teal-200 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            </svg>
                            <span id="pres-btn-selfie-cam-text">Kamera Selfie</span>
                        </button>

                        <label for="pres_bukti_foto_file" class="py-2.5 px-3 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 cursor-pointer text-center">
                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Pilih Berkas</span>
                        </label>
                        <input type="file" id="pres_bukti_foto_file" name="bukti_foto" accept="image/*" class="hidden" onchange="previewPresFile(event)">
                    </div>

                    <div id="pres-file-chosen" class="hidden mb-4 p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span id="pres-file-chosen-text">Foto selfie siap dikirim.</span>
                    </div>

                    {{-- Snapshot button when camera is active --}}
                    <div id="pres-snapshot-action" class="hidden mb-4">
                        <button type="button" onclick="takePresSnapshot()"
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

                <button type="submit"
                        class="w-full bg-[#1A6B6B] hover:bg-[#155757] text-white font-bold py-3.5 px-6 rounded-xl transition duration-200 shadow-sm text-xs flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Simpan Presensi Sekarang
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Tab 2: Riwayat Presensi Kegiatan --}}
<div id="contentRiwayat" class="{{ $activeTab === 'riwayat' ? '' : 'hidden' }} bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h4 class="text-base font-bold text-gray-900">Riwayat Presensi Kegiatan</h4>
        <span class="text-xs font-bold px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full border border-emerald-200">
            Total: {{ $riwayatPresensi->count() }} Hadir
        </span>
    </div>
    @if($riwayatPresensi->isEmpty())
    <div class="p-12 text-center text-gray-400 text-sm">
        Belum ada catatan presensi kegiatan.
    </div>
    @else
    <div class="divide-y divide-gray-100">
        @foreach($riwayatPresensi as $presensi)
        <div class="p-5 flex items-center justify-between hover:bg-gray-50/50 transition">
            <div class="flex items-center gap-3.5">
                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">
                    ✓
                </div>
                <div>
                    <h5 class="text-sm font-bold text-gray-900">{{ $presensi->kegiatan->nama ?? 'Kegiatan BEM' }}</h5>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $presensi->waktu_presensi->copy()->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y') }} •
                        <span class="font-mono text-emerald-600">🕒 {{ $presensi->waktu_presensi->copy()->timezone('Asia/Jakarta')->format('H:i:s') }} WIB</span> • via QR Code
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if($presensi->bukti_foto)
                <a href="{{ $presensi->bukti_foto_url }}" target="_blank"
                   class="text-xs text-[#1A6B6B] hover:underline font-semibold flex items-center gap-1">
                    <span>📷 Bukti Selfie</span>
                </a>
                @endif
                <span class="px-3.5 py-1 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-full border border-emerald-200">
                    Hadir
                </span>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    let presQrStream = null;
    let presQrAnimationFrame = null;
    let presQrCanvas = document.createElement('canvas');
    let presQrLastScanAt = 0;
    let presSelfieStream = null;

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
            stopPresQrCamera();
            stopPresSelfieCamera();
        }
    }

    async function togglePresQrCamera() {
        const video = document.getElementById('pres-qr-camera');
        const placeholder = document.getElementById('pres-qr-placeholder');
        const button = document.getElementById('pres-qr-camera-toggle');

        if (presQrStream) {
            stopPresQrCamera();
            return;
        }

        if (!navigator.mediaDevices?.getUserMedia || !window.jsQR) {
            alert('Pemindai QR tidak tersedia di browser ini. Silakan masukkan kode QR secara manual.');
            return;
        }

        try {
            presQrStream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'environment' }
            });
            video.srcObject = presQrStream;
            await video.play();
            video.classList.remove('hidden');
            placeholder.classList.add('hidden');
            button.innerText = 'Matikan Kamera';
            document.getElementById('pres-qr-scan-status').innerText = 'Arahkan kamera ke QR Code kegiatan.';
            presQrAnimationFrame = requestAnimationFrame(scanPresQrFrame);
        } catch (error) {
            stopPresQrCamera();
            alert('Tidak dapat mengakses kamera perangkat. Pastikan izin kamera aktif atau masukkan kode QR secara manual.');
        }
    }

    function scanPresQrFrame(timestamp) {
        if (!presQrStream) return;

        if (timestamp - presQrLastScanAt >= 200) {
            const video = document.getElementById('pres-qr-camera');
            if (video.readyState === HTMLMediaElement.HAVE_ENOUGH_DATA) {
                presQrCanvas.width = video.videoWidth;
                presQrCanvas.height = video.videoHeight;
                const context = presQrCanvas.getContext('2d', { willReadFrequently: true });
                context.drawImage(video, 0, 0, presQrCanvas.width, presQrCanvas.height);
                const image = context.getImageData(0, 0, presQrCanvas.width, presQrCanvas.height);
                const result = window.jsQR(image.data, image.width, image.height, {
                    inversionAttempts: 'attemptBoth'
                });

                if (result?.data) {
                    const input = document.getElementById('pres-qr-input');
                    input.value = result.data.trim();
                    input.dispatchEvent(new Event('input', { bubbles: true }));
                    document.getElementById('pres-qr-scan-status').innerText = 'QR Code berhasil dipindai. Silakan unggah foto selfie.';
                    stopPresQrCamera();
                    return;
                }
            }

            presQrLastScanAt = timestamp;
        }

        presQrAnimationFrame = requestAnimationFrame(scanPresQrFrame);
    }

    function stopPresQrCamera() {
        if (presQrAnimationFrame !== null) {
            cancelAnimationFrame(presQrAnimationFrame);
            presQrAnimationFrame = null;
        }
        if (presQrStream) {
            presQrStream.getTracks().forEach(track => track.stop());
            presQrStream = null;
        }

        const video = document.getElementById('pres-qr-camera');
        if (!video) return;
        video.srcObject = null;
        video.classList.add('hidden');
        document.getElementById('pres-qr-placeholder').classList.remove('hidden');
        document.getElementById('pres-qr-camera-toggle').innerText = 'Aktifkan Kamera Scan';
    }

    async function startPresSelfieCamera() {
        const video = document.getElementById('pres-selfie-video');
        const placeholder = document.getElementById('pres-placeholder');
        const preview = document.getElementById('pres-selfie-preview');
        const snapshotAction = document.getElementById('pres-snapshot-action');
        const btnText = document.getElementById('pres-btn-selfie-cam-text');

        if (presSelfieStream) {
            stopPresSelfieCamera();
            if (!preview.src) {
                placeholder.classList.remove('hidden');
            }
        } else {
            try {
                presSelfieStream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: 'user' }
                });
                video.srcObject = presSelfieStream;
                await video.play();
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

    function stopPresSelfieCamera() {
        if (presSelfieStream) {
            presSelfieStream.getTracks().forEach(t => t.stop());
            presSelfieStream = null;
        }
        const video = document.getElementById('pres-selfie-video');
        if (video) {
            video.srcObject = null;
            video.classList.add('hidden');
        }
        const snapshotAction = document.getElementById('pres-snapshot-action');
        if (snapshotAction) snapshotAction.classList.add('hidden');
        const btnText = document.getElementById('pres-btn-selfie-cam-text');
        if (btnText) btnText.innerText = 'Kamera Selfie';
    }

    function takePresSnapshot() {
        const video = document.getElementById('pres-selfie-video');
        const canvas = document.getElementById('pres-selfie-canvas');
        const preview = document.getElementById('pres-selfie-preview');
        const placeholder = document.getElementById('pres-placeholder');
        const base64Input = document.getElementById('pres_bukti_foto_base64');
        const statusBox = document.getElementById('pres-file-chosen');
        const statusText = document.getElementById('pres-file-chosen-text');
        const snapshotAction = document.getElementById('pres-snapshot-action');

        document.getElementById('pres_bukti_foto_file').value = '';
        canvas.width = video.videoWidth || 640;
        canvas.height = video.videoHeight || 480;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataUrl = canvas.toDataURL('image/jpeg', 0.85);
        base64Input.value = dataUrl;
        preview.src = dataUrl;
        preview.classList.remove('hidden');
        if (placeholder) placeholder.classList.add('hidden');
        video.classList.add('hidden');

        if (presSelfieStream) {
            presSelfieStream.getTracks().forEach(t => t.stop());
            presSelfieStream = null;
        }

        const btnText = document.getElementById('pres-btn-selfie-cam-text');
        if (btnText) btnText.innerText = 'Ambil Ulang Selfie';
        if (snapshotAction) snapshotAction.classList.add('hidden');

        if (statusBox) statusBox.classList.remove('hidden');
        if (statusText) statusText.innerText = 'Foto selfie berhasil dijepret dari kamera webcam!';
    }

    function previewPresFile(event) {
        const file = event.target.files[0];
        if (!file) return;

        stopPresSelfieCamera();

        const preview = document.getElementById('pres-selfie-preview');
        const placeholder = document.getElementById('pres-placeholder');
        const fileBox = document.getElementById('pres-file-chosen');
        const statusText = document.getElementById('pres-file-chosen-text');

        document.getElementById('pres_bukti_foto_base64').value = '';
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
            if (fileBox) fileBox.classList.remove('hidden');
            if (statusText) statusText.innerText = `Berkas "${file.name}" siap diunggah sebagai bukti kehadiran.`;
        };
        reader.readAsDataURL(file);
    }

    function validatePresSubmit(event) {
        const fileInput = document.getElementById('pres_bukti_foto_file');
        const base64Input = document.getElementById('pres_bukti_foto_base64');

        // Jika kamera selfie masih aktif menyala saat tombol submit ditekan, otomatis jepret foto
        if (presSelfieStream && (!base64Input.value || base64Input.value.trim() === '')) {
            takePresSnapshot();
        }

        const hasFile = fileInput && fileInput.files && fileInput.files.length > 0;
        const hasBase64 = base64Input && base64Input.value && base64Input.value.trim().length > 0;

        if (!hasFile && !hasBase64) {
            event.preventDefault();
            alert('Wajib menyertakan foto selfie! Silakan klik "Jepret Foto Selfie Sekarang" atau gunakan "Pilih Berkas" terlebih dahulu.');
            return false;
        }

        return true;
    }

    window.addEventListener('beforeunload', () => {
        stopPresQrCamera();
        stopPresSelfieCamera();
    });
</script>
@endpush
