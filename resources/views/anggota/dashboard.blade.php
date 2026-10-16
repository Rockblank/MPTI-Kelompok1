@extends('layouts.anggota')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Dashboard Saya</h2>
    <p class="text-sm text-gray-500 mt-0.5">Ringkasan aktivitas dan status kewajiban</p>
</div>

{{-- Profile Hero Card --}}
<div class="bg-[#1A6B6B] rounded-2xl p-6 mb-5 text-white relative overflow-hidden">
    {{-- Decorative circle --}}
    <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -translate-y-1/3 translate-x-1/4 pointer-events-none"></div>
    <div class="absolute bottom-0 right-20 w-32 h-32 bg-white/5 rounded-full translate-y-1/3 pointer-events-none"></div>

    <div class="flex items-center gap-4 mb-6">
        <div class="w-12 h-12 bg-[#2A8A8A] rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
            BS
        </div>
        <div>
            <h3 class="text-lg font-bold text-white">Budi Santoso</h3>
            <p class="text-[#5AADAD] text-sm font-medium">215150700111003</p>
            <p class="text-white/70 text-xs">Anggota Biasa · BEM FILKOM UB</p>
        </div>
    </div>

    <div class="border-t border-white/20 pt-5 grid grid-cols-3 divide-x divide-white/20">
        <div class="text-center px-4">
            <div class="text-2xl font-bold text-white">Sep</div>
            <div class="text-white/60 text-xs mt-0.5">Bulan Ini</div>
        </div>
        <div class="text-center px-4">
            <div class="text-2xl font-bold text-white">87%</div>
            <div class="text-white/60 text-xs mt-0.5">Kehadiran</div>
        </div>
        <div class="text-center px-4">
            <div class="text-2xl font-bold text-white">Lunas</div>
            <div class="text-white/60 text-xs mt-0.5">Status Kas</div>
        </div>
    </div>
</div>

{{-- Status Cards Row --}}
<div class="grid grid-cols-2 gap-4 mb-5">
    {{-- Status Kas --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-medium text-gray-600">Status Kas</span>
            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-full px-2.5 py-0.5">Lunas</span>
        </div>
        <div class="text-2xl font-bold text-emerald-600">Rp50.000</div>
        <div class="text-xs text-gray-400 mt-1">Dibayar 05/09/2025</div>
    </div>

    {{-- Denda Aktif --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-medium text-gray-600">Denda Aktif</span>
            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-full px-2.5 py-0.5">Lunas</span>
        </div>
        <div class="text-2xl font-bold text-gray-300">Rp0</div>
        <div class="text-xs text-gray-400 mt-1">Tidak ada denda</div>
    </div>
</div>

{{-- Jadwal Piket --}}
<div class="bg-white rounded-2xl p-5 border border-gray-100 mb-5">
    <h3 class="text-sm font-semibold text-gray-800 mb-4">Jadwal Piket Minggu Ini</h3>
    <div class="space-y-3">
        {{-- Hadir item --}}
        <div class="bg-emerald-50 rounded-xl p-4 flex items-center justify-between">
            <div>
                <div class="text-sm font-semibold text-emerald-700">Senin, 22/09</div>
                <div class="text-xs text-gray-500 mt-0.5">08:00 – 10:00 · Sekretariat</div>
            </div>
            <span class="flex items-center gap-1.5 text-xs font-semibold text-emerald-600 bg-emerald-600 text-white rounded-full px-3 py-1.5">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                Hadir
            </span>
        </div>
        {{-- Akan Datang item --}}
        <div class="bg-white border border-gray-100 rounded-xl p-4 flex items-center justify-between">
            <div>
                <div class="text-sm font-semibold text-[#1A8A8A]">Kamis, 25/09</div>
                <div class="text-xs text-gray-500 mt-0.5">08:00 – 10:00 · Sekretariat</div>
            </div>
            <span class="text-xs font-semibold text-white bg-[#1A6B6B] rounded-full px-3 py-1.5">
                Akan Datang
            </span>
        </div>
    </div>
</div>

{{-- Kegiatan Mendatang --}}
<div class="bg-white rounded-2xl p-5 border border-gray-100">
    <h3 class="text-sm font-semibold text-gray-800 mb-4">Kegiatan Mendatang</h3>
    <div class="space-y-3">
        <div class="flex items-center gap-3.5">
            <div class="w-8 h-8 bg-[#F0EDE8] rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-[#1A8A8A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <div class="text-sm font-semibold text-gray-800">Pelatihan Public Speaking</div>
                <div class="text-xs text-gray-400">28/09/2025 · Ruang Rapat BEM</div>
            </div>
        </div>
        <div class="border-t border-gray-50"></div>
        <div class="flex items-center gap-3.5">
            <div class="w-8 h-8 bg-[#F0EDE8] rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-[#1A8A8A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <div class="text-sm font-semibold text-gray-800">FGD Roadmap BEM 2026</div>
                <div class="text-xs text-gray-400">30/09/2025 · Sekretariat BEM</div>
            </div>
        </div>
    </div>
</div>
@endsection
