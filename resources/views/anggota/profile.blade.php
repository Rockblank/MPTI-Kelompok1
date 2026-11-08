@extends('layouts.anggota')

@section('title', 'Profile')
@section('page-title', 'Profile')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Profile</h2>
    <p class="mt-0.5 text-sm text-gray-500">Informasi akun Anda.</p>
</div>

<section class="mb-5 rounded-2xl border border-gray-100 bg-white">
    <div class="h-28 rounded-t-2xl bg-gradient-to-r from-[#1A6B6B] to-[#2AADAD]"></div>
    <div class="px-6 py-5">
        <div class="mb-5">
            <h3 class="text-lg font-bold text-gray-900">{{ auth()->user()->name }}</h3>
            <p class="text-sm text-gray-500">{{ auth()->user()->role_badge }}</p>
        </div>
        <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div><dt class="text-xs text-[#1A8A8A]">NIM</dt><dd class="mt-1 text-sm font-semibold text-gray-800">{{ auth()->user()->nim ?: '—' }}</dd></div>
            <div><dt class="text-xs text-[#1A8A8A]">Departemen</dt><dd class="mt-1 text-sm font-semibold text-gray-800">{{ auth()->user()->departemen ?: '—' }}</dd></div>
            <div><dt class="text-xs text-[#1A8A8A]">Angkatan</dt><dd class="mt-1 text-sm font-semibold text-gray-800">{{ auth()->user()->angkatan ?: '—' }}</dd></div>
            <div><dt class="text-xs text-[#1A8A8A]">Email</dt><dd class="mt-1 text-sm font-semibold text-gray-800">{{ auth()->user()->email }}</dd></div>
        </dl>
    </div>
</section>

<section class="overflow-hidden rounded-2xl border border-gray-100 bg-white">
    <h3 class="border-b border-gray-50 px-5 py-4 text-sm font-semibold text-gray-800">Ringkasan Kewajiban</h3>
    <div class="divide-y divide-gray-50">
        <div class="flex items-center justify-between px-5 py-4">
            <span class="text-sm text-gray-700">Kas Bulan Ini</span>
            <span class="text-sm font-semibold text-gray-800">
                @switch($currentPayment?->status)
                    @case(\App\Models\CashPayment::STATUS_APPROVED) Lunas @break
                    @case(\App\Models\CashPayment::STATUS_PENDING) Menunggu verifikasi @break
                    @case(\App\Models\CashPayment::STATUS_REJECTED) Ditolak @break
                    @default Belum ada pembayaran
                @endswitch
            </span>
        </div>
        <a href="{{ route('anggota.denda') }}" class="flex items-center justify-between px-5 py-4 hover:bg-gray-50">
            <span class="text-sm text-gray-700">Denda Aktif</span>
            <span class="text-sm font-bold {{ $outstandingLateFees > 0 ? 'text-red-600' : 'text-gray-800' }}">
                Rp{{ number_format($outstandingLateFees, 0, ',', '.') }} · {{ $activeLateFeeCount }} tagihan
            </span>
        </a>
        <div class="flex items-center justify-between px-5 py-4">
            <span class="text-sm text-gray-700">Total Kas Dibayar</span>
            <span class="text-sm font-bold text-gray-800">Rp{{ number_format($totalCashPaid, 0, ',', '.') }}</span>
        </div>
    </div>
</section>
@endsection
