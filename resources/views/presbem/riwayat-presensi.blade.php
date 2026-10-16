@extends('layouts.presbem')

@section('title', 'Riwayat Presensi')
@section('page-title', 'Riwayat Presensi')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Riwayat Presensi</h2>
    <p class="text-sm text-gray-500 mt-1">Rekaman kehadiran piket dan kegiatan Anda</p>
</div>

{{-- Sub Tabs (Piket / Kegiatan) --}}
<div class="flex items-center gap-6 border-b border-gray-200/80 mb-6">
    <button type="button" class="pb-3 text-sm font-bold text-[#1A6B6B] border-b-2 border-[#1A6B6B]">
        Piket
    </button>
    <a href="{{ route('presbem.presensi-kegiatan') }}" class="pb-3 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
        Kegiatan
    </a>
</div>

{{-- 3 Top Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
        <div class="text-4xl font-black text-emerald-600 tracking-tight">6</div>
        <div class="text-xs font-semibold text-gray-500 mt-1">Hadir</div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
        <div class="text-4xl font-black text-red-600 tracking-tight">1</div>
        <div class="text-xs font-semibold text-gray-500 mt-1">Alpha</div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
        <div class="text-4xl font-black text-[#1A6B6B] tracking-tight">86%</div>
        <div class="text-xs font-semibold text-gray-500 mt-1">Kehadiran</div>
    </div>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50/70 text-gray-400 font-semibold uppercase tracking-wider border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3.5">Tanggal</th>
                    <th class="px-6 py-3.5">Shift</th>
                    <th class="px-6 py-3.5">Lokasi</th>
                    <th class="px-6 py-3.5 text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100/70 text-gray-700">
                @php
                    $piketData = [
                        ['tgl' => '22/09/2025', 'hari' => 'Senin', 'shift' => '08:00–10:00', 'lok' => 'Sekretariat', 'status' => 'Hadir'],
                        ['tgl' => '18/09/2025', 'hari' => 'Kamis', 'shift' => '08:00–10:00', 'lok' => 'Sekretariat', 'status' => 'Hadir'],
                        ['tgl' => '15/09/2025', 'hari' => 'Senin', 'shift' => '08:00–10:00', 'lok' => 'Sekretariat', 'status' => 'Hadir'],
                        ['tgl' => '11/09/2025', 'hari' => 'Kamis', 'shift' => '08:00–10:00', 'lok' => 'Sekretariat', 'status' => 'Alpha'],
                        ['tgl' => '08/09/2025', 'hari' => 'Senin', 'shift' => '08:00–10:00', 'lok' => 'Sekretariat', 'status' => 'Hadir'],
                        ['tgl' => '04/09/2025', 'hari' => 'Kamis', 'shift' => '08:00–10:00', 'lok' => 'Sekretariat', 'status' => 'Hadir'],
                        ['tgl' => '01/09/2025', 'hari' => 'Senin', 'shift' => '08:00–10:00', 'lok' => 'Sekretariat', 'status' => 'Hadir'],
                    ];
                @endphp

                @foreach($piketData as $p)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">{{ $p['tgl'] }}</div>
                        <div class="text-[11px] text-gray-400">{{ $p['hari'] }}</div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $p['shift'] }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $p['lok'] }}</td>
                    <td class="px-6 py-4 text-right">
                        @if($p['status'] === 'Hadir')
                        <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-full border border-emerald-200">
                            Hadir
                        </span>
                        @else
                        <span class="inline-block px-3 py-1 bg-red-50 text-red-600 font-bold text-xs rounded-full border border-red-200">
                            Alpha
                        </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
