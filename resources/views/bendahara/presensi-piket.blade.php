@extends('layouts.bendahara')

@section('title', 'Presensi Piket')
@section('page-title', 'Presensi Piket')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Presensi Piket</h2>
    <p class="text-sm text-gray-500 mt-1">Rekaman kehadiran piket anggota</p>
</div>

{{-- 3 Top Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
        <div class="text-4xl font-black text-emerald-600 tracking-tight">5</div>
        <div class="text-xs font-semibold text-gray-500 mt-1">Hadir</div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
        <div class="text-4xl font-black text-red-600 tracking-tight">2</div>
        <div class="text-xs font-semibold text-gray-500 mt-1">Alpha</div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
        <div class="text-4xl font-black text-amber-500 tracking-tight">1</div>
        <div class="text-xs font-semibold text-gray-500 mt-1">Izin</div>
    </div>
</div>

{{-- Filters --}}
<div class="inline-flex items-center gap-2 bg-gray-100/80 p-1.5 rounded-2xl text-xs font-semibold mb-6">
    <button type="button" onclick="filterPresensi('all')" id="pres-all" class="pres-filter px-4 py-2 rounded-xl bg-[#1A6B6B] text-white transition shadow-sm">
        Semua
    </button>
    <button type="button" onclick="filterPresensi('hadir')" id="pres-hadir" class="pres-filter px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition">
        Hadir
    </button>
    <button type="button" onclick="filterPresensi('alpha')" id="pres-alpha" class="pres-filter px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition">
        Alpha
    </button>
    <button type="button" onclick="filterPresensi('izin')" id="pres-izin" class="pres-filter px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition">
        Izin
    </button>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50/70 text-gray-400 font-semibold uppercase tracking-wider border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3.5">Anggota</th>
                    <th class="px-6 py-3.5">Hari / Shift</th>
                    <th class="px-6 py-3.5">Tanggal</th>
                    <th class="px-6 py-3.5">Keterangan</th>
                    <th class="px-6 py-3.5 text-center">Status</th>
                    <th class="px-6 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100/70 text-gray-700" id="presensiTableBody">
                {{-- Row 1 --}}
                <tr class="presensi-row hover:bg-gray-50/50 transition" data-status="hadir">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Budi Santoso</div>
                        <div class="text-[11px] text-gray-400">215150700111001</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-800">Senin</div>
                        <div class="text-[11px] text-gray-400">08:00 – 10:00</div>
                    </td>
                    <td class="px-6 py-4 text-gray-700">22/09/2025</td>
                    <td class="px-6 py-4 text-gray-400">—</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 font-bold text-[11px] rounded-full border border-emerald-200">
                            Hadir
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button type="button" onclick="openEditPresensi('Budi Santoso', '215150700111001', 'Hadir', '—')"
                                class="text-xs font-bold text-[#1A6B6B] hover:underline">
                            Edit
                        </button>
                    </td>
                </tr>

                {{-- Row 2 --}}
                <tr class="presensi-row hover:bg-gray-50/50 transition" data-status="hadir">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Dewi Lestari</div>
                        <div class="text-[11px] text-gray-400">215150700111002</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-800">Senin</div>
                        <div class="text-[11px] text-gray-400">08:00 – 10:00</div>
                    </td>
                    <td class="px-6 py-4 text-gray-700">22/09/2025</td>
                    <td class="px-6 py-4 text-gray-400">—</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 font-bold text-[11px] rounded-full border border-emerald-200">
                            Hadir
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button type="button" onclick="openEditPresensi('Dewi Lestari', '215150700111002', 'Hadir', '—')"
                                class="text-xs font-bold text-[#1A6B6B] hover:underline">
                            Edit
                        </button>
                    </td>
                </tr>

                {{-- Row 3 --}}
                <tr class="presensi-row hover:bg-gray-50/50 transition" data-status="alpha">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Rizky Aditya</div>
                        <div class="text-[11px] text-gray-400">215150700111003</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-800">Senin</div>
                        <div class="text-[11px] text-gray-400">08:00 – 10:00</div>
                    </td>
                    <td class="px-6 py-4 text-gray-700">22/09/2025</td>
                    <td class="px-6 py-4 text-gray-600">Tidak ada pemberitahuan</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-red-50 text-red-600 font-bold text-[11px] rounded-full border border-red-200">
                            Alpha
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button type="button" onclick="openEditPresensi('Rizky Aditya', '215150700111003', 'Alpha', 'Tidak ada pemberitahuan')"
                                class="text-xs font-bold text-[#1A6B6B] hover:underline">
                            Edit
                        </button>
                    </td>
                </tr>

                {{-- Row 4 --}}
                <tr class="presensi-row hover:bg-gray-50/50 transition" data-status="izin">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Ahmad Reza</div>
                        <div class="text-[11px] text-gray-400">215150700111005</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-800">Senin</div>
                        <div class="text-[11px] text-gray-400">13:00 – 15:00</div>
                    </td>
                    <td class="px-6 py-4 text-gray-700">22/09/2025</td>
                    <td class="px-6 py-4 text-gray-600">Sakit (ada surat)</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-amber-50 text-amber-700 font-bold text-[11px] rounded-full border border-amber-200">
                            Izin
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button type="button" onclick="openEditPresensi('Ahmad Reza', '215150700111005', 'Izin', 'Sakit (ada surat)')"
                                class="text-xs font-bold text-[#1A6B6B] hover:underline">
                            Edit
                        </button>
                    </td>
                </tr>

                {{-- Row 5 --}}
                <tr class="presensi-row hover:bg-gray-50/50 transition" data-status="hadir">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Siti Rahayu</div>
                        <div class="text-[11px] text-gray-400">215150700111004</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-800">Selasa</div>
                        <div class="text-[11px] text-gray-400">08:00 – 10:00</div>
                    </td>
                    <td class="px-6 py-4 text-gray-700">23/09/2025</td>
                    <td class="px-6 py-4 text-gray-400">—</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 font-bold text-[11px] rounded-full border border-emerald-200">
                            Hadir
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button type="button" onclick="openEditPresensi('Siti Rahayu', '215150700111004', 'Hadir', '—')"
                                class="text-xs font-bold text-[#1A6B6B] hover:underline">
                            Edit
                        </button>
                    </td>
                </tr>

                {{-- Row 6 --}}
                <tr class="presensi-row hover:bg-gray-50/50 transition" data-status="alpha">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Maya Putri</div>
                        <div class="text-[11px] text-gray-400">215150700111006</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-800">Selasa</div>
                        <div class="text-[11px] text-gray-400">08:00 – 10:00</div>
                    </td>
                    <td class="px-6 py-4 text-gray-700">23/09/2025</td>
                    <td class="px-6 py-4 text-gray-400">—</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-red-50 text-red-600 font-bold text-[11px] rounded-full border border-red-200">
                            Alpha
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button type="button" onclick="openEditPresensi('Maya Putri', '215150700111006', 'Alpha', '—')"
                                class="text-xs font-bold text-[#1A6B6B] hover:underline">
                            Edit
                        </button>
                    </td>
                </tr>

                {{-- Row 7 --}}
                <tr class="presensi-row hover:bg-gray-50/50 transition" data-status="hadir">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Cici Amelia</div>
                        <div class="text-[11px] text-gray-400">215150700111007</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-800">Selasa</div>
                        <div class="text-[11px] text-gray-400">08:00 – 10:00</div>
                    </td>
                    <td class="px-6 py-4 text-gray-700">23/09/2025</td>
                    <td class="px-6 py-4 text-gray-400">—</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 font-bold text-[11px] rounded-full border border-emerald-200">
                            Hadir
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button type="button" onclick="openEditPresensi('Cici Amelia', '215150700111007', 'Hadir', '—')"
                                class="text-xs font-bold text-[#1A6B6B] hover:underline">
                            Edit
                        </button>
                    </td>
                </tr>

                {{-- Row 8 --}}
                <tr class="presensi-row hover:bg-gray-50/50 transition" data-status="hadir">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Gita Anggraini</div>
                        <div class="text-[11px] text-gray-400">215150700111011</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-800">Rabu</div>
                        <div class="text-[11px] text-gray-400">08:00 – 10:00</div>
                    </td>
                    <td class="px-6 py-4 text-gray-700">24/09/2025</td>
                    <td class="px-6 py-4 text-gray-400">—</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 font-bold text-[11px] rounded-full border border-emerald-200">
                            Hadir
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button type="button" onclick="openEditPresensi('Gita Anggraini', '215150700111011', 'Hadir', '—')"
                                class="text-xs font-bold text-[#1A6B6B] hover:underline">
                            Edit
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('modals')
{{-- Modal Edit Presensi --}}
<div id="modalEditPresensi" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden border border-gray-100 animate-in fade-in zoom-in-95 duration-200">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-gray-900">Ubah Status Presensi</h3>
            <button type="button" onclick="closeEditPresensi()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form onsubmit="handleSimpanEditPresensi(event)" class="p-6 space-y-4">
            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100 text-xs">
                <div class="text-gray-400">Anggota</div>
                <div id="modalAnggotaNama" class="font-bold text-gray-900 text-sm">-</div>
                <div id="modalAnggotaNim" class="text-gray-500 text-[11px]">-</div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Status Kehadiran</label>
                <select id="modalStatusSelect" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B]">
                    <option value="Hadir">Hadir</option>
                    <option value="Izin">Izin</option>
                    <option value="Alpha">Alpha</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Keterangan Tambahan</label>
                <textarea id="modalKeteranganInput" rows="2" placeholder="Alasan izin / sakit..."
                          class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B] resize-none"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-3">
                <button type="button" onclick="closeEditPresensi()"
                        class="w-full py-2.5 px-4 rounded-xl border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="w-full py-2.5 px-4 rounded-xl bg-[#1A6B6B] hover:bg-[#155757] text-xs font-bold text-white transition shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function openEditPresensi(nama, nim, status, ket) {
        document.getElementById('modalAnggotaNama').innerText = nama;
        document.getElementById('modalAnggotaNim').innerText = nim;
        document.getElementById('modalStatusSelect').value = status;
        document.getElementById('modalKeteranganInput').value = ket === '—' ? '' : ket;
        document.getElementById('modalEditPresensi').classList.remove('hidden');
    }

    function closeEditPresensi() {
        document.getElementById('modalEditPresensi').classList.add('hidden');
    }

    function handleSimpanEditPresensi(e) {
        e.preventDefault();
        alert('Presensi berhasil diperbarui!');
        closeEditPresensi();
    }

    function filterPresensi(status) {
        const rows = document.querySelectorAll('.presensi-row');
        const buttons = document.querySelectorAll('.pres-filter');

        buttons.forEach(b => {
            b.className = 'pres-filter px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition';
        });

        const activeBtn = document.getElementById('pres-' + status);
        if (activeBtn) {
            activeBtn.className = 'pres-filter px-4 py-2 rounded-xl bg-[#1A6B6B] text-white transition shadow-sm';
        }

        rows.forEach(r => {
            if (status === 'all') {
                r.style.display = '';
            } else if (r.dataset.status === status) {
                r.style.display = '';
            } else {
                r.style.display = 'none';
            }
        });
    }
</script>
@endpush
