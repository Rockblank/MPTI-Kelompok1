@extends('layouts.anggota')

@section('title', 'Bayar Kas')
@section('page-title', 'Bayar Kas')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Bayar Kas</h2>
    <p class="text-sm text-gray-500 mt-0.5">Pembayaran kas bulanan anggota</p>
</div>

{{-- Progress Banner --}}
<div class="bg-[#1A6B6B] rounded-2xl p-6 mb-6 text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
    <div class="flex items-start justify-between mb-4">
        <div>
            <p class="text-white/70 text-sm mb-1">Status Pembayaran</p>
            <h3 class="text-3xl font-extrabold text-white">7/8 Bulan Lunas</h3>
        </div>
        <div class="w-16 h-16 rounded-full border-4 border-white/30 flex items-center justify-center flex-shrink-0 relative">
            <svg class="absolute inset-0 w-full h-full -rotate-90" viewBox="0 0 64 64">
                <circle cx="32" cy="32" r="26" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="4"/>
                <circle cx="32" cy="32" r="26" fill="none" stroke="white" stroke-width="4"
                    stroke-dasharray="163.4" stroke-dashoffset="19.6" stroke-linecap="round"/>
            </svg>
            <span class="text-white font-bold text-sm relative z-10">88%</span>
        </div>
    </div>
    <div class="bg-white/20 rounded-full h-2.5 overflow-hidden">
        <div class="bg-white h-full rounded-full" style="width: 87.5%"></div>
    </div>
</div>

{{-- Tagihan Belum Dibayar --}}
<div class="mb-5">
    <h3 class="text-sm font-semibold text-gray-700 mb-3">Tagihan Belum Dibayar</h3>
    <div class="bg-white rounded-2xl border border-red-100 p-4 flex items-center gap-4">
        <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <div class="font-semibold text-gray-800 text-sm">Oktober 2025</div>
            <div class="text-xs text-gray-400 mt-0.5">Kas Bulanan BEM FILKOM UB</div>
        </div>
        <div class="flex items-center gap-3 flex-shrink-0">
            <span class="text-base font-bold text-red-600">Rp50.000</span>
            <button id="btn-bayar-oktober" class="bg-[#1A6B6B] hover:bg-[#157070] text-white text-sm font-semibold px-5 py-2 rounded-lg transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">
                Bayar
            </button>
        </div>
    </div>
</div>

{{-- Riwayat Pembayaran --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-50">
        <h3 class="text-sm font-semibold text-gray-800">Riwayat Pembayaran</h3>
    </div>
    <div class="divide-y divide-gray-50">
        @php
        $payments = [
            ['bulan' => 'Maret 2025',    'tanggal' => '05/03/2025'],
            ['bulan' => 'April 2025',    'tanggal' => '04/04/2025'],
            ['bulan' => 'Mei 2025',      'tanggal' => '05/05/2025'],
            ['bulan' => 'Juni 2025',     'tanggal' => '03/06/2025'],
            ['bulan' => 'Juli 2025',     'tanggal' => '07/07/2025'],
            ['bulan' => 'Agustus 2025',  'tanggal' => '04/08/2025'],
            ['bulan' => 'September 2025','tanggal' => '05/09/2025'],
        ];
        @endphp

        @foreach($payments as $payment)
        <div class="px-5 py-4 flex items-center gap-3">
            <div class="w-7 h-7 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-medium text-gray-800">{{ $payment['bulan'] }}</div>
                <div class="text-xs text-gray-400 mt-0.5">{{ $payment['tanggal'] }}</div>
            </div>
            <div class="text-right flex-shrink-0">
                <div class="text-sm font-semibold text-gray-800">Rp50.000</div>
                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 border border-emerald-100 rounded-full px-2 py-0.5 mt-0.5 inline-block">Lunas</span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
