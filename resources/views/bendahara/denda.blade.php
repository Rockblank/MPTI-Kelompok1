@extends('layouts.bendahara')

@section('title', 'Denda')
@section('page-title', 'Denda')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Denda</h2>
        <p class="text-sm text-gray-500 mt-1">Manajemen denda piket dan kegiatan anggota</p>
    </div>
    <button type="button" onclick="openModalTambahDenda()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#1A6B6B] hover:bg-[#155757] text-white text-xs font-bold rounded-xl shadow-sm transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Denda
    </button>
</div>

{{-- 2 Top Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6 max-w-2xl">
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="text-xs font-semibold text-gray-500 mb-1.5">Belum Bayar</div>
        <div class="text-3xl font-black text-red-600 tracking-tight">Rp125.000</div>
        <div class="text-xs text-gray-400 mt-1">4 anggota</div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="text-xs font-semibold text-gray-500 mb-1.5">Sudah Lunas</div>
        <div class="text-3xl font-black text-emerald-600 tracking-tight">Rp75.000</div>
        <div class="text-xs text-gray-400 mt-1">2 anggota</div>
    </div>
</div>

{{-- Filters --}}
<div class="inline-flex items-center gap-2 bg-gray-100/80 p-1.5 rounded-2xl text-xs font-semibold mb-6">
    <button type="button" onclick="filterDenda('all')" id="denda-all" class="denda-filter px-4 py-2 rounded-xl bg-[#1A6B6B] text-white transition shadow-sm">
        Semua
    </button>
    <button type="button" onclick="filterDenda('belum')" id="denda-belum" class="denda-filter px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition">
        Belum Bayar
    </button>
    <button type="button" onclick="filterDenda('lunas')" id="denda-lunas" class="denda-filter px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition">
        Lunas
    </button>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50/70 text-gray-400 font-semibold uppercase tracking-wider border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3.5">Anggota</th>
                    <th class="px-6 py-3.5">Jenis</th>
                    <th class="px-6 py-3.5">Alasan</th>
                    <th class="px-6 py-3.5 text-right">Nominal</th>
                    <th class="px-6 py-3.5 text-center">Status</th>
                    <th class="px-6 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100/70 text-gray-700" id="dendaTableBody">
                {{-- Row 1 --}}
                <tr class="denda-row hover:bg-gray-50/50 transition" data-status="belum">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Ahmad Reza</div>
                        <div class="text-[11px] text-gray-400">215150700111005</div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-700">Denda Piket</td>
                    <td class="px-6 py-4 text-gray-500">Tidak hadir piket 15/09</td>
                    <td class="px-6 py-4 text-right font-bold text-red-600 text-sm whitespace-nowrap">Rp25.000</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-red-50 text-red-600 font-bold text-[11px] rounded-full border border-red-200">
                            Belum Bayar
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button type="button" onclick="openDetailDenda('Ahmad Reza', '215150700111005', 'Denda Piket', 'Tidak hadir piket 15/09', 'Rp25.000', 'Belum Bayar')"
                                class="text-xs font-bold text-[#1A6B6B] hover:underline">
                            Detail
                        </button>
                    </td>
                </tr>

                {{-- Row 2 --}}
                <tr class="denda-row hover:bg-gray-50/50 transition" data-status="lunas">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Budi Santoso</div>
                        <div class="text-[11px] text-gray-400">215150700111001</div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-700">Denda Piket</td>
                    <td class="px-6 py-4 text-gray-500">Tidak hadir piket 12/09</td>
                    <td class="px-6 py-4 text-right font-bold text-red-600 text-sm whitespace-nowrap">Rp25.000</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 font-bold text-[11px] rounded-full border border-emerald-200">
                            Lunas
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button type="button" onclick="openDetailDenda('Budi Santoso', '215150700111001', 'Denda Piket', 'Tidak hadir piket 12/09', 'Rp25.000', 'Lunas')"
                                class="text-xs font-bold text-[#1A6B6B] hover:underline">
                            Detail
                        </button>
                    </td>
                </tr>

                {{-- Row 3 --}}
                <tr class="denda-row hover:bg-gray-50/50 transition" data-status="belum">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Cici Amelia</div>
                        <div class="text-[11px] text-gray-400">215150700111007</div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-700">Denda Kegiatan</td>
                    <td class="px-6 py-4 text-gray-500">Alpha kegiatan wajib</td>
                    <td class="px-6 py-4 text-right font-bold text-red-600 text-sm whitespace-nowrap">Rp50.000</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-red-50 text-red-600 font-bold text-[11px] rounded-full border border-red-200">
                            Belum Bayar
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button type="button" onclick="openDetailDenda('Cici Amelia', '215150700111007', 'Denda Kegiatan', 'Alpha kegiatan wajib', 'Rp50.000', 'Belum Bayar')"
                                class="text-xs font-bold text-[#1A6B6B] hover:underline">
                            Detail
                        </button>
                    </td>
                </tr>

                {{-- Row 4 --}}
                <tr class="denda-row hover:bg-gray-50/50 transition" data-status="belum">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Dedy Permana</div>
                        <div class="text-[11px] text-gray-400">215150700111008</div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-700">Denda Piket</td>
                    <td class="px-6 py-4 text-gray-500">Tidak hadir piket 08/09</td>
                    <td class="px-6 py-4 text-right font-bold text-red-600 text-sm whitespace-nowrap">Rp25.000</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-red-50 text-red-600 font-bold text-[11px] rounded-full border border-red-200">
                            Belum Bayar
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button type="button" onclick="openDetailDenda('Dedy Permana', '215150700111008', 'Denda Piket', 'Tidak hadir piket 08/09', 'Rp25.000', 'Belum Bayar')"
                                class="text-xs font-bold text-[#1A6B6B] hover:underline">
                            Detail
                        </button>
                    </td>
                </tr>

                {{-- Row 5 --}}
                <tr class="denda-row hover:bg-gray-50/50 transition" data-status="lunas">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Eka Yulianti</div>
                        <div class="text-[11px] text-gray-400">215150700111009</div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-700">Denda Kegiatan</td>
                    <td class="px-6 py-4 text-gray-500">Alpha kegiatan wajib</td>
                    <td class="px-6 py-4 text-right font-bold text-red-600 text-sm whitespace-nowrap">Rp50.000</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 font-bold text-[11px] rounded-full border border-emerald-200">
                            Lunas
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button type="button" onclick="openDetailDenda('Eka Yulianti', '215150700111009', 'Denda Kegiatan', 'Alpha kegiatan wajib', 'Rp50.000', 'Lunas')"
                                class="text-xs font-bold text-[#1A6B6B] hover:underline">
                            Detail
                        </button>
                    </td>
                </tr>

                {{-- Row 6 --}}
                <tr class="denda-row hover:bg-gray-50/50 transition" data-status="belum">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Fauzan Malik</div>
                        <div class="text-[11px] text-gray-400">215150700111010</div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-700">Denda Piket</td>
                    <td class="px-6 py-4 text-gray-500">Tidak hadir piket 03/09</td>
                    <td class="px-6 py-4 text-right font-bold text-red-600 text-sm whitespace-nowrap">Rp25.000</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-red-50 text-red-600 font-bold text-[11px] rounded-full border border-red-200">
                            Belum Bayar
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button type="button" onclick="openDetailDenda('Fauzan Malik', '215150700111010', 'Denda Piket', 'Tidak hadir piket 03/09', 'Rp25.000', 'Belum Bayar')"
                                class="text-xs font-bold text-[#1A6B6B] hover:underline">
                            Detail
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('modals')
{{-- Modal Tambah Denda --}}
<div id="modalTambahDenda" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden border border-gray-100 animate-in fade-in zoom-in-95 duration-200">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-gray-900">Tambah Denda Anggota</h3>
            <button type="button" onclick="closeModalTambahDenda()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form onsubmit="handleSimpanDenda(event)" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Pilih Anggota</label>
                <select required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B]">
                    <option value="">Pilih Anggota...</option>
                    <option value="1">Ahmad Reza (215150700111005)</option>
                    <option value="2">Budi Santoso (215150700111001)</option>
                    <option value="3">Cici Amelia (215150700111007)</option>
                    <option value="4">Dedy Permana (215150700111008)</option>
                    <option value="5">Dewi Lestari (215150700111002)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Jenis Denda</label>
                <select required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B]">
                    <option value="piket">Denda Piket (Rp25.000)</option>
                    <option value="kegiatan">Denda Kegiatan (Rp50.000)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Alasan Denda</label>
                <input type="text" required placeholder="Contoh: Tidak hadir piket 15/09"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B]">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nominal (Rp)</label>
                <input type="number" required value="25000"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B]">
            </div>

            <div class="grid grid-cols-2 gap-3 pt-3">
                <button type="button" onclick="closeModalTambahDenda()"
                        class="w-full py-2.5 px-4 rounded-xl border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="w-full py-2.5 px-4 rounded-xl bg-[#1A6B6B] hover:bg-[#155757] text-xs font-bold text-white transition shadow-sm">
                    Simpan Denda
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Detail Denda --}}
<div id="modalDetailDenda" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden border border-gray-100 animate-in fade-in zoom-in-95 duration-200">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-gray-900">Detail Denda</h3>
            <button type="button" onclick="closeDetailDenda()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-6 space-y-4">
            <div class="space-y-3 bg-gray-50 p-4 rounded-2xl border border-gray-100 text-xs">
                <div class="flex justify-between">
                    <span class="text-gray-400">Nama Anggota</span>
                    <span id="detailNama" class="font-bold text-gray-900">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">NIM</span>
                    <span id="detailNim" class="font-bold text-gray-700">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Jenis Denda</span>
                    <span id="detailJenis" class="font-bold text-gray-700">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Alasan</span>
                    <span id="detailAlasan" class="font-semibold text-gray-800 text-right">-</span>
                </div>
                <div class="flex justify-between items-center border-t border-gray-200/60 pt-2">
                    <span class="text-gray-400">Nominal</span>
                    <span id="detailNominal" class="font-black text-red-600 text-base">-</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400">Status</span>
                    <span id="detailStatus" class="font-bold px-2.5 py-0.5 rounded-full text-[11px]">-</span>
                </div>
            </div>

            <div class="pt-2">
                <button type="button" onclick="tandaiLunas()" id="btnTandaiLunas"
                        class="w-full py-2.5 px-4 rounded-xl bg-[#1A6B6B] hover:bg-[#155757] text-xs font-bold text-white transition shadow-sm">
                    Tandai Sebagai Lunas
                </button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function openModalTambahDenda() {
        document.getElementById('modalTambahDenda').classList.remove('hidden');
    }
    function closeModalTambahDenda() {
        document.getElementById('modalTambahDenda').classList.add('hidden');
    }
    function handleSimpanDenda(e) {
        e.preventDefault();
        alert('Denda berhasil ditambahkan!');
        closeModalTambahDenda();
    }

    function openDetailDenda(nama, nim, jenis, alasan, nominal, status) {
        document.getElementById('detailNama').innerText = nama;
        document.getElementById('detailNim').innerText = nim;
        document.getElementById('detailJenis').innerText = jenis;
        document.getElementById('detailAlasan').innerText = alasan;
        document.getElementById('detailNominal').innerText = nominal;

        const statusEl = document.getElementById('detailStatus');
        const btnLunas = document.getElementById('btnTandaiLunas');
        statusEl.innerText = status;

        if (status === 'Lunas') {
            statusEl.className = 'font-bold px-2.5 py-0.5 rounded-full text-[11px] bg-emerald-50 text-emerald-700 border border-emerald-200';
            btnLunas.classList.add('hidden');
        } else {
            statusEl.className = 'font-bold px-2.5 py-0.5 rounded-full text-[11px] bg-red-50 text-red-600 border border-red-200';
            btnLunas.classList.remove('hidden');
        }

        document.getElementById('modalDetailDenda').classList.remove('hidden');
    }

    function closeDetailDenda() {
        document.getElementById('modalDetailDenda').classList.add('hidden');
    }

    function tandaiLunas() {
        alert('Status denda berhasil diperbarui menjadi Lunas!');
        closeDetailDenda();
    }

    function filterDenda(status) {
        const rows = document.querySelectorAll('.denda-row');
        const buttons = document.querySelectorAll('.denda-filter');

        buttons.forEach(b => {
            b.className = 'denda-filter px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition';
        });

        const activeBtn = document.getElementById('denda-' + status);
        if (activeBtn) {
            activeBtn.className = 'denda-filter px-4 py-2 rounded-xl bg-[#1A6B6B] text-white transition shadow-sm';
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
