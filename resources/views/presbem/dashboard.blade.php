@extends('layouts.presbem')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Dashboard Ketua BEM</h2>
    <p class="mt-1 text-sm text-gray-500">Ringkasan kas, pembayaran, dan kegiatan berdasarkan data sistem.</p>
</div>

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="rounded-2xl border border-gray-100 bg-white p-5">
        <div class="text-2xl font-bold text-[#1A6B6B]">Rp{{ number_format($saldo, 0, ',', '.') }}</div>
        <div class="mt-1 text-sm text-gray-500">Saldo kas</div>
    </div>
    <div class="rounded-2xl border border-gray-100 bg-white p-5">
        <div class="text-2xl font-bold text-gray-900">{{ $anggotaCount }}</div>
        <div class="mt-1 text-sm text-gray-500">Fungsionaris</div>
    </div>
    <div class="rounded-2xl border border-gray-100 bg-white p-5">
        <div class="text-2xl font-bold text-amber-600">{{ $pendingPaymentsCount }}</div>
        <div class="mt-1 text-sm text-gray-500">Pembayaran menunggu verifikasi</div>
    </div>
    <div class="rounded-2xl border border-gray-100 bg-white p-5">
        <div class="text-2xl font-bold text-gray-900">{{ $kegiatanAktif->count() }}</div>
        <div class="mt-1 text-sm text-gray-500">Kegiatan aktif/mendatang</div>
    </div>
</div>

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <a href="{{ route('presbem.rekap-kas') }}" class="rounded-2xl border border-gray-100 bg-white p-5 transition hover:bg-gray-50">
        <div class="text-sm font-bold text-gray-900">Rekap Kas</div>
        <div class="mt-1 text-xs text-gray-500">Laporan keuangan</div>
    </a>
    <a href="{{ route('presbem.rekap-presensi') }}" class="rounded-2xl border border-gray-100 bg-white p-5 transition hover:bg-gray-50">
        <div class="text-sm font-bold text-gray-900">Rekap Presensi</div>
        <div class="mt-1 text-xs text-gray-500">Kehadiran fungsionaris</div>
    </a>
    <a href="{{ route('presbem.bayar-kas') }}" class="rounded-2xl border border-gray-100 bg-white p-5 transition hover:bg-gray-50">
        <div class="text-sm font-bold text-gray-900">Bayar Kas Saya</div>
        <div class="mt-1 text-xs text-gray-500">Status pembayaran</div>
    </a>
    <a href="{{ route('presbem.denda') }}" class="rounded-2xl border border-gray-100 bg-white p-5 transition hover:bg-gray-50">
        <div class="text-sm font-bold text-gray-900">Denda Saya</div>
        <div class="mt-1 text-xs text-gray-500">Tagihan denda</div>
    </a>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
    <section class="rounded-2xl border border-gray-100 bg-white p-6">
        <h3 class="mb-4 text-base font-bold text-gray-900">Transaksi Terbaru</h3>
        <div class="divide-y divide-gray-100">
            @forelse($transaksiTerbaru as $transaksi)
                <div class="flex items-center justify-between gap-3 py-3">
                    <div>
                        <p class="text-sm font-semibold text-gray-900">{{ $transaksi->description }}</p>
                        <p class="mt-1 text-xs text-gray-500">{{ $transaksi->transaction_date->format('d/m/Y') }}</p>
                    </div>
                    <span class="text-sm font-bold {{ $transaksi->type === 'masuk' ? 'text-emerald-700' : 'text-red-600' }}">
                        {{ $transaksi->type === 'masuk' ? '+' : '-' }}Rp{{ number_format($transaksi->amount, 0, ',', '.') }}
                    </span>
                </div>
            @empty
                <p class="py-6 text-center text-sm text-gray-500">Belum ada transaksi kas.</p>
            @endforelse
        </div>
    </section>

    <section class="rounded-2xl border border-gray-100 bg-white p-6">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-base font-bold text-gray-900">Kegiatan Mendatang</h3>
            <a href="{{ route('presbem.presensi-kegiatan') }}" class="text-xs font-semibold text-[#1A6B6B] hover:underline">Lihat presensi</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($kegiatanAktif as $kegiatan)
                <div class="py-3">
                    <p class="text-sm font-semibold text-gray-900">{{ $kegiatan->nama }}</p>
                    <p class="mt-1 text-xs text-gray-500">
                        {{ $kegiatan->tanggal->format('d/m/Y') }}
                        @if($kegiatan->jam_mulai) · {{ $kegiatan->jam_mulai }} WIB @endif
                    </p>
                </div>
            @empty
                <p class="py-6 text-center text-sm text-gray-500">Belum ada kegiatan mendatang.</p>
            @endforelse
        </div>
    </section>
</div>
@endsection
