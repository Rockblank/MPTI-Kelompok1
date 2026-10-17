@extends('layouts.bendahara')

@section('title', 'Jadwal Piket')
@section('page-title', 'Jadwal Piket')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Jadwal Piket</h2>
        <p class="text-sm text-gray-500 mt-1">Atur dan kelola jadwal piket anggota</p>
    </div>
    <button type="button" onclick="openModalTambahJadwal()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#1A6B6B] hover:bg-[#155757] text-white text-xs font-bold rounded-xl shadow-sm transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Jadwal
    </button>
</div>

{{-- Filters --}}
<div class="inline-flex flex-wrap items-center gap-2 bg-gray-100/80 p-1.5 rounded-2xl text-xs font-semibold mb-6">
    <button type="button" onclick="filterHari('all')" id="hari-all" class="hari-filter px-4 py-2 rounded-xl bg-[#2F3336] text-white transition shadow-sm">
        Semua
    </button>
    <button type="button" onclick="filterHari('senin')" id="hari-senin" class="hari-filter px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition">
        Senin
    </button>
    <button type="button" onclick="filterHari('selasa')" id="hari-selasa" class="hari-filter px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition">
        Selasa
    </button>
    <button type="button" onclick="filterHari('rabu')" id="hari-rabu" class="hari-filter px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition">
        Rabu
    </button>
    <button type="button" onclick="filterHari('kamis')" id="hari-kamis" class="hari-filter px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition">
        Kamis
    </button>
    <button type="button" onclick="filterHari('jumat')" id="hari-jumat" class="hari-filter px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition">
        Jumat
    </button>
</div>

{{-- Grid Day Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="jadwalGrid">
    {{-- Senin --}}
    <div class="day-card bg-white rounded-2xl p-6 border border-gray-100 shadow-sm" data-day="senin">
        <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-100">
            <h3 class="text-base font-bold text-gray-900">Senin</h3>
            <span class="text-xs text-gray-400">5 anggota</span>
        </div>
        <div class="space-y-5">
            {{-- Shift 1 --}}
            <div>
                <div class="flex items-center justify-between text-xs mb-2.5">
                    <span class="font-bold text-gray-900">08:00 – 10:00</span>
                    <span class="text-gray-400">Sekretariat</span>
                </div>
                <div class="flex flex-wrap gap-1.5">
                    <span class="px-3 py-1 bg-teal-50 text-[#1A6B6B] font-semibold text-xs rounded-full border border-teal-100">Budi</span>
                    <span class="px-3 py-1 bg-teal-50 text-[#1A6B6B] font-semibold text-xs rounded-full border border-teal-100">Dewi</span>
                    <span class="px-3 py-1 bg-teal-50 text-[#1A6B6B] font-semibold text-xs rounded-full border border-teal-100">Rizky</span>
                </div>
            </div>
            {{-- Shift 2 --}}
            <div class="pt-2 border-t border-gray-50">
                <div class="flex items-center justify-between text-xs mb-2.5">
                    <span class="font-bold text-gray-900">13:00 – 15:00</span>
                    <span class="text-gray-400">Sekretariat</span>
                </div>
                <div class="flex flex-wrap gap-1.5">
                    <span class="px-3 py-1 bg-teal-50 text-[#1A6B6B] font-semibold text-xs rounded-full border border-teal-100">Ahmad</span>
                    <span class="px-3 py-1 bg-teal-50 text-[#1A6B6B] font-semibold text-xs rounded-full border border-teal-100">Siti</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Selasa --}}
    <div class="day-card bg-white rounded-2xl p-6 border border-gray-100 shadow-sm" data-day="selasa">
        <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-100">
            <h3 class="text-base font-bold text-gray-900">Selasa</h3>
            <span class="text-xs text-gray-400">5 anggota</span>
        </div>
        <div class="space-y-5">
            {{-- Shift 1 --}}
            <div>
                <div class="flex items-center justify-between text-xs mb-2.5">
                    <span class="font-bold text-gray-900">08:00 – 10:00</span>
                    <span class="text-gray-400">Sekretariat</span>
                </div>
                <div class="flex flex-wrap gap-1.5">
                    <span class="px-3 py-1 bg-teal-50 text-[#1A6B6B] font-semibold text-xs rounded-full border border-teal-100">Maya</span>
                    <span class="px-3 py-1 bg-teal-50 text-[#1A6B6B] font-semibold text-xs rounded-full border border-teal-100">Cici</span>
                    <span class="px-3 py-1 bg-teal-50 text-[#1A6B6B] font-semibold text-xs rounded-full border border-teal-100">Dedy</span>
                </div>
            </div>
            {{-- Shift 2 --}}
            <div class="pt-2 border-t border-gray-50">
                <div class="flex items-center justify-between text-xs mb-2.5">
                    <span class="font-bold text-gray-900">13:00 – 15:00</span>
                    <span class="text-gray-400">Sekretariat</span>
                </div>
                <div class="flex flex-wrap gap-1.5">
                    <span class="px-3 py-1 bg-teal-50 text-[#1A6B6B] font-semibold text-xs rounded-full border border-teal-100">Eka</span>
                    <span class="px-3 py-1 bg-teal-50 text-[#1A6B6B] font-semibold text-xs rounded-full border border-teal-100">Fauzan</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Rabu --}}
    <div class="day-card bg-white rounded-2xl p-6 border border-gray-100 shadow-sm" data-day="rabu">
        <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-100">
            <h3 class="text-base font-bold text-gray-900">Rabu</h3>
            <span class="text-xs text-gray-400">2 anggota</span>
        </div>
        <div class="space-y-5">
            <div>
                <div class="flex items-center justify-between text-xs mb-2.5">
                    <span class="font-bold text-gray-900">08:00 – 10:00</span>
                    <span class="text-gray-400">Sekretariat</span>
                </div>
                <div class="flex flex-wrap gap-1.5">
                    <span class="px-3 py-1 bg-teal-50 text-[#1A6B6B] font-semibold text-xs rounded-full border border-teal-100">Gita</span>
                    <span class="px-3 py-1 bg-teal-50 text-[#1A6B6B] font-semibold text-xs rounded-full border border-teal-100">Hendra</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Kamis --}}
    <div class="day-card bg-white rounded-2xl p-6 border border-gray-100 shadow-sm" data-day="kamis">
        <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-100">
            <h3 class="text-base font-bold text-gray-900">Kamis</h3>
            <span class="text-xs text-gray-400">3 anggota</span>
        </div>
        <div class="space-y-5">
            <div>
                <div class="flex items-center justify-between text-xs mb-2.5">
                    <span class="font-bold text-gray-900">08:00 – 10:00</span>
                    <span class="text-gray-400">Sekretariat</span>
                </div>
                <div class="flex flex-wrap gap-1.5">
                    <span class="px-3 py-1 bg-teal-50 text-[#1A6B6B] font-semibold text-xs rounded-full border border-teal-100">Budi</span>
                    <span class="px-3 py-1 bg-teal-50 text-[#1A6B6B] font-semibold text-xs rounded-full border border-teal-100">Maya</span>
                    <span class="px-3 py-1 bg-teal-50 text-[#1A6B6B] font-semibold text-xs rounded-full border border-teal-100">Rizky</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Jumat --}}
    <div class="day-card bg-white rounded-2xl p-6 border border-gray-100 shadow-sm" data-day="jumat">
        <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-100">
            <h3 class="text-base font-bold text-gray-900">Jumat</h3>
            <span class="text-xs text-gray-400">2 anggota</span>
        </div>
        <div class="space-y-5">
            <div>
                <div class="flex items-center justify-between text-xs mb-2.5">
                    <span class="font-bold text-gray-900">08:00 – 10:00</span>
                    <span class="text-gray-400">Sekretariat</span>
                </div>
                <div class="flex flex-wrap gap-1.5">
                    <span class="px-3 py-1 bg-teal-50 text-[#1A6B6B] font-semibold text-xs rounded-full border border-teal-100">Ahmad</span>
                    <span class="px-3 py-1 bg-teal-50 text-[#1A6B6B] font-semibold text-xs rounded-full border border-teal-100">Cici</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
{{-- Modal Tambah Jadwal --}}
<div id="modalTambahJadwal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden border border-gray-100 animate-in fade-in zoom-in-95 duration-200">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-gray-900">Tambah Jadwal Piket</h3>
            <button type="button" onclick="closeModalTambahJadwal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form onsubmit="handleSimpanJadwal(event)" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Hari</label>
                <select required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B]">
                    <option value="senin">Senin</option>
                    <option value="selasa">Selasa</option>
                    <option value="rabu">Rabu</option>
                    <option value="kamis">Kamis</option>
                    <option value="jumat">Jumat</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Jam / Shift</label>
                <select required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B]">
                    <option value="08:00 - 10:00">08:00 – 10:00 (Pagi)</option>
                    <option value="10:00 - 12:00">10:00 – 12:00 (Siang 1)</option>
                    <option value="13:00 - 15:00">13:00 – 15:00 (Siang 2)</option>
                    <option value="15:00 - 17:00">15:00 – 17:00 (Sore)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Lokasi</label>
                <input type="text" value="Sekretariat BEM FILKOM" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B]">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Pilih Anggota</label>
                <div class="grid grid-cols-2 gap-2 border border-gray-200 p-3 rounded-xl max-h-36 overflow-y-auto text-xs text-gray-700">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="rounded text-[#1A6B6B] focus:ring-[#1A6B6B]">
                        <span>Budi Santoso</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="rounded text-[#1A6B6B] focus:ring-[#1A6B6B]">
                        <span>Dewi Lestari</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="rounded text-[#1A6B6B] focus:ring-[#1A6B6B]">
                        <span>Rizky Aditya</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="rounded text-[#1A6B6B] focus:ring-[#1A6B6B]">
                        <span>Ahmad Reza</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="rounded text-[#1A6B6B] focus:ring-[#1A6B6B]">
                        <span>Siti Rahayu</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-3">
                <button type="button" onclick="closeModalTambahJadwal()"
                        class="w-full py-2.5 px-4 rounded-xl border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="w-full py-2.5 px-4 rounded-xl bg-[#1A6B6B] hover:bg-[#155757] text-xs font-bold text-white transition shadow-sm">
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function openModalTambahJadwal() {
        document.getElementById('modalTambahJadwal').classList.remove('hidden');
    }
    function closeModalTambahJadwal() {
        document.getElementById('modalTambahJadwal').classList.add('hidden');
    }
    function handleSimpanJadwal(e) {
        e.preventDefault();
        alert('Jadwal piket berhasil disimpan!');
        closeModalTambahJadwal();
    }

    function filterHari(hari) {
        const cards = document.querySelectorAll('.day-card');
        const buttons = document.querySelectorAll('.hari-filter');

        buttons.forEach(b => {
            b.className = 'hari-filter px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition';
        });

        const activeBtn = document.getElementById('hari-' + hari);
        if (activeBtn) {
            activeBtn.className = 'hari-filter px-4 py-2 rounded-xl bg-[#2F3336] text-white transition shadow-sm';
        }

        cards.forEach(card => {
            if (hari === 'all' || card.dataset.day === hari) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@endpush
