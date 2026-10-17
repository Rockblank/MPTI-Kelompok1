@extends('layouts.bendahara')

@section('title', 'Validasi Pembayaran')
@section('page-title', 'Validasi Pembayaran')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Validasi Pembayaran</h2>
        <p class="text-sm text-gray-500 mt-1">Verifikasi bukti pembayaran kas dan denda anggota</p>
    </div>
    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-50 border border-amber-200 text-amber-700 text-xs font-bold">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.834-1.964-.834-2.732 0L3.07 16.5c-.77.833.193 2.5 1.732 2.5z" />
        </svg>
        3 menunggu validasi
    </div>
</div>

{{-- Filters --}}
<div class="inline-flex items-center gap-2 bg-gray-100/80 p-1.5 rounded-2xl text-xs font-semibold mb-6">
    <button type="button" onclick="filterStatus('all')" id="val-all" class="val-filter-btn px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition">
        Semua
    </button>
    <button type="button" onclick="filterStatus('pending')" id="val-pending" class="val-filter-btn px-4 py-2 rounded-xl bg-[#1A6B6B] text-white transition shadow-sm flex items-center gap-1.5">
        <span>Pending</span>
        <span class="px-1.5 py-0.2 bg-amber-400 text-gray-900 rounded-full text-[10px] font-black">3</span>
    </button>
    <button type="button" onclick="filterStatus('disetujui')" id="val-disetujui" class="val-filter-btn px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition">
        Disetujui
    </button>
    <button type="button" onclick="filterStatus('ditolak')" id="val-ditolak" class="val-filter-btn px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition">
        Ditolak
    </button>
</div>

{{-- List Cards --}}
<div class="space-y-4" id="validasiList">
    {{-- Item 1 --}}
    <div class="validasi-item bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-status="pending">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-[#1A6B6B] text-white font-bold text-sm flex items-center justify-center flex-shrink-0">
                BS
            </div>
            <div>
                <h4 class="text-base font-bold text-gray-900">Budi Santoso</h4>
                <p class="text-xs text-gray-500 mt-0.5">215150700111001 · Kas Bulanan - September</p>
                <p class="text-[11px] text-gray-400 mt-0.5">23/09/2025</p>
            </div>
        </div>
        <div class="flex items-center justify-between sm:justify-end gap-5">
            <div class="text-right">
                <div class="text-base font-bold text-gray-900">Rp50.000</div>
                <span class="status-badge inline-block mt-0.5 text-[11px] font-bold text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-200">
                    Menunggu
                </span>
            </div>
            <button type="button" onclick="periksaPembayaran('Budi Santoso', '215150700111001', 'Kas Bulanan - September', 'Rp50.000', '23/09/2025')"
                    class="px-5 py-2.5 bg-[#1A6B6B] hover:bg-[#155757] text-white text-xs font-bold rounded-xl transition shadow-sm">
                Periksa
            </button>
        </div>
    </div>

    {{-- Item 2 --}}
    <div class="validasi-item bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-status="pending">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-[#1A6B6B] text-white font-bold text-sm flex items-center justify-center flex-shrink-0">
                DL
            </div>
            <div>
                <h4 class="text-base font-bold text-gray-900">Dewi Lestari</h4>
                <p class="text-xs text-gray-500 mt-0.5">215150700111002 · Kas Bulanan - September</p>
                <p class="text-[11px] text-gray-400 mt-0.5">22/09/2025</p>
            </div>
        </div>
        <div class="flex items-center justify-between sm:justify-end gap-5">
            <div class="text-right">
                <div class="text-base font-bold text-gray-900">Rp50.000</div>
                <span class="status-badge inline-block mt-0.5 text-[11px] font-bold text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-200">
                    Menunggu
                </span>
            </div>
            <button type="button" onclick="periksaPembayaran('Dewi Lestari', '215150700111002', 'Kas Bulanan - September', 'Rp50.000', '22/09/2025')"
                    class="px-5 py-2.5 bg-[#1A6B6B] hover:bg-[#155757] text-white text-xs font-bold rounded-xl transition shadow-sm">
                Periksa
            </button>
        </div>
    </div>

    {{-- Item 3 --}}
    <div class="validasi-item bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-status="pending">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-[#1A6B6B] text-white font-bold text-sm flex items-center justify-center flex-shrink-0">
                MP
            </div>
            <div>
                <h4 class="text-base font-bold text-gray-900">Maya Putri</h4>
                <p class="text-xs text-gray-500 mt-0.5">215150700111006 · Kas Bulanan - September</p>
                <p class="text-[11px] text-gray-400 mt-0.5">18/09/2025</p>
            </div>
        </div>
        <div class="flex items-center justify-between sm:justify-end gap-5">
            <div class="text-right">
                <div class="text-base font-bold text-gray-900">Rp50.000</div>
                <span class="status-badge inline-block mt-0.5 text-[11px] font-bold text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-200">
                    Menunggu
                </span>
            </div>
            <button type="button" onclick="periksaPembayaran('Maya Putri', '215150700111006', 'Kas Bulanan - September', 'Rp50.000', '18/09/2025')"
                    class="px-5 py-2.5 bg-[#1A6B6B] hover:bg-[#155757] text-white text-xs font-bold rounded-xl transition shadow-sm">
                Periksa
            </button>
        </div>
    </div>
</div>
@endsection

@push('modals')
{{-- Modal Periksa Pembayaran --}}
<div id="modalPeriksa" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden border border-gray-100 animate-in fade-in zoom-in-95 duration-200">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-gray-900">Verifikasi Bukti Pembayaran</h3>
            <button type="button" onclick="closeModalPeriksa()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-6 space-y-5">
            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 grid grid-cols-2 gap-3 text-xs">
                <div>
                    <span class="text-gray-400">Nama Anggota</span>
                    <p id="modalNama" class="font-bold text-gray-900 text-sm mt-0.5">-</p>
                </div>
                <div>
                    <span class="text-gray-400">NIM</span>
                    <p id="modalNim" class="font-bold text-gray-900 text-sm mt-0.5">-</p>
                </div>
                <div>
                    <span class="text-gray-400">Keperluan</span>
                    <p id="modalJenis" class="font-bold text-gray-900 text-sm mt-0.5">-</p>
                </div>
                <div>
                    <span class="text-gray-400">Nominal Transfer</span>
                    <p id="modalNominal" class="font-bold text-emerald-600 text-base mt-0.5">-</p>
                </div>
            </div>

            {{-- Bukti Transfer Preview --}}
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-2">Bukti Struk Transfer</label>
                <div class="border-2 border-dashed border-gray-200 rounded-2xl p-4 bg-gray-50/50 flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 rounded-2xl bg-teal-50 text-[#1A6B6B] flex items-center justify-center mb-2">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="text-xs font-bold text-gray-800">transfer_bukti_bca.jpg</div>
                    <div class="text-[11px] text-gray-400 mt-0.5">245 KB · Terunggah via Bank BCA Virtual Account</div>
                    <button type="button" class="mt-3 text-xs font-bold text-[#1A6B6B] hover:underline">
                        Lihat Gambar Penuh
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-2">
                <button type="button" onclick="konfirmasiAksi('tolak')"
                        class="w-full py-2.5 px-4 rounded-xl border border-red-200 text-xs font-bold text-red-600 hover:bg-red-50 transition">
                    Tolak Pembayaran
                </button>
                <button type="button" onclick="konfirmasiAksi('setuju')"
                        class="w-full py-2.5 px-4 rounded-xl bg-[#1A6B6B] hover:bg-[#155757] text-xs font-bold text-white transition shadow-sm">
                    Setujui Pembayaran
                </button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function periksaPembayaran(nama, nim, jenis, nominal, tanggal) {
        document.getElementById('modalNama').innerText = nama;
        document.getElementById('modalNim').innerText = nim;
        document.getElementById('modalJenis').innerText = jenis;
        document.getElementById('modalNominal').innerText = nominal;
        document.getElementById('modalPeriksa').classList.remove('hidden');
    }

    function closeModalPeriksa() {
        document.getElementById('modalPeriksa').classList.add('hidden');
    }

    function konfirmasiAksi(aksi) {
        if (aksi === 'setuju') {
            alert('Pembayaran berhasil disetujui!');
        } else {
            alert('Pembayaran ditolak!');
        }
        closeModalPeriksa();
    }

    function filterStatus(status) {
        const items = document.querySelectorAll('.validasi-item');
        const buttons = document.querySelectorAll('.val-filter-btn');

        buttons.forEach(b => {
            b.className = 'val-filter-btn px-4 py-2 rounded-xl text-gray-600 hover:text-gray-900 transition';
        });

        const activeBtn = document.getElementById('val-' + status);
        if (activeBtn) {
            activeBtn.className = 'val-filter-btn px-4 py-2 rounded-xl bg-[#1A6B6B] text-white transition shadow-sm';
        }

        items.forEach(item => {
            if (status === 'all') {
                item.style.display = 'flex';
            } else if (status === item.dataset.status) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>
@endpush
