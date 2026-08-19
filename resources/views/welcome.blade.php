<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="E-Lapor - Sistem Pengaduan Masyarakat tingkat kecamatan. Laporkan kerusakan fasilitas umum, kebersihan lingkungan, dan gangguan ketertiban secara transparan dan terukur.">
    <meta name="theme-color" content="#2563EB">
    <title>E-Lapor - Layanan Pengaduan Masyarakat {{ $kecamatanName }}</title>

    <!-- Google Fonts: Poppins (font resmi sistem, lihat Design.md §5) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome v6 (icon set resmi sistem, lihat Design.md §12) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- LeafletJS - dipakai untuk Peta Cakupan Wilayah, sesuai PRD §4 -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Tailwind CSS v4 / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            /* Token warna - satu sumber kebenaran, mengikuti Design.md §4 */
            --color-primary: #2563EB;
            --color-primary-dark: #1d4ed8;
            --color-secondary: #10B981;
            --color-accent: #F59E0B;
            --color-bg: #F8FAFC;
            --color-surface: #FFFFFF;
            --color-text: #1E293B;
            --color-border: #E2E8F0;
            --color-success: #22C55E;
            --color-warning: #F59E0B;
            --color-error: #EF4444;
            --color-info: #3B82F6;

            /* Token radius - Design.md §6 */
            --radius-btn: 12px;
            --radius-input: 12px;
            --radius-card: 16px;
            --radius-modal: 18px;
            --radius-badge: 999px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--color-bg);
            color: var(--color-text);
        }

        /* Fokus keyboard yang jelas - wajib untuk aksesibilitas (Design.md §2) */
        a:focus-visible,
        button:focus-visible,
        input:focus-visible,
        textarea:focus-visible,
        select:focus-visible,
        [tabindex]:focus-visible {
            outline: 2px solid var(--color-primary);
            outline-offset: 2px;
            border-radius: 6px;
        }

        /* Motif "jalur rute": garis putus-putus penghubung titik proses */
        .route-line {
            background-image: linear-gradient(to right, var(--color-border) 50%, transparent 50%);
            background-size: 12px 2px;
            background-repeat: repeat-x;
            background-position: center;
        }

        .route-line-vertical {
            background-image: linear-gradient(to bottom, var(--color-border) 50%, transparent 50%);
            background-size: 2px 12px;
            background-repeat: repeat-y;
            background-position: center;
        }

        /* Reveal-on-scroll - dipakai selektif (judul seksi + grid kartu),
           bukan pada setiap elemen, lihat catatan MOTION dial di atas. */
        [x-cloak] {
            display: none !important;
        }

        .reveal-up {
            opacity: 0;
            transform: translateY(16px);
            transition: opacity .5s ease, transform .5s ease;
        }

        .reveal-up.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Skeleton shimmer - dipakai untuk loading state peta */
        .skeleton-shimmer {
            background: linear-gradient(90deg, #F1F5F9 25%, #E2E8F0 37%, #F1F5F9 63%);
            background-size: 400% 100%;
            animation: shimmer 1.4s ease infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0 50%;
            }
        }

        #leaflet-map {
            border-radius: var(--radius-card);
            z-index: 0;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
        }

        @media (prefers-reduced-motion: reduce) {
            .reveal-up {
                opacity: 1;
                transform: none;
                transition: none;
            }

            .skeleton-shimmer {
                animation: none;
            }

            html {
                scroll-behavior: auto;
            }
        }
    </style>
</head>

<body class="bg-(--color-bg) text-(--color-text) antialiased" x-data="{ mobileMenuOpen: false, activeSection: 'beranda' }" x-init="const ids = ['beranda', 'alur-status', 'cara-kerja', 'peta-wilayah', 'aduan-publik', 'faq'];
const sections = ids.map((id) => document.getElementById(id)).filter(Boolean);
const spy = new IntersectionObserver((entries) => {
    entries.forEach((entry) => { if (entry.isIntersecting) activeSection = entry.target.id; });
}, { rootMargin: '-40% 0px -55% 0px', threshold: 0 });
sections.forEach((section) => spy.observe(section));"
    @keydown.escape.window="mobileMenuOpen = false">

    <!-- Lewati ke konten utama - aksesibilitas keyboard -->
    <a href="#konten-utama"
        class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-100 focus:bg-white focus:text-(--color-primary) focus:px-4 focus:py-2 focus:rounded-(--radius-btn) focus:shadow-lg">
        Lewati ke konten utama
    </a>

    <!-- ========================================== -->
    <!-- SECTION 1: TOP NAVBAR / HEADER             -->
    <!-- ========================================== -->
    <header x-data="{ scrolled: false }" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 8)"
        :class="scrolled ? 'shadow-sm border-b border-(--color-border)' : 'border-b border-transparent'"
        class="sticky top-0 z-50 bg-white/90 backdrop-blur-md transition-shadow duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">

            <!-- Brand Logo -->
            <a href="#beranda" class="flex items-center gap-3 shrink-0">
                <div
                    class="w-10 h-10 bg-(--color-primary) rounded-xl flex items-center justify-center text-white text-xl shadow-sm">
                    <i class="fa-solid fa-bullhorn" aria-hidden="true"></i>
                </div>
                <div>
                    <span
                        class="text-xl font-bold text-(--color-primary) tracking-tight block leading-none">E-Lapor</span>
                    <span class="text-[11px] font-medium text-(--color-text)/60 tracking-wide">Portal Pengaduan
                        {{ $kecamatanName }}</span>
                </div>
            </a>

            <!-- Quick Navigation Menu (Desktop) - scrollspy via IntersectionObserver -->
            <nav class="hidden lg:flex items-center gap-1" aria-label="Navigasi utama">
                <template
                    x-for="item in [
                    { id: 'beranda', label: 'Beranda' },
                    { id: 'alur-status', label: 'Alur Status' },
                    { id: 'cara-kerja', label: 'Cara Kerja' },
                    { id: 'peta-wilayah', label: 'Peta Wilayah' },
                    { id: 'aduan-publik', label: 'Aduan Publik' },
                    { id: 'faq', label: 'FAQ' },
                ]"
                    :key="item.id">
                    <a :href="'#' + item.id"
                        :class="activeSection === item.id ? 'text-(--color-primary) bg-(--color-primary)/5' :
                            'text-(--color-text)/70 hover:text-(--color-primary) hover:bg-(--color-bg)'"
                        class="px-3.5 py-2 rounded-lg text-sm font-medium transition duration-200"
                        x-text="item.label"></a>
                </template>
            </nav>

            <!-- Action Buttons (Desktop) -->
            <div class="hidden lg:flex items-center gap-3">
                <a href="{{ route('login') }}"
                    class="px-5 py-2.5 rounded-(--radius-btn) border border-(--color-primary) text-(--color-primary) text-sm font-medium hover:bg-(--color-primary) hover:text-white transition duration-200">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                    class="px-5 py-2.5 rounded-(--radius-btn) bg-(--color-primary) text-white text-sm font-medium hover:bg-(--color-primary-dark) shadow-sm hover:shadow transition duration-200">
                    Daftar Akun Warga
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" :aria-expanded="mobileMenuOpen.toString()"
                aria-controls="mobile-menu" aria-label="Buka menu navigasi"
                class="lg:hidden p-2 text-(--color-text) hover:text-(--color-primary) focus:outline-none">
                <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark text-2xl' : 'fa-bars text-xl'"
                    aria-hidden="true"></i>
            </button>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" x-show="mobileMenuOpen" x-collapse x-cloak
            class="lg:hidden bg-white border-b border-(--color-border) px-4 pt-2 pb-6 space-y-1">
            <a href="#beranda" @click="mobileMenuOpen = false"
                class="block px-3 py-2.5 rounded-lg text-sm font-medium text-(--color-text) hover:bg-(--color-bg)">Beranda</a>
            <a href="#alur-status" @click="mobileMenuOpen = false"
                class="block px-3 py-2.5 rounded-lg text-sm font-medium text-(--color-text) hover:bg-(--color-bg)">Alur
                Status</a>
            <a href="#cara-kerja" @click="mobileMenuOpen = false"
                class="block px-3 py-2.5 rounded-lg text-sm font-medium text-(--color-text) hover:bg-(--color-bg)">Cara
                Kerja</a>
            <a href="#peta-wilayah" @click="mobileMenuOpen = false"
                class="block px-3 py-2.5 rounded-lg text-sm font-medium text-(--color-text) hover:bg-(--color-bg)">Peta
                Wilayah</a>
            <a href="#aduan-publik" @click="mobileMenuOpen = false"
                class="block px-3 py-2.5 rounded-lg text-sm font-medium text-(--color-text) hover:bg-(--color-bg)">Aduan
                Publik</a>
            <a href="#faq" @click="mobileMenuOpen = false"
                class="block px-3 py-2.5 rounded-lg text-sm font-medium text-(--color-text) hover:bg-(--color-bg)">FAQ</a>
            <div class="pt-4 mt-2 border-t border-(--color-border) flex flex-col gap-2">
                <a href="{{ route('login') }}"
                    class="w-full text-center py-2.5 rounded-(--radius-btn) border border-(--color-primary) text-(--color-primary) text-sm font-medium">Masuk</a>
                <a href="{{ route('register') }}"
                    class="w-full text-center py-2.5 rounded-(--radius-btn) bg-(--color-primary) text-white text-sm font-medium">Daftar
                    Akun Warga</a>
            </div>
        </div>
    </header>

    <main id="konten-utama">
        <!-- ========================================== -->
        <!-- SECTION 2: HERO                            -->
        <!-- ========================================== -->
        <section id="beranda" class="relative pt-12 pb-20 lg:pt-20 lg:pb-32 overflow-hidden scroll-mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-12 gap-12 items-center">

                    <!-- Left Column: Content & CTA -->
                    <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                        <span
                            class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-(--radius-badge) bg-(--color-primary)/10 text-(--color-primary) text-xs font-semibold">
                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i> Melayani seluruh desa di
                            {{ $kecamatanName }}
                        </span>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-(--color-text) leading-tight">
                            Laporkan Masalah di Lingkungan Anda, Terpantau Sampai Tuntas.
                        </h1>
                        <p class="text-base sm:text-lg text-(--color-text)/70 max-w-2xl mx-auto lg:mx-0">
                            Tandai lokasi kejadian di peta, unggah bukti foto, dan laporan Anda otomatis
                            diteruskan ke petugas desa yang berwenang menangani wilayah tersebut.
                        </p>

                        <!-- CTA Buttons -->
                        <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3">
                            <a href="{{ route('register') }}"
                                class="w-full sm:w-auto px-8 py-4 rounded-(--radius-btn) bg-(--color-primary) text-white font-medium text-base hover:bg-(--color-primary-dark) shadow-md hover:shadow-lg transition duration-200 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-plus-circle" aria-hidden="true"></i>
                                <span>Buat Laporan Baru</span>
                            </a>
                            <a href="#alur-status"
                                class="w-full sm:w-auto px-8 py-4 rounded-(--radius-btn) border border-(--color-border) text-(--color-text) font-medium text-base hover:border-(--color-primary) hover:text-(--color-primary) transition duration-200 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-route" aria-hidden="true"></i>
                                <span>Lihat Alur Prosesnya</span>
                            </a>
                        </div>

                        <!-- Quick Ticket Check -->
                        <div x-data="{ kode: '' }"
                            @submit.prevent="if (kode.trim()) window.location.href = '{{ route('login') }}?ref=' + encodeURIComponent(kode.trim())"
                            class="pt-4 max-w-md mx-auto lg:mx-0">
                            <form
                                @submit.prevent="if (kode.trim()) window.location.href = '{{ route('login') }}?ref=' + encodeURIComponent(kode.trim())"
                                class="flex items-center gap-2 bg-white border border-(--color-border) rounded-(--radius-input) p-1.5 shadow-sm focus-within:border-(--color-primary) transition duration-200">
                                <label for="kode-tiket" class="sr-only">Nomor tiket laporan</label>
                                <i class="fa-solid fa-magnifying-glass text-(--color-text)/40 pl-2"
                                    aria-hidden="true"></i>
                                <input id="kode-tiket" x-model="kode" type="text"
                                    placeholder="Sudah lapor? Masukkan kode tiket ADU-..."
                                    class="flex-1 min-w-0 bg-transparent text-sm px-1 py-2 outline-none placeholder:text-(--color-text)/40">
                                <button type="submit"
                                    class="shrink-0 px-4 py-2 rounded-lg bg-(--color-text) text-white text-xs font-semibold hover:bg-(--color-primary) transition duration-200">
                                    Lacak
                                </button>
                            </form>
                            <p class="text-xs text-(--color-text)/50 mt-2 px-1">Anda akan diarahkan untuk masuk
                                agar dapat melihat detail lengkap status laporan.</p>
                        </div>

                        <!-- Trust Badges -->
                        <div class="pt-4 flex flex-wrap items-center justify-center lg:justify-start gap-3">
                            <span
                                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-(--radius-badge) bg-white border border-(--color-border) text-xs font-medium text-(--color-text) shadow-sm">
                                <i class="fa-solid fa-user-secret text-(--color-primary)" aria-hidden="true"></i>
                                Bisa Lapor Anonim
                            </span>
                            <span
                                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-(--radius-badge) bg-white border border-(--color-border) text-xs font-medium text-(--color-text) shadow-sm">
                                <i class="fa-solid fa-bolt text-(--color-accent)" aria-hidden="true"></i>
                                Verifikasi &lt; 24 Jam
                            </span>
                            <span
                                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-(--radius-badge) bg-white border border-(--color-border) text-xs font-medium text-(--color-text) shadow-sm">
                                <i class="fa-solid fa-map-location-dot text-(--color-secondary)"
                                    aria-hidden="true"></i> Rute Otomatis per Desa
                            </span>
                        </div>
                    </div>

                    <!-- Right Column: Illustration / Hero Report Card (Dinamis jika ada data) -->
                    <div class="lg:col-span-5 flex justify-center">
                        <div class="relative w-full max-w-md lg:max-w-none">
                            <div
                                class="absolute -top-6 -left-6 w-72 h-72 bg-(--color-primary)/10 rounded-full filter blur-3xl pointer-events-none">
                            </div>
                            <div
                                class="absolute -bottom-6 -right-6 w-72 h-72 bg-(--color-secondary)/10 rounded-full filter blur-3xl pointer-events-none">
                            </div>

                            @if ($recentComplaints->isNotEmpty())
                                @php
                                    $heroComplaint = $recentComplaints->first();

                                    // Mapping step timeline berdasarkan status aduan
                                    $stepMap = [
                                        'pending' => 1,
                                        'processed' => 2,
                                        'rejected' => 2,
                                        'completed' => 4,
                                    ];
                                    $currentStep = $stepMap[$heroComplaint['status'] ?? 'pending'] ?? 1;

                                    $meta =
                                        $statusLabel[$heroComplaint['status'] ?? 'pending'] ?? $statusLabel['pending'];
                                @endphp

                                <div class="relative bg-white border border-(--color-border) p-6 rounded-(--radius-card) shadow-xl space-y-5"
                                    x-data="{ step: {{ $currentStep }} }">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-11 h-11 rounded-xl bg-(--color-primary)/10 text-(--color-primary) flex items-center justify-center text-lg">
                                                <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-bold text-(--color-text)">
                                                    {{ $heroComplaint['code'] ?? 'ADU-00000' }}</h4>
                                                <p class="text-xs text-(--color-text)/50">
                                                    {{ $heroComplaint['title'] ?? 'Laporan Warga' }} &middot;
                                                    {{ $heroComplaint['village'] ?? $kecamatanName }}
                                                </p>
                                            </div>
                                        </div>
                                        <span class="px-2.5 py-1 rounded-(--radius-badge) text-[11px] font-semibold"
                                            style="background-color: {{ $meta['bg'] }}; color: {{ $meta['color'] }};">
                                            {{ $meta['label'] }}
                                        </span>
                                    </div>

                                    <!-- Mini timeline demo, motif garis rute -->
                                    <div class="grid grid-cols-4 gap-0 items-start pt-2">
                                        <template x-for="(s, i) in ['Masuk', 'Verifikasi', 'Dikerjakan', 'Selesai']"
                                            :key="i">
                                            <div class="flex flex-col items-center relative">
                                                <div class="w-full h-0.5 absolute top-3.5 route-line"
                                                    :class="i === 0 ? 'invisible' : ''"></div>
                                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-bold relative z-10 border-2"
                                                    :class="i < step ?
                                                        'bg-(--color-primary) border-(--color-primary) text-white' :
                                                        (i === step ?
                                                            'bg-white border-(--color-accent) text-(--color-accent) animate-pulse' :
                                                            'bg-white border-(--color-border) text-(--color-text)/30'
                                                        )">
                                                    <i class="fa-solid fa-check text-[9px]" x-show="i < step"
                                                        aria-hidden="true"></i>
                                                    <span x-show="i >= step" x-text="i + 1"></span>
                                                </div>
                                                <span class="text-[10px] mt-1.5 text-center text-(--color-text)/60"
                                                    x-text="s"></span>
                                            </div>
                                        </template>
                                    </div>

                                    <div
                                        class="bg-(--color-bg) border border-(--color-border) rounded-xl p-3 text-xs text-(--color-text)/70">
                                        <span class="font-semibold text-(--color-primary)">Tanggapan
                                            terbaru:</span>
                                        {{ $heroComplaint['response'] ?? 'Belum ada tanggapan dari petugas.' }}
                                    </div>
                                </div>
                            @else
                                {{-- Placeholder Ilustratif Fallback --}}
                                <div class="relative bg-white border border-(--color-border) p-6 rounded-(--radius-card) shadow-xl space-y-5"
                                    x-data="{ step: 3 }">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-11 h-11 rounded-xl bg-(--color-primary)/10 text-(--color-primary) flex items-center justify-center text-lg">
                                                <i class="fa-solid fa-road-bridge" aria-hidden="true"></i>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-bold text-(--color-text)">
                                                    ADU-{{ now()->format('Ymd') }}-0192</h4>
                                                <p class="text-xs text-(--color-text)/50">Jalan Berlubang &middot;
                                                    Desa Sukamaju</p>
                                            </div>
                                        </div>
                                        <span
                                            class="px-2.5 py-1 rounded-(--radius-badge) bg-(--color-info)/10 text-(--color-info) text-[11px] font-semibold">Diproses</span>
                                    </div>

                                    <!-- Mini timeline demo, motif garis rute -->
                                    <div class="grid grid-cols-4 gap-0 items-start pt-2">
                                        <template x-for="(s, i) in ['Masuk', 'Verifikasi', 'Dikerjakan', 'Selesai']"
                                            :key="i">
                                            <div class="flex flex-col items-center relative">
                                                <div class="w-full h-0.5 absolute top-3.5 route-line"
                                                    :class="i === 0 ? 'invisible' : ''"></div>
                                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-bold relative z-10 border-2"
                                                    :class="i < step ?
                                                        'bg-(--color-primary) border-(--color-primary) text-white' :
                                                        (i === step ?
                                                            'bg-white border-(--color-accent) text-(--color-accent) animate-pulse' :
                                                            'bg-white border-(--color-border) text-(--color-text)/30'
                                                        )">
                                                    <i class="fa-solid fa-check text-[9px]" x-show="i < step"
                                                        aria-hidden="true"></i>
                                                    <span x-show="i >= step" x-text="i + 1"></span>
                                                </div>
                                                <span class="text-[10px] mt-1.5 text-center text-(--color-text)/60"
                                                    x-text="s"></span>
                                            </div>
                                        </template>
                                    </div>

                                    <div
                                        class="bg-(--color-bg) border border-(--color-border) rounded-xl p-3 text-xs text-(--color-text)/70">
                                        <span class="font-semibold text-(--color-primary)">Tanggapan
                                            terbaru:</span>
                                        Tim teknis Desa Sukamaju telah menuju lokasi untuk penambalan aspal.
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 3: LIVE STATISTICS BANNER          -->
        <!-- ========================================== -->
        <section class="relative -mt-8 z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-(--color-border) rounded-(--radius-card) p-6 sm:p-8 shadow-sm reveal-up"
                x-intersect-once="$el.classList.add('is-visible')" x-data>
                <div
                    class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 divide-y lg:divide-y-0 lg:divide-x divide-(--color-border)">

                    <div class="flex items-center gap-4 pt-4 lg:pt-0" x-data="{ n: 0 }"
                        x-intersect-once="Array.from({length: 30}).forEach((_, i) => setTimeout(() => n = Math.round({{ (int) $stats['total'] }} * (i + 1) / 30), i * 20))">
                        <div
                            class="w-12 h-12 rounded-xl bg-(--color-primary)/10 text-(--color-primary) flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-inbox" aria-hidden="true"></i>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-bold text-(--color-text)"
                                x-text="n.toLocaleString('id-ID')">0</div>
                            <div class="text-xs sm:text-sm font-medium text-(--color-text)/60">Total Aduan Masuk
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-4 lg:pt-0 lg:pl-8" x-data="{ n: 0 }"
                        x-intersect-once="Array.from({length: 30}).forEach((_, i) => setTimeout(() => n = Math.round({{ (int) $stats['diproses'] }} * (i + 1) / 30), i * 20))">
                        <div
                            class="w-12 h-12 rounded-xl bg-(--color-accent)/10 text-(--color-accent) flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-spinner" aria-hidden="true"></i>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-bold text-(--color-text)"
                                x-text="n.toLocaleString('id-ID')">0</div>
                            <div class="text-xs sm:text-sm font-medium text-(--color-text)/60">Sedang Diproses
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-4 lg:pt-0 lg:pl-8" x-data="{ n: 0 }"
                        x-intersect-once="Array.from({length: 30}).forEach((_, i) => setTimeout(() => n = Math.round({{ (int) $stats['selesai'] }} * (i + 1) / 30), i * 20))">
                        <div
                            class="w-12 h-12 rounded-xl bg-(--color-secondary)/10 text-(--color-secondary) flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-bold text-(--color-text)"
                                x-text="n.toLocaleString('id-ID')">0</div>
                            <div class="text-xs sm:text-sm font-medium text-(--color-text)/60">Selesai Ditangani
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-4 lg:pt-0 lg:pl-8">
                        <div
                            class="w-12 h-12 rounded-xl bg-(--color-info)/10 text-(--color-info) flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-chart-line" aria-hidden="true"></i>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-bold text-(--color-text)">
                                @if ($stats['responRate'] !== null)
                                    {{ $stats['responRate'] }}%
                                @else
                                    <span class="text-base text-(--color-text)/40 font-medium">Belum ada
                                        data</span>
                                @endif
                            </div>
                            <div class="text-xs sm:text-sm font-medium text-(--color-text)/60">Verifikasi &lt; 24
                                Jam</div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 4: ALUR STATUS ADUAN (interactive) -->
        <!-- ========================================== -->
        <section id="alur-status" class="py-20 scroll-mt-20">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center max-w-2xl mx-auto mb-14 space-y-3">
                    <h2 class="text-2xl sm:text-3xl font-bold text-(--color-text)">Alur Status Laporan</h2>
                    <p class="text-sm sm:text-base text-(--color-text)/70">
                        Setiap laporan melewati tahapan yang jelas. Klik tiap tahap untuk melihat apa yang terjadi di
                        baliknya.
                    </p>
                </div>

                <div x-data="{ active: 'pending' }" class="space-y-8">

                    <!-- Stepper -->
                    <div class="relative flex justify-between items-start max-w-3xl mx-auto">
                        <div class="absolute top-6 left-0 right-0 h-0.5 route-line"></div>

                        <button @click="active = 'pending'"
                            class="relative z-10 flex flex-col items-center gap-2 group"
                            :aria-pressed="(active === 'pending').toString()">
                            <span
                                class="w-12 h-12 rounded-full flex items-center justify-center text-lg border-2 transition duration-200"
                                :class="active === 'pending' ?
                                    'bg-(--color-accent) border-(--color-accent) text-white shadow-md scale-105' :
                                    'bg-white border-(--color-border) text-(--color-text)/50 group-hover:border-(--color-accent)'">
                                <i class="fa-solid fa-hourglass-half" aria-hidden="true"></i>
                            </span>
                            <span class="text-xs font-semibold text-center"
                                :class="active === 'pending' ? 'text-(--color-accent)' : 'text-(--color-text)/60'">Menunggu<br>Verifikasi</span>
                        </button>

                        <button @click="active = 'processed'"
                            class="relative z-10 flex flex-col items-center gap-2 group"
                            :aria-pressed="(active === 'processed').toString()">
                            <span
                                class="w-12 h-12 rounded-full flex items-center justify-center text-lg border-2 transition duration-200"
                                :class="active === 'processed' ?
                                    'bg-(--color-info) border-(--color-info) text-white shadow-md scale-105' :
                                    'bg-white border-(--color-border) text-(--color-text)/50 group-hover:border-(--color-info)'">
                                <i class="fa-solid fa-screwdriver-wrench" aria-hidden="true"></i>
                            </span>
                            <span class="text-xs font-semibold text-center"
                                :class="active === 'processed' ? 'text-(--color-info)' : 'text-(--color-text)/60'">Diproses</span>
                        </button>

                        <button @click="active = 'rejected'"
                            class="relative z-10 flex flex-col items-center gap-2 group"
                            :aria-pressed="(active === 'rejected').toString()">
                            <span
                                class="w-12 h-12 rounded-full flex items-center justify-center text-lg border-2 transition duration-200"
                                :class="active === 'rejected' ?
                                    'bg-(--color-error) border-(--color-error) text-white shadow-md scale-105' :
                                    'bg-white border-(--color-border) text-(--color-text)/50 group-hover:border-(--color-error)'">
                                <i class="fa-solid fa-circle-xmark" aria-hidden="true"></i>
                            </span>
                            <span class="text-xs font-semibold text-center"
                                :class="active === 'rejected' ? 'text-(--color-error)' : 'text-(--color-text)/60'">Ditolak</span>
                        </button>

                        <button @click="active = 'completed'"
                            class="relative z-10 flex flex-col items-center gap-2 group"
                            :aria-pressed="(active === 'completed').toString()">
                            <span
                                class="w-12 h-12 rounded-full flex items-center justify-center text-lg border-2 transition duration-200"
                                :class="active === 'completed' ?
                                    'bg-(--color-secondary) border-(--color-secondary) text-white shadow-md scale-105' :
                                    'bg-white border-(--color-border) text-(--color-text)/50 group-hover:border-(--color-secondary)'">
                                <i class="fa-solid fa-flag-checkered" aria-hidden="true"></i>
                            </span>
                            <span class="text-xs font-semibold text-center"
                                :class="active === 'completed' ? 'text-(--color-secondary)' :
                                    'text-(--color-text)/60'">Selesai</span>
                        </button>
                    </div>

                    <!-- Detail Panel -->
                    <div
                        class="bg-white border border-(--color-border) rounded-(--radius-card) p-6 sm:p-8 shadow-sm max-w-3xl mx-auto">
                        <div x-show="active === 'pending'" x-cloak>
                            <h3 class="text-lg font-semibold text-(--color-text) mb-2"><i
                                    class="fa-solid fa-hourglass-half text-(--color-accent) mr-2"
                                    aria-hidden="true"></i>Menunggu Verifikasi</h3>
                            <p class="text-sm text-(--color-text)/70 leading-relaxed">Laporan baru masuk ke inbox
                                petugas desa sesuai lokasi kejadian yang Anda tandai di peta. Petugas memeriksa
                                kelengkapan data dan bukti foto dalam waktu kurang dari 24 jam.</p>
                        </div>
                        <div x-show="active === 'processed'" x-cloak>
                            <h3 class="text-lg font-semibold text-(--color-text) mb-2"><i
                                    class="fa-solid fa-screwdriver-wrench text-(--color-info) mr-2"
                                    aria-hidden="true"></i>Diproses</h3>
                            <p class="text-sm text-(--color-text)/70 leading-relaxed">Laporan diterima dan sedang
                                ditindaklanjuti di lapangan. Petugas dapat menambahkan catatan progres beserta foto
                                bukti pengerjaan yang bisa Anda pantau langsung.</p>
                        </div>
                        <div x-show="active === 'rejected'" x-cloak>
                            <h3 class="text-lg font-semibold text-(--color-text) mb-2"><i
                                    class="fa-solid fa-circle-xmark text-(--color-error) mr-2"
                                    aria-hidden="true"></i>Ditolak</h3>
                            <p class="text-sm text-(--color-text)/70 leading-relaxed">Laporan tidak dapat diproses
                                lebih lanjut. Alasan penolakan selalu dicantumkan oleh petugas, misalnya data kurang
                                lengkap atau di luar cakupan kewenangan desa.</p>
                        </div>
                        <div x-show="active === 'completed'" x-cloak>
                            <h3 class="text-lg font-semibold text-(--color-text) mb-2"><i
                                    class="fa-solid fa-flag-checkered text-(--color-secondary) mr-2"
                                    aria-hidden="true"></i>Selesai</h3>
                            <p class="text-sm text-(--color-text)/70 leading-relaxed">Masalah telah ditangani,
                                lengkap dengan foto bukti pengerjaan di lapangan. Anda dapat memberikan penilaian
                                kepuasan atas hasil penanganan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 5: CARA KERJA                      -->
        <!-- ========================================== -->
        <section id="cara-kerja" class="py-20 bg-white border-y border-(--color-border) scroll-mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center max-w-2xl mx-auto mb-16 space-y-3 reveal-up"
                    x-intersect-once="$el.classList.add('is-visible')" x-data>
                    <h2 class="text-2xl sm:text-3xl font-bold text-(--color-text)">Cara Kerja Pengaduan</h2>
                    <p class="text-sm sm:text-base text-(--color-text)/70">Empat langkah dari laporan ditulis
                        sampai ditangani petugas desa.</p>
                </div>

                <div class="relative grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="hidden lg:block absolute top-12 left-[12.5%] right-[12.5%] h-0.5 route-line"></div>

                    <div class="relative bg-white border border-(--color-border) rounded-(--radius-card) p-6 hover:shadow-md hover:-translate-y-0.5 transition duration-200 reveal-up"
                        style="transition-delay:0ms" x-intersect-once="$el.classList.add('is-visible')" x-data>
                        <div
                            class="w-12 h-12 rounded-xl bg-(--color-primary)/10 text-(--color-primary) flex items-center justify-center text-xl mb-6">
                            <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-(--color-text) mb-2">1. Tulis Laporan</h3>
                        <p class="text-sm text-(--color-text)/70 leading-relaxed">Isi formulir, pilih kategori,
                            tandai titik lokasi di peta interaktif, dan lampirkan bukti foto (maks. 5MB).</p>
                    </div>

                    <div class="relative bg-white border border-(--color-border) rounded-(--radius-card) p-6 hover:shadow-md hover:-translate-y-0.5 transition duration-200 reveal-up"
                        style="transition-delay:80ms" x-intersect-once="$el.classList.add('is-visible')" x-data>
                        <div
                            class="w-12 h-12 rounded-xl bg-(--color-info)/10 text-(--color-info) flex items-center justify-center text-xl mb-6">
                            <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-(--color-text) mb-2">2. Dirutekan Otomatis</h3>
                        <p class="text-sm text-(--color-text)/70 leading-relaxed">Sistem mendeteksi desa lokasi
                            kejadian dan meneruskan laporan ke petugas desa yang berwenang.</p>
                    </div>

                    <div class="relative bg-white border border-(--color-border) rounded-(--radius-card) p-6 hover:shadow-md hover:-translate-y-0.5 transition duration-200 reveal-up"
                        style="transition-delay:160ms" x-intersect-once="$el.classList.add('is-visible')" x-data>
                        <div
                            class="w-12 h-12 rounded-xl bg-(--color-accent)/10 text-(--color-accent) flex items-center justify-center text-xl mb-6">
                            <i class="fa-solid fa-screwdriver-wrench" aria-hidden="true"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-(--color-text) mb-2">3. Ditindaklanjuti</h3>
                        <p class="text-sm text-(--color-text)/70 leading-relaxed">Petugas memproses masalah di
                            lapangan dan memperbarui progres beserta foto bukti secara transparan.</p>
                    </div>

                    <div class="relative bg-white border border-(--color-border) rounded-(--radius-card) p-6 hover:shadow-md hover:-translate-y-0.5 transition duration-200 reveal-up"
                        style="transition-delay:240ms" x-intersect-once="$el.classList.add('is-visible')" x-data>
                        <div
                            class="w-12 h-12 rounded-xl bg-(--color-secondary)/10 text-(--color-secondary) flex items-center justify-center text-xl mb-6">
                            <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-(--color-text) mb-2">4. Selesai & Dinilai</h3>
                        <p class="text-sm text-(--color-text)/70 leading-relaxed">Laporan dinyatakan selesai
                            lengkap dengan foto bukti pengerjaan, lalu Anda dapat memberi penilaian.</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 6: PETA CAKUPAN WILAYAH (LeafletJS)-->
        <!-- ========================================== -->
        <section id="peta-wilayah" class="py-20 scroll-mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-5 gap-10 items-center">

                    <div class="lg:col-span-2 space-y-4 reveal-up" x-intersect-once="$el.classList.add('is-visible')"
                        x-data>
                        <h2 class="text-2xl sm:text-3xl font-bold text-(--color-text)">Peta Cakupan Wilayah</h2>
                        <p class="text-sm sm:text-base text-(--color-text)/70 leading-relaxed">
                            Saat membuat laporan, Anda menandai titik kejadian langsung di peta interaktif berbasis
                            OpenStreetMap.
                            Sistem otomatis mencocokkan titik tersebut dengan batas desa agar laporan sampai ke petugas
                            yang tepat,
                            tanpa tugas antarpetugas desa saling tercampur.
                        </p>
                        <ul class="space-y-3 pt-2">
                            <li class="flex items-start gap-3 text-sm text-(--color-text)/80">
                                <i class="fa-solid fa-check text-(--color-secondary) mt-1" aria-hidden="true"></i>
                                Titik koordinat presisi, bukan sekadar nama alamat
                            </li>
                            <li class="flex items-start gap-3 text-sm text-(--color-text)/80">
                                <i class="fa-solid fa-check text-(--color-secondary) mt-1" aria-hidden="true"></i>
                                Penentuan desa otomatis dari lokasi yang ditandai
                            </li>
                            <li class="flex items-start gap-3 text-sm text-(--color-text)/80">
                                <i class="fa-solid fa-check text-(--color-secondary) mt-1" aria-hidden="true"></i>
                                Petugas menerima laporan lengkap dengan titik lokasinya
                            </li>
                        </ul>
                    </div>

                    <div class="lg:col-span-3">
                        <div x-data="{ loaded: false, failed: false }" x-init="const timeoutId = setTimeout(() => { if (!loaded) failed = true }, 8000);
                        $nextTick(() => {
                            try {
                                const map = L.map($refs.mapEl, { scrollWheelZoom: false }).setView([{{ $kecamatanCenter['lat'] }}, {{ $kecamatanCenter['lng'] }}], 13);
                                const tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; OpenStreetMap contributors',
                                    maxZoom: 18,
                                });
                                tiles.on('load', () => {
                                    loaded = true;
                                    clearTimeout(timeoutId);
                                });
                                tiles.addTo(map);
                                L.marker([{{ $kecamatanCenter['lat'] }}, {{ $kecamatanCenter['lng'] }}]).addTo(map)
                                    .bindPopup('Kantor {{ $kecamatanName }}').openPopup();
                            } catch (e) {
                                failed = true;
                                clearTimeout(timeoutId);
                            }
                        })"
                            class="relative w-full h-90 sm:h-105 rounded-(--radius-card) overflow-hidden border border-(--color-border) shadow-sm">

                            <div x-show="!loaded && !failed"
                                class="absolute inset-0 skeleton-shimmer flex items-center justify-center z-1">
                                <span
                                    class="text-xs font-medium text-(--color-text)/50 bg-white/80 px-3 py-1.5 rounded-full">Memuat
                                    peta&hellip;</span>
                            </div>

                            <div x-show="failed" x-cloak
                                class="absolute inset-0 bg-(--color-bg) flex flex-col items-center justify-center gap-2 text-center px-6 z-1">
                                <i class="fa-solid fa-map-location-dot text-2xl text-(--color-text)/30"
                                    aria-hidden="true"></i>
                                <p class="text-sm text-(--color-text)/60">Peta tidak dapat dimuat. Periksa koneksi
                                    internet Anda lalu muat ulang halaman.</p>
                            </div>

                            <div id="leaflet-map" x-ref="mapEl" class="w-full h-full"></div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 7: KATEGORI PENGADUAN POPULER      -->
        <!-- ========================================== -->
        <section class="py-20 bg-white border-y border-(--color-border)" x-data="{ selected: null }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center max-w-2xl mx-auto mb-16 space-y-3 reveal-up"
                    x-intersect-once="$el.classList.add('is-visible')" x-data>
                    <h2 class="text-2xl sm:text-3xl font-bold text-(--color-text)">Kategori Pengaduan</h2>
                    <p class="text-sm sm:text-base text-(--color-text)/70">Pilih kategori yang paling sesuai
                        dengan masalah yang ingin Anda laporkan.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">

                    <button @click="selected = 'infrastruktur'"
                        :aria-pressed="(selected === 'infrastruktur').toString()"
                        class="bg-(--color-bg) border rounded-(--radius-card) p-6 hover:-translate-y-0.5 transition duration-200 text-center group"
                        :class="selected === 'infrastruktur' ?
                            'border-(--color-primary) ring-1 ring-(--color-primary)' :
                            'border-(--color-border) hover:border-(--color-primary)'">
                        <div
                            class="w-14 h-14 rounded-full bg-white border border-(--color-border) text-(--color-primary) text-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-(--color-primary) group-hover:text-white transition duration-200">
                            <i class="fa-solid fa-road-bridge" aria-hidden="true"></i>
                        </div>
                        <h4 class="text-base font-semibold text-(--color-text) mb-1">Infrastruktur & Jalan</h4>
                        <p class="text-xs text-(--color-text)/60">Jalan berlubang, lampu jalan mati</p>
                    </button>

                    <button @click="selected = 'kebersihan'" :aria-pressed="(selected === 'kebersihan').toString()"
                        class="bg-(--color-bg) border rounded-(--radius-card) p-6 hover:-translate-y-0.5 transition duration-200 text-center group"
                        :class="selected === 'kebersihan' ?
                            'border-(--color-secondary) ring-1 ring-(--color-secondary)' :
                            'border-(--color-border) hover:border-(--color-secondary)'">
                        <div
                            class="w-14 h-14 rounded-full bg-white border border-(--color-border) text-(--color-secondary) text-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-(--color-secondary) group-hover:text-white transition duration-200">
                            <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                        </div>
                        <h4 class="text-base font-semibold text-(--color-text) mb-1">Kebersihan Lingkungan</h4>
                        <p class="text-xs text-(--color-text)/60">Sampah menumpuk, saluran air tersumbat</p>
                    </button>

                    <button @click="selected = 'ketertiban'" :aria-pressed="(selected === 'ketertiban').toString()"
                        class="bg-(--color-bg) border rounded-(--radius-card) p-6 hover:-translate-y-0.5 transition duration-200 text-center group"
                        :class="selected === 'ketertiban' ? 'border-(--color-accent) ring-1 ring-(--color-accent)' :
                            'border-(--color-border) hover:border-(--color-accent)'">
                        <div
                            class="w-14 h-14 rounded-full bg-white border border-(--color-border) text-(--color-accent) text-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-(--color-accent) group-hover:text-white transition duration-200">
                            <i class="fa-solid fa-shield" aria-hidden="true"></i>
                        </div>
                        <h4 class="text-base font-semibold text-(--color-text) mb-1">Ketertiban Umum</h4>
                        <p class="text-xs text-(--color-text)/60">Gangguan ketertiban, pedagang liar</p>
                    </button>

                    <button @click="selected = 'pelayanan'" :aria-pressed="(selected === 'pelayanan').toString()"
                        class="bg-(--color-bg) border rounded-(--radius-card) p-6 hover:-translate-y-0.5 transition duration-200 text-center group"
                        :class="selected === 'pelayanan' ? 'border-(--color-info) ring-1 ring-(--color-info)' :
                            'border-(--color-border) hover:border-(--color-info)'">
                        <div
                            class="w-14 h-14 rounded-full bg-white border border-(--color-border) text-(--color-info) text-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-(--color-info) group-hover:text-white transition duration-200">
                            <i class="fa-solid fa-hospital-user" aria-hidden="true"></i>
                        </div>
                        <h4 class="text-base font-semibold text-(--color-text) mb-1">Pelayanan Publik</h4>
                        <p class="text-xs text-(--color-text)/60">Layanan administrasi, fasilitas kesehatan</p>
                    </button>

                    <button @click="selected = 'lainnya'" :aria-pressed="(selected === 'lainnya').toString()"
                        class="bg-(--color-bg) border rounded-(--radius-card) p-6 hover:-translate-y-0.5 transition duration-200 text-center group sm:col-span-2 lg:col-span-1"
                        :class="selected === 'lainnya' ? 'border-(--color-text) ring-1 ring-(--color-text)' :
                            'border-(--color-border) hover:border-(--color-text)'">
                        <div
                            class="w-14 h-14 rounded-full bg-white border border-(--color-border) text-(--color-text) text-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-(--color-text) group-hover:text-white transition duration-200">
                            <i class="fa-solid fa-comments" aria-hidden="true"></i>
                        </div>
                        <h4 class="text-base font-semibold text-(--color-text) mb-1">Lainnya / Aspirasi</h4>
                        <p class="text-xs text-(--color-text)/60">Pertanyaan dan aspirasi umum warga</p>
                    </button>

                </div>

                <div x-show="selected" x-cloak x-transition
                    class="mt-8 max-w-xl mx-auto text-center bg-(--color-bg) border border-(--color-border) rounded-(--radius-card) p-5">
                    <p class="text-sm text-(--color-text)/70 mb-3">Siap melaporkan masalah kategori ini?</p>
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-(--radius-btn) bg-(--color-primary) text-white text-sm font-medium hover:bg-(--color-primary-dark) transition duration-200">
                        <i class="fa-solid fa-plus-circle" aria-hidden="true"></i> Buat Laporan Sekarang
                    </a>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 8: ADUAN PUBLIK TERBARU            -->
        <!-- ========================================== -->
        <section id="aduan-publik" class="py-20 scroll-mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-(--color-text) mb-2">Transparansi Aduan
                            Publik</h2>
                        <p class="text-sm sm:text-base text-(--color-text)/70">Laporan nyata dari warga yang
                            sedang dan telah ditangani petugas desa.</p>
                    </div>
                </div>

                <div x-data="{ filter: 'all' }" class="space-y-8">
                    <!-- Filter Tabs -->
                    <div class="flex flex-wrap gap-2" role="tablist" aria-label="Filter status aduan">
                        <button @click="filter = 'all'" role="tab"
                            :aria-selected="(filter === 'all').toString()"
                            class="px-4 py-2 rounded-(--radius-badge) text-xs font-semibold border transition duration-200"
                            :class="filter === 'all' ? 'bg-(--color-text) border-(--color-text) text-white' :
                                'bg-white border-(--color-border) text-(--color-text)/70 hover:border-(--color-text)'">
                            Semua
                        </button>
                        <button @click="filter = 'processed'" role="tab"
                            :aria-selected="(filter === 'processed').toString()"
                            class="px-4 py-2 rounded-(--radius-badge) text-xs font-semibold border transition duration-200"
                            :class="filter === 'processed' ? 'bg-(--color-info) border-(--color-info) text-white' :
                                'bg-white border-(--color-border) text-(--color-text)/70 hover:border-(--color-info)'">
                            Diproses
                        </button>
                        <button @click="filter = 'completed'" role="tab"
                            :aria-selected="(filter === 'completed').toString()"
                            class="px-4 py-2 rounded-(--radius-badge) text-xs font-semibold border transition duration-200"
                            :class="filter === 'completed' ?
                                'bg-(--color-secondary) border-(--color-secondary) text-white' :
                                'bg-white border-(--color-border) text-(--color-text)/70 hover:border-(--color-secondary)'">
                            Selesai
                        </button>
                    </div>

                    @if ($recentComplaints->isEmpty())
                        <!-- Empty state -->
                        <div
                            class="bg-white border border-dashed border-(--color-border) rounded-(--radius-card) p-12 text-center">
                            <i class="fa-solid fa-inbox text-3xl text-(--color-text)/20 mb-3" aria-hidden="true"></i>
                            <p class="text-sm text-(--color-text)/60">Belum ada laporan publik yang dapat
                                ditampilkan saat ini.</p>
                        </div>
                    @else
                        <div class="grid md:grid-cols-3 gap-6">
                            @foreach ($recentComplaints->take(6) as $item)
                                @php
                                    $statusKey = $item['status'] ?? 'processed';
                                    $meta = $statusLabel[$statusKey] ?? $statusLabel['processed'];
                                @endphp
                                <div x-show="filter === 'all' || filter === '{{ $statusKey }}'"
                                    class="bg-white border border-(--color-border) rounded-(--radius-card) p-6 hover:shadow-md transition duration-200 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between gap-2 mb-4">
                                            <span
                                                class="px-3 py-1 rounded-(--radius-badge) bg-(--color-primary)/10 text-(--color-primary) text-xs font-medium">{{ $item['category'] ?? 'Umum' }}</span>
                                            <span class="px-3 py-1 rounded-(--radius-badge) text-xs font-semibold"
                                                style="background-color:{{ $meta['bg'] }}; color:{{ $meta['color'] }}">{{ $meta['label'] }}</span>
                                        </div>
                                        <div class="text-xs text-(--color-text)/50 font-medium mb-2">
                                            {{ $item['code'] ?? '-' }} &bull; {{ $item['date'] ?? '-' }}</div>
                                        <h3 class="text-base font-semibold text-(--color-text) mb-2 line-clamp-1">
                                            {{ $item['title'] ?? 'Laporan Warga' }}</h3>
                                        <p class="text-sm text-(--color-text)/70 line-clamp-2 mb-4">
                                            {{ $item['description'] ?? '' }}</p>

                                        @if (!empty($item['response']))
                                            <div
                                                class="bg-(--color-bg) border border-(--color-border) rounded-xl p-3 text-xs text-(--color-text)/80 mb-4">
                                                <span class="font-semibold text-(--color-primary)">Tanggapan
                                                    Petugas:</span> {{ $item['response'] }}
                                            </div>
                                        @endif
                                    </div>
                                    <div
                                        class="pt-4 border-t border-(--color-border) flex items-center justify-between text-xs text-(--color-text)/60">
                                        <span>Pelapor: <strong>{{ $item['reporter'] ?? 'Anonim' }}</strong></span>
                                        <span><i class="fa-solid fa-location-dot text-(--color-error)"
                                                aria-hidden="true"></i>
                                            {{ $item['village'] ?? $kecamatanName }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 9: KEUNGGULAN & JAMINAN            -->
        <!-- ========================================== -->
        <section class="py-20 bg-white border-t border-(--color-border)">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 gap-8">

                    <div class="flex gap-4 reveal-up" x-intersect-once="$el.classList.add('is-visible')" x-data>
                        <div
                            class="w-12 h-12 rounded-xl bg-(--color-primary)/10 text-(--color-primary) flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-user-shield" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-(--color-text) mb-2">Jaminan Privasi</h3>
                            <p class="text-sm text-(--color-text)/70 leading-relaxed">Opsi anonim menjamin nama
                                dan identitas pelapor tidak ditampilkan ke publik.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 reveal-up" style="transition-delay:80ms"
                        x-intersect-once="$el.classList.add('is-visible')" x-data>
                        <div
                            class="w-12 h-12 rounded-xl bg-(--color-accent)/10 text-(--color-accent) flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-envelope-circle-check" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-(--color-text) mb-2">Notifikasi Email</h3>
                            <p class="text-sm text-(--color-text)/70 leading-relaxed">Pemberitahuan otomatis ke
                                email Anda setiap kali status laporan berubah.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 reveal-up" style="transition-delay:160ms"
                        x-intersect-once="$el.classList.add('is-visible')" x-data>
                        <div
                            class="w-12 h-12 rounded-xl bg-(--color-secondary)/10 text-(--color-secondary) flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-square-check" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-(--color-text) mb-2">Bukti Foto Pengerjaan</h3>
                            <p class="text-sm text-(--color-text)/70 leading-relaxed">Setiap tindak lanjut
                                disertai foto langsung dari tim lapangan, bukan sekadar keterangan tertulis.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 10: FAQ (ACCORDION)                -->
        <!-- ========================================== -->
        <section id="faq" class="py-20 scroll-mt-20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-16 space-y-3 reveal-up" x-intersect-once="$el.classList.add('is-visible')"
                    x-data>
                    <h2 class="text-2xl sm:text-3xl font-bold text-(--color-text)">Pertanyaan Sering Diajukan</h2>
                    <p class="text-sm sm:text-base text-(--color-text)/70">Jawaban seputar pendaftaran, pelaporan,
                        dan status aduan.</p>
                </div>

                <div class="space-y-3" x-data="{ active: null }">

                    @php
                        $faqs = [
                            [
                                'q' => 'Apakah saya wajib memakai NIK untuk mendaftar?',
                                'a' =>
                                    'Ya. Registrasi warga memakai Nomor Induk Kependudukan (NIK) 16 digit beserta email aktif, untuk memastikan setiap laporan berasal dari warga yang terverifikasi.',
                            ],
                            [
                                'q' => 'Bagaimana jika saya takut identitas saya tersebar?',
                                'a' =>
                                    'Aktifkan opsi Anonim saat membuat laporan. Nama dan data pribadi Anda tidak akan ditampilkan pada halaman Aduan Publik.',
                            ],
                            [
                                'q' => 'Bagaimana sistem menentukan petugas yang menangani laporan saya?',
                                'a' =>
                                    'Sistem mendeteksi desa dari titik lokasi kejadian yang Anda tandai di peta, lalu meneruskan laporan ke petugas yang bertugas di desa tersebut, bukan berdasarkan desa tempat Anda terdaftar.',
                            ],
                            [
                                'q' => 'Berapa lama laporan saya diproses?',
                                'a' =>
                                    'Verifikasi awal (diterima atau ditolak) dilakukan maksimal 24 jam. Penyelesaian masalah umumnya berkisar 1 sampai 7 hari kerja tergantung tingkat kerumitan di lapangan.',
                            ],
                            [
                                'q' => 'Format dan ukuran foto apa saja yang didukung?',
                                'a' =>
                                    'Sistem menerima berkas foto berformat JPEG, PNG, atau WebP dengan ukuran maksimum 5MB per foto.',
                            ],
                            [
                                'q' => 'Apakah layanan ini dipungut biaya?',
                                'a' => 'Tidak. Seluruh layanan pelaporan di E-Lapor tidak dipungut biaya apa pun.',
                            ],
                        ];
                    @endphp

                    @foreach ($faqs as $i => $faq)
                        <div class="bg-white border border-(--color-border) rounded-xl overflow-hidden shadow-sm">
                            <button @click="active = (active === {{ $i }} ? null : {{ $i }})"
                                :aria-expanded="(active === {{ $i }}).toString()"
                                aria-controls="faq-panel-{{ $i }}"
                                class="w-full p-5 text-left font-semibold text-(--color-text) flex justify-between items-center gap-4 hover:bg-(--color-bg) transition duration-200">
                                <span>{{ $faq['q'] }}</span>
                                <i class="fa-solid fa-chevron-down text-xs transition duration-200 shrink-0"
                                    :class="active === {{ $i }} ? 'rotate-180 text-(--color-primary)' :
                                        'text-(--color-text)/40'"
                                    aria-hidden="true"></i>
                            </button>
                            <div id="faq-panel-{{ $i }}" x-show="active === {{ $i }}"
                                x-collapse
                                class="px-5 pb-5 text-sm text-(--color-text)/70 leading-relaxed border-t border-(--color-border)/60 pt-3">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 11: CALL TO ACTION BANNER          -->
        <!-- ========================================== -->
        <section class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="bg-(--color-primary) rounded-(--radius-modal) p-8 sm:p-12 text-center text-white shadow-lg space-y-6">
                    <h2 class="text-2xl sm:text-4xl font-bold leading-tight">Menemukan Masalah di Lingkungan Anda?</h2>
                    <p class="text-base sm:text-lg text-white/80 max-w-2xl mx-auto">Satu laporan yang Anda kirim
                        membantu petugas desa memprioritaskan penanganan di wilayah Anda.</p>
                    <div class="pt-2">
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-(--radius-btn) bg-white text-(--color-primary) font-bold text-base hover:bg-slate-100 shadow transition duration-200">
                            <i class="fa-solid fa-plus-circle" aria-hidden="true"></i> Laporkan Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ========================================== -->
    <!-- SECTION 12: FOOTER                         -->
    <!-- ========================================== -->
    <footer class="bg-white border-t border-(--color-border) pt-16 pb-8 text-sm text-(--color-text)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 bg-(--color-primary) rounded-lg flex items-center justify-center text-white text-base">
                            <i class="fa-solid fa-bullhorn" aria-hidden="true"></i>
                        </div>
                        <span class="text-lg font-bold text-(--color-primary)">E-Lapor</span>
                    </div>
                    <p class="text-xs text-(--color-text)/70 leading-relaxed">
                        Sistem pengaduan masyarakat digital tingkat kecamatan untuk mendukung transparansi dan kecepatan
                        penanganan layanan publik.
                    </p>
                    <p class="text-xs text-(--color-text)/60">
                        <i class="fa-solid fa-location-dot mr-1 text-(--color-primary)" aria-hidden="true"></i>
                        Kantor {{ $kecamatanName }}
                    </p>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-(--color-text) mb-4">Navigasi Cepat</h4>
                    <ul class="space-y-2.5 text-xs text-(--color-text)/70">
                        <li><a href="#beranda"
                                class="hover:text-(--color-primary) transition duration-200">Beranda</a></li>
                        <li><a href="#alur-status" class="hover:text-(--color-primary) transition duration-200">Alur
                                Status</a></li>
                        <li><a href="#cara-kerja" class="hover:text-(--color-primary) transition duration-200">Cara
                                Kerja</a></li>
                        <li><a href="#aduan-publik" class="hover:text-(--color-primary) transition duration-200">Aduan
                                Publik</a></li>
                        <li><a href="#faq" class="hover:text-(--color-primary) transition duration-200">FAQ</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-(--color-text) mb-4">Akun</h4>
                    <ul class="space-y-2.5 text-xs text-(--color-text)/70">
                        <li><a href="{{ route('login') }}"
                                class="hover:text-(--color-primary) transition duration-200">Masuk Warga</a></li>
                        <li><a href="{{ route('register') }}"
                                class="hover:text-(--color-primary) transition duration-200">Daftar Akun Warga</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-(--color-text) mb-4">Kontak Layanan</h4>
                    <ul class="space-y-2.5 text-xs text-(--color-text)/70">
                        <li><i class="fa-solid fa-envelope mr-1 text-(--color-primary)" aria-hidden="true"></i>
                            support@elapor.go.id</li>
                        <li><i class="fa-solid fa-clock mr-1 text-(--color-primary)" aria-hidden="true"></i>
                            Senin&ndash;Jumat, 08.00&ndash;16.00 WIB</li>
                    </ul>
                </div>

            </div>

            <div
                class="pt-8 border-t border-(--color-border) flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-(--color-text)/50">
                <span>&copy; {{ now()->year }} E-Lapor. Hak Cipta Dilindungi Undang-Undang.</span>
                <span>Dikelola oleh Pemerintah {{ $kecamatanName }}</span>
            </div>
        </div>
    </footer>

    <!-- LeafletJS script -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        // Directive x-intersect-once: menjalankan ekspresi sekali saat elemen
        // pertama kali terlihat di viewport. Dipakai selektif untuk reveal
        // dan animasi hitung-naik statistik, bukan dipasang di semua elemen.
        document.addEventListener('alpine:init', () => {
            Alpine.directive('intersect-once', (el, {
                expression
            }, {
                evaluate,
                cleanup
            }) => {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            evaluate(expression);
                            observer.unobserve(el);
                        }
                    });
                }, {
                    threshold: 0.2
                });
                observer.observe(el);
                cleanup(() => observer.disconnect());
            });
        });

        // Catatan: scrollspy navbar diinisialisasi langsung lewat x-init pada <body>
        // (lihat atas), sehingga activeSection tetap berada dalam satu scope Alpine
        // yang sama dengan state mobileMenuOpen.
    </script>

</body>

</html>
