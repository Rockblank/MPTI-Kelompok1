@extends('layouts.psdi')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard PSDI</h2>
    <p class="text-sm text-gray-500 mt-1">Manajemen kegiatan dan presensi BEM FILKOM UB</p>
</div>

{{-- 4 Metric Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
    {{-- Card 1: Total Kegiatan --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center text-xl mb-3">
            📅
        </div>
        <div class="text-3xl font-black text-gray-900 tracking-tight">8</div>
        <div class="text-sm font-bold text-gray-700 mt-1">Total Kegiatan</div>
        <div class="text-xs text-gray-400 mt-0.5">Tahun 2025</div>
    </div>

    {{-- Card 2: Kegiatan Aktif --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center mb-3">
            <span class="w-4 h-4 rounded-full bg-red-500 ring-4 ring-red-100"></span>
        </div>
        <div class="text-3xl font-black text-red-600 tracking-tight">2</div>
        <div class="text-sm font-bold text-gray-700 mt-1">Kegiatan Aktif</div>
        <div class="text-xs text-gray-400 mt-0.5">Sedang berlangsung</div>
    </div>

    {{-- Card 3: Rata-rata Kehadiran --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-3">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="text-3xl font-black text-emerald-600 tracking-tight">85%</div>
        <div class="text-sm font-bold text-gray-700 mt-1">Rata-rata Kehadiran</div>
        <div class="text-xs text-gray-400 mt-0.5">Semua kegiatan</div>
    </div>

    {{-- Card 4: Peserta Terdaftar --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-600 mb-3">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>
        <div class="text-3xl font-black text-gray-900 tracking-tight">156</div>
        <div class="text-sm font-bold text-gray-700 mt-1">Peserta Terdaftar</div>
        <div class="text-xs text-gray-400 mt-0.5">Akumulatif</div>
    </div>
</div>

{{-- Kegiatan Terbaru Card --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-base font-bold text-gray-900">Kegiatan Terbaru</h3>
        <a href="{{ route('psdi.kegiatan') }}" class="text-xs font-semibold text-[#1A6B6B] hover:underline flex items-center gap-1">
            <span>Lihat semua</span>
            <span>&rarr;</span>
        </a>
    </div>

    <div class="divide-y divide-gray-100">
        {{-- Item 1 --}}
        <div class="py-4 flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-[#1A6B6B] flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900">Seminar Kepemimpinan</h4>
                    <p class="text-xs text-gray-400 mt-0.5">20/09/2025 · 30 peserta terdaftar</p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-sm font-extrabold text-gray-900">28/30</div>
                <div class="text-[11px] text-gray-400">hadir</div>
            </div>
        </div>

        {{-- Item 2 --}}
        <div class="py-4 flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-[#1A6B6B] flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900">Workshop UI/UX Design</h4>
                    <p class="text-xs text-gray-400 mt-0.5">15/09/2025 · 25 peserta terdaftar</p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-sm font-extrabold text-gray-900">22/25</div>
                <div class="text-[11px] text-gray-400">hadir</div>
            </div>
        </div>

        {{-- Item 3 --}}
        <div class="py-4 flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-[#1A6B6B] flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900">Pelatihan Public Speaking</h4>
                    <p class="text-xs text-gray-400 mt-0.5">28/09/2025 · 20 peserta terdaftar</p>
                </div>
            </div>
            <div>
                <span class="inline-block px-3 py-1 bg-teal-50 text-[#1A6B6B] border border-teal-200 text-xs font-bold rounded-full">
                    Upcoming
                </span>
            </div>
        </div>

        {{-- Item 4 --}}
        <div class="py-4 flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-[#1A6B6B] flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900">FGD Roadmap BEM 2026</h4>
                    <p class="text-xs text-gray-400 mt-0.5">30/09/2025 · 32 peserta terdaftar</p>
                </div>
            </div>
            <div>
                <span class="inline-block px-3 py-1 bg-teal-50 text-[#1A6B6B] border border-teal-200 text-xs font-bold rounded-full">
                    Upcoming
                </span>
            </div>
        </div>
    </div>
</div>

{{-- Bottom 2 Action / Navigation Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Card 1: Buat Kegiatan Baru --}}
    <a href="{{ route('psdi.kegiatan') }}?tambah=true"
       class="bg-[#1A6B6B] hover:bg-[#155757] text-white rounded-2xl p-6 shadow-sm transition-all duration-200 group block">
        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
        </div>
        <h4 class="text-base font-bold mb-1">Buat Kegiatan Baru</h4>
        <p class="text-xs text-white/70">Tambah & generate QR presensi</p>
    </a>

    {{-- Card 2: Rekap Presensi --}}
    <a href="{{ route('psdi.rekap-presensi') }}"
       class="bg-white hover:bg-gray-50/80 border border-gray-100 rounded-2xl p-6 shadow-sm transition-all duration-200 group block">
        <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-600 mb-4 group-hover:scale-105 transition-transform">
            <svg class="w-6 h-6 text-[#1A6B6B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
        <h4 class="text-base font-bold text-gray-900 mb-1">Rekap Presensi</h4>
        <p class="text-xs text-gray-500">Lihat semua data kehadiran</p>
    </a>
</div>
@endsection
