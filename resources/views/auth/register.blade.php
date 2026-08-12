<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - E-Lapor</title>

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
        <div class="w-full max-w-2xl">

            <!-- Card Container -->
            <div class="bg-white border border-[#E2E8F0] rounded-2xl shadow-sm p-6 sm:p-8">

                <!-- Card Header -->
                <div class="text-center mb-8">
                    <div
                        class="inline-flex items-center justify-center w-12 h-12 bg-[#2563EB]/10 rounded-xl text-[#2563EB] mb-3 text-xl">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-[#1E293B] mb-2">Pendaftaran Akun Baru</h1>
                    <p class="text-xs sm:text-sm text-[#1E293B]/70">Lengkapi data diri Anda sesuai NIK untuk mulai
                        menyampaikan laporan dan aspirasi.</p>
                </div>

                <!-- Session Alert Status -->
                @if (session('status'))
                    <div
                        class="mb-6 p-4 rounded-xl bg-[#10B981]/10 border border-[#10B981]/30 text-[#10B981] text-xs font-medium flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-sm"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <!-- General Error Notification -->
                @if ($errors->any())
                    <div
                        class="mb-6 p-4 rounded-xl bg-[#EF4444]/10 border border-[#EF4444]/30 text-[#EF4444] text-xs font-medium">
                        <div class="flex items-center gap-2 mb-1 font-semibold">
                            <i class="fa-solid fa-circle-exclamation text-sm"></i>
                            <span>Mohon periksa kembali inputan Anda:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-0.5 pl-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Register -->
                <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data"
                    class="space-y-5" x-data="{ avatarPreview: null, showPassword: false, showConfirmPassword: false }">
                    @csrf

                    <!-- Role Default Warga -->
                    <input type="hidden" name="role" value="Warga">

                    <!-- Grid Layout for Inputs -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <!-- Field NIK -->
                        <div>
                            <label for="nik"
                                class="block text-xs font-semibold text-[#1E293B] uppercase tracking-wider mb-2">
                                NIK (16 Digit) <span class="text-[#EF4444]">*</span>
                            </label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#1E293B]/40 text-sm">
                                    <i class="fa-solid fa-id-card"></i>
                                </div>
                                <input type="text" id="nik" name="nik" value="{{ old('nik') }}" required
                                    autofocus maxlength="16" placeholder="3516xxxxxxxxxxxx" inputmode="numeric"
                                    class="w-full pl-10 pr-4 py-3 bg-[#F8FAFC] border @error('nik') border-[#EF4444] @else border-[#E2E8F0] @enderror rounded-xl text-sm text-[#1E293B] placeholder-[#1E293B]/40 focus:outline-none focus:border-[#2563EB] focus:bg-white transition duration-200">
                            </div>
                            @error('nik')
                                <p class="mt-1.5 text-xs text-[#EF4444] font-medium flex items-center gap-1">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Field Nama Lengkap -->
                        <div>
                            <label for="name"
                                class="block text-xs font-semibold text-[#1E293B] uppercase tracking-wider mb-2">
                                Nama Lengkap <span class="text-[#EF4444]">*</span>
                            </label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#1E293B]/40 text-sm">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    placeholder="Nama sesuai KTP"
                                    class="w-full pl-10 pr-4 py-3 bg-[#F8FAFC] border @error('name') border-[#EF4444] @else border-[#E2E8F0] @enderror rounded-xl text-sm text-[#1E293B] placeholder-[#1E293B]/40 focus:outline-none focus:border-[#2563EB] focus:bg-white transition duration-200">
                            </div>
                            @error('name')
                                <p class="mt-1.5 text-xs text-[#EF4444] font-medium flex items-center gap-1">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Field Email -->
                        <div>
                            <label for="email"
                                class="block text-xs font-semibold text-[#1E293B] uppercase tracking-wider mb-2">
                                Alamat Email <span class="text-[#EF4444]">*</span>
                            </label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#1E293B]/40 text-sm">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                    placeholder="nama@domain.com"
                                    class="w-full pl-10 pr-4 py-3 bg-[#F8FAFC] border @error('email') border-[#EF4444] @else border-[#E2E8F0] @enderror rounded-xl text-sm text-[#1E293B] placeholder-[#1E293B]/40 focus:outline-none focus:border-[#2563EB] focus:bg-white transition duration-200">
                            </div>
                            @error('email')
                                <p class="mt-1.5 text-xs text-[#EF4444] font-medium flex items-center gap-1">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Field No HP -->
                        <div>
                            <label for="no_hp"
                                class="block text-xs font-semibold text-[#1E293B] uppercase tracking-wider mb-2">
                                Nomor Handphone / WhatsApp
                            </label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#1E293B]/40 text-sm">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <input type="tel" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                                    placeholder="08xxxxxxxxxx"
                                    class="w-full pl-10 pr-4 py-3 bg-[#F8FAFC] border @error('no_hp') border-[#EF4444] @else border-[#E2E8F0] @enderror rounded-xl text-sm text-[#1E293B] placeholder-[#1E293B]/40 focus:outline-none focus:border-[#2563EB] focus:bg-white transition duration-200">
                            </div>
                            @error('no_hp')
                                <p class="mt-1.5 text-xs text-[#EF4444] font-medium flex items-center gap-1">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Field Wilayah -->
                        <div class="md:col-span-2">
                            <label for="wilayah_id"
                                class="block text-xs font-semibold text-[#1E293B] uppercase tracking-wider mb-2">
                                Wilayah / Kelurahan <span class="text-[#EF4444]">*</span>
                            </label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#1E293B]/40 text-sm">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                </div>
                                @if (isset($wilayahs) && count($wilayahs) > 0)
                                    <select id="wilayah_id" name="wilayah_id" required
                                        class="w-full pl-10 pr-4 py-3 bg-[#F8FAFC] border @error('wilayah_id') border-[#EF4444] @else border-[#E2E8F0] @enderror rounded-xl text-sm text-[#1E293B] focus:outline-none focus:border-[#2563EB] focus:bg-white transition duration-200 appearance-none">
                                        <option value="" disabled selected>-- Pilih Wilayah / Kelurahan --
                                        </option>
                                        @foreach ($wilayahs as $wilayah)
                                            <option value="{{ $wilayah->id }}"
                                                {{ old('wilayah_id') == $wilayah->id ? 'selected' : '' }}>
                                                {{ $wilayah->nama_wilayah ?? ($wilayah->nama ?? ($wilayah->name ?? 'Wilayah #' . $wilayah->id)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <select id="wilayah_id" name="wilayah_id" required
                                        class="w-full pl-10 pr-4 py-3 bg-[#F8FAFC] border @error('wilayah_id') border-[#EF4444] @else border-[#E2E8F0] @enderror rounded-xl text-sm text-[#1E293B] focus:outline-none focus:border-[#2563EB] focus:bg-white transition duration-200 appearance-none">
                                        <option value="" disabled {{ old('wilayah_id') ? '' : 'selected' }}>--
                                            Pilih Wilayah / Kelurahan --</option>
                                        <option value="1" {{ old('wilayah_id') == '1' ? 'selected' : '' }}>
                                            Wilayah Pusat / Kecamatan</option>
                                        <option value="2" {{ old('wilayah_id') == '2' ? 'selected' : '' }}>
                                            Kelurahan / Desa 01</option>
                                        <option value="3" {{ old('wilayah_id') == '3' ? 'selected' : '' }}>
                                            Kelurahan / Desa 02</option>
                                    </select>
                                @endif
                                <div
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-[#1E293B]/40 text-xs">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                            @error('wilayah_id')
                                <p class="mt-1.5 text-xs text-[#EF4444] font-medium flex items-center gap-1">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Field Password -->
                        <div>
                            <label for="password"
                                class="block text-xs font-semibold text-[#1E293B] uppercase tracking-wider mb-2">
                                Kata Sandi <span class="text-[#EF4444]">*</span>
                            </label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#1E293B]/40 text-sm">
                                    <i class="fa-solid fa-lock"></i>
                                </div>
                                <input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                                    required placeholder="••••••••"
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

                        <!-- Field Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation"
                                class="block text-xs font-semibold text-[#1E293B] uppercase tracking-wider mb-2">
                                Konfirmasi Kata Sandi <span class="text-[#EF4444]">*</span>
                            </label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#1E293B]/40 text-sm">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <input :type="showConfirmPassword ? 'text' : 'password'" id="password_confirmation"
                                    name="password_confirmation" required placeholder="••••••••"
                                    class="w-full pl-10 pr-10 py-3 bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl text-sm text-[#1E293B] placeholder-[#1E293B]/40 focus:outline-none focus:border-[#2563EB] focus:bg-white transition duration-200">
                                <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[#1E293B]/40 hover:text-[#2563EB] focus:outline-none text-sm transition duration-200">
                                    <i class="fa-solid" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Terms & Conditions Checkbox -->
                    <div class="flex items-start pt-2">
                        <input type="checkbox" id="terms" name="terms" required
                            class="mt-0.5 w-4 h-4 rounded border-[#E2E8F0] text-[#2563EB] focus:ring-[#2563EB] focus:ring-offset-0 cursor-pointer">
                        <label for="terms" class="ml-2 text-xs text-[#1E293B]/70 cursor-pointer select-none">
                            Saya menyatakan bahwa data yang saya masukkan adalah benar dan menyetujui <a href="#"
                                class="text-[#2563EB] hover:underline font-medium">Syarat & Ketentuan</a> E-Lapor.
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-3.5 px-4 bg-[#2563EB] hover:bg-[#1d4ed8] text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-200 flex items-center justify-center gap-2 mt-4">
                        <span>Daftar Akun Sekarang</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>

                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-[#E2E8F0]"></div>
                    </div>
                    <div class="relative flex justify-center text-xs uppercase">
                        <span class="bg-white px-2 text-[#1E293B]/40 font-medium">Atau</span>
                    </div>
                </div>

                <!-- Footer Link Login -->
                <div class="text-center text-xs text-[#1E293B]/70">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="font-semibold text-[#2563EB] hover:underline">
                        Masuk Sekarang
                    </a>
                </div>

            </div>

        </div>
    </main>

    <!-- Footer Copyright -->
    <footer class="py-4 text-center text-xs text-[#1E293B]/50 border-t border-[#E2E8F0]/60 bg-white">
        &copy; 2026 E-Lapor. Hak Cipta Dilindungi Undang-Undang.
    </footer>

</body>

</html>
