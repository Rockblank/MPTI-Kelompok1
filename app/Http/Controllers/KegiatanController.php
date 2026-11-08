<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class KegiatanController extends Controller
{
    public function index(): View
    {
        return view('psdi.kegiatan', [
            'kegiatans' => Kegiatan::query()
                ->withCount('presensis')
                ->orderByDesc('tanggal')
                ->orderByDesc('created_at')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'jenis' => ['required', 'string', 'max:100'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'lokasi' => ['nullable', 'string', 'max:255'],
        ]);

        Kegiatan::create([
            ...$validated,
            'lokasi' => ($validated['lokasi'] ?? null) ?: 'Belum ditentukan',
            'status' => Kegiatan::STATUS_AKAN_DATANG,
            'qr_code' => Str::random(48),
            'created_by' => $request->user()->id,
        ]);

        return redirect()->route('psdi.kegiatan')->with('success', 'Kegiatan berhasil disimpan. Buka sesi untuk menampilkan QR presensi.');
    }

    public function openSession(Kegiatan $kegiatan): RedirectResponse
    {
        DB::transaction(function () use ($kegiatan): void {
            $kegiatan = Kegiatan::query()->lockForUpdate()->findOrFail($kegiatan->id);

            if ($kegiatan->status !== Kegiatan::STATUS_AKAN_DATANG) {
                throw ValidationException::withMessages([
                    'sesi' => 'Sesi hanya dapat dibuka untuk kegiatan yang belum dimulai atau ditutup.',
                ]);
            }

            $kegiatan->update([
                'status' => Kegiatan::STATUS_BERLANGSUNG,
                'qr_code' => Str::random(48),
                'qr_expires_at' => null,
            ]);
        });

        return redirect()->route('psdi.kegiatan')
            ->with('success', 'Sesi berhasil dibuka. QR presensi sekarang aktif.')
            ->with('show_qr_for', $kegiatan->id);
    }

    public function closeSession(Kegiatan $kegiatan): RedirectResponse
    {
        DB::transaction(function () use ($kegiatan): void {
            $kegiatan = Kegiatan::query()->lockForUpdate()->findOrFail($kegiatan->id);

            if ($kegiatan->status !== Kegiatan::STATUS_BERLANGSUNG) {
                throw ValidationException::withMessages([
                    'sesi' => 'Hanya sesi yang sedang aktif yang dapat ditutup.',
                ]);
            }

            $kegiatan->update([
                'status' => Kegiatan::STATUS_SELESAI,
                'qr_expires_at' => now(),
            ]);
        });

        return redirect()->route('psdi.kegiatan')->with('success', 'Sesi berhasil ditutup. QR presensi tidak dapat digunakan lagi.');
    }
}
