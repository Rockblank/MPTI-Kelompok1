<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - BEM FILKOM UB</title>
    <meta name="description" content="Login ke Sistem Kas & Presensi BEM FILKOM Universitas Brawijaya">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>* { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen flex">

    {{-- Left Panel --}}
    <div class="w-[45%] bg-[#2F3336] flex flex-col p-10 relative overflow-hidden">
        {{-- Logo --}}
        <div class="flex items-center gap-3 mb-auto">
            <div class="w-10 h-10 bg-[#1A8A8A] rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <span class="text-white font-bold text-lg">BEM FILKOM UB</span>
        </div>

        {{-- Hero Content --}}
        <div class="py-16">
            <span class="inline-block text-[#5AADAD] text-xs border border-[#5AADAD]/40 rounded px-3 py-1.5 mb-8">
                Sistem Manajemen Organisasi
            </span>
            <h1 class="text-4xl font-extrabold text-white leading-tight mb-6">
                Kelola kas &<br>kehadiran dengan<br>lebih efisien.
            </h1>
            <p class="text-[#9CA3AF] text-sm leading-relaxed max-w-sm">
                Platform terpusat untuk manajemen kas, iuran, denda, dan presensi anggota BEM FILKOM Universitas Brawijaya.
            </p>
        </div>

        {{-- Role Tersedia --}}
        <div>
            <div class="text-[11px] font-semibold text-gray-400 tracking-wider uppercase mb-3">Role Tersedia</div>
            <div class="grid grid-cols-2 gap-2.5 max-w-md">
                <a href="{{ route('bendahara.login') }}" class="px-4 py-2.5 rounded-lg bg-white/5 hover:bg-white/10 text-gray-300 font-medium text-xs transition border border-white/5">
                    ADKEU
                </a>
                <a href="#" class="px-4 py-2.5 rounded-lg bg-white/5 hover:bg-white/10 text-gray-300 font-medium text-xs transition border border-white/5">
                    PresBEM
                </a>
                <a href="#" class="px-4 py-2.5 rounded-lg bg-white/5 hover:bg-white/10 text-gray-300 font-medium text-xs transition border border-white/5">
                    PSDI
                </a>
                <a href="{{ route('anggota.login') }}" class="px-4 py-2.5 rounded-lg bg-white/10 hover:bg-white/15 text-white font-semibold text-xs transition border border-white/10 flex items-center justify-between">
                    <span>Anggota Biasa</span>
                    <span class="w-2 h-2 rounded-full bg-[#1A8A8A]"></span>
                </a>
            </div>
        </div>

        {{-- Decorative gradient --}}
        <div class="absolute bottom-0 right-0 w-40 h-40 bg-[#1A8A8A]/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    {{-- Right Panel --}}
    <div class="flex-1 bg-[#F0EDE8] flex flex-col items-center justify-center px-12">
        <div class="w-full max-w-md">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-1">Masuk ke akun Anda</h2>
                <p class="text-sm text-gray-500">Kas & Presensi BEM FILKOM UB</p>
            </div>

            <form method="POST" action="#" class="space-y-5">
                @csrf
                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="ananda@bem-filkom.ub.ac.id"
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1A8A8A]/40 focus:border-[#1A8A8A] transition-all"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••••"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1A8A8A]/40 focus:border-[#1A8A8A] transition-all pr-12"
                            required
                        >
                        <button type="button" id="togglePassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg id="eyeOpen" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeClosed" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember & Forgot --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-gray-300 text-[#1A8A8A] focus:ring-[#1A8A8A]/30 cursor-pointer">
                        <span class="text-sm text-gray-600">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm text-[#1A8A8A] hover:text-[#157070] font-medium transition-colors">Lupa password?</a>
                </div>

                {{-- Submit --}}
                <button type="submit" id="btn-masuk"
                    class="w-full bg-[#1A8A8A] hover:bg-[#157070] text-white font-semibold py-3.5 rounded-xl transition-all duration-200 text-sm shadow-lg shadow-[#1A8A8A]/20 hover:shadow-[#1A8A8A]/30 hover:-translate-y-0.5 active:translate-y-0">
                    Masuk
                </button>

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-600">
                        {{ session('error') }}
                    </div>
                @endif
            </form>

            <p class="text-center text-xs text-gray-400 mt-10">© 2025 BEM FILKOM Universitas Brawijaya</p>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');
        if (togglePassword) {
            togglePassword.addEventListener('click', () => {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                eyeOpen.classList.toggle('hidden', isPassword);
                eyeClosed.classList.toggle('hidden', !isPassword);
            });
        }
    </script>
</body>
</html>
