@extends('layouts.presbem')

@section('title', 'Denda Saya')
@section('page-title', 'Denda Saya')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Denda Saya</h2>
    <p class="text-sm text-gray-500 mt-1">Riwayat dan pembayaran denda Anda</p>
</div>

<div class="space-y-6">
    {{-- Hero Red Card: Total Denda Belum Dibayar --}}
    <div class="bg-[#DC2626] rounded-3xl p-6 sm:p-8 text-white shadow-sm flex items-center justify-between relative overflow-hidden">
        <div>
            <span class="text-xs font-semibold text-red-100 uppercase tracking-wider">Total Denda Belum Dibayar</span>
            <div class="text-3xl sm:text-4xl font-black mt-1">Rp25.000</div>
            <div class="text-xs text-red-100/80 mt-1">1 denda aktif</div>
        </div>
        <div class="text-white/20">
            <svg class="w-20 h-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.834-1.964-.834-2.732 0L3.07 16.5c-.77.833.193 2.5 1.732 2.5z" />
            </svg>
        </div>
    </div>

    {{-- Denda List --}}
    <div class="space-y-4">
        {{-- Item 1: Belum Dibayar --}}
        <div class="bg-white rounded-2xl p-5 border border-red-100 shadow-sm flex items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2.5 mb-1">
                    <h4 class="text-sm font-bold text-gray-900">Denda Piket</h4>
                    <span class="px-2.5 py-0.5 bg-red-50 text-red-600 font-bold text-[11px] rounded-full border border-red-200">
                        Belum Dibayar
                    </span>
                </div>
                <p class="text-xs text-gray-500">Tidak hadir piket 11/09</p>
                <p class="text-[11px] text-gray-400 mt-0.5">11/09/2025</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-base font-bold text-red-600">Rp25.000</span>
                <button type="button" onclick="openModalBayarDenda('Denda Piket (11/09/2025)', 'Rp25.000')"
                        class="px-5 py-2 bg-[#DC2626] hover:bg-red-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                    Bayar
                </button>
            </div>
        </div>

        {{-- Item 2: Lunas --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2.5 mb-1">
                    <h4 class="text-sm font-bold text-gray-900">Denda Piket</h4>
                    <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 font-bold text-[11px] rounded-full border border-emerald-200">
                        Lunas
                    </span>
                </div>
                <p class="text-xs text-gray-500">Tidak hadir piket 28/08</p>
                <p class="text-[11px] text-gray-400 mt-0.5">28/08/2025</p>
            </div>
            <span class="text-sm font-bold text-gray-900">Rp25.000</span>
        </div>

        {{-- Item 3: Lunas --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2.5 mb-1">
                    <h4 class="text-sm font-bold text-gray-900">Denda Kegiatan</h4>
                    <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 font-bold text-[11px] rounded-full border border-emerald-200">
                        Lunas
                    </span>
                </div>
                <p class="text-xs text-gray-500">Alpha kegiatan wajib</p>
                <p class="text-[11px] text-gray-400 mt-0.5">01/08/2025</p>
            </div>
            <span class="text-sm font-bold text-gray-900">Rp50.000</span>
        </div>
    </div>
</div>
@endsection

@push('modals')
{{-- Modal Bayar Denda --}}
<div id="modalBayarDenda" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden border border-gray-100 animate-in fade-in zoom-in-95 duration-200">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-gray-900">Pembayaran Denda</h3>
            <button type="button" onclick="closeModalBayarDenda()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form onsubmit="handleBayarDendaSubmit(event)" class="p-6 space-y-4 text-xs">
            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-400">Keperluan Denda</span>
                    <span id="dendaDesc" class="font-bold text-gray-900">-</span>
                </div>
                <div class="flex justify-between items-center border-t border-gray-200/60 pt-2">
                    <span class="text-gray-400">Total Tagihan</span>
                    <span id="dendaNominal" class="font-black text-red-600 text-base">-</span>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Metode Pembayaran</label>
                <select class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B]">
                    <option>Transfer Bank BCA (1234567890 a.n BEM FILKOM)</option>
                    <option>QRIS BEM FILKOM UB</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Upload Bukti Transfer</label>
                <div class="border-2 border-dashed border-gray-200 rounded-2xl p-4 text-center cursor-pointer hover:bg-gray-50 transition">
                    <input type="file" id="buktiDenda" class="hidden" onchange="previewUploadDenda(this)">
                    <label for="buktiDenda" class="cursor-pointer block">
                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span id="dendaUploadLabel" class="text-xs text-gray-500 font-semibold">Pilih foto struk transfer</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-3">
                <button type="button" onclick="closeModalBayarDenda()"
                        class="w-full py-2.5 px-4 rounded-xl border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="w-full py-2.5 px-4 rounded-xl bg-[#DC2626] hover:bg-red-700 text-xs font-bold text-white transition shadow-sm">
                    Kirim Bukti
                </button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function openModalBayarDenda(desc, nominal) {
        document.getElementById('dendaDesc').innerText = desc;
        document.getElementById('dendaNominal').innerText = nominal;
        document.getElementById('modalBayarDenda').classList.remove('hidden');
    }
    function closeModalBayarDenda() {
        document.getElementById('modalBayarDenda').classList.add('hidden');
    }
    function previewUploadDenda(input) {
        if (input.files && input.files[0]) {
            document.getElementById('dendaUploadLabel').innerText = input.files[0].name;
        }
    }
    function handleBayarDendaSubmit(e) {
        e.preventDefault();
        alert('Bukti pembayaran denda berhasil dikirim ke ADKEU!');
        closeModalBayarDenda();
    }
</script>
@endpush
