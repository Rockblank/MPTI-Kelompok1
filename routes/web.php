<?php

use Illuminate\Support\Facades\Route;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('anggota.login');
});

// Auth Routes
Route::get('/login', function () {
    return view('anggota.login');
})->name('anggota.login');

// Anggota Routes
Route::prefix('anggota')->name('anggota.')->group(function () {
    Route::get('/dashboard', function () {
        return view('anggota.dashboard');
    })->name('dashboard');

    Route::get('/bayar-kas', function () {
        return view('anggota.bayar-kas');
    })->name('bayar-kas');

    Route::get('/riwayat-pembayaran', function () {
        return view('anggota.riwayat-pembayaran');
    })->name('riwayat-pembayaran');

    Route::get('/jadwal-piket', function () {
        return view('anggota.jadwal-piket');
    })->name('jadwal-piket');

    Route::get('/presensi-kegiatan', function () {
        return view('anggota.presensi-kegiatan');
    })->name('presensi-kegiatan');

    Route::get('/riwayat-presensi', function () {
        return view('anggota.riwayat-presensi');
    })->name('riwayat-presensi');

    Route::get('/denda', function () {
        return view('anggota.denda');
    })->name('denda');

    Route::get('/profile', function () {
        return view('anggota.profile');
    })->name('profile');
});
