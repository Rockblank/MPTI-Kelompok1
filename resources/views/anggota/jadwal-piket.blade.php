@extends('layouts.anggota')

@section('title', 'Jadwal Piket Saya')
@section('page-title', 'Jadwal Piket Saya')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Jadwal Piket Saya</h2>
    <p class="text-sm text-gray-500 mt-0.5">Riwayat dan jadwal piket Anda</p>
</div>

{{-- Stats Row --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center">
        <div class="text-3xl font-extrabold text-emerald-500 mb-1">6</div>
        <div class="text-xs text-gray-500 font-medium">Hadir</div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center">
        <div class="text-3xl font-extrabold text-red-500 mb-1">1</div>
        <div class="text-xs text-gray-500 font-medium">Alpha</div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center">
        <div class="text-3xl font-extrabold text-[#1A8A8A] mb-1">86%</div>
        <div class="text-xs text-gray-500 font-medium">Kehadiran</div>
    </div>
</div>

{{-- Piket List --}}
<div class="space-y-3">
    @php
    $piketList = [
        ['day'=>'Sen','date'=>'01','month'=>'09/2025','shift'=>'08:00 – 10:00','lokasi'=>'Sekretariat','file'=>'foto_piket_1.jpg','status'=>'hadir'],
        ['day'=>'Kam','date'=>'04','month'=>'09/2025','shift'=>'08:00 – 10:00','lokasi'=>'Sekretariat','file'=>'foto_piket_2.jpg','status'=>'hadir'],
        ['day'=>'Sen','date'=>'08','month'=>'09/2025','shift'=>'08:00 – 10:00','lokasi'=>'Sekretariat','file'=>'foto_piket_3.jpg','status'=>'hadir'],
        ['day'=>'Kam','date'=>'11','month'=>'09/2025','shift'=>'08:00 – 10:00','lokasi'=>'Sekretariat','file'=>null,'status'=>'alpha'],
        ['day'=>'Sen','date'=>'15','month'=>'09/2025','shift'=>'08:00 – 10:00','lokasi'=>'Sekretariat','file'=>'foto_piket_5.jpg','status'=>'hadir'],
        ['day'=>'Kam','date'=>'18','month'=>'09/2025','shift'=>'08:00 – 10:00','lokasi'=>'Sekretariat','file'=>'foto_piket_6.jpg','status'=>'hadir'],
        ['day'=>'Sen','date'=>'22','month'=>'09/2025','shift'=>'08:00 – 10:00','lokasi'=>'Sekretariat','file'=>'foto_piket_7.jpg','status'=>'hadir'],
        ['day'=>'Kam','date'=>'25','month'=>'09/2025','shift'=>'08:00 – 10:00','lokasi'=>'Sekretariat','file'=>null,'status'=>'akan-datang'],
        ['day'=>'Sen','date'=>'29','month'=>'09/2025','shift'=>'08:00 – 10:00','lokasi'=>'Sekretariat','file'=>null,'status'=>'akan-datang'],
    ];
    @endphp

    @foreach($piketList as $piket)
    <div class="bg-white rounded-2xl border {{ $piket['status'] === 'alpha' ? 'border-red-100' : 'border-gray-100' }} p-4 flex items-center gap-4">
        {{-- Date Block --}}
        <div class="text-center flex-shrink-0 w-12">
            <div class="text-xs font-medium text-gray-500">{{ $piket['day'] }}</div>
            <div class="text-2xl font-extrabold text-gray-800 leading-tight">{{ $piket['date'] }}</div>
            <div class="text-xs text-gray-400">{{ $piket['month'] }}</div>
        </div>

        {{-- Divider --}}
        <div class="w-px h-10 bg-gray-100 flex-shrink-0"></div>

        {{-- Info --}}
        <div class="flex-1 min-w-0">
            <div class="text-sm font-medium text-gray-800">{{ $piket['shift'] }}</div>
            <div class="text-xs text-gray-500 mt-0.5">{{ $piket['lokasi'] }}</div>
            @if($piket['file'])
            <div class="flex items-center gap-1 mt-1">
                <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                </svg>
                <span class="text-xs text-gray-400">{{ $piket['file'] }}</span>
            </div>
            @endif
        </div>

        {{-- Status / Actions --}}
        <div class="flex items-center gap-2 flex-shrink-0">
            @if($piket['status'] === 'hadir')
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-full px-3 py-1">Hadir</span>
            @elseif($piket['status'] === 'alpha')
                <span class="text-xs font-semibold text-red-600 bg-red-50 border border-red-200 rounded-full px-3 py-1">Alpha</span>
                <button class="bg-[#1A6B6B] hover:bg-[#157070] text-white text-xs font-semibold px-4 py-1.5 rounded-lg transition-all">Upload Bukti</button>
            @elseif($piket['status'] === 'akan-datang')
                <span class="text-xs font-semibold text-gray-600 bg-gray-50 border border-gray-200 rounded-full px-3 py-1">Akan Datang</span>
                <button class="bg-[#1A6B6B] hover:bg-[#157070] text-white text-xs font-semibold px-4 py-1.5 rounded-lg transition-all">Upload Bukti</button>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection
