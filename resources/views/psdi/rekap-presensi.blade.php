@extends('layouts.psdi')

@section('title', 'Rekap Presensi')
@section('page-title', 'Rekap Presensi')

@section('content')
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Rekap Presensi Terpusat</h2>
        <p class="text-sm text-gray-500 mt-1">Statistik kehadiran seluruh fungsionaris pada agenda BEM yang tercatat.</p>
    </div>
    <a href="{{ route('psdi.rekap-presensi.export') }}"
       class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#1A6B6B] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#155757]">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M7 10l5 5 5-5M12 15V3" />
        </svg>
        Unduh Rekap CSV
    </a>
</div>

<section aria-label="Ringkasan presensi" class="grid grid-cols-2 gap-4 lg:grid-cols-5 mb-6">
    <div class="rounded-2xl border border-gray-100 bg-white p-5 text-center shadow-sm">
        <div class="text-3xl font-black text-emerald-600">{{ $ringkasanUmum['rataRata'] }}%</div>
        <div class="mt-1 text-xs font-semibold text-gray-500">Rata-rata Kehadiran</div>
    </div>
    <div class="rounded-2xl border border-gray-100 bg-white p-5 text-center shadow-sm">
        <div class="text-3xl font-black text-emerald-600">{{ $ringkasanUmum['totalHadir'] }}</div>
        <div class="mt-1 text-xs font-semibold text-gray-500">Total Hadir</div>
    </div>
    <div class="rounded-2xl border border-gray-100 bg-white p-5 text-center shadow-sm">
        <div class="text-3xl font-black text-amber-500">{{ $ringkasanUmum['totalIzin'] }}</div>
        <div class="mt-1 text-xs font-semibold text-gray-500">Total Izin</div>
    </div>
    <div class="rounded-2xl border border-gray-100 bg-white p-5 text-center shadow-sm">
        <div class="text-3xl font-black text-red-600">{{ $ringkasanUmum['totalAlpha'] }}</div>
        <div class="mt-1 text-xs font-semibold text-gray-500">Total Alpha</div>
    </div>
    <div class="col-span-2 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm lg:col-span-1">
        <div class="flex items-center justify-between">
            <span class="text-3xl font-black text-[#1A6B6B]">{{ $ringkasanUmum['kelengkapan'] }}%</span>
            <span class="rounded-full px-2.5 py-1 text-[11px] font-bold {{ $ringkasanUmum['totalStatus'] > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                {{ $ringkasanUmum['totalStatus'] > 0 ? 'Lengkap' : 'Menunggu data' }}
            </span>
        </div>
        <div class="mt-1 text-xs font-semibold text-gray-500">Kelengkapan Data</div>
        <div class="mt-3 h-2 overflow-hidden rounded-full bg-gray-100">
            <div class="h-full rounded-full bg-[#1A8A8A]" style="width: {{ $ringkasanUmum['kelengkapan'] }}%"></div>
        </div>
    </div>
</section>

<p class="mb-6 text-xs text-gray-500">
    Kelengkapan dihitung dari status setiap fungsionaris pada agenda yang selesai. Jika tidak ada catatan presensi atau izin, statusnya dihitung sebagai Alpha. Agenda aktif dan mendatang belum masuk statistik.
    {{ $ringkasanUmum['totalStatus'] }} status dievaluasi dari {{ $ringkasanUmum['totalKegiatanSelesai'] }} agenda selesai.
</p>

<section class="mb-6 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
    <div class="border-b border-gray-100 p-5">
        <h3 class="text-base font-bold text-gray-900">Kehadiran per Fungsionaris</h3>
        <p class="mt-1 text-xs text-gray-500">Persentase = jumlah hadir dibagi seluruh agenda selesai.</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full min-w-[720px] text-left text-sm">
            <thead class="bg-gray-50/70 text-xs uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="px-5 py-3">Fungsionaris</th>
                    <th class="px-5 py-3 text-center">Hadir</th>
                    <th class="px-5 py-3 text-center">Izin</th>
                    <th class="px-5 py-3 text-center">Alpha</th>
                    <th class="px-5 py-3 text-right">Kehadiran</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($anggota as $user)
                    @php
                        $stat = $ringkasan[$user->id];
                    @endphp
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-5 py-4">
                            <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $user->nim ?? $user->email }} · {{ $user->departemen ?? $user->role }}</div>
                        </td>
                        <td class="px-5 py-4 text-center font-bold text-emerald-600">{{ $stat['hadir'] }}</td>
                        <td class="px-5 py-4 text-center font-bold text-amber-600">{{ $stat['izin'] }}</td>
                        <td class="px-5 py-4 text-center font-bold text-red-600">{{ $stat['alpha'] }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-3">
                                <div class="h-2 w-24 overflow-hidden rounded-full bg-gray-100">
                                    <div class="h-full rounded-full {{ $stat['persentase'] >= 75 ? 'bg-[#1A6B6B]' : 'bg-red-500' }}" style="width: {{ $stat['persentase'] }}%"></div>
                                </div>
                                <span class="w-10 text-right font-bold">{{ $stat['persentase'] }}%</span>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500">Belum ada data fungsionaris.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<section class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
    <div class="border-b border-gray-100 p-5">
        <h3 class="text-base font-bold text-gray-900">Kehadiran per Kegiatan</h3>
        <p class="mt-1 text-xs text-gray-500">Kelengkapan berstatus 100% setelah agenda selesai dan status Alpha yang belum tercatat dihitung otomatis.</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full min-w-[720px] text-left text-sm">
            <thead class="bg-gray-50/70 text-xs uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="px-5 py-3">Kegiatan</th>
                    <th class="px-5 py-3 text-center">Hadir</th>
                    <th class="px-5 py-3 text-center">Izin</th>
                    <th class="px-5 py-3 text-center">Alpha</th>
                    <th class="px-5 py-3 text-right">Kelengkapan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($kegiatan as $event)
                    @php
                        $eventHadir = $event->presensis->where('status', 'hadir')->count();
                        $eventIzin = $event->presensis->where('status', 'izin')->count();
                        $eventAlpha = $event->status === \App\Models\Kegiatan::STATUS_SELESAI
                            ? max(0, $anggota->count() - $eventHadir - $eventIzin)
                            : $event->presensis->where('status', 'tidak-hadir')->count();
                    @endphp
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-5 py-4">
                            <div class="font-semibold text-gray-900">{{ $event->nama }}</div>
                            <div class="text-xs text-gray-500">{{ $event->tanggal->locale('id')->isoFormat('D MMMM Y') }} · {{ $event->status }}</div>
                        </td>
                        <td class="px-5 py-4 text-center font-bold text-emerald-600">{{ $eventHadir }}</td>
                        <td class="px-5 py-4 text-center font-bold text-amber-600">{{ $eventIzin }}</td>
                        <td class="px-5 py-4 text-center font-bold text-red-600">{{ $eventAlpha }}</td>
                        <td class="px-5 py-4 text-right font-bold {{ $event->status === \App\Models\Kegiatan::STATUS_SELESAI ? 'text-emerald-600' : 'text-gray-500' }}">
                            {{ $event->status === \App\Models\Kegiatan::STATUS_SELESAI ? '100%' : 'Dalam proses' }}
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500">Belum ada kegiatan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
