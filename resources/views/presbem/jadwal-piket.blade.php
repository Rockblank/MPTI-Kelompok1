@extends('layouts.presbem')

@section('title', 'Jadwal Piket Saya')
@section('page-title', 'Jadwal Piket Saya')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Jadwal Piket Saya</h2>
    <p class="text-sm text-gray-500 mt-1">Riwayat dan jadwal piket Anda</p>
</div>

{{-- 3 Top Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
        <div class="text-4xl font-black text-emerald-600 tracking-tight">6</div>
        <div class="text-xs font-semibold text-gray-500 mt-1">Hadir</div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
        <div class="text-4xl font-black text-red-600 tracking-tight">1</div>
        <div class="text-xs font-semibold text-gray-500 mt-1">Alpha</div>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
        <div class="text-4xl font-black text-[#1A6B6B] tracking-tight">86%</div>
        <div class="text-xs font-semibold text-gray-500 mt-1">Kehadiran</div>
    </div>
</div>

{{-- List of Schedule Cards --}}
<div class="space-y-4">
    {{-- Item 1 --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-5">
            <div class="text-center w-12 flex-shrink-0">
                <div class="text-xs font-semibold text-gray-400">Sen</div>
                <div class="text-xl font-black text-gray-900 leading-tight">01</div>
                <div class="text-[10px] text-gray-400">09/2025</div>
            </div>
            <div>
                <div class="text-sm font-bold text-gray-900">08:00 – 10:00</div>
                <div class="text-xs text-gray-400">Sekretariat</div>
                <div class="text-xs text-teal-600 font-medium mt-1 flex items-center gap-1">
                    <span>📎</span> <span>foto_piket_1.jpg</span>
                </div>
            </div>
        </div>
        <span class="px-3.5 py-1 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-full border border-emerald-200">
            Hadir
        </span>
    </div>

    {{-- Item 2 --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-5">
            <div class="text-center w-12 flex-shrink-0">
                <div class="text-xs font-semibold text-gray-400">Kam</div>
                <div class="text-xl font-black text-gray-900 leading-tight">04</div>
                <div class="text-[10px] text-gray-400">09/2025</div>
            </div>
            <div>
                <div class="text-sm font-bold text-gray-900">08:00 – 10:00</div>
                <div class="text-xs text-gray-400">Sekretariat</div>
                <div class="text-xs text-teal-600 font-medium mt-1 flex items-center gap-1">
                    <span>📎</span> <span>foto_piket_2.jpg</span>
                </div>
            </div>
        </div>
        <span class="px-3.5 py-1 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-full border border-emerald-200">
            Hadir
        </span>
    </div>

    {{-- Item 3 --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-5">
            <div class="text-center w-12 flex-shrink-0">
                <div class="text-xs font-semibold text-gray-400">Sen</div>
                <div class="text-xl font-black text-gray-900 leading-tight">08</div>
                <div class="text-[10px] text-gray-400">09/2025</div>
            </div>
            <div>
                <div class="text-sm font-bold text-gray-900">08:00 – 10:00</div>
                <div class="text-xs text-gray-400">Sekretariat</div>
                <div class="text-xs text-teal-600 font-medium mt-1 flex items-center gap-1">
                    <span>📎</span> <span>foto_piket_3.jpg</span>
                </div>
            </div>
        </div>
        <span class="px-3.5 py-1 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-full border border-emerald-200">
            Hadir
        </span>
    </div>

    {{-- Item 4 (Alpha with Upload button) --}}
    <div class="bg-white rounded-2xl p-5 border border-red-100 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-5">
            <div class="text-center w-12 flex-shrink-0">
                <div class="text-xs font-semibold text-gray-400">Kam</div>
                <div class="text-xl font-black text-gray-900 leading-tight">11</div>
                <div class="text-[10px] text-gray-400">09/2025</div>
            </div>
            <div>
                <div class="text-sm font-bold text-gray-900">08:00 – 10:00</div>
                <div class="text-xs text-gray-400">Sekretariat</div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3.5 py-1 bg-red-50 text-red-600 font-bold text-xs rounded-full border border-red-200">
                Alpha
            </span>
            <button type="button" onclick="openModalUploadBukti('11/09/2025', '08:00 – 10:00')"
                    class="px-4 py-1.5 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition shadow-sm">
                Upload Bukti
            </button>
        </div>
    </div>

    {{-- Item 5 --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-5">
            <div class="text-center w-12 flex-shrink-0">
                <div class="text-xs font-semibold text-gray-400">Sen</div>
                <div class="text-xl font-black text-gray-900 leading-tight">15</div>
                <div class="text-[10px] text-gray-400">09/2025</div>
            </div>
            <div>
                <div class="text-sm font-bold text-gray-900">08:00 – 10:00</div>
                <div class="text-xs text-gray-400">Sekretariat</div>
                <div class="text-xs text-teal-600 font-medium mt-1 flex items-center gap-1">
                    <span>📎</span> <span>foto_piket_5.jpg</span>
                </div>
            </div>
        </div>
        <span class="px-3.5 py-1 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-full border border-emerald-200">
            Hadir
        </span>
    </div>

    {{-- Item 6 --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-5">
            <div class="text-center w-12 flex-shrink-0">
                <div class="text-xs font-semibold text-gray-400">Kam</div>
                <div class="text-xl font-black text-gray-900 leading-tight">18</div>
                <div class="text-[10px] text-gray-400">09/2025</div>
            </div>
            <div>
                <div class="text-sm font-bold text-gray-900">08:00 – 10:00</div>
                <div class="text-xs text-gray-400">Sekretariat</div>
                <div class="text-xs text-teal-600 font-medium mt-1 flex items-center gap-1">
                    <span>📎</span> <span>foto_piket_6.jpg</span>
                </div>
            </div>
        </div>
        <span class="px-3.5 py-1 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-full border border-emerald-200">
            Hadir
        </span>
    </div>

    {{-- Item 7 --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-5">
            <div class="text-center w-12 flex-shrink-0">
                <div class="text-xs font-semibold text-gray-400">Sen</div>
                <div class="text-xl font-black text-gray-900 leading-tight">22</div>
                <div class="text-[10px] text-gray-400">09/2025</div>
            </div>
            <div>
                <div class="text-sm font-bold text-gray-900">08:00 – 10:00</div>
                <div class="text-xs text-gray-400">Sekretariat</div>
                <div class="text-xs text-teal-600 font-medium mt-1 flex items-center gap-1">
                    <span>📎</span> <span>foto_piket_7.jpg</span>
                </div>
            </div>
        </div>
        <span class="px-3.5 py-1 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-full border border-emerald-200">
            Hadir
        </span>
    </div>

    {{-- Item 8 (Akan datang) --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-5">
            <div class="text-center w-12 flex-shrink-0">
                <div class="text-xs font-semibold text-gray-400">Kam</div>
                <div class="text-xl font-black text-gray-900 leading-tight">25</div>
                <div class="text-[10px] text-gray-400">09/2025</div>
            </div>
            <div>
                <div class="text-sm font-bold text-gray-900">08:00 – 10:00</div>
                <div class="text-xs text-gray-400">Sekretariat</div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3.5 py-1 bg-teal-50 text-[#1A6B6B] font-bold text-xs rounded-full border border-teal-200">
                Akan Datang
            </span>
            <button type="button" onclick="openModalUploadBukti('25/09/2025', '08:00 – 10:00')"
                    class="px-4 py-1.5 bg-[#1A6B6B] hover:bg-[#155757] text-white font-bold text-xs rounded-xl transition shadow-sm">
                Upload Bukti
            </button>
        </div>
    </div>

    {{-- Item 9 (Akan datang) --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-5">
            <div class="text-center w-12 flex-shrink-0">
                <div class="text-xs font-semibold text-gray-400">Sen</div>
                <div class="text-xl font-black text-gray-900 leading-tight">29</div>
                <div class="text-[10px] text-gray-400">09/2025</div>
            </div>
            <div>
                <div class="text-sm font-bold text-gray-900">08:00 – 10:00</div>
                <div class="text-xs text-gray-400">Sekretariat</div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3.5 py-1 bg-teal-50 text-[#1A6B6B] font-bold text-xs rounded-full border border-teal-200">
                Akan Datang
            </span>
            <button type="button" onclick="openModalUploadBukti('29/09/2025', '08:00 – 10:00')"
                    class="px-4 py-1.5 bg-[#1A6B6B] hover:bg-[#155757] text-white font-bold text-xs rounded-xl transition shadow-sm">
                Upload Bukti
            </button>
        </div>
    </div>
</div>
@endsection

@push('modals')
{{-- Modal Upload Bukti Piket --}}
<div id="modalUploadBukti" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden border border-gray-100 animate-in fade-in zoom-in-95 duration-200">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-gray-900">Upload Bukti Piket</h3>
            <button type="button" onclick="closeModalUploadBukti()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form onsubmit="handleUploadPiket(event)" class="p-6 space-y-4 text-xs">
            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-400">Tanggal Piket</span>
                    <span id="piketTanggal" class="font-bold text-gray-900">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Shift</span>
                    <span id="piketShift" class="font-bold text-gray-800">-</span>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Foto Presensi Piket</label>
                <div class="border-2 border-dashed border-gray-200 rounded-2xl p-4 text-center cursor-pointer hover:bg-gray-50 transition">
                    <input type="file" id="fotoPiket" class="hidden" onchange="previewPiket(this)">
                    <label for="fotoPiket" class="cursor-pointer block">
                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span id="piketLabel" class="text-xs text-gray-500 font-semibold">Pilih atau ambil foto piket di sekretariat</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Catatan Tambahan (opsional)</label>
                <textarea rows="2" placeholder="Catatan kegiatan piket..."
                          class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/30 focus:border-[#1A6B6B] resize-none"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3 pt-3">
                <button type="button" onclick="closeModalUploadBukti()"
                        class="w-full py-2.5 px-4 rounded-xl border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="w-full py-2.5 px-4 rounded-xl bg-[#1A6B6B] hover:bg-[#155757] text-xs font-bold text-white transition shadow-sm">
                    Kirim Presensi
                </button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function openModalUploadBukti(tgl, shift) {
        document.getElementById('piketTanggal').innerText = tgl;
        document.getElementById('piketShift').innerText = shift;
        document.getElementById('modalUploadBukti').classList.remove('hidden');
    }
    function closeModalUploadBukti() {
        document.getElementById('modalUploadBukti').classList.add('hidden');
    }
    function previewPiket(input) {
        if (input.files && input.files[0]) {
            document.getElementById('piketLabel').innerText = input.files[0].name;
        }
    }
    function handleUploadPiket(e) {
        e.preventDefault();
        alert('Bukti piket berhasil diunggah!');
        closeModalUploadBukti();
    }
</script>
@endpush
