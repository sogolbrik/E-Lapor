<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - E-Lapor</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">
    <script src="{{ asset('assets/vendor/fontawesome/js/all.min.js') }}"></script>

    <!-- Tailwind CSS v4 & AlpineJs -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F8FAFC;
            color: #1E293B;
        }
    </style>
</head>

<body class="bg-[#F8FAFC] text-[#1E293B] antialiased min-h-screen flex flex-col justify-between">

    <!-- Main Form Container -->
    <main class="grow flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="w-full max-w-md">

            <!-- Card Container -->
            <div class="bg-white border border-[#E2E8F0] rounded-2xl shadow-sm p-6 sm:p-8">

                <!-- Card Header -->
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-[#1E293B] mb-2">Selamat Datang Kembali</h1>
                    <p class="text-xs sm:text-sm text-[#1E293B]/70">Masuk ke akun Anda untuk membuat atau memantau
                        laporan.</p>
                </div>

                <!-- Session Alert Status (Pesan sukses/logout dari Laravel) -->
                @if (session('status'))
                    <div
                        class="mb-6 p-4 rounded-xl bg-[#10B981]/10 border border-[#10B981]/30 text-[#10B981] text-xs font-medium flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-sm"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <!-- Form Login -->
                <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                    @csrf

                    <!-- Field Email / NIK -->
                    <div>
                        <label for="email"
                            class="block text-xs font-semibold text-[#1E293B] uppercase tracking-wider mb-2">
                            Alamat Email / NIK
                        </label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#1E293B]/40 text-sm">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <input type="text" id="email" name="email" value="{{ old('email') }}" required
                                autofocus placeholder="nama@email.com atau 3516xxxxxxxxxxxx"
                                class="w-full pl-10 pr-4 py-3 bg-[#F8FAFC] border @error('email') border-[#EF4444] @else border-[#E2E8F0] @enderror rounded-xl text-sm text-[#1E293B] placeholder-[#1E293B]/40 focus:outline-none focus:border-[#2563EB] focus:bg-white transition duration-200">
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-[#EF4444] font-medium flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Field Password with Toggle Show/Hide (Alpine.js) -->
                    <div x-data="{ showPassword: false }">
                        <div class="flex items-center justify-between mb-2">
                            <label for="password"
                                class="block text-xs font-semibold text-[#1E293B] uppercase tracking-wider">
                                Kata Sandi
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-xs font-medium text-[#2563EB] hover:underline">
                                    Lupa Kata Sandi?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#1E293B]/40 text-sm">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required
                                placeholder="••••••••"
                                class="w-full pl-10 pr-10 py-3 bg-[#F8FAFC] border @error('password') border-[#EF4444] @else border-[#E2E8F0] @enderror rounded-xl text-sm text-[#1E293B] placeholder-[#1E293B]/40 focus:outline-none focus:border-[#2563EB] focus:bg-white transition duration-200">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[#1E293B]/40 hover:text-[#2563EB] focus:outline-none text-sm transition duration-200">
                                <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-[#EF4444] font-medium flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" id="remember"
                                class="w-4 h-4 rounded border-[#E2E8F0] text-[#2563EB] focus:ring-[#2563EB] focus:ring-offset-0 cursor-pointer">
                            <span class="ml-2 text-xs text-[#1E293B]/70 font-medium">Ingat Saya di Perangkat Ini</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-3.5 px-4 bg-[#2563EB] hover:bg-[#1d4ed8] text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-200 flex items-center justify-center gap-2 mt-2">
                        <span>Masuk Sekarang</span>
                        <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                    </button>

                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-[#E2E8F0]"></div>
                    </div>
                    <div class="relative flex justify-center text-xs uppercase"><span
                            class="bg-white px-2 text-[#1E293B]/40 font-medium">Atau</span></div>
                </div>

                <!-- Footer Link Register -->
                <div class="text-center text-xs text-[#1E293B]/70">
                    Belum memiliki akun?
                    <a href="{{ route('register') }}" class="font-semibold text-[#2563EB] hover:underline">
                        Daftar Akun Baru
                    </a>
                </div>

            </div>

            {{-- <!-- Discrete Officer Login Link -->
            <div class="text-center mt-6">
                <a href="#portal-petugas"
                    class="inline-flex items-center gap-2 text-xs font-medium text-[#1E293B]/60 hover:text-[#2563EB] transition duration-200">
                    <i class="fa-solid fa-user-shield text-[#2563EB]"></i> Masuk sebagai Petugas / Admin Instansi
                </a>
            </div> --}}

        </div>
    </main>

    <!-- Footer Copyright -->
    <footer class="py-4 text-center text-xs text-[#1E293B]/50 border-t border-[#E2E8F0]/60 bg-white">
        &copy; 2026 E-Lapor. Hak Cipta Dilindungi Undang-Undang.
    </footer>

</body>

</html>
