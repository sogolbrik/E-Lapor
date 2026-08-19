<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Warga Page' }} | E-Lapor</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">
    <script src="{{ asset('assets/vendor/fontawesome/js/all.min.js') }}" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="flex flex-col min-h-full font-sans antialiased bg-slate-50 text-slate-800">

    <x-partials.toast />

    {{-- Top Header Navigation for Citizens --}}
    <header x-data="{ mobileMenuOpen: false, userDropdownOpen: false }" class="sticky top-0 z-40 w-full bg-white border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-4">

                {{-- Brand Logo & Title --}}
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('warga.dashboard') }}"
                        class="flex items-center gap-2.5 rounded-lg focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-600 text-white font-bold text-lg shadow-xs">
                            <i class="fa-solid fa-bullhorn text-lg" aria-hidden="true"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-lg leading-tight tracking-tight text-slate-900">E-Lapor</span>
                            <span class="text-xs text-slate-500 font-medium">Layanan Warga</span>
                        </div>
                    </a>
                </div>

                {{-- Desktop Main Navigation --}}
                <nav class="hidden md:flex items-center gap-1" aria-label="Navigasi Utama">
                    <a href="{{ route('warga.dashboard') }}"
                        class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('warga.dashboard') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <i class="fa-solid fa-house mr-1.5 text-xs" aria-hidden="true"></i>
                        Dashboard
                    </a>

                    {{-- <a href="#"
                        class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors duration-150 {{ request()->routeIs('warga.aduan.*') && !request()->routeIs('warga.pengaduan.create') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <i class="fa-solid fa-list-check mr-1.5 text-xs" aria-hidden="true"></i>
                        Aduan Saya
                    </a> --}}

                    <a href="{{ route('warga.pengaduan.create') }}"
                        class="inline-flex items-center justify-center ml-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition-colors duration-150 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                        <i class="fa-solid fa-plus mr-2 text-xs" aria-hidden="true"></i>
                        Buat Aduan
                    </a>
                </nav>

                {{-- Right Actions: Profile Dropdown & Mobile Menu Button --}}
                <div class="flex items-center gap-2">

                    {{-- User Profile Dropdown (Desktop & Tablet) --}}
                    <div class="relative hidden md:block" @click.away="userDropdownOpen = false"
                        @keydown.escape.window="userDropdownOpen = false">
                        <button @click="userDropdownOpen = !userDropdownOpen" type="button"
                            class="flex items-center gap-3 p-1.5 rounded-xl hover:bg-slate-100 transition-colors duration-150 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2"
                            aria-expanded="false" :aria-expanded="userDropdownOpen" aria-label="Menu Pengguna">
                            @php
                                $user = auth()->user();
                            @endphp
                            @if ($user && $user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}"
                                    class="w-8 h-8 rounded-full object-cover border border-blue-200" alt="Avatar">
                            @else
                                <div
                                    class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-semibold flex items-center justify-center text-sm border border-blue-200">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'W', 0, 1)) }}
                                </div>
                            @endif
                            <span class="text-sm font-medium text-slate-700 max-w-30 truncate">
                                {{ auth()->user()->name ?? 'Warga' }}
                            </span>
                            <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-200"
                                :class="{ 'rotate-180': userDropdownOpen }" aria-hidden="true"></i>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="userDropdownOpen" x-cloak x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-56 rounded-xl bg-white border border-slate-200 shadow-lg py-1 z-50">

                            <div class="px-4 py-2.5 border-b border-slate-100">
                                <p class="text-xs text-slate-500 font-medium">Login sebagai</p>
                                <p class="text-sm font-semibold text-slate-900 truncate">
                                    {{ auth()->user()->email ?? 'warga@desa.id' }}</p>
                            </div>

                            <a href="{{ route('warga.profile.edit') }}"
                                class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                                <i class="fa-solid fa-user w-5 text-slate-400 text-xs mr-2" aria-hidden="true"></i>
                                Profil Saya
                            </a>

                            <div class="border-t border-slate-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                                    <i class="fa-solid fa-right-from-bracket w-5 text-red-500 text-xs mr-2"
                                        aria-hidden="true"></i>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Mobile Menu Trigger Button --}}
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                        class="md:hidden p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-hidden focus:ring-2 focus:ring-blue-600"
                        aria-label="Buka Menu Navigasi" :aria-expanded="mobileMenuOpen">
                        <i x-show="!mobileMenuOpen" class="fa-solid fa-bars text-lg" aria-hidden="true"></i>
                        <i x-show="mobileMenuOpen" x-cloak class="fa-solid fa-xmark text-lg" aria-hidden="true"></i>
                    </button>
                </div>

            </div>
        </div>

        {{-- Mobile Drawer Navigation --}}
        <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden border-b border-slate-200 bg-white px-4 pt-2 pb-4 space-y-2">

            <a href="{{ route('warga.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('warga.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-100' }}">
                <i class="fa-solid fa-house w-5 text-center text-xs" aria-hidden="true"></i>
                Dashboard
            </a>

            {{-- <a href="#"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('warga.aduan.*') && !request()->routeIs('warga.pengaduan.create') ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-100' }}">
                <i class="fa-solid fa-list-check w-5 text-center text-xs" aria-hidden="true"></i>
                Aduan Saya
            </a> --}}

            <a href="{{ route('warga.pengaduan.create') }}"
                class="flex items-center justify-center gap-2 w-full px-4 py-2.5 my-1 rounded-xl bg-blue-600 text-white text-sm font-medium shadow-xs">
                <i class="fa-solid fa-plus text-xs" aria-hidden="true"></i>
                Buat Aduan Baru
            </a>

            <div class="border-t border-slate-200 my-2 pt-2">
                <a href="{{ route('warga.profile.edit') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-100">
                    <i class="fa-solid fa-user w-5 text-center text-xs text-slate-400" aria-hidden="true"></i>
                    Profil Saya
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 text-left">
                        <i class="fa-solid fa-right-from-bracket w-5 text-center text-xs text-red-500"
                            aria-hidden="true"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- Main Content Container --}}
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="mt-auto bg-white border-t border-slate-200/80 py-6 text-sm text-slate-500">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; {{ date('Y') }} E-Lapor. Sistem Pengaduan Masyarakat Kecamatan.</p>
            <div class="flex items-center gap-6 text-xs text-slate-500">
                <span>Layanan Publik Transparan & Terukur</span>
            </div>
        </div>
    </footer>

    @stack('scripts')

</body>

</html>
