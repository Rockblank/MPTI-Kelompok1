<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashPaymentController;
use App\Http\Controllers\CashReportController;
use App\Http\Controllers\CashTransactionController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\PresensiRekapController;
use Illuminate\Support\Facades\Route;

// Redirect root ke dashboard atau login
Route::get('/', function () {
    if (auth()->check()) {
        return redirect(auth()->user()->dashboard_route);
    }

    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

    // Keep legacy login URLs working while serving a single login page.
    Route::redirect('/anggota/login', '/login')->name('anggota.login');
    Route::redirect('/bendahara/login', '/login')->name('bendahara.login');
    Route::redirect('/psdi/login', '/login')->name('psdi.login');
    Route::redirect('/presbem/login', '/login')->name('presbem.login');

    // Login Submission
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.post');
});

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware(['auth', 'idle'])
    ->name('logout');

// ==========================================
// 1. ANGGOTA ROUTES (Role: anggota)
// ==========================================
Route::prefix('anggota')
    ->name('anggota.')
    ->middleware(['auth', 'idle', 'role:anggota'])
    ->group(function () {
        Route::get('/dashboard', [CashPaymentController::class, 'memberDashboard'])->name('dashboard');

        Route::get('/bayar-kas', [CashPaymentController::class, 'memberIndex'])->name('bayar-kas');
        Route::post('/bayar-kas', [CashPaymentController::class, 'submit'])->name('bayar-kas.submit');

        Route::get('/riwayat-pembayaran', [CashPaymentController::class, 'memberHistory'])->name('riwayat-pembayaran');

        Route::get('/jadwal-piket', function () {
            return view('anggota.jadwal-piket');
        })->name('jadwal-piket');

        Route::get('/presensi-kegiatan', [PresensiController::class, 'index'])->name('presensi-kegiatan');
        Route::post('/presensi-kegiatan', [PresensiController::class, 'store'])->name('presensi-kegiatan.store');
        Route::get('/presensi-kegiatan/bukti/{presensi}', [PresensiController::class, 'bukti'])->name('presensi-kegiatan.bukti');

        Route::get('/riwayat-presensi', [PresensiController::class, 'history'])->name('riwayat-presensi');

        Route::get('/denda', [CashPaymentController::class, 'memberFines'])->name('denda');

        Route::get('/profile', [CashPaymentController::class, 'memberProfile'])->name('profile');
    });

// ==========================================
// 2. BENDAHARA / ADKEU ROUTES (Role: bendahara, adkeu)
// ==========================================
Route::prefix('bendahara')
    ->name('bendahara.')
    ->middleware(['auth', 'idle', 'role:bendahara,adkeu'])
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('bendahara.dashboard');
        })->name('dashboard');

        Route::get('/kas', [CashTransactionController::class, 'index'])->name('kas');
        Route::post('/kas/transaksi', [CashTransactionController::class, 'store'])->name('kas.store');
        Route::put('/kas/transaksi/{transaction}', [CashTransactionController::class, 'update'])->name('kas.update');
        Route::delete('/kas/transaksi/{transaction}', [CashTransactionController::class, 'destroy'])->name('kas.destroy');

        Route::get('/validasi-pembayaran', [CashPaymentController::class, 'reviewIndex'])->name('validasi-pembayaran');
        Route::get('/validasi-pembayaran/{payment}/bukti', [CashPaymentController::class, 'evidence'])->name('validasi-pembayaran.evidence');
        Route::post('/validasi-pembayaran/{payment}/approve', [CashPaymentController::class, 'approve'])->name('validasi-pembayaran.approve');
        Route::post('/validasi-pembayaran/{payment}/reject', [CashPaymentController::class, 'reject'])->name('validasi-pembayaran.reject');

        Route::get('/rekap-kas', [CashReportController::class, 'index'])->name('rekap-kas');
        Route::get('/rekap-kas/export', [CashReportController::class, 'export'])->name('rekap-kas.export');

        Route::get('/denda', function () {
            return view('bendahara.denda');
        })->name('denda');

        Route::get('/jadwal-piket', function () {
            return view('bendahara.jadwal-piket');
        })->name('jadwal-piket');

        Route::get('/presensi-piket', function () {
            return view('bendahara.presensi-piket');
        })->name('presensi-piket');

        Route::get('/rekap-presensi', [PresensiRekapController::class, 'index'])->name('rekap-presensi');
        Route::get('/rekap-presensi/export', [PresensiRekapController::class, 'export'])->name('rekap-presensi.export');

        Route::get('/profile', function () {
            return view('bendahara.profile');
        })->name('profile');
    });

Route::prefix('api/bendahara')
    ->name('api.bendahara.')
    ->middleware(['auth', 'idle', 'role:bendahara,adkeu'])
    ->group(function () {
        Route::get('/transaksi-kas', [CashTransactionController::class, 'index'])->name('transaksi-kas.index');
        Route::post('/transaksi-kas', [CashTransactionController::class, 'store'])->name('transaksi-kas.store');
        Route::put('/transaksi-kas/{transaction}', [CashTransactionController::class, 'update'])->name('transaksi-kas.update');
        Route::delete('/transaksi-kas/{transaction}', [CashTransactionController::class, 'destroy'])->name('transaksi-kas.destroy');
    });

// ==========================================
// 3. PSDI ROUTES (Role: psdi)
// ==========================================
Route::prefix('psdi')
    ->name('psdi.')
    ->middleware(['auth', 'idle', 'role:psdi'])
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('psdi.dashboard');
        })->name('dashboard');

        Route::get('/kegiatan', function () {
            return view('psdi.kegiatan');
        })->name('kegiatan');

        Route::get('/rekap-presensi', [PresensiRekapController::class, 'index'])->name('rekap-presensi');
        Route::get('/rekap-presensi/export', [PresensiRekapController::class, 'export'])->name('rekap-presensi.export');

        Route::get('/profile', function () {
            return view('psdi.profile');
        })->name('profile');
    });

// ==========================================
// 4. PRESBEM ROUTES (Role: presbem)
// ==========================================
Route::prefix('presbem')
    ->name('presbem.')
    ->middleware(['auth', 'idle', 'role:presbem'])
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('presbem.dashboard');
        })->name('dashboard');

        Route::get('/bayar-kas', [CashPaymentController::class, 'memberIndex'])->name('bayar-kas');
        Route::post('/bayar-kas', [CashPaymentController::class, 'submit'])->name('bayar-kas.submit');

        Route::get('/riwayat-pembayaran', [CashPaymentController::class, 'memberHistory'])->name('riwayat-pembayaran');

        Route::get('/jadwal-piket', function () {
            return view('presbem.jadwal-piket');
        })->name('jadwal-piket');

        Route::get('/presensi-kegiatan', [PresensiController::class, 'index'])->name('presensi-kegiatan');
        Route::post('/presensi-kegiatan', [PresensiController::class, 'store'])->name('presensi-kegiatan.store');
        Route::get('/presensi-kegiatan/bukti/{presensi}', [PresensiController::class, 'bukti'])->name('presensi-kegiatan.bukti');

        Route::get('/riwayat-presensi', [PresensiController::class, 'history'])->name('riwayat-presensi');

        Route::get('/denda', function () {
            return view('presbem.denda');
        })->name('denda');

        Route::get('/rekap-kas', [CashReportController::class, 'index'])->name('rekap-kas');
        Route::get('/rekap-kas/export', [CashReportController::class, 'export'])->name('rekap-kas.export');

        Route::get('/rekap-presensi', [PresensiRekapController::class, 'index'])->name('rekap-presensi');
        Route::get('/rekap-presensi/export', [PresensiRekapController::class, 'export'])->name('rekap-presensi.export');

        Route::get('/profile', function () {
            return view('presbem.profile');
        })->name('profile');
    });
