<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            // ADKEU (Bendahara)
            [
                'name' => 'Nayla Shaffa',
                'email' => 'nayla@bem-filkom.ub.ac.id',
                'password' => Hash::make('adkeu123'),
                'role' => 'bendahara',
                'nim' => '245150700111001',
                'departemen' => 'ADKEU',
                'angkatan' => '2024',
                'jabatan' => 'Bendahara Umum',
                'status_kas' => 'Lunas',
                'denda_aktif' => 0,
                'kehadiran_piket' => 87,
                'total_kas_dibayar' => 350000,
            ],
            [
                'name' => 'Rizky Pratama',
                'email' => 'rizky@bem-filkom.ub.ac.id',
                'password' => Hash::make('adkeu123'),
                'role' => 'bendahara',
                'nim' => '245150700111002',
                'departemen' => 'ADKEU',
                'angkatan' => '2024',
                'jabatan' => 'Staff ADKEU',
                'status_kas' => 'Lunas',
                'denda_aktif' => 0,
                'kehadiran_piket' => 92,
                'total_kas_dibayar' => 350000,
            ],

            // PresBEM (Ketua BEM / Eksekutif)
            [
                'name' => 'M. Daffa Riyadlussalam',
                'email' => 'daffa@bem-filkom.ub.ac.id',
                'password' => Hash::make('presbem123'),
                'role' => 'presbem',
                'nim' => '235150700111001',
                'departemen' => 'Eksekutif',
                'angkatan' => '2023',
                'jabatan' => 'Ketua BEM',
                'status_kas' => 'Lunas',
                'denda_aktif' => 0,
                'kehadiran_piket' => 88,
                'total_kas_dibayar' => 350000,
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad@bem-filkom.ub.ac.id',
                'password' => Hash::make('presbem123'),
                'role' => 'presbem',
                'nim' => '235150700111002',
                'departemen' => 'Eksekutif',
                'angkatan' => '2023',
                'jabatan' => 'Wakil Ketua BEM',
                'status_kas' => 'Lunas',
                'denda_aktif' => 0,
                'kehadiran_piket' => 90,
                'total_kas_dibayar' => 350000,
            ],

            // PSDI
            [
                'name' => 'Vanessa Dewi Agustina',
                'email' => 'vanessa@bem-filkom.ub.ac.id',
                'password' => Hash::make('psdi123'),
                'role' => 'psdi',
                'nim' => '245150700111003',
                'departemen' => 'PSDI',
                'angkatan' => '2024',
                'jabatan' => 'Kepala Departemen PSDI',
                'status_kas' => 'Lunas',
                'denda_aktif' => 0,
                'kehadiran_piket' => 95,
                'total_kas_dibayar' => 350000,
            ],
            [
                'name' => 'Siti Aisyah',
                'email' => 'siti@bem-filkom.ub.ac.id',
                'password' => Hash::make('psdi123'),
                'role' => 'psdi',
                'nim' => '245150700111004',
                'departemen' => 'PSDI',
                'angkatan' => '2024',
                'jabatan' => 'Staff PSDI',
                'status_kas' => 'Lunas',
                'denda_aktif' => 0,
                'kehadiran_piket' => 85,
                'total_kas_dibayar' => 350000,
            ],

            // Anggota Biasa
            [
                'name' => 'Ananda',
                'email' => 'ananda@bem-filkom.ub.ac.id',
                'password' => Hash::make('anggota123'),
                'role' => 'anggota',
                'nim' => '255150700111003',
                'departemen' => 'Umum',
                'angkatan' => '2025',
                'jabatan' => 'Anggota Biasa',
                'status_kas' => 'Lunas',
                'denda_aktif' => 0,
                'kehadiran_piket' => 87,
                'total_kas_dibayar' => 350000,
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@student.ub.ac.id',
                'password' => Hash::make('anggota123'),
                'role' => 'anggota',
                'nim' => '255150700111004',
                'departemen' => 'Umum',
                'angkatan' => '2025',
                'jabatan' => 'Anggota Biasa',
                'status_kas' => 'Lunas',
                'denda_aktif' => 0,
                'kehadiran_piket' => 80,
                'total_kas_dibayar' => 300000,
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@bem-filkom.ub.ac.id',
                'password' => Hash::make('anggota123'),
                'role' => 'anggota',
                'nim' => '255150700111004',
                'departemen' => 'Umum',
                'angkatan' => '2025',
                'jabatan' => 'Anggota Biasa',
                'status_kas' => 'Lunas',
                'denda_aktif' => 0,
                'kehadiran_piket' => 80,
                'total_kas_dibayar' => 300000,
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
