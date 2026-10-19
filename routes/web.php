<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Redirect root ke dashboard atau login
Route::get('/', function () {
    if (auth()->check()) {
        return redirect(auth()->user()->dashboard_route);
    }
    return redirect()->route('anggota.login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Default / Anggota Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/anggota/login', [AuthController::class, 'showLoginForm'])->name('anggota.login');

    // Role-specific Login Views
    Route::get('/bendahara/login', fn() => app(AuthController::class)->showLoginForm(request(), 'bendahara'))->name('bendahara.login');
    Route::get('/psdi/login', fn() => app(AuthController::class)->showLoginForm(request(), 'psdi'))->name('psdi.login');
    Route::get('/presbem/login', fn() => app(AuthController::class)->showLoginForm(request(), 'presbem'))->name('presbem.login');

    // Login Submission
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.post');
});

// Logout Route (Auth only, supports both POST and GET for UX convenience)
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ==========================================
// 1. ANGGOTA ROUTES (Role: anggota)
// ==========================================
Route::prefix('anggota')
    ->name('anggota.')
    ->middleware(['auth', 'role:anggota'])
    ->group(function () {
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

// ==========================================
// 2. BENDAHARA / ADKEU ROUTES (Role: bendahara, adkeu)
// ==========================================
Route::prefix('bendahara')
    ->name('bendahara.')
    ->middleware(['auth', 'role:bendahara,adkeu'])
    ->group(function () {
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

// ==========================================
// 3. PSDI ROUTES (Role: psdi)
// ==========================================
Route::prefix('psdi')
    ->name('psdi.')
    ->middleware(['auth', 'role:psdi'])
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('psdi.dashboard');
        })->name('dashboard');

        Route::get('/kegiatan', function () {
            return view('psdi.kegiatan');
        })->name('kegiatan');

        Route::get('/rekap-presensi', function () {
            return view('psdi.rekap-presensi');
        })->name('rekap-presensi');

        Route::get('/profile', function () {
            return view('psdi.profile');
        })->name('profile');
    });

// ==========================================
// 4. PRESBEM ROUTES (Role: presbem)
// ==========================================
Route::prefix('presbem')
    ->name('presbem.')
    ->middleware(['auth', 'role:presbem'])
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('presbem.dashboard');
        })->name('dashboard');

        Route::get('/bayar-kas', function () {
            return view('presbem.bayar-kas');
        })->name('bayar-kas');

        Route::get('/riwayat-pembayaran', function () {
            return view('presbem.riwayat-pembayaran');
        })->name('riwayat-pembayaran');

        Route::get('/jadwal-piket', function () {
            return view('presbem.jadwal-piket');
        })->name('jadwal-piket');

        Route::get('/presensi-kegiatan', function () {
            return view('presbem.presensi-kegiatan');
        })->name('presensi-kegiatan');

        Route::get('/riwayat-presensi', function () {
            return view('presbem.riwayat-presensi');
        })->name('riwayat-presensi');

        Route::get('/denda', function () {
            return view('presbem.denda');
        })->name('denda');

        Route::get('/rekap-kas', function () {
            return view('presbem.rekap-kas');
        })->name('rekap-kas');

        Route::get('/rekap-presensi', function () {
            return view('presbem.rekap-presensi');
        })->name('rekap-presensi');

        Route::get('/profile', function () {
            return view('presbem.profile');
        })->name('profile');
    });
