<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Petugas Page' }} | E-Lapor</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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

<body
    class="min-h-screen font-['Poppins'] text-slate-800 antialiased bg-slate-50 flex flex-col selection:bg-blue-500 selection:text-white">

    <x-partials.toast />

    {{-- Alpine Layout Container --}}
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex flex-col lg:flex-row bg-slate-50">

        {{-- Mobile Sidebar Backdrop --}}
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden" x-cloak></div>

        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col bg-white border-r border-slate-200/80 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 shrink-0">

            {{-- Brand Logo / Header --}}
            <div class="flex h-16 items-center justify-between px-6 border-b border-slate-100">
                <a href="{{ route('petugas.dashboard') }}" class="flex items-center gap-3 group">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white font-bold text-lg shadow-md shadow-blue-500/20 group-hover:scale-105 transition">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-base leading-tight text-slate-800 tracking-tight">E-Lapor</span>
                        <span class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Portal
                            Petugas</span>
                    </div>
                </a>

                {{-- Close Sidebar Button (Mobile) --}}
                <button type="button" @click="sidebarOpen = false"
                    class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600 lg:hidden">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            {{-- Sidebar Navigation --}}
            <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-6">

                <div>
                    <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">
                        Menu Utama
                    </p>

                    <div class="space-y-1">
                        {{-- Dashboard --}}
                        <a href="{{ route('petugas.dashboard') }}"
                            class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs font-semibold transition {{ request()->routeIs('petugas.dashboard') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <i
                                class="fa-solid fa-chart-pie text-sm w-5 text-center {{ request()->routeIs('petugas.dashboard') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                            <span>Dashboard</span>
                        </a>

                        {{-- Daftar Aduan --}}
                        <a href="{{ route('petugas.aduan.index') }}"
                            class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs font-semibold transition {{ request()->routeIs('petugas.aduan.*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <i
                                class="fa-solid fa-inbox text-sm w-5 text-center {{ request()->routeIs('petugas.aduan.*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                            <span>Daftar Aduan</span>
                        </a>
                    </div>
                </div>

                <div>
                    <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">
                        Pengaturan
                    </p>

                    <div class="space-y-1">
                        {{-- Profil Petugas --}}
                        <a href="{{ route('petugas.profile.edit') }}"
                            class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs font-semibold transition {{ request()->routeIs('petugas.profile.*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <i
                                class="fa-solid fa-user-gear text-sm w-5 text-center {{ request()->routeIs('petugas.profile.*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                            <span>Profil Saya</span>
                        </a>
                    </div>
                </div>

            </nav>

            {{-- Sidebar Footer / Badge Desa --}}
            <div class="p-4 border-t border-slate-100">
                <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3 border border-slate-100">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-600 font-semibold text-xs shrink-0">
                        <i class="fa-solid fa-building-user"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] font-medium text-slate-400 truncate">Wilayah Tugas</p>
                        <p class="text-xs font-bold text-slate-700 truncate">
                            {{ auth()->user()->desa->nama ?? 'Semua Desa' }}
                        </p>
                    </div>
                </div>
            </div>

        </aside>

        {{-- Main Wrapper --}}
        <div class="flex flex-1 flex-col min-w-0 min-h-screen">

            {{-- Header Top Bar --}}
            <header
                class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200/80 bg-white/80 px-4 sm:px-6 lg:px-8 backdrop-blur-md">

                <div class="flex items-center gap-4">
                    {{-- Toggle Mobile Sidebar --}}
                    <button type="button" @click="sidebarOpen = true"
                        class="rounded-xl p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700 lg:hidden focus:outline-none">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>

                    <div class="hidden sm:block">
                        <span class="text-xs font-medium text-slate-400">Portal Petugas E-Lapor</span>
                    </div>
                </div>

                {{-- Right Top Bar (Profile Dropdown) --}}
                <div class="flex items-center gap-4">
                    {{-- User Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button type="button" @click="open = !open"
                            class="flex items-center gap-3 rounded-xl p-1.5 hover:bg-slate-50 transition focus:outline-none">
                            <img class="h-8 w-8 rounded-xl object-cover ring-2 ring-slate-100"
                                src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . strtoupper(substr(auth()->user()->name ?? 'P', 0, 2)) . '&background=2563eb&color=fff' }}"
                                alt="User Avatar">
                            <div class="hidden text-left sm:block">
                                <span class="block text-xs font-bold text-slate-700 leading-tight">
                                    {{ auth()->user()->name ?? 'Petugas' }}
                                </span>
                                <span class="block text-[10px] font-medium text-slate-400">
                                    Petugas {{ auth()->user()->desa->nama ?? '' }}
                                </span>
                            </div>
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-1"></i>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="open" @click.away="open = false" x-cloak
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 rounded-2xl bg-white p-1.5 shadow-xl ring-1 ring-slate-200/60 z-50">

                            <a href="{{ route('petugas.profile.edit') }}"
                                class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition">
                                <i class="fa-solid fa-user-gear w-4 text-center"></i>
                                <span>Profil Saya</span>
                            </a>

                            <div class="my-1 border-t border-slate-100"></div>

                            @if (Route::has('logout'))
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 transition">
                                        <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                                        <span>Keluar</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            {{-- Main Content --}}
            <main class="w-full flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 min-w-0">
                {{ $slot }}
            </main>

        </div>

    </div>

    @stack('scripts')

</body>

</html>
