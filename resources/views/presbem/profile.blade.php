@extends('layouts.presbem')

@section('title', 'Profile')
@section('page-title', 'Profile')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Profile</h2>
    <p class="mt-1 text-sm text-gray-500">Informasi akun Anda.</p>
</div>

<section class="max-w-4xl overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
    <div class="h-32 bg-gradient-to-r from-[#1A6B6B] to-[#258282]"></div>
    <div class="px-8 py-6">
        <div class="mb-6">
            <h3 class="text-xl font-extrabold text-gray-900">{{ auth()->user()->name }}</h3>
            <p class="mt-0.5 text-sm text-gray-500">{{ auth()->user()->role_badge }}</p>
        </div>
        <dl class="grid grid-cols-1 gap-5 border-t border-gray-100 pt-5 sm:grid-cols-2">
            <div><dt class="text-xs text-gray-400">NIM</dt><dd class="mt-1 text-sm font-bold text-gray-900">{{ auth()->user()->nim ?: '—' }}</dd></div>
            <div><dt class="text-xs text-gray-400">Angkatan</dt><dd class="mt-1 text-sm font-bold text-gray-900">{{ auth()->user()->angkatan ?: '—' }}</dd></div>
            <div><dt class="text-xs text-gray-400">Departemen</dt><dd class="mt-1 text-sm font-bold text-gray-900">{{ auth()->user()->departemen ?: '—' }}</dd></div>
            <div><dt class="text-xs text-gray-400">Email</dt><dd class="mt-1 text-sm font-bold text-gray-900">{{ auth()->user()->email }}</dd></div>
        </dl>
    </div>
</section>
@endsection
