@extends('layouts.presbem')

@section('title', 'Riwayat Pembayaran')
@section('page-title', 'Riwayat Pembayaran')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Riwayat Pembayaran</h2>
    <p class="text-sm text-gray-500 mt-1">Daftar transaksi pembayaran kas yang telah dilakukan</p>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-base font-bold text-gray-900">Semua Transaksi Pembayaran</h3>
        <span class="text-xs font-semibold text-gray-400">Total: 7 Transaksi</span>
    </div>

    <div class="divide-y divide-gray-100">
        @php
            $items = [
                ['bulan' => 'September 2025', 'tgl' => '05/09/2025', 'nom' => 'Rp50.000', 'metode' => 'Transfer Bank BCA', 'status' => 'Lunas'],
                ['bulan' => 'Agustus 2025', 'tgl' => '04/08/2025', 'nom' => 'Rp50.000', 'metode' => 'Transfer Bank BCA', 'status' => 'Lunas'],
                ['bulan' => 'Juli 2025', 'tgl' => '07/07/2025', 'nom' => 'Rp50.000', 'metode' => 'QRIS BEM FILKOM', 'status' => 'Lunas'],
                ['bulan' => 'Juni 2025', 'tgl' => '03/06/2025', 'nom' => 'Rp50.000', 'metode' => 'Transfer Bank BCA', 'status' => 'Lunas'],
                ['bulan' => 'Mei 2025', 'tgl' => '05/05/2025', 'nom' => 'Rp50.000', 'metode' => 'QRIS BEM FILKOM', 'status' => 'Lunas'],
                ['bulan' => 'April 2025', 'tgl' => '04/04/2025', 'nom' => 'Rp50.000', 'metode' => 'Transfer Bank BCA', 'status' => 'Lunas'],
                ['bulan' => 'Maret 2025', 'tgl' => '05/03/2025', 'nom' => 'Rp50.000', 'metode' => 'Transfer Bank BCA', 'status' => 'Lunas'],
            ];
        @endphp

        @foreach($items as $item)
        <div class="p-5 flex items-center justify-between hover:bg-gray-50/50 transition">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">
                    ✓
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900">{{ $item['bulan'] }}</h4>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $item['tgl'] }} · {{ $item['metode'] }}</p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-sm font-bold text-gray-900">{{ $item['nom'] }}</div>
                <span class="inline-block mt-0.5 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                    {{ $item['status'] }}
                </span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
