@extends('layouts.presbem')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard Ketua BEM</h2>
    <p class="text-sm text-gray-500 mt-1">Pantau kondisi kas dan presensi secara keseluruhan</p>
</div>

{{-- 4 Metric Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
    {{-- Card 1: Saldo Kas BEM --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="text-2xl lg:text-3xl font-extrabold text-[#1A6B6B] tracking-tight">Rp28.450.000</div>
        <div class="text-sm font-bold text-gray-800 mt-1">Saldo Kas BEM</div>
        <div class="text-xs text-gray-400 mt-0.5">September 2025</div>
    </div>

    {{-- Card 2: Anggota Lunas Kas --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="text-2xl lg:text-3xl font-extrabold text-[#1A6B6B] tracking-tight">24 / 32</div>
        <div class="text-sm font-bold text-gray-800 mt-1">Anggota Lunas Kas</div>
        <div class="text-xs text-gray-400 mt-0.5">75% kepatuhan</div>
    </div>

    {{-- Card 3: Denda Beredar --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="text-2xl lg:text-3xl font-extrabold text-red-600 tracking-tight">Rp250.000</div>
        <div class="text-sm font-bold text-gray-800 mt-1">Denda Beredar</div>
        <div class="text-xs text-gray-400 mt-0.5">7 anggota</div>
    </div>

    {{-- Card 4: Kehadiran Rata-rata --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="text-2xl lg:text-3xl font-extrabold text-[#1A6B6B] tracking-tight">88%</div>
        <div class="text-sm font-bold text-gray-800 mt-1">Kehadiran Rata-rata</div>
        <div class="text-xs text-gray-400 mt-0.5">Piket & Kegiatan</div>
    </div>
</div>

{{-- 4 Quick Navigation Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
    <a href="{{ route('presbem.rekap-kas') }}"
       class="bg-white hover:bg-gray-50/80 rounded-2xl p-5 border border-gray-100 shadow-sm transition group block">
        <div class="text-2xl mb-2 group-hover:scale-110 transition-transform">📊</div>
        <div class="text-sm font-bold text-gray-900">Rekap Kas</div>
        <div class="text-xs text-gray-400 mt-0.5">Laporan keuangan</div>
    </a>

    <a href="{{ route('presbem.rekap-presensi') }}"
       class="bg-white hover:bg-gray-50/80 rounded-2xl p-5 border border-gray-100 shadow-sm transition group block">
        <div class="text-2xl mb-2 group-hover:scale-110 transition-transform">📋</div>
        <div class="text-sm font-bold text-gray-900">Rekap Presensi</div>
        <div class="text-xs text-gray-400 mt-0.5">Kehadiran anggota</div>
    </a>

    <a href="{{ route('presbem.bayar-kas') }}"
       class="bg-white hover:bg-gray-50/80 rounded-2xl p-5 border border-gray-100 shadow-sm transition group block">
        <div class="text-2xl mb-2 group-hover:scale-110 transition-transform">💳</div>
        <div class="text-sm font-bold text-gray-900">Bayar Kas Saya</div>
        <div class="text-xs text-gray-400 mt-0.5">Status pembayaran</div>
    </a>

    <a href="{{ route('presbem.denda') }}"
       class="bg-white hover:bg-gray-50/80 rounded-2xl p-5 border border-gray-100 shadow-sm transition group block">
        <div class="text-2xl mb-2 group-hover:scale-110 transition-transform">⚠️</div>
        <div class="text-sm font-bold text-gray-900">Denda Saya</div>
        <div class="text-xs text-gray-400 mt-0.5">Tagihan denda</div>
    </a>
</div>

{{-- Notifikasi & Perhatian --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
    <h3 class="text-base font-bold text-gray-900 mb-4">Notifikasi & Perhatian</h3>
    <div class="space-y-3">
        {{-- Item 1: Yellow --}}
        <div class="p-4 rounded-xl bg-amber-50/70 border-l-4 border-amber-400 flex items-center justify-between text-xs">
            <span class="font-bold text-amber-900">7 anggota belum bayar kas September</span>
            <span class="text-amber-700/80 font-medium whitespace-nowrap">Hari ini</span>
        </div>

        {{-- Item 2: Red --}}
        <div class="p-4 rounded-xl bg-red-50/70 border-l-4 border-red-400 flex items-center justify-between text-xs">
            <span class="font-bold text-red-900">4 anggota di bawah 75% kehadiran piket</span>
            <span class="text-red-700/80 font-medium whitespace-nowrap">Kemarin</span>
        </div>

        {{-- Item 3: Green --}}
        <div class="p-4 rounded-xl bg-emerald-50/70 border-l-4 border-emerald-500 flex items-center justify-between text-xs">
            <span class="font-bold text-emerald-900">Kegiatan Seminar berhasil dilaksanakan, 28/30 hadir</span>
            <span class="text-emerald-700/80 font-medium whitespace-nowrap">21/09/2025</span>
        </div>

        {{-- Item 4: Yellow --}}
        <div class="p-4 rounded-xl bg-amber-50/70 border-l-4 border-amber-400 flex items-center justify-between text-xs">
            <span class="font-bold text-amber-900">3 anggota denda belum dibayar &gt; 30 hari</span>
            <span class="text-amber-700/80 font-medium whitespace-nowrap">20/09/2025</span>
        </div>
    </div>
</div>

{{-- Ringkasan Per Departemen --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-base font-bold text-gray-900">Ringkasan Per Departemen</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50/70 text-gray-400 font-semibold uppercase tracking-wider border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3.5">Departemen</th>
                    <th class="px-6 py-3.5 text-center">Anggota</th>
                    <th class="px-6 py-3.5 text-center">Lunas Kas</th>
                    <th class="px-6 py-3.5 text-right">Kehadiran</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100/70 text-gray-700">
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4 font-bold text-gray-900">ADKEU</td>
                    <td class="px-6 py-4 text-center font-medium">5</td>
                    <td class="px-6 py-4 text-center font-bold text-emerald-600">5/5</td>
                    <td class="px-6 py-4 text-right font-bold text-emerald-600">94%</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4 font-bold text-gray-900">PSDI</td>
                    <td class="px-6 py-4 text-center font-medium">6</td>
                    <td class="px-6 py-4 text-center font-bold text-amber-600">4/6</td>
                    <td class="px-6 py-4 text-right font-bold text-emerald-600">88%</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4 font-bold text-gray-900">Kementerian A</td>
                    <td class="px-6 py-4 text-center font-medium">7</td>
                    <td class="px-6 py-4 text-center font-bold text-amber-600">5/7</td>
                    <td class="px-6 py-4 text-right font-bold text-amber-600">82%</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4 font-bold text-gray-900">Kementerian B</td>
                    <td class="px-6 py-4 text-center font-medium">8</td>
                    <td class="px-6 py-4 text-center font-bold text-amber-600">6/8</td>
                    <td class="px-6 py-4 text-right font-bold text-emerald-600">91%</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4 font-bold text-gray-900">Anggota Umum</td>
                    <td class="px-6 py-4 text-center font-medium">6</td>
                    <td class="px-6 py-4 text-center font-bold text-amber-600">4/6</td>
                    <td class="px-6 py-4 text-right font-bold text-amber-600">75%</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
