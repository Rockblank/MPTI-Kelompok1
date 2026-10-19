<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nim',
        'departemen',
        'angkatan',
        'jabatan',
        'avatar',
        'status_kas',
        'denda_aktif',
        'kehadiran_piket',
        'total_kas_dibayar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'denda_aktif' => 'integer',
            'kehadiran_piket' => 'integer',
            'total_kas_dibayar' => 'integer',
        ];
    }

    public function hasRole(string|array $roles): bool
    {
        $roles = (array) $roles;

        if (in_array('bendahara', $roles, true) || in_array('adkeu', $roles, true)) {
            $roles = [...$roles, 'bendahara', 'adkeu'];
        }

        return in_array($this->role, $roles, true);
    }

    public function getDashboardRouteAttribute(): string
    {
        return match ($this->role) {
            'bendahara', 'adkeu' => route('bendahara.dashboard'),
            'psdi' => route('psdi.dashboard'),
            'presbem' => route('presbem.dashboard'),
            default => route('anggota.dashboard'),
        };
    }
}
