@extends('layouts.anggota')

@section('title', 'Riwayat Pembayaran')
@section('page-title', 'Riwayat Pembayaran')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Riwayat Pembayaran</h2>
    <p class="text-sm text-gray-500 mt-0.5">Riwayat pembayaran kas bulanan Anda</p>
</div>

{{-- Summary Stats --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center">
        <div class="text-2xl font-extrabold text-[#1A8A8A] mb-1">7</div>
        <div class="text-xs text-gray-500 font-medium">Bulan Lunas</div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center">
        <div class="text-2xl font-extrabold text-red-500 mb-1">1</div>
        <div class="text-xs text-gray-500 font-medium">Belum Lunas</div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center">
        <div class="text-2xl font-extrabold text-gray-800 mb-1">Rp350rb</div>
        <div class="text-xs text-gray-500 font-medium">Total Dibayar</div>
    </div>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Bulan</th>
                <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Bayar</th>
                <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah</th>
                <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @php
            $payments = [
                ['bulan'=>'Oktober 2025', 'tanggal'=>'-',         'jumlah'=>'Rp50.000','status'=>'belum'],
                ['bulan'=>'September 2025','tanggal'=>'05/09/2025','jumlah'=>'Rp50.000','status'=>'lunas'],
                ['bulan'=>'Agustus 2025', 'tanggal'=>'04/08/2025','jumlah'=>'Rp50.000','status'=>'lunas'],
                ['bulan'=>'Juli 2025',    'tanggal'=>'07/07/2025','jumlah'=>'Rp50.000','status'=>'lunas'],
                ['bulan'=>'Juni 2025',    'tanggal'=>'03/06/2025','jumlah'=>'Rp50.000','status'=>'lunas'],
                ['bulan'=>'Mei 2025',     'tanggal'=>'05/05/2025','jumlah'=>'Rp50.000','status'=>'lunas'],
                ['bulan'=>'April 2025',   'tanggal'=>'04/04/2025','jumlah'=>'Rp50.000','status'=>'lunas'],
                ['bulan'=>'Maret 2025',   'tanggal'=>'05/03/2025','jumlah'=>'Rp50.000','status'=>'lunas'],
            ];
            @endphp

            @foreach($payments as $payment)
            <tr class="hover:bg-gray-50/50 transition-colors">
                <td class="px-5 py-4 font-medium text-gray-800">{{ $payment['bulan'] }}</td>
                <td class="px-5 py-4 text-gray-500">{{ $payment['tanggal'] }}</td>
                <td class="px-5 py-4 text-right font-semibold text-gray-800">{{ $payment['jumlah'] }}</td>
                <td class="px-5 py-4 text-right">
                    @if($payment['status'] === 'lunas')
                        <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-full px-3 py-1">Lunas</span>
                    @else
                        <span class="text-xs font-semibold text-red-600 bg-red-50 border border-red-200 rounded-full px-3 py-1">Belum Dibayar</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
