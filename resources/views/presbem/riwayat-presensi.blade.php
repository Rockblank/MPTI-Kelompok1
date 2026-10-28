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
    <button type="button" onclick="switchPresensiTab('piket')" id="tabBtnPiket"
            class="pb-3 text-sm font-bold text-[#1A6B6B] border-b-2 border-[#1A6B6B] transition">
        Piket
    </button>
    <button type="button" onclick="switchPresensiTab('kegiatan')" id="tabBtnKegiatan"
            class="pb-3 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
        Kegiatan
    </button>
</div>

{{-- Panel Piket --}}
<div id="panel-piket">
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
</div>

{{-- Panel Kegiatan --}}
<div id="panel-kegiatan" class="hidden">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-gray-50/70 text-gray-400 font-semibold uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3.5">Kegiatan</th>
                        <th class="px-6 py-3.5">Waktu Presensi</th>
                        <th class="px-6 py-3.5 text-center">Bukti Selfie</th>
                        <th class="px-6 py-3.5 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/70 text-gray-700">
                    @if(isset($kegiatanRiwayat) && $kegiatanRiwayat->isNotEmpty())
                        @foreach($kegiatanRiwayat as $presensi)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900 text-sm">{{ $presensi->kegiatan->nama ?? 'Kegiatan BEM' }}</div>
                                <div class="text-[11px] text-gray-400">{{ $presensi->kegiatan->lokasi ?? 'Sekretariat' }}</div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                <div>{{ $presensi->waktu_presensi->copy()->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y') }}</div>
                                <div class="text-[11px] font-mono text-emerald-700 mt-0.5">🕒 {{ $presensi->waktu_presensi->copy()->timezone('Asia/Jakarta')->format('H:i:s') }} WIB</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($presensi->bukti_foto)
                                <a href="{{ $presensi->bukti_foto_url }}" target="_blank"
                                   class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-teal-50 hover:bg-teal-100 text-[#1A6B6B] border border-teal-200 text-xs font-medium transition">
                                    <span>📷</span>
                                    <span>Lihat Foto</span>
                                </a>
                                @else
                                <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-full border border-emerald-200">
                                    Hadir
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400">
                                Belum ada riwayat presensi kegiatan.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function switchPresensiTab(tab) {
        const btnPiket = document.getElementById('tabBtnPiket');
        const btnKegiatan = document.getElementById('tabBtnKegiatan');
        const panelPiket = document.getElementById('panel-piket');
        const panelKegiatan = document.getElementById('panel-kegiatan');

        if (tab === 'piket') {
            btnPiket.className = 'pb-3 text-sm font-bold text-[#1A6B6B] border-b-2 border-[#1A6B6B] transition';
            btnKegiatan.className = 'pb-3 text-sm font-medium text-gray-500 hover:text-gray-800 transition';
            panelPiket.classList.remove('hidden');
            panelKegiatan.classList.add('hidden');
        } else {
            btnKegiatan.className = 'pb-3 text-sm font-bold text-[#1A6B6B] border-b-2 border-[#1A6B6B] transition';
            btnPiket.className = 'pb-3 text-sm font-medium text-gray-500 hover:text-gray-800 transition';
            panelPiket.classList.add('hidden');
            panelKegiatan.classList.remove('hidden');
        }
    }
</script>
@endpush
@endsection
