@extends(auth()->user()->role === 'presbem' ? 'layouts.presbem' : 'layouts.anggota')

@section('title', 'Bayar Kas')
@section('page-title', 'Bayar Kas')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Bayar Kas</h2>
    <p class="mt-0.5 text-sm text-gray-500">Kirim bukti transfer kas bulanan untuk diverifikasi ADKEU.</p>
</div>

@if(session('success'))
    <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" role="status">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">
        <ul class="list-inside list-disc">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    $statusLabels = [
        'pending' => ['Menunggu verifikasi', 'border-amber-200 bg-amber-50 text-amber-700'],
        'approved' => ['Disetujui', 'border-emerald-200 bg-emerald-50 text-emerald-700'],
        'rejected' => ['Ditolak', 'border-red-200 bg-red-50 text-red-700'],
    ];
@endphp

<div class="mb-6 rounded-2xl bg-[#1A6B6B] p-6 text-white">
    <p class="text-sm text-white/75">Tagihan periode {{ $currentPeriod->locale('id')->translatedFormat('F Y') }}</p>
    <div class="mt-1 flex flex-wrap items-end justify-between gap-4">
        <h3 class="text-3xl font-extrabold">Rp{{ number_format(\App\Models\CashPayment::AMOUNT, 0, ',', '.') }}</h3>
        @if($currentPayment)
            @if($currentPayment->status === 'approved')
                <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">Lunas</span>
            @else
                <span class="rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-bold text-red-700">Belum lunas · {{ $statusLabels[$currentPayment->status][0] }}</span>
            @endif
        @else
            <span class="rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-bold text-red-700">Belum lunas</span>
        @endif
    </div>
</div>

@if(!$currentPayment || $currentPayment->status === 'rejected')
    <div class="mb-6 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
        <h3 class="mb-1 text-base font-bold text-gray-900">{{ $currentPayment ? 'Kirim Ulang Bukti Pembayaran' : 'Kirim Bukti Pembayaran' }}</h3>
        <p class="mb-4 text-sm text-gray-500">Unggah bukti transfer JPG, PNG, atau PDF (maksimal 2 MB).</p>
        @if($currentPayment?->rejection_reason)
            <p class="mb-4 rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                Alasan penolakan: {{ $currentPayment->rejection_reason }}
            </p>
        @endif

        <form action="{{ route(auth()->user()->role === 'presbem' ? 'presbem.bayar-kas.submit' : 'anggota.bayar-kas.submit') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 sm:grid-cols-2">
            @csrf
            <div>
                <label for="period" class="mb-1.5 block text-xs font-semibold text-gray-700">Periode kas</label>
                <input id="period" name="period" type="month" required max="{{ now()->format('Y-m') }}" value="{{ old('period', now()->format('Y-m')) }}" class="w-full rounded-xl border border-gray-200 px-3.5 py-2.5 text-sm text-gray-800 focus:border-[#1A6B6B] focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30">
                @error('period')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="proof" class="mb-1.5 block text-xs font-semibold text-gray-700">Bukti transfer</label>
                <input id="proof" name="proof" type="file" accept=".jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf" required class="block w-full rounded-xl border border-gray-200 px-3 py-2 text-sm text-gray-700 file:mr-3 file:rounded-lg file:border-0 file:bg-teal-50 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-[#1A6B6B]">
                @error('proof')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="sm:col-span-2">
                <button type="submit" class="rounded-xl bg-[#1A6B6B] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#155757]">
                    Kirim untuk Verifikasi
                </button>
            </div>
        </form>
    </div>
@elseif($currentPayment->status === 'pending')
    <p class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
        Status pembayaran masih belum lunas sampai bukti disetujui ADKEU. Bukti saat ini sedang menunggu verifikasi.
    </p>
@else
    <p class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
        Pembayaran periode ini sudah disetujui oleh ADKEU.
    </p>
@endif

<div class="overflow-hidden rounded-2xl border border-gray-100 bg-white">
    <div class="flex items-center justify-between border-b border-gray-50 px-5 py-4">
        <h3 class="text-sm font-semibold text-gray-800">Riwayat Pengajuan Pembayaran</h3>
        <a href="{{ route(auth()->user()->role === 'presbem' ? 'presbem.riwayat-pembayaran' : 'anggota.riwayat-pembayaran') }}" class="text-xs font-semibold text-[#1A6B6B] hover:underline">Lihat riwayat lengkap</a>
    </div>
    <div class="divide-y divide-gray-50">
        @forelse($payments as $payment)
            <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4">
                <div>
                    <div class="text-sm font-medium text-gray-800">{{ $payment->period->locale('id')->translatedFormat('F Y') }}</div>
                    <div class="mt-0.5 text-xs text-gray-400">Dikirim {{ $payment->created_at->format('d/m/Y H:i') }}</div>
                    @if($payment->rejection_reason)
                        <div class="mt-1 text-xs text-red-600">Alasan: {{ $payment->rejection_reason }}</div>
                    @endif
                </div>
                <div class="text-right">
                    <div class="text-sm font-semibold text-gray-800">Rp{{ number_format($payment->amount, 0, ',', '.') }}</div>
                    <span class="mt-1 inline-block rounded-full border px-2.5 py-0.5 text-xs font-medium {{ $statusLabels[$payment->status][1] }}">{{ $statusLabels[$payment->status][0] }}</span>
                </div>
            </div>
        @empty
            <p class="px-5 py-8 text-center text-sm text-gray-500">Belum ada pengajuan pembayaran.</p>
        @endforelse
    </div>
</div>
@endsection
