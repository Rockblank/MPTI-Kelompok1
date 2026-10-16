@extends('layouts.bendahara')

@section('title', 'Kas')
@section('page-title', 'Kas')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Kas</h2>
        <p class="text-sm text-gray-500 mt-1">Pencatatan kas masuk dan keluar BEM FILKOM UB</p>
    </div>
    <button type="button" onclick="openModalTambah()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#1A6B6B] hover:bg-[#155757] text-white text-sm font-semibold rounded-xl shadow-sm transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Transaksi
    </button>
</div>

{{-- 3 Top Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
    <div class="bg-white rounded-2xl p-5 border border-gray-100/80 shadow-sm">
        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Saldo Saat Ini</div>
        <div class="text-3xl font-black text-[#1A6B6B] tracking-tight">Rp19.250.000</div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100/80 shadow-sm">
        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Total Pemasukan</div>
        <div class="text-3xl font-black text-emerald-600 tracking-tight">Rp22.350.000</div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100/80 shadow-sm">
        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Total Pengeluaran</div>
        <div class="text-3xl font-black text-red-600 tracking-tight">Rp3.100.000</div>
    </div>
</div>

{{-- Riwayat Transaksi Card --}}
<div class="bg-white rounded-2xl border border-gray-100/80 shadow-sm overflow-hidden">
    {{-- Header & Filter --}}
    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h3 class="text-base font-bold text-gray-900">Riwayat Transaksi</h3>
        <div class="inline-flex items-center gap-1.5 bg-gray-100/80 p-1 rounded-xl text-xs font-semibold">
            <button type="button" onclick="filterKas('all')" id="filter-all" class="filter-btn px-4 py-1.5 rounded-lg bg-[#1A6B6B] text-white transition shadow-sm">
                Semua
            </button>
            <button type="button" onclick="filterKas('masuk')" id="filter-masuk" class="filter-btn px-4 py-1.5 rounded-lg text-gray-600 hover:text-gray-900 transition">
                Masuk
            </button>
            <button type="button" onclick="filterKas('keluar')" id="filter-keluar" class="filter-btn px-4 py-1.5 rounded-lg text-gray-600 hover:text-gray-900 transition">
                Keluar
            </button>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50/70 text-gray-400 font-semibold uppercase tracking-wider border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3.5">Tanggal</th>
                    <th class="px-6 py-3.5">Keterangan</th>
                    <th class="px-6 py-3.5 text-center">Jenis</th>
                    <th class="px-6 py-3.5 text-right">Nominal</th>
                    <th class="px-6 py-3.5 text-right">Saldo</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100/70 text-gray-700" id="kasTableBody">
                {{-- Row 1 --}}
                <tr class="kas-row" data-type="masuk">
                    <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">01/09/2025</td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Saldo Awal</div>
                        <div class="text-[11px] text-gray-400">Saldo awal periode</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                            ↑ Masuk
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-emerald-600 text-sm whitespace-nowrap">+Rp20.000.000</td>
                    <td class="px-6 py-4 text-right font-bold text-gray-900 text-sm whitespace-nowrap">Rp20.000.000</td>
                </tr>

                {{-- Row 2 --}}
                <tr class="kas-row" data-type="masuk">
                    <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">05/09/2025</td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Iuran Kas Bulanan</div>
                        <div class="text-[11px] text-gray-400">32 anggota &times; Rp50.000</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                            ↑ Masuk
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-emerald-600 text-sm whitespace-nowrap">+Rp1.600.000</td>
                    <td class="px-6 py-4 text-right font-bold text-gray-900 text-sm whitespace-nowrap">Rp21.600.000</td>
                </tr>

                {{-- Row 3 --}}
                <tr class="kas-row" data-type="keluar">
                    <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">10/09/2025</td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Pembelian ATK</div>
                        <div class="text-[11px] text-gray-400">Alat tulis kantor</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-red-600 bg-red-50 px-3 py-1 rounded-full border border-red-200">
                            ↓ Keluar
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-red-600 text-sm whitespace-nowrap">-Rp450.000</td>
                    <td class="px-6 py-4 text-right font-bold text-gray-900 text-sm whitespace-nowrap">Rp21.150.000</td>
                </tr>

                {{-- Row 4 --}}
                <tr class="kas-row" data-type="keluar">
                    <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">12/09/2025</td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Konsumsi Rapat</div>
                        <div class="text-[11px] text-gray-400">Rapat koordinasi</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-red-600 bg-red-50 px-3 py-1 rounded-full border border-red-200">
                            ↓ Keluar
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-red-600 text-sm whitespace-nowrap">-Rp350.000</td>
                    <td class="px-6 py-4 text-right font-bold text-gray-900 text-sm whitespace-nowrap">Rp20.800.000</td>
                </tr>

                {{-- Row 5 --}}
                <tr class="kas-row" data-type="keluar">
                    <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">15/09/2025</td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Dana Kegiatan PSDI</div>
                        <div class="text-[11px] text-gray-400">Transfer ke PSDI</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-red-600 bg-red-50 px-3 py-1 rounded-full border border-red-200">
                            ↓ Keluar
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-red-600 text-sm whitespace-nowrap">-Rp1.500.000</td>
                    <td class="px-6 py-4 text-right font-bold text-gray-900 text-sm whitespace-nowrap">Rp19.300.000</td>
                </tr>

                {{-- Row 6 --}}
                <tr class="kas-row" data-type="masuk">
                    <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">18/09/2025</td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Denda Piket</div>
                        <div class="text-[11px] text-gray-400">10 denda &times; Rp25.000</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                            ↑ Masuk
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-emerald-600 text-sm whitespace-nowrap">+Rp250.000</td>
                    <td class="px-6 py-4 text-right font-bold text-gray-900 text-sm whitespace-nowrap">Rp19.550.000</td>
                </tr>

                {{-- Row 7 --}}
                <tr class="kas-row" data-type="keluar">
                    <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">20/09/2025</td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Perlengkapan Acara</div>
                        <div class="text-[11px] text-gray-400">Banner + dekorasi</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-red-600 bg-red-50 px-3 py-1 rounded-full border border-red-200">
                            ↓ Keluar
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-red-600 text-sm whitespace-nowrap">-Rp800.000</td>
                    <td class="px-6 py-4 text-right font-bold text-gray-900 text-sm whitespace-nowrap">Rp18.750.000</td>
                </tr>

                {{-- Row 8 --}}
                <tr class="kas-row" data-type="masuk">
                    <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">22/09/2025</td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">Iuran Kas Tambahan</div>
                        <div class="text-[11px] text-gray-400">Voluntary 10 anggota</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                            ↑ Masuk
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-emerald-600 text-sm whitespace-nowrap">+Rp500.000</td>
                    <td class="px-6 py-4 text-right font-bold text-gray-900 text-sm whitespace-nowrap">Rp19.250.000</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('modals')
{{-- Modal Tambah Transaksi Kas (matches kas masuk.png & kas keluar.png) --}}
<div id="modalTambahKas" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden border border-gray-100 animate-in fade-in zoom-in-95 duration-200">
        {{-- Modal Header --}}
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-gray-900">Tambah Transaksi Kas</h3>
            <button type="button" onclick="closeModalTambah()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <form onsubmit="handleSimpanKas(event)" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-2">Jenis Transaksi</label>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" id="tabJenisMasuk" onclick="setJenisTransaksi('masuk')"
                            class="py-2.5 px-4 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 bg-[#16A34A] text-white shadow-sm">
                        ↑ Kas Masuk
                    </button>
                    <button type="button" id="tabJenisKeluar" onclick="setJenisTransaksi('keluar')"
                            class="py-2.5 px-4 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 bg-gray-100 text-gray-600 hover:bg-gray-200">
                        ↓ Kas Keluar
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Tanggal</label>
                <input type="date" required value="{{ date('Y-m-d') }}"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B]">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Keterangan</label>
                <input type="text" required placeholder="Nama transaksi..."
                       class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B]">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nominal (Rp)</label>
                <input type="number" required placeholder="0"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B]">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Catatan (opsional)</label>
                <textarea rows="2" placeholder="Detail tambahan..."
                          class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B] resize-none"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-3">
                <button type="button" onclick="closeModalTambah()"
                        class="w-full py-2.5 px-4 rounded-xl border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="w-full py-2.5 px-4 rounded-xl bg-[#1A6B6B] hover:bg-[#155757] text-xs font-bold text-white transition shadow-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function openModalTambah() {
        document.getElementById('modalTambahKas').classList.remove('hidden');
    }

    function closeModalTambah() {
        document.getElementById('modalTambahKas').classList.add('hidden');
    }

    let jenisAktif = 'masuk';
    function setJenisTransaksi(jenis) {
        jenisAktif = jenis;
        const btnMasuk = document.getElementById('tabJenisMasuk');
        const btnKeluar = document.getElementById('tabJenisKeluar');

        if (jenis === 'masuk') {
            btnMasuk.className = 'py-2.5 px-4 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 bg-[#16A34A] text-white shadow-sm';
            btnKeluar.className = 'py-2.5 px-4 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 bg-gray-100 text-gray-600 hover:bg-gray-200';
        } else {
            btnMasuk.className = 'py-2.5 px-4 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 bg-gray-100 text-gray-600 hover:bg-gray-200';
            btnKeluar.className = 'py-2.5 px-4 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 bg-[#DC2626] text-white shadow-sm';
        }
    }

    function handleSimpanKas(e) {
        e.preventDefault();
        alert('Transaksi berhasil ditambahkan!');
        closeModalTambah();
    }

    function filterKas(type) {
        const rows = document.querySelectorAll('.kas-row');
        const btnAll = document.getElementById('filter-all');
        const btnMasuk = document.getElementById('filter-masuk');
        const btnKeluar = document.getElementById('filter-keluar');

        [btnAll, btnMasuk, btnKeluar].forEach(btn => {
            btn.className = 'filter-btn px-4 py-1.5 rounded-lg text-gray-600 hover:text-gray-900 transition';
        });

        if (type === 'all') {
            btnAll.className = 'filter-btn px-4 py-1.5 rounded-lg bg-[#1A6B6B] text-white transition shadow-sm';
            rows.forEach(r => r.style.display = '');
        } else if (type === 'masuk') {
            btnMasuk.className = 'filter-btn px-4 py-1.5 rounded-lg bg-[#1A6B6B] text-white transition shadow-sm';
            rows.forEach(r => {
                r.style.display = r.dataset.type === 'masuk' ? '' : 'none';
            });
        } else if (type === 'keluar') {
            btnKeluar.className = 'filter-btn px-4 py-1.5 rounded-lg bg-[#1A6B6B] text-white transition shadow-sm';
            rows.forEach(r => {
                r.style.display = r.dataset.type === 'keluar' ? '' : 'none';
            });
        }
    }
</script>
@endpush
