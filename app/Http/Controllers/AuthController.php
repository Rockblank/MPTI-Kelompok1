<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show login form based on role or default anggota.
     */
    public function showLoginForm(Request $request, ?string $role = null): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect(Auth::user()->dashboard_route);
        }

        return match ($role) {
            'bendahara', 'adkeu' => view('bendahara.login'),
            'presbem' => view('presbem.login'),
            'psdi' => view('psdi.login'),
            default => view('anggota.login'),
        };
    }

    /**
     * Handle user authentication.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(Auth::user()->dashboard_route);
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->with('error', 'Email atau password yang Anda masukkan salah.');
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('anggota.login')->with('success', 'Anda telah berhasil keluar dari akun.');
    }
}
