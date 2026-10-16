@extends('layouts.anggota')

@section('title', 'Denda Saya')
@section('page-title', 'Denda Saya')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Denda Saya</h2>
    <p class="text-sm text-gray-500 mt-0.5">Riwayat dan pembayaran denda Anda</p>
</div>

{{-- Total Denda Banner --}}
<div class="bg-red-600 rounded-2xl p-6 mb-5 text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/3 translate-x-1/4 pointer-events-none"></div>
    <div class="flex items-start justify-between">
        <div>
            <p class="text-red-200 text-sm mb-2">Total Denda Belum Dibayar</p>
            <h3 class="text-4xl font-extrabold text-white">Rp25.000</h3>
            <p class="text-red-200 text-sm mt-1.5">1 denda aktif</p>
        </div>
        <div class="opacity-30 flex-shrink-0">
            <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.834-1.964-.834-2.732 0L3.07 16.5c-.77.833.193 2.5 1.732 2.5z" />
            </svg>
        </div>
    </div>
</div>

{{-- Denda List --}}
<div class="space-y-3">
    {{-- Belum Dibayar --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <div class="flex items-start justify-between mb-1">
            <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-gray-800">Denda Piket</span>
                <span class="text-xs font-semibold text-red-600 bg-red-50 border border-red-200 rounded-full px-2.5 py-0.5">Belum Dibayar</span>
            </div>
            <span class="text-base font-bold text-red-600">Rp25.000</span>
        </div>
        <p class="text-xs text-gray-500">Tidak hadir piket 11/09</p>
        <div class="flex items-center justify-between mt-3">
            <span class="text-xs text-gray-400">11/09/2025</span>
            <button id="btn-bayar-denda-1" class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-5 py-2 rounded-lg transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">
                Bayar
            </button>
        </div>
    </div>

    {{-- Lunas --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <div class="flex items-start justify-between mb-1">
            <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-gray-800">Denda Piket</span>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-full px-2.5 py-0.5">Lunas</span>
            </div>
            <span class="text-base font-bold text-gray-700">Rp25.000</span>
        </div>
        <p class="text-xs text-gray-500">Tidak hadir piket 28/08</p>
        <div class="flex items-center justify-between mt-3">
            <span class="text-xs text-gray-400">28/08/2025</span>
        </div>
    </div>

    {{-- Lunas Denda Kegiatan --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <div class="flex items-start justify-between mb-1">
            <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-gray-800">Denda Kegiatan</span>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-full px-2.5 py-0.5">Lunas</span>
            </div>
            <span class="text-base font-bold text-gray-700">Rp50.000</span>
        </div>
        <p class="text-xs text-gray-500">Alpha kegiatan wajib</p>
        <div class="flex items-center justify-between mt-3">
            <span class="text-xs text-gray-400">01/08/2025</span>
        </div>
    </div>
</div>
@endsection
