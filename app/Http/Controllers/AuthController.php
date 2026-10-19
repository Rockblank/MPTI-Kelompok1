<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
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

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->with('error', 'Email atau password yang Anda masukkan salah.');
        }

        $request->session()->regenerate();

        return redirect(Auth::user()->dashboard_route);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('anggota.login')
            ->with('success', 'Anda telah berhasil keluar dari akun.');
    }
}
