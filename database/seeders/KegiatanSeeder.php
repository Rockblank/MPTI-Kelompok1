<?php

namespace Database\Seeders;

use App\Models\Kegiatan;
use Illuminate\Database\Seeder;

class KegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $kegiatans = [
            [
                'nama' => 'Seminar Kepemimpinan',
                'deskripsi' => 'Seminar pengembangan jiwa kepemimpinan bagi anggota BEM',
                'tanggal' => now()->toDateString(),
                'jam_mulai' => '09:00',
                'jam_selesai' => '12:00',
                'lokasi' => 'Aula FILKOM',
                'status' => Kegiatan::STATUS_BERLANGSUNG,
                'qr_code' => 'SEMINAR-KPM-2025',
                'qr_expires_at' => now()->addDays(7),
            ],
            [
                'nama' => 'Workshop UI/UX Design',
                'deskripsi' => 'Pelatihan riset pengguna dan perancangan antarmuka digital',
                'tanggal' => now()->toDateString(),
                'jam_mulai' => '13:00',
                'jam_selesai' => '16:00',
                'lokasi' => 'Lab Komputer 301',
                'status' => Kegiatan::STATUS_BERLANGSUNG,
                'qr_code' => 'WORKSHOP-UIUX-2025',
                'qr_expires_at' => now()->addDays(7),
            ],
            [
                'nama' => 'Pelatihan Public Speaking',
                'deskripsi' => 'Teknik komunikasi efektif dan presentasi profesional fungsionaris',
                'tanggal' => now()->addDays(3)->toDateString(),
                'jam_mulai' => '08:30',
                'jam_selesai' => '11:30',
                'lokasi' => 'Gedung F Lantai 2',
                'status' => Kegiatan::STATUS_AKAN_DATANG,
                'qr_code' => 'SPEAKING-2025',
                'qr_expires_at' => now()->addDays(10),
            ],
            [
                'nama' => 'Rapat Koordinasi Bulanan',
                'deskripsi' => 'Evaluasi program kerja divisi dan koordinasi bulanan',
                'tanggal' => now()->subDays(5)->toDateString(),
                'jam_mulai' => '16:00',
                'jam_selesai' => '18:00',
                'lokasi' => 'Ruang Rapat BEM',
                'status' => Kegiatan::STATUS_SELESAI,
                'qr_code' => 'RAKOR-BEM-2025',
                'qr_expires_at' => now()->subDays(4),
            ],
        ];

        foreach ($kegiatans as $data) {
            Kegiatan::updateOrCreate(
                ['qr_code' => $data['qr_code']],
                $data
            );
        }
    }
}
