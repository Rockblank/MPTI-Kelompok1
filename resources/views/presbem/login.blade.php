<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk PresBEM - BEM FILKOM UB</title>
    <meta name="description" content="Login ke Sistem Kas & Presensi BEM FILKOM UB - Ketua BEM">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>* { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen flex bg-[#2F3336]">

    {{-- Left Panel --}}
    <div class="w-[48%] bg-[#2F3336] flex flex-col justify-between p-12 text-white relative overflow-hidden">
        {{-- Logo --}}
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-[#1A8A8A] rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <span class="text-white font-bold text-lg">BEM FILKOM UB</span>
        </div>

        {{-- Hero Text --}}
        <div class="my-auto py-8">
            <span class="inline-block text-[#5AADAD] text-xs bg-[#1A8A8A]/20 border border-[#5AADAD]/30 rounded-full px-3.5 py-1.5 mb-8 font-medium">
                Sistem Manajemen Internal
            </span>
            <h1 class="text-4xl lg:text-5xl font-black text-white leading-tight mb-6 tracking-tight">
                Kelola kas &<br>presensi dengan<br>lebih efisien.
            </h1>
            <p class="text-[#9CA3AF] text-sm leading-relaxed max-w-md">
                Platform terpusat untuk manajemen kas, denda, piket, dan presensi kegiatan BEM FILKOM Universitas Brawijaya.
            </p>
        </div>

        {{-- Role Tersedia --}}
        <div>
            <div class="text-[11px] font-semibold text-gray-400 tracking-wider uppercase mb-3">Role Tersedia</div>
            <div class="grid grid-cols-2 gap-2.5 max-w-md">
                <a href="{{ route('bendahara.login') }}" class="px-4 py-2.5 rounded-lg bg-white/5 hover:bg-white/10 text-gray-300 font-medium text-xs transition border border-white/5">
                    ADKEU
                </a>
                <a href="{{ route('presbem.login') }}" class="px-4 py-2.5 rounded-lg bg-white/10 hover:bg-white/15 text-white font-semibold text-xs transition border border-white/10 flex items-center justify-between">
                    <span>PresBEM</span>
                    <span class="w-2 h-2 rounded-full bg-[#1A8A8A]"></span>
                </a>
                <a href="{{ route('psdi.login') }}" class="px-4 py-2.5 rounded-lg bg-white/5 hover:bg-white/10 text-gray-300 font-medium text-xs transition border border-white/5">
                    PSDI
                </a>
                <a href="{{ route('anggota.login') }}" class="px-4 py-2.5 rounded-lg bg-white/5 hover:bg-white/10 text-gray-300 font-medium text-xs transition border border-white/5">
                    Anggota Biasa
                </a>
            </div>
        </div>
    </div>

    {{-- Right Panel --}}
    <div class="flex-1 bg-[#F4F0EB] flex flex-col justify-between p-12 overflow-y-auto">
        <div></div>

        <div class="w-full max-w-md mx-auto my-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-1.5 tracking-tight">Masuk ke akun Anda</h2>
                <p class="text-sm text-gray-500">Sistem Kas & Presensi BEM FILKOM UB</p>
            </div>

            <form action="{{ route('presbem.dashboard') }}" method="GET" class="space-y-5">
                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="daffa@bem-filkom.ub.ac.id"
                        class="w-full px-4 py-3 bg-white/80 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/40 focus:border-[#1A6B6B] transition-all"
                        required
                    >
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            value="password123"
                            class="w-full px-4 py-3 bg-white/80 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1A6B6B]/40 focus:border-[#1A6B6B] transition-all pr-12"
                            required
                        >
                        <button type="button" id="togglePassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember & Forgot --}}
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer text-gray-600">
                        <input type="checkbox" checked class="w-4 h-4 text-[#1A6B6B] border-gray-300 rounded focus:ring-[#1A6B6B]">
                        <span>Ingat saya</span>
                    </label>
                    <a href="#" class="text-[#1A6B6B] font-semibold hover:underline">Lupa password?</a>
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full py-3.5 bg-[#1A6B6B] hover:bg-[#155757] text-white font-semibold rounded-xl text-sm transition-all duration-200 shadow-sm hover:shadow"
                >
                    Masuk
                </button>

                {{-- Demo Accounts Accordion --}}
                <div class="border border-dashed border-gray-300 rounded-xl bg-white/50 overflow-hidden">
                    <button type="button" id="toggleDemo" class="w-full px-4 py-3 flex items-center justify-between text-xs font-semibold text-gray-600 hover:bg-gray-50/50 transition">
                        <span>Akun Demo</span>
                        <svg id="demoChevron" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="demoContent" class="hidden px-4 pb-3 pt-1 border-t border-gray-200/60 text-xs text-gray-600 space-y-2">
                        <div class="flex items-center justify-between p-2 rounded bg-gray-50 hover:bg-teal-50 cursor-pointer" onclick="setDemo('daffa@bem-filkom.ub.ac.id')">
                            <div>
                                <div class="font-bold text-gray-800">Daffa R. (PresBEM)</div>
                                <div class="text-[11px] text-gray-500">daffa@bem-filkom.ub.ac.id</div>
                            </div>
                            <span class="text-xs text-[#1A6B6B] font-semibold">Pilih</span>
                        </div>
                        <div class="flex items-center justify-between p-2 rounded bg-gray-50 hover:bg-teal-50 cursor-pointer" onclick="setDemo('nayla@bem-filkom.ub.ac.id')">
                            <div>
                                <div class="font-bold text-gray-800">Nayla Shaffa (ADKEU)</div>
                                <div class="text-[11px] text-gray-500">nayla@bem-filkom.ub.ac.id</div>
                            </div>
                            <a href="{{ route('bendahara.login') }}" class="text-xs text-[#1A6B6B] font-semibold">Buka</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="text-center text-xs text-gray-400 mt-8">
            &copy; 2025 BEM FILKOM Universitas Brawijaya
        </div>
    </div>

    <script>
        const toggleDemo = document.getElementById('toggleDemo');
        const demoContent = document.getElementById('demoContent');
        const demoChevron = document.getElementById('demoChevron');

        if (toggleDemo && demoContent) {
            toggleDemo.addEventListener('click', () => {
                demoContent.classList.toggle('hidden');
                demoChevron.classList.toggle('rotate-180');
            });
        }

        function setDemo(email) {
            document.getElementById('email').value = email;
        }

        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', () => {
                passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
            });
        }
    </script>
</body>
</html>
