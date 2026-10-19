@extends('layouts.presbem')

@section('title', 'Bayar Kas')
@section('page-title', 'Bayar Kas')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Bayar Kas</h2>
    <p class="text-sm text-gray-500 mt-1">Pembayaran kas bulanan anggota</p>
</div>

<div class="space-y-6">
    {{-- Status Pembayaran Hero Card --}}
    <div class="bg-[#1A6B6B] rounded-3xl p-6 sm:p-8 text-white shadow-sm flex flex-col justify-between relative overflow-hidden">
        <div class="flex items-center justify-between mb-6">
            <div>
                <span class="text-xs font-semibold text-teal-200 uppercase tracking-wider">Status Pembayaran</span>
                <h3 class="text-3xl font-extrabold mt-1">7/8 Bulan Lunas</h3>
            </div>
            <div class="w-16 h-16 rounded-full bg-white/10 border-2 border-white/20 flex items-center justify-center text-lg font-black tracking-tight">
                88%
            </div>
        </div>
        <div class="w-full bg-white/20 rounded-full h-3 overflow-hidden">
            <div class="bg-white h-3 rounded-full transition-all duration-500" style="width: 88%"></div>
        </div>
    </div>

    {{-- Tagihan Belum Dibayar --}}
    <div>
        <h4 class="text-sm font-bold text-gray-800 mb-3">Tagihan Belum Dibayar</h4>
        <div class="bg-white rounded-2xl p-5 border border-red-100 shadow-sm flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center font-bold text-lg flex-shrink-0">
                    🪙
                </div>
                <div>
                    <h5 class="text-base font-bold text-gray-900">Oktober 2025</h5>
                    <p class="text-xs text-gray-500 mt-0.5">Kas Bulanan BEM FILKOM UB</p>
                </div>
            </div>
            <div class="flex items-center gap-5">
                <span class="text-base font-bold text-red-600">Rp50.000</span>
                <button type="button" onclick="openModalBayarKas('Oktober 2025', 'Rp50.000')"
                        class="px-6 py-2.5 bg-[#1A6B6B] hover:bg-[#155757] text-white text-xs font-bold rounded-xl transition shadow-sm">
                    Bayar
                </button>
            </div>
        </div>
    </div>

    {{-- Riwayat Pembayaran --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h4 class="text-base font-bold text-gray-900">Riwayat Pembayaran</h4>
        </div>
        <div class="divide-y divide-gray-100">
            @php
                $riwayat = [
                    ['bulan' => 'Maret 2025', 'tgl' => '05/03/2025', 'nom' => 'Rp50.000'],
                    ['bulan' => 'April 2025', 'tgl' => '04/04/2025', 'nom' => 'Rp50.000'],
                    ['bulan' => 'Mei 2025', 'tgl' => '05/05/2025', 'nom' => 'Rp50.000'],
                    ['bulan' => 'Juni 2025', 'tgl' => '03/06/2025', 'nom' => 'Rp50.000'],
                    ['bulan' => 'Juli 2025', 'tgl' => '07/07/2025', 'nom' => 'Rp50.000'],
                    ['bulan' => 'Agustus 2025', 'tgl' => '04/08/2025', 'nom' => 'Rp50.000'],
                    ['bulan' => 'September 2025', 'tgl' => '05/09/2025', 'nom' => 'Rp50.000'],
                ];
            @endphp

            @foreach($riwayat as $r)
            <div class="p-5 flex items-center justify-between hover:bg-gray-50/50 transition">
                <div class="flex items-center gap-3.5">
                    <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm">
                        ✓
                    </div>
                    <div>
                        <div class="text-sm font-bold text-gray-900">{{ $r['bulan'] }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $r['tgl'] }}</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm font-bold text-gray-900">{{ $r['nom'] }}</div>
                    <span class="inline-block mt-0.5 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                        Lunas
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('modals')
{{-- Modal Bayar Kas --}}
<div id="modalBayarKas" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden border border-gray-100 animate-in fade-in zoom-in-95 duration-200">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-gray-900">Pembayaran Kas</h3>
            <button type="button" onclick="closeModalBayarKas()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form onsubmit="handleBayarKasSubmit(event)" class="p-6 space-y-4 text-xs">
            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-400">Periode</span>
                    <span id="bayarPeriode" class="font-bold text-gray-900">-</span>
                </div>
                <div class="flex justify-between items-center border-t border-gray-200/60 pt-2">
                    <span class="text-gray-400">Total Tagihan</span>
                    <span id="bayarNominal" class="font-black text-[#1A6B6B] text-base">-</span>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Metode Pembayaran</label>
                <select class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B]">
                    <option>Transfer Bank BCA (1234567890 a.n BEM FILKOM)</option>
                    <option>QRIS BEM FILKOM UB</option>
                    <option>Transfer Bank Mandiri (0987654321 a.n BEM FILKOM)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Upload Bukti Transfer</label>
                <div class="border-2 border-dashed border-gray-200 rounded-2xl p-4 text-center cursor-pointer hover:bg-gray-50 transition">
                    <input type="file" id="buktiTransfer" class="hidden" onchange="previewUpload(this)">
                    <label for="buktiTransfer" class="cursor-pointer block">
                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span id="uploadLabel" class="text-xs text-gray-500 font-semibold">Pilih foto struk transfer</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-3">
                <button type="button" onclick="closeModalBayarKas()"
                        class="w-full py-2.5 px-4 rounded-xl border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="w-full py-2.5 px-4 rounded-xl bg-[#1A6B6B] hover:bg-[#155757] text-xs font-bold text-white transition shadow-sm">
                    Kirim Bukti
                </button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function openModalBayarKas(periode, nominal) {
        document.getElementById('bayarPeriode').innerText = periode;
        document.getElementById('bayarNominal').innerText = nominal;
        document.getElementById('modalBayarKas').classList.remove('hidden');
    }
    function closeModalBayarKas() {
        document.getElementById('modalBayarKas').classList.add('hidden');
    }
    function previewUpload(input) {
        if (input.files && input.files[0]) {
            document.getElementById('uploadLabel').innerText = input.files[0].name;
        }
    }
    function handleBayarKasSubmit(e) {
        e.preventDefault();
        alert('Bukti pembayaran berhasil dikirim untuk divalidasi ADKEU!');
        closeModalBayarKas();
    }
</script>
@endpush
