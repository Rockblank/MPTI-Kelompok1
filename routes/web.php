<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashTransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect(auth()->user()->dashboard_route);
    }

    return redirect()->route('anggota.login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/anggota/login', [AuthController::class, 'showLoginForm'])->name('anggota.login');
    Route::get('/bendahara/login', fn () => app(AuthController::class)->showLoginForm(request(), 'bendahara'))->name('bendahara.login');
    Route::get('/psdi/login', fn () => app(AuthController::class)->showLoginForm(request(), 'psdi'))->name('psdi.login');
    Route::get('/presbem/login', fn () => app(AuthController::class)->showLoginForm(request(), 'presbem'))->name('presbem.login');

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.post');
});

Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('anggota')
    ->name('anggota.')
    ->middleware(['auth', 'role:anggota'])
    ->group(function () {
        Route::get('/dashboard', fn () => view('anggota.dashboard'))->name('dashboard');
        Route::get('/bayar-kas', fn () => view('anggota.bayar-kas'))->name('bayar-kas');
        Route::get('/riwayat-pembayaran', fn () => view('anggota.riwayat-pembayaran'))->name('riwayat-pembayaran');
        Route::get('/jadwal-piket', fn () => view('anggota.jadwal-piket'))->name('jadwal-piket');
        Route::get('/presensi-kegiatan', fn () => view('anggota.presensi-kegiatan'))->name('presensi-kegiatan');
        Route::get('/riwayat-presensi', fn () => view('anggota.riwayat-presensi'))->name('riwayat-presensi');
        Route::get('/denda', fn () => view('anggota.denda'))->name('denda');
        Route::get('/profile', fn () => view('anggota.profile'))->name('profile');
    });

Route::prefix('bendahara')
    ->name('bendahara.')
    ->middleware(['auth', 'role:bendahara,adkeu'])
    ->group(function () {
        Route::get('/dashboard', fn () => view('bendahara.dashboard'))->name('dashboard');
        Route::get('/kas', [CashTransactionController::class, 'index'])->name('kas');
        Route::post('/kas/transaksi', [CashTransactionController::class, 'store'])->name('kas.store');
        Route::put('/kas/transaksi/{transaction}', [CashTransactionController::class, 'update'])->name('kas.update');
        Route::delete('/kas/transaksi/{transaction}', [CashTransactionController::class, 'destroy'])->name('kas.destroy');
        Route::get('/validasi-pembayaran', fn () => view('bendahara.validasi-pembayaran'))->name('validasi-pembayaran');
        Route::get('/rekap-kas', fn () => view('bendahara.rekap-kas'))->name('rekap-kas');
        Route::get('/denda', fn () => view('bendahara.denda'))->name('denda');
        Route::get('/jadwal-piket', fn () => view('bendahara.jadwal-piket'))->name('jadwal-piket');
        Route::get('/presensi-piket', fn () => view('bendahara.presensi-piket'))->name('presensi-piket');
        Route::get('/rekap-presensi', fn () => view('bendahara.rekap-presensi'))->name('rekap-presensi');
        Route::get('/profile', fn () => view('bendahara.profile'))->name('profile');
    });

Route::prefix('api/bendahara')
    ->name('api.bendahara.')
    ->middleware(['auth', 'role:bendahara,adkeu'])
    ->group(function () {
        Route::get('/transaksi-kas', [CashTransactionController::class, 'index'])->name('transaksi-kas.index');
        Route::post('/transaksi-kas', [CashTransactionController::class, 'store'])->name('transaksi-kas.store');
        Route::put('/transaksi-kas/{transaction}', [CashTransactionController::class, 'update'])->name('transaksi-kas.update');
        Route::delete('/transaksi-kas/{transaction}', [CashTransactionController::class, 'destroy'])->name('transaksi-kas.destroy');
    });

Route::prefix('psdi')
    ->name('psdi.')
    ->middleware(['auth', 'role:psdi'])
    ->group(function () {
        Route::get('/dashboard', fn () => view('psdi.dashboard'))->name('dashboard');
        Route::get('/kegiatan', fn () => view('psdi.kegiatan'))->name('kegiatan');
        Route::get('/rekap-presensi', fn () => view('psdi.rekap-presensi'))->name('rekap-presensi');
        Route::get('/profile', fn () => view('psdi.profile'))->name('profile');
    });

Route::prefix('presbem')
    ->name('presbem.')
    ->middleware(['auth', 'role:presbem'])
    ->group(function () {
        Route::get('/dashboard', fn () => view('presbem.dashboard'))->name('dashboard');
        Route::get('/bayar-kas', fn () => view('presbem.bayar-kas'))->name('bayar-kas');
        Route::get('/riwayat-pembayaran', fn () => view('presbem.riwayat-pembayaran'))->name('riwayat-pembayaran');
        Route::get('/jadwal-piket', fn () => view('presbem.jadwal-piket'))->name('jadwal-piket');
        Route::get('/presensi-kegiatan', fn () => view('presbem.presensi-kegiatan'))->name('presensi-kegiatan');
        Route::get('/riwayat-presensi', fn () => view('presbem.riwayat-presensi'))->name('riwayat-presensi');
        Route::get('/denda', fn () => view('presbem.denda'))->name('denda');
        Route::get('/rekap-kas', fn () => view('presbem.rekap-kas'))->name('rekap-kas');
        Route::get('/rekap-presensi', fn () => view('presbem.rekap-presensi'))->name('rekap-presensi');
        Route::get('/profile', fn () => view('presbem.profile'))->name('profile');
    });
