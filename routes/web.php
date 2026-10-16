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

// Bendahara Auth
Route::get('/bendahara/login', function () {
    return view('bendahara.login');
})->name('bendahara.login');

// Bendahara Routes
Route::prefix('bendahara')->name('bendahara.')->group(function () {
    Route::get('/dashboard', function () {
        return view('bendahara.dashboard');
    })->name('dashboard');

    Route::get('/kas', function () {
        return view('bendahara.kas');
    })->name('kas');

    Route::get('/validasi-pembayaran', function () {
        return view('bendahara.validasi-pembayaran');
    })->name('validasi-pembayaran');

    Route::get('/rekap-kas', function () {
        return view('bendahara.rekap-kas');
    })->name('rekap-kas');

    Route::get('/denda', function () {
        return view('bendahara.denda');
    })->name('denda');

    Route::get('/jadwal-piket', function () {
        return view('bendahara.jadwal-piket');
    })->name('jadwal-piket');

    Route::get('/presensi-piket', function () {
        return view('bendahara.presensi-piket');
    })->name('presensi-piket');

    Route::get('/rekap-presensi', function () {
        return view('bendahara.rekap-presensi');
    })->name('rekap-presensi');

    Route::get('/profile', function () {
        return view('bendahara.profile');
    })->name('profile');
});
