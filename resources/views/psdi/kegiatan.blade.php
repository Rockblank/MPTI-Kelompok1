@extends('layouts.psdi')

@section('title', 'Kegiatan')
@section('page-title', 'Kegiatan')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Kegiatan</h2>
        <p class="text-sm text-gray-500 mt-1">Manajemen kegiatan dan generate QR presensi</p>
    </div>
    <button type="button" onclick="openModalTambahKegiatan()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#1A6B6B] hover:bg-[#155757] text-white text-xs font-bold rounded-xl shadow-sm transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Kegiatan
    </button>
</div>

{{-- Filters --}}
<div class="inline-flex flex-wrap items-center gap-2 bg-gray-100/80 p-1.5 rounded-2xl text-xs font-semibold mb-6">
    <button type="button" onclick="filterKategori('all')" id="keg-all" class="keg-filter px-4 py-2 rounded-xl bg-[#1A6B6B] text-white transition shadow-sm">
        Semua
    </button>
    <button type="button" onclick="filterKategori('akan-datang')" id="keg-akan-datang" class="keg-filter px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition">
        Akan Datang
    </button>
    <button type="button" onclick="filterKategori('berlangsung')" id="keg-berlangsung" class="keg-filter px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition">
        Berlangsung
    </button>
    <button type="button" onclick="filterKategori('selesai')" id="keg-selesai" class="keg-filter px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition">
        Selesai
    </button>
</div>

{{-- Empty State (Shown when no events in category) --}}
<div id="kegiatanEmpty" class="hidden bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm max-w-md mx-auto my-12">
    <div class="w-16 h-16 rounded-2xl bg-gray-50 text-gray-400 flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
    </div>
    <h3 class="text-base font-bold text-gray-900 mb-1">Tidak Ada Kegiatan</h3>
    <p class="text-xs text-gray-500">Tidak ada kegiatan yang sedang berlangsung saat ini.</p>
</div>

{{-- 2x2 Grid of Event Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="kegiatanGrid">
    {{-- Card 1: Seminar Kepemimpinan --}}
    <div class="kegiatan-card bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between" data-category="selesai">
        <div>
            <div class="flex items-center justify-between gap-3 mb-2">
                <h3 class="text-base font-bold text-gray-900">Seminar Kepemimpinan</h3>
            </div>
            <span class="inline-block px-3 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold rounded-full mb-3">
                Selesai
            </span>
            <p class="text-xs text-gray-500 leading-relaxed mb-4">
                Seminar pengembangan jiwa kepemimpinan bagi anggota BEM
            </p>
            <div class="space-y-2 text-xs text-gray-600 mb-6">
                <div class="flex items-center gap-2.5">
                    <span class="text-gray-400">📅</span>
                    <span>20/09/2025</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <span class="text-gray-400">📍</span>
                    <span>Aula FILKOM</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <span class="text-gray-400">👥</span>
                    <span>28/30 hadir</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-3 pt-2">
            <button type="button" onclick="openDetailKegiatan('Seminar Kepemimpinan', 'Selesai', 'Seminar pengembangan jiwa kepemimpinan bagi anggota BEM', '20/09/2025', 'Aula FILKOM', '28/30 hadir')"
                    class="w-full py-2.5 px-4 rounded-xl border border-gray-200 text-xs font-bold text-gray-700 hover:bg-gray-50 transition text-center">
                Detail
            </button>
            <button type="button" onclick="openQrModal('Seminar Kepemimpinan', 'SEMINAR-KPM-2025')"
                    class="w-full py-2.5 px-4 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-bold text-gray-700 transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                Lihat QR
            </button>
        </div>
    </div>

    {{-- Card 2: Workshop UI/UX Design --}}
    <div class="kegiatan-card bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between" data-category="selesai">
        <div>
            <div class="flex items-center justify-between gap-3 mb-2">
                <h3 class="text-base font-bold text-gray-900">Workshop UI/UX Design</h3>
            </div>
            <span class="inline-block px-3 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold rounded-full mb-3">
                Selesai
            </span>
            <p class="text-xs text-gray-500 leading-relaxed mb-4">
                Pelatihan desain antarmuka untuk anggota divisi PSDI
            </p>
            <div class="space-y-2 text-xs text-gray-600 mb-6">
                <div class="flex items-center gap-2.5">
                    <span class="text-gray-400">📅</span>
                    <span>15/09/2025</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <span class="text-gray-400">📍</span>
                    <span>Lab Komputer 301</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <span class="text-gray-400">👥</span>
                    <span>22/25 hadir</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-3 pt-2">
            <button type="button" onclick="openDetailKegiatan('Workshop UI/UX Design', 'Selesai', 'Pelatihan desain antarmuka untuk anggota divisi PSDI', '15/09/2025', 'Lab Komputer 301', '22/25 hadir')"
                    class="w-full py-2.5 px-4 rounded-xl border border-gray-200 text-xs font-bold text-gray-700 hover:bg-gray-50 transition text-center">
                Detail
            </button>
            <button type="button" onclick="openQrModal('Workshop UI/UX Design', 'WORKSHOP-UIUX-2025')"
                    class="w-full py-2.5 px-4 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-bold text-gray-700 transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                Lihat QR
            </button>
        </div>
    </div>

    {{-- Card 3: Pelatihan Public Speaking --}}
    <div class="kegiatan-card bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between" data-category="akan-datang">
        <div>
            <div class="flex items-center justify-between gap-3 mb-2">
                <h3 class="text-base font-bold text-gray-900">Pelatihan Public Speaking</h3>
            </div>
            <span class="inline-block px-3 py-0.5 bg-teal-50 text-[#1A6B6B] border border-teal-200 text-xs font-bold rounded-full mb-3">
                Akan Datang
            </span>
            <p class="text-xs text-gray-500 leading-relaxed mb-4">
                Pelatihan berbicara di depan umum untuk semua anggota
            </p>
            <div class="space-y-2 text-xs text-gray-600 mb-6">
                <div class="flex items-center gap-2.5">
                    <span class="text-gray-400">📅</span>
                    <span>28/09/2025</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <span class="text-gray-400">📍</span>
                    <span>Ruang Rapat BEM</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <span class="text-gray-400">👥</span>
                    <span>20 peserta terdaftar</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-3 pt-2">
            <button type="button" onclick="openDetailKegiatan('Pelatihan Public Speaking', 'Akan Datang', 'Pelatihan berbicara di depan umum untuk semua anggota', '28/09/2025', 'Ruang Rapat BEM', '20 peserta terdaftar')"
                    class="w-full py-2.5 px-4 rounded-xl border border-gray-200 text-xs font-bold text-gray-700 hover:bg-gray-50 transition text-center">
                Detail
            </button>
            <button type="button" onclick="openQrModal('Pelatihan Public Speaking', 'PUBLIC-SPEAKING-2025')"
                    class="w-full py-2.5 px-4 rounded-xl bg-[#1A6B6B] hover:bg-[#155757] text-xs font-bold text-white transition flex items-center justify-center gap-2 shadow-sm">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                Generate QR
            </button>
        </div>
    </div>

    {{-- Card 4: FGD Roadmap BEM 2026 --}}
    <div class="kegiatan-card bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between" data-category="akan-datang">
        <div>
            <div class="flex items-center justify-between gap-3 mb-2">
                <h3 class="text-base font-bold text-gray-900">FGD Roadmap BEM 2026</h3>
            </div>
            <span class="inline-block px-3 py-0.5 bg-teal-50 text-[#1A6B6B] border border-teal-200 text-xs font-bold rounded-full mb-3">
                Akan Datang
            </span>
            <p class="text-xs text-gray-500 leading-relaxed mb-4">
                Focus Group Discussion perencanaan program kerja 2026
            </p>
            <div class="space-y-2 text-xs text-gray-600 mb-6">
                <div class="flex items-center gap-2.5">
                    <span class="text-gray-400">📅</span>
                    <span>30/09/2025</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <span class="text-gray-400">📍</span>
                    <span>Sekretariat BEM</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <span class="text-gray-400">👥</span>
                    <span>32 peserta terdaftar</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-3 pt-2">
            <button type="button" onclick="openDetailKegiatan('FGD Roadmap BEM 2026', 'Akan Datang', 'Focus Group Discussion perencanaan program kerja 2026', '30/09/2025', 'Sekretariat BEM', '32 peserta terdaftar')"
                    class="w-full py-2.5 px-4 rounded-xl border border-gray-200 text-xs font-bold text-gray-700 hover:bg-gray-50 transition text-center">
                Detail
            </button>
            <button type="button" onclick="openQrModal('FGD Roadmap BEM 2026', 'FGD-ROADMAP-2026')"
                    class="w-full py-2.5 px-4 rounded-xl bg-[#1A6B6B] hover:bg-[#155757] text-xs font-bold text-white transition flex items-center justify-center gap-2 shadow-sm">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                Generate QR
            </button>
        </div>
    </div>
</div>
@endsection

@push('modals')
{{-- Modal Tambah Kegiatan --}}
<div id="modalTambahKegiatan" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden border border-gray-100 animate-in fade-in zoom-in-95 duration-200">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-gray-900">Buat Kegiatan Baru</h3>
            <button type="button" onclick="closeModalTambahKegiatan()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form onsubmit="handleSimpanKegiatan(event)" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Kegiatan</label>
                <input type="text" required placeholder="Contoh: Diskusi Terbuka Organisasi"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B]">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Deskripsi Kegiatan</label>
                <textarea rows="2" placeholder="Jelaskan ringkasan tujuan kegiatan..."
                          class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B] resize-none"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Tanggal Pelaksanaan</label>
                    <input type="date" required value="{{ date('Y-m-d') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B]">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Target Kuota Peserta</label>
                    <input type="number" required value="30"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Lokasi Acara</label>
                <input type="text" required placeholder="Contoh: Gedung F FILKOM Lantai 2"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B]">
            </div>

            <div class="grid grid-cols-2 gap-3 pt-3">
                <button type="button" onclick="closeModalTambahKegiatan()"
                        class="w-full py-2.5 px-4 rounded-xl border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="w-full py-2.5 px-4 rounded-xl bg-[#1A6B6B] hover:bg-[#155757] text-xs font-bold text-white transition shadow-sm">
                    Simpan & Buat QR
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Detail Kegiatan --}}
<div id="modalDetailKegiatan" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden border border-gray-100 animate-in fade-in zoom-in-95 duration-200">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-gray-900">Detail Kegiatan</h3>
            <button type="button" onclick="closeDetailKegiatan()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-6 space-y-4 text-xs">
            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 space-y-3">
                <div>
                    <span class="text-gray-400">Nama Acara</span>
                    <h4 id="detNama" class="text-base font-bold text-gray-900 mt-0.5">-</h4>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-gray-400">Status:</span>
                    <span id="detStatusBadge" class="font-bold px-2.5 py-0.5 rounded-full text-[11px]">-</span>
                </div>
                <div>
                    <span class="text-gray-400">Deskripsi</span>
                    <p id="detDesc" class="text-gray-700 mt-0.5">-</p>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-2 border-t border-gray-200/60">
                    <div>
                        <span class="text-gray-400">Tanggal</span>
                        <p id="detTanggal" class="font-bold text-gray-800 mt-0.5">-</p>
                    </div>
                    <div>
                        <span class="text-gray-400">Lokasi</span>
                        <p id="detLokasi" class="font-bold text-gray-800 mt-0.5">-</p>
                    </div>
                </div>
                <div>
                    <span class="text-gray-400">Kehadiran Peserta</span>
                    <p id="detPeserta" class="font-extrabold text-[#1A6B6B] text-sm mt-0.5">-</p>
                </div>
            </div>

            <button type="button" onclick="closeDetailKegiatan()"
                    class="w-full py-2.5 px-4 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-bold text-gray-700 transition">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- Modal QR Code Presensi --}}
<div id="modalQrCode" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden border border-gray-100 animate-in fade-in zoom-in-95 duration-200 text-center">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-gray-900">QR Code Presensi</h3>
            <button type="button" onclick="closeQrModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-6 space-y-4">
            <div>
                <h4 id="qrKegiatanJudul" class="text-sm font-bold text-gray-900">-</h4>
                <p class="text-[11px] text-gray-400 mt-0.5">Scan untuk konfirmasi kehadiran kegiatan</p>
            </div>

            {{-- QR Container --}}
            <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl p-6 flex flex-col items-center justify-center">
                <div class="w-48 h-48 bg-white p-3 rounded-2xl shadow-sm border border-gray-200 flex items-center justify-center">
                    {{-- Clean visual SVG QR pattern --}}
                    <svg class="w-full h-full text-gray-900" viewBox="0 0 100 100" fill="currentColor">
                        <rect x="10" y="10" width="24" height="24" rx="3" fill="#1A6B6B" />
                        <rect x="14" y="14" width="16" height="16" rx="2" fill="white" />
                        <rect x="18" y="18" width="8" height="8" rx="1" fill="#1A6B6B" />

                        <rect x="66" y="10" width="24" height="24" rx="3" fill="#1A6B6B" />
                        <rect x="70" y="14" width="16" height="16" rx="2" fill="white" />
                        <rect x="74" y="18" width="8" height="8" rx="1" fill="#1A6B6B" />

                        <rect x="10" y="66" width="24" height="24" rx="3" fill="#1A6B6B" />
                        <rect x="14" y="70" width="16" height="16" rx="2" fill="white" />
                        <rect x="18" y="74" width="8" height="8" rx="1" fill="#1A6B6B" />

                        <!-- Dots matrix pattern -->
                        <rect x="38" y="12" width="6" height="6" rx="1"/>
                        <rect x="48" y="16" width="6" height="6" rx="1"/>
                        <rect x="40" y="26" width="6" height="6" rx="1"/>
                        <rect x="52" y="26" width="6" height="6" rx="1"/>
                        <rect x="12" y="42" width="6" height="6" rx="1"/>
                        <rect x="22" y="48" width="6" height="6" rx="1"/>
                        <rect x="34" y="40" width="8" height="8" rx="1" fill="#1A6B6B"/>
                        <rect x="46" y="44" width="6" height="6" rx="1"/>
                        <rect x="56" y="38" width="6" height="6" rx="1"/>
                        <rect x="68" y="44" width="8" height="8" rx="1"/>
                        <rect x="80" y="40" width="6" height="6" rx="1"/>
                        <rect x="38" y="56" width="6" height="6" rx="1"/>
                        <rect x="48" y="60" width="8" height="8" rx="1" fill="#1A6B6B"/>
                        <rect x="60" y="56" width="6" height="6" rx="1"/>
                        <rect x="40" y="74" width="6" height="6" rx="1"/>
                        <rect x="52" y="76" width="6" height="6" rx="1"/>
                        <rect x="66" y="70" width="8" height="8" rx="1"/>
                        <rect x="78" y="76" width="6" height="6" rx="1"/>
                        <rect x="68" y="84" width="6" height="6" rx="1"/>
                        <rect x="80" y="86" width="6" height="6" rx="1"/>
                    </svg>
                </div>
                <div id="qrCodeText" class="text-[11px] font-mono text-gray-400 mt-3 uppercase tracking-wider">-</div>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-2">
                <button type="button" onclick="alert('QR Code berhasil diunduh!')"
                        class="w-full py-2.5 px-4 rounded-xl border border-gray-200 text-xs font-bold text-gray-700 hover:bg-gray-50 transition">
                    Unduh QR
                </button>
                <button type="button" onclick="closeQrModal()"
                        class="w-full py-2.5 px-4 rounded-xl bg-[#1A6B6B] hover:bg-[#155757] text-xs font-bold text-white transition shadow-sm">
                    Selesai
                </button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function openModalTambahKegiatan() {
        document.getElementById('modalTambahKegiatan').classList.remove('hidden');
    }
    function closeModalTambahKegiatan() {
        document.getElementById('modalTambahKegiatan').classList.add('hidden');
    }
    function handleSimpanKegiatan(e) {
        e.preventDefault();
        alert('Kegiatan baru dan QR Code berhasil dibuat!');
        closeModalTambahKegiatan();
    }

    function openDetailKegiatan(nama, status, desc, tgl, lok, peserta) {
        document.getElementById('detNama').innerText = nama;
        document.getElementById('detDesc').innerText = desc;
        document.getElementById('detTanggal').innerText = tgl;
        document.getElementById('detLokasi').innerText = lok;
        document.getElementById('detPeserta').innerText = peserta;

        const badge = document.getElementById('detStatusBadge');
        badge.innerText = status;
        if (status === 'Selesai') {
            badge.className = 'font-bold px-2.5 py-0.5 rounded-full text-[11px] bg-emerald-50 text-emerald-700 border border-emerald-200';
        } else {
            badge.className = 'font-bold px-2.5 py-0.5 rounded-full text-[11px] bg-teal-50 text-[#1A6B6B] border border-teal-200';
        }

        document.getElementById('modalDetailKegiatan').classList.remove('hidden');
    }

    function closeDetailKegiatan() {
        document.getElementById('modalDetailKegiatan').classList.add('hidden');
    }

    function openQrModal(judul, code) {
        document.getElementById('qrKegiatanJudul').innerText = judul;
        document.getElementById('qrCodeText').innerText = code;
        document.getElementById('modalQrCode').classList.remove('hidden');
    }

    function closeQrModal() {
        document.getElementById('modalQrCode').classList.add('hidden');
    }

    function filterKategori(kategori) {
        const cards = document.querySelectorAll('.kegiatan-card');
        const buttons = document.querySelectorAll('.keg-filter');
        const grid = document.getElementById('kegiatanGrid');
        const empty = document.getElementById('kegiatanEmpty');

        buttons.forEach(b => {
            b.className = 'keg-filter px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition';
        });

        const activeBtn = document.getElementById('keg-' + kategori);
        if (activeBtn) {
            activeBtn.className = 'keg-filter px-4 py-2 rounded-xl bg-[#1A6B6B] text-white transition shadow-sm';
        }

        let visibleCount = 0;
        cards.forEach(c => {
            if (kategori === 'all') {
                c.style.display = 'flex';
                visibleCount++;
            } else if (c.dataset.category === kategori) {
                c.style.display = 'flex';
                visibleCount++;
            } else {
                c.style.display = 'none';
            }
        });

        if (visibleCount === 0) {
            grid.classList.add('hidden');
            empty.classList.remove('hidden');
        } else {
            grid.classList.remove('hidden');
            empty.classList.add('hidden');
        }
    }

    // Check if query param ?tambah=true
    if (new URLSearchParams(window.location.search).get('tambah') === 'true') {
        openModalTambahKegiatan();
    }
</script>
@endpush
