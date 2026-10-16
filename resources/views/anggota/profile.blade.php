@extends('layouts.anggota')

@section('title', 'Profile')
@section('page-title', 'Profile')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Profile</h2>
    <p class="text-sm text-gray-500 mt-0.5">Informasi akun dan pengaturan</p>
</div>

{{-- Profile Card --}}
<div class="bg-white rounded-2xl border border-gray-100 mb-5">
    {{-- Cover Banner + Avatar overlap --}}
    <div class="h-28 bg-gradient-to-r from-[#1A6B6B] to-[#2AADAD] relative rounded-t-2xl">
        {{-- Avatar positioned at bottom of banner, overflowing downward --}}
        <div class="absolute -bottom-10 left-6">
            <div class="w-20 h-20 bg-[#2F3336] rounded-2xl flex items-center justify-center text-white font-bold text-2xl border-4 border-white shadow-md">
                A
            </div>
        </div>
    </div>

    {{-- Info (padding-top besar untuk beri ruang avatar) --}}
    <div class="px-6 pb-6 pt-14">
        <div class="mb-6">
            <h3 class="text-lg font-bold text-gray-900">Ananda</h3>
            <p class="text-sm text-gray-500">Anggota Biasa</p>
        </div>

        <div class="grid grid-cols-2 gap-x-8 gap-y-5">
            <div>
                <div class="text-xs font-medium text-[#1A8A8A] mb-1">NIM</div>
                <div class="text-sm font-semibold text-gray-800">255150700111003</div>
            </div>
            <div>
                <div class="text-xs font-medium text-[#1A8A8A] mb-1">Departemen</div>
                <div class="text-sm font-semibold text-gray-800">Umum</div>
            </div>
            <div>
                <div class="text-xs font-medium text-[#1A8A8A] mb-1">Angkatan</div>
                <div class="text-sm font-semibold text-gray-800">2025</div>
            </div>
            <div>
                <div class="text-xs font-medium text-[#1A8A8A] mb-1">Email</div>
                <div class="text-sm font-semibold text-gray-800">budi@student.ub.ac.id</div>
            </div>
        </div>
    </div>
</div>

{{-- Ringkasan Kewajiban --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden mb-5">
    <div class="px-5 py-4 border-b border-gray-50">
        <h3 class="text-sm font-semibold text-gray-800">Ringkasan Kewajiban</h3>
    </div>
    <div class="divide-y divide-gray-50">
        <div class="px-5 py-4 flex items-center justify-between">
            <span class="text-sm text-gray-700">Status Kas Bulan Ini</span>
            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-full px-3 py-1">Lunas</span>
        </div>
        <div class="px-5 py-4 flex items-center justify-between">
            <span class="text-sm text-gray-700">Denda Aktif</span>
            <span class="text-sm font-bold text-gray-800">Rp0</span>
        </div>
        <div class="px-5 py-4 flex items-center justify-between">
            <span class="text-sm text-gray-700">Kehadiran Piket</span>
            <span class="text-sm font-bold text-emerald-600">87%</span>
        </div>
        <div class="px-5 py-4 flex items-center justify-between">
            <span class="text-sm text-gray-700">Total Kas Dibayar</span>
            <span class="text-sm font-bold text-[#1A8A8A]">Rp350.000</span>
        </div>
    </div>
</div>

{{-- Actions --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <a href="#" id="btn-edit-profil" class="px-5 py-4 flex items-center gap-3 hover:bg-gray-50 transition-colors border-b border-gray-50">
        <span class="text-lg">✏️</span>
        <span class="text-sm font-medium text-gray-800 flex-1">Edit Profil</span>
        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
    <a href="#" id="btn-ganti-password" class="px-5 py-4 flex items-center gap-3 hover:bg-gray-50 transition-colors">
        <span class="text-lg">🔒</span>
        <span class="text-sm font-medium text-gray-800 flex-1">Ganti Password</span>
        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
</div>
@endsection
