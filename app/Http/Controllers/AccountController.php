<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountController extends Controller
{
    private const ROLES = [
        'anggota' => 'Anggota Biasa',
        'bendahara' => 'ADKEU / Bendahara',
        'presbem' => 'PresBEM',
        'psdi' => 'PSDI',
    ];

    public function create(): View
    {
        return view('admin.accounts.create', [
            'roles' => self::ROLES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'string', 'in:'.implode(',', array_keys(self::ROLES))],
            'nim' => ['nullable', 'string', 'max:20'],
            'departemen' => ['nullable', 'string', 'max:50'],
            'angkatan' => ['nullable', 'string', 'max:10'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'email.unique' => 'Email tersebut sudah digunakan.',
            'role.in' => 'Role akun tidak valid.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create($validated);

        return redirect()
            ->route('admin.accounts.create')
            ->with('success', 'Akun berhasil ditambahkan.');
    }
}
