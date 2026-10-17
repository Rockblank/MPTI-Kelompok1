@extends('layouts.psdi')

@section('title', 'Profile')
@section('page-title', 'Profile')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Profile</h2>
    <p class="text-sm text-gray-500 mt-1">Informasi akun dan pengaturan</p>
</div>

<div class="max-w-4xl space-y-6">
    {{-- Profile Hero Card --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        {{-- Banner --}}
        <div class="h-32 bg-gradient-to-r from-[#1A6B6B] to-[#258282] relative">
            <div class="absolute -bottom-8 left-8">
                <div class="w-20 h-20 bg-[#2F3336] rounded-2xl border-4 border-white shadow-md flex items-center justify-center text-white text-2xl font-extrabold tracking-wider">
                    VD
                </div>
            </div>
        </div>

        {{-- Info Area --}}
        <div class="pt-12 px-8 pb-8">
            <div class="mb-6">
                <h3 class="text-xl font-extrabold text-gray-900">Vanessa Dewi Agustina</h3>
                <p class="text-xs font-semibold text-gray-400 mt-0.5">Kepala Departemen PSDI</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-gray-100 text-xs">
                <div class="space-y-4">
                    <div>
                        <div class="text-gray-400 font-medium">NIM</div>
                        <div class="text-sm font-bold text-gray-900 mt-0.5">245150700111002</div>
                    </div>
                    <div>
                        <div class="text-gray-400 font-medium">Angkatan</div>
                        <div class="text-sm font-bold text-gray-900 mt-0.5">2024</div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <div class="text-gray-400 font-medium">Departemen</div>
                        <div class="text-sm font-bold text-gray-900 mt-0.5">PSDI</div>
                    </div>
                    <div>
                        <div class="text-gray-400 font-medium">Email</div>
                        <div class="text-sm font-bold text-gray-900 mt-0.5">vanessa@bem-filkom.ub.ac.id</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Ringkasan Kewajiban --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
        <h4 class="text-sm font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100">Ringkasan Kewajiban</h4>
        <div class="divide-y divide-gray-100 text-xs">
            <div class="py-3.5 flex items-center justify-between">
                <span class="text-gray-600 font-medium">Status Kas Bulan Ini</span>
                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 font-bold rounded-full border border-emerald-200">
                    Lunas
                </span>
            </div>
            <div class="py-3.5 flex items-center justify-between">
                <span class="text-gray-600 font-medium">Denda Aktif</span>
                <span class="font-bold text-gray-900 text-sm">Rp0</span>
            </div>
            <div class="py-3.5 flex items-center justify-between">
                <span class="text-gray-600 font-medium">Kehadiran Piket</span>
                <span class="font-bold text-emerald-600 text-sm">87%</span>
            </div>
            <div class="py-3.5 flex items-center justify-between">
                <span class="text-gray-600 font-medium">Total Kas Dibayar</span>
                <span class="font-bold text-gray-900 text-sm">Rp350.000</span>
            </div>
        </div>
    </div>

    {{-- Menu List --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm divide-y divide-gray-100 overflow-hidden text-xs">
        <a href="#" class="px-6 py-4 flex items-center justify-between hover:bg-gray-50/70 transition">
            <div class="flex items-center gap-3">
                <span class="text-base">✏️</span>
                <span class="font-semibold text-gray-800 text-sm">Edit Profil</span>
            </div>
            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>

        <a href="#" class="px-6 py-4 flex items-center justify-between hover:bg-gray-50/70 transition">
            <div class="flex items-center gap-3">
                <span class="text-base">🔐</span>
                <span class="font-semibold text-gray-800 text-sm">Ganti Password</span>
            </div>
            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>

        <a href="#" class="px-6 py-4 flex items-center justify-between hover:bg-gray-50/70 transition">
            <div class="flex items-center gap-3">
                <span class="text-base">🔔</span>
                <span class="font-semibold text-gray-800 text-sm">Notifikasi</span>
            </div>
            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>

        <a href="#" class="px-6 py-4 flex items-center justify-between hover:bg-gray-50/70 transition">
            <div class="flex items-center gap-3">
                <span class="text-base">ℹ️</span>
                <span class="font-semibold text-gray-800 text-sm">Tentang Aplikasi</span>
            </div>
            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    {{-- Keluar dari Akun Button --}}
    <div class="pt-2">
        <a href="{{ route('psdi.login') }}"
           class="w-full py-3.5 px-4 rounded-2xl border border-red-300 text-red-600 hover:bg-red-50 text-sm font-bold flex items-center justify-center gap-2 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Keluar dari Akun
        </a>
    </div>
</div>
@endsection
