<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }} - E-Lapor</title>

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

<body
    class="min-h-screen font-['Poppins'] text-slate-800 antialiased bg-slate-50 flex flex-col selection:bg-blue-500 selection:text-white">

    <x-partials.toast />

    {{-- Alpine Layout Container --}}
    <div x-data="{ sidebarOpen: false }" class="min-h-screen w-full bg-slate-50 flex flex-col flex-1 relative">

        {{-- Mobile Overlay --}}
        <div x-show="sidebarOpen" x-cloak x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden">
        </div>

        {{-- Sidebar --}}
        <aside
            class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-slate-200 bg-white shadow-lg lg:shadow-none transition-transform duration-200 ease-in-out -translate-x-full lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            {{-- Logo --}}
            <div class="flex h-20 shrink-0 items-center gap-3 border-b border-slate-100 px-6">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-md shadow-blue-500/20">
                    <i class="fa-solid fa-bullhorn text-lg"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-slate-800 leading-tight">E-Lapor</h1>
                    <p class="text-xs text-slate-400 font-medium">Administrator</p>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-6">
                <div>
                    <p class="mb-3 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                        Menu Utama
                    </p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}"
                            class="{{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }} group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition">
                            <i class="fa-solid fa-chart-pie w-5 text-center text-base"></i>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('admin.user.index') }}"
                            class="{{ request()->routeIs('admin.user.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }} group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition">
                            <i class="fa-solid fa-users w-5 text-center text-base"></i>
                            <span>Manajemen User</span>
                        </a>

                        <a href="{{ route('admin.desa.index') }}"
                            class="{{ request()->routeIs('admin.desa.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }} group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition">
                            <i class="fa-solid fa-location-dot w-5 text-center text-base"></i>
                            <span>Manajemen Desa</span>
                        </a>

                        <a href="#"
                            class="{{ request()->routeIs('admin.pengaduan.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }} group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition">
                            <i class="fa-solid fa-file-circle-exclamation w-5 text-center text-base"></i>
                            <span>Manajemen Pengaduan</span>
                        </a>
                    </div>
                </div>

                <div>
                    <p class="mb-3 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                        Pengaturan
                    </p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.profile.edit') }}"
                            class="{{ request()->routeIs('admin.profile.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }} group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition">
                            <i class="fa-solid fa-user-gear w-5 text-center text-base"></i>
                            <span>Profil Admin</span>
                        </a>
                    </div>
                </div>
            </nav>

            {{-- Sidebar Bottom User Box --}}
            <div class="shrink-0 border-t border-slate-100 p-4">
                <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full overflow-hidden bg-blue-100">
                        @if (auth()->user()->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}"
                                alt="{{ auth()->user()->name }}" class="h-full w-full object-cover">
                        @else
                            <span class="text-sm font-bold text-blue-600">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-slate-700">
                            {{ auth()->user()->name ?? 'Administrator' }}</p>
                        <p class="truncate text-xs text-slate-400">{{ auth()->user()->role ?? 'Admin' }}</p>
                    </div>
                    @if (Route::has('logout'))
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" title="Keluar"
                                class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-600 transition">
                                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

        </aside>

        {{-- Main Wrapper --}}
        <div class="flex flex-1 flex-col transition-all duration-200 lg:pl-64 min-w-0 w-full min-h-screen">

            {{-- Sticky Header --}}
            <header
                class="sticky top-0 z-30 flex h-20 w-full shrink-0 items-center justify-between border-b border-slate-200/80 bg-white/95 px-4 sm:px-6 lg:px-8 backdrop-blur-md">
                <div class="flex items-center gap-4 min-w-0">
                    <button @click="sidebarOpen = !sidebarOpen" type="button" aria-label="Toggle Sidebar"
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-slate-600 hover:bg-slate-100 lg:hidden focus:outline-none transition">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>

                    <div class="min-w-0">
                        <p class="text-xs font-medium text-slate-400">Portal Administrator</p>
                        <h2 class="text-base font-bold text-slate-800 truncate">
                            {{ $title ?? 'Dashboard' }}
                        </h2>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" title="Notifikasi"
                        class="relative flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-100 focus:outline-none">
                        <i class="fa-regular fa-bell text-lg"></i>
                        <span
                            class="absolute right-2.5 top-2.5 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                    </button>

                    {{-- User Dropdown --}}
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" type="button"
                            class="flex items-center gap-3 rounded-xl p-1.5 transition hover:bg-slate-100 focus:outline-none">
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full overflow-hidden bg-blue-100 ring-2 ring-blue-500/20">
                                @if (auth()->user()->avatar)
                                    <img src="{{ Storage::url(auth()->user()->avatar) }}"
                                        alt="{{ auth()->user()->name }}" class="h-full w-full object-cover">
                                @else
                                    <span class="text-sm font-bold text-blue-600">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                                @endif
                            </div>
                            <div class="hidden text-left sm:block">
                                <p class="text-xs font-semibold text-slate-700 leading-tight">
                                    {{ auth()->user()->name ?? 'Administrator' }}</p>
                                <p class="text-[11px] text-slate-400 font-medium">{{ auth()->user()->role ?? 'Admin' }}
                                </p>
                            </div>
                            <i class="fa-solid fa-chevron-down hidden text-xs text-slate-400 sm:block transition-transform duration-200"
                                :class="dropdownOpen ? 'rotate-180' : ''"></i>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="dropdownOpen" x-cloak x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 origin-top-right rounded-2xl border border-slate-100 bg-white p-2 shadow-xl ring-1 ring-slate-900/5 focus:outline-none z-50">

                            <div class="px-3 py-2 border-b border-slate-100 sm:hidden">
                                <p class="text-xs font-semibold text-slate-700">
                                    {{ auth()->user()->name ?? 'Administrator' }}</p>
                                <p class="text-[11px] text-slate-400">{{ auth()->user()->Role ?? 'Admin' }}</p>
                            </div>

                            <a href="{{ route('admin.profile.edit') }}"
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
            <main class="w-full flex-1 p-4 sm:p-6 lg:p-8 min-w-0">
                {{ $slot }}
            </main>

        </div>

    </div>

    @stack('scripts')

</body>

</html>
