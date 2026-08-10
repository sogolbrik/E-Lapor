<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Lapor - Layanan Pengaduan Masyarakat Online</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome v6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS v4 / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F8FAFC;
            color: #1E293B;
        }
    </style>
</head>

<body class="bg-[#F8FAFC] text-[#1E293B] antialiased">

    <!-- ========================================== -->
    <!-- SECTION 1: TOP NAVBAR / HEADER             -->
    <!-- ========================================== -->
    <header x-data="{ mobileMenuOpen: false }"
        class="sticky top-0 z-50 bg-[#FFFFFF]/90 backdrop-blur-md border-b border-[#E2E8F0] transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">

            <!-- Brand Logo -->
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 bg-[#2563EB] rounded-xl flex items-center justify-center text-white text-xl shadow-sm">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <div>
                    <span class="text-xl font-bold text-[#2563EB] tracking-tight block leading-none">E-Lapor</span>
                    <span class="text-[11px] font-medium text-[#1E293B]/60 tracking-wider uppercase">Portal Pengaduan
                        Publik</span>
                </div>
            </div>

            <!-- Quick Navigation Menu (Desktop) -->
            <nav class="hidden lg:flex items-center gap-8">
                <a href="#beranda"
                    class="text-sm font-semibold text-[#2563EB] relative py-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-[#2563EB] after:rounded-full">Beranda</a>
                <a href="#cara-kerja"
                    class="text-sm font-medium text-[#1E293B] hover:text-[#2563EB] transition duration-200">Cara
                    Kerja</a>
                <a href="#statistik"
                    class="text-sm font-medium text-[#1E293B] hover:text-[#2563EB] transition duration-200">Statistik</a>
                <a href="#aduan-publik"
                    class="text-sm font-medium text-[#1E293B] hover:text-[#2563EB] transition duration-200">Aduan
                    Publik</a>
                <a href="#faq"
                    class="text-sm font-medium text-[#1E293B] hover:text-[#2563EB] transition duration-200">FAQ</a>
            </nav>

            <!-- Action Buttons (Desktop) -->
            <div class="hidden lg:flex items-center gap-4">
                <a href="{{ route('login') }}"
                    class="px-5 py-2.5 rounded-xl border border-[#2563EB] text-[#2563EB] text-sm font-medium hover:bg-[#2563EB] hover:text-white transition duration-200">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                    class="px-5 py-2.5 rounded-xl bg-[#2563EB] text-white text-sm font-medium hover:bg-[#1d4ed8] shadow-sm hover:shadow transition duration-200">
                    Daftar
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="lg:hidden p-2 text-[#1E293B] hover:text-[#2563EB] focus:outline-none">
                <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark text-2xl' : 'fa-bars text-xl'"></i>
            </button>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileMenuOpen" x-collapse
            class="lg:hidden bg-[#FFFFFF] border-b border-[#E2E8F0] px-4 pt-2 pb-6 space-y-3">
            <a href="#beranda" @click="mobileMenuOpen = false"
                class="block py-2 text-sm font-semibold text-[#2563EB]">Beranda</a>
            <a href="#cara-kerja" @click="mobileMenuOpen = false"
                class="block py-2 text-sm font-medium text-[#1E293B]">Cara Kerja</a>
            <a href="#statistik" @click="mobileMenuOpen = false"
                class="block py-2 text-sm font-medium text-[#1E293B]">Statistik</a>
            <a href="#aduan-publik" @click="mobileMenuOpen = false"
                class="block py-2 text-sm font-medium text-[#1E293B]">Aduan Publik</a>
            <a href="#faq" @click="mobileMenuOpen = false"
                class="block py-2 text-sm font-medium text-[#1E293B]">FAQ</a>
            <div class="pt-4 border-t border-[#E2E8F0] flex flex-col gap-2">
                <a href="{{ route('login') }}"
                    class="w-full text-center py-2.5 rounded-xl border border-[#2563EB] text-[#2563EB] text-sm font-medium">Masuk</a>
                <a href="{{ route('register') }}"
                    class="w-full text-center py-2.5 rounded-xl bg-[#2563EB] text-white text-sm font-medium">Daftar</a>
                <a href="#portal-petugas"
                    class="text-center text-xs font-medium text-[#1E293B]/70 py-2 flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-user-shield text-[#2563EB]"></i> Portal Petugas
                </a>
            </div>
        </div>
    </header>

    <main id="beranda">
        <!-- ========================================== -->
        <!-- SECTION 2: HERO SECTION                    -->
        <!-- ========================================== -->
        <section class="relative pt-12 pb-20 lg:pt-20 lg:pb-32 overflow-hidden bg-[#F8FAFC]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-12 gap-12 items-center">

                    <!-- Left Column: Content & CTA -->
                    <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-[#1E293B] leading-tight">
                            Sampaikan Laporan Anda, Wujudkan Pelayanan Publik yang Lebih Baik.
                        </h1>
                        <p class="text-base sm:text-lg text-[#1E293B]/70 max-w-2xl mx-auto lg:mx-0">
                            Platform resmi pengaduan dan aspirasi masyarakat secara transparan, terukur, dan
                            terintegrasi.
                        </p>

                        <!-- CTA Buttons -->
                        <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                            <a href="{{ route('login') }}"
                                class="w-full sm:w-auto px-8 py-4 rounded-xl bg-[#2563EB] text-white font-medium text-base hover:bg-[#1d4ed8] shadow-md hover:shadow-lg transition duration-200 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-plus-circle"></i>
                                <span>Buat Laporan Baru</span>
                            </a>
                        </div>

                        <!-- Trust Badges -->
                        <div class="pt-6 flex flex-wrap items-center justify-center lg:justify-start gap-3">
                            <span
                                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-[#E2E8F0] text-xs font-medium text-[#1E293B] shadow-sm">
                                <i class="fa-solid fa-user-ninja text-[#2563EB]"></i> Identitas Aman / Bisa Anonim
                            </span>
                            <span
                                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-[#E2E8F0] text-xs font-medium text-[#1E293B] shadow-sm">
                                <i class="fa-solid fa-bolt text-[#F59E0B]"></i> Respon &lt; 24 Jam
                            </span>
                            <span
                                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-[#E2E8F0] text-xs font-medium text-[#1E293B] shadow-sm">
                                <i class="fa-solid fa-map-location-dot text-[#10B981]"></i> Berbasis Peta Presisi
                            </span>
                        </div>
                    </div>

                    <!-- Right Column: Illustration -->
                    <div class="lg:col-span-5 flex justify-center">
                        <div class="relative w-full max-w-md lg:max-w-none">
                            <div
                                class="absolute -top-6 -left-6 w-72 h-72 bg-[#2563EB]/10 rounded-full filter blur-3xl pointer-events-none">
                            </div>
                            <div
                                class="absolute -bottom-6 -right-6 w-72 h-72 bg-[#10B981]/10 rounded-full filter blur-3xl pointer-events-none">
                            </div>

                            <!-- Vector Card Illustration Container -->
                            <div class="relative bg-white border border-[#E2E8F0] p-8 rounded-2xl shadow-xl space-y-6">
                                <div class="flex items-center gap-4 border-b border-[#E2E8F0] pb-4">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-[#2563EB]/10 text-[#2563EB] flex items-center justify-center text-xl">
                                        <i class="fa-solid fa-shield-cat"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-base font-bold text-[#1E293B]">Laporan Terverifikasi</h4>
                                        <p class="text-xs text-[#1E293B]/60">Sistem terintegrasi instansi resmi</p>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <div class="h-3 bg-[#F8FAFC] rounded-full w-3/4"></div>
                                    <div class="h-3 bg-[#F8FAFC] rounded-full w-full"></div>
                                    <div class="h-3 bg-[#F8FAFC] rounded-full w-5/6"></div>
                                </div>
                                <div class="pt-2 flex items-center justify-between">
                                    <span
                                        class="px-3 py-1 rounded-full bg-[#10B981]/10 text-[#10B981] text-xs font-semibold">
                                        <i class="fa-solid fa-check-circle mr-1"></i> Tuntas 100%
                                    </span>
                                    <span class="text-xs font-medium text-[#1E293B]/50">Pengerjaan Transparan</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 3: LIVE STATISTICS BANNER          -->
        <!-- ========================================== -->
        <section id="statistik" class="relative -mt-12 z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-[#E2E8F0] rounded-2xl p-6 sm:p-8 shadow-sm">
                <div
                    class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 divide-y lg:divide-y-0 lg:divide-x divide-[#E2E8F0]">

                    <!-- Metric 1 -->
                    <div class="flex items-center gap-4 pt-4 lg:pt-0">
                        <div
                            class="w-12 h-12 rounded-xl bg-[#2563EB]/10 text-[#2563EB] flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-inbox"></i>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-bold text-[#1E293B]">1,420</div>
                            <div class="text-xs sm:text-sm font-medium text-[#1E293B]/60">Total Aduan Masuk</div>
                        </div>
                    </div>

                    <!-- Metric 2 -->
                    <div class="flex items-center gap-4 pt-4 lg:pt-0 lg:pl-8">
                        <div
                            class="w-12 h-12 rounded-xl bg-[#F59E0B]/10 text-[#F59E0B] flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-spinner"></i>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-bold text-[#1E293B]">105</div>
                            <div class="text-xs sm:text-sm font-medium text-[#1E293B]/60">Sedang Diproses</div>
                        </div>
                    </div>

                    <!-- Metric 3 -->
                    <div class="flex items-center gap-4 pt-4 lg:pt-0 lg:pl-8">
                        <div
                            class="w-12 h-12 rounded-xl bg-[#10B981]/10 text-[#10B981] flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-bold text-[#1E293B]">1,280</div>
                            <div class="text-xs sm:text-sm font-medium text-[#1E293B]/60">Selesai Ditangani</div>
                        </div>
                    </div>

                    <!-- Metric 4 -->
                    <div class="flex items-center gap-4 pt-4 lg:pt-0 lg:pl-8">
                        <div
                            class="w-12 h-12 rounded-xl bg-[#3B82F6]/10 text-[#3B82F6] flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-bold text-[#1E293B]">98.5%</div>
                            <div class="text-xs sm:text-sm font-medium text-[#1E293B]/60">Tingkat Respon Cepat</div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 4: CARA KERJA / TATA CARA          -->
        <!-- ========================================== -->
        <section id="cara-kerja" class="py-20 bg-[#F8FAFC]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                    <h2 class="text-2xl sm:text-3xl font-bold text-[#1E293B]">Cara Kerja Pengaduan</h2>
                    <p class="text-sm sm:text-base text-[#1E293B]/70">4 langkah mudah menyampaikan laporan hingga
                        diselesaikan oleh petugas.</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- Step 1 -->
                    <div
                        class="bg-white border border-[#E2E8F0] rounded-2xl p-6 hover:shadow-md transition duration-200">
                        <div
                            class="w-12 h-12 rounded-xl bg-[#2563EB]/10 text-[#2563EB] flex items-center justify-center text-xl font-bold mb-6">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-[#1E293B] mb-2">1. Tulis Laporan</h3>
                        <p class="text-sm text-[#1E293B]/70 leading-relaxed">Isi formulir, pilih kategori, tentukan
                            titik lokasi peta, dan lampirkan bukti foto.</p>
                    </div>

                    <!-- Step 2 -->
                    <div
                        class="bg-white border border-[#E2E8F0] rounded-2xl p-6 hover:shadow-md transition duration-200">
                        <div
                            class="w-12 h-12 rounded-xl bg-[#3B82F6]/10 text-[#3B82F6] flex items-center justify-center text-xl font-bold mb-6">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-[#1E293B] mb-2">2. Verifikasi & Disposisi</h3>
                        <p class="text-sm text-[#1E293B]/70 leading-relaxed">Laporan diverifikasi oleh petugas dalam
                            kurun waktu &lt; 24 jam lalu ditugaskan ke dinas terkait.</p>
                    </div>

                    <!-- Step 3 -->
                    <div
                        class="bg-white border border-[#E2E8F0] rounded-2xl p-6 hover:shadow-md transition duration-200">
                        <div
                            class="w-12 h-12 rounded-xl bg-[#F59E0B]/10 text-[#F59E0B] flex items-center justify-center text-xl font-bold mb-6">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-[#1E293B] mb-2">3. Tindak Lanjut Lapangan</h3>
                        <p class="text-sm text-[#1E293B]/70 leading-relaxed">Petugas memproses masalah di lapangan dan
                            memperbarui progres secara transparan.</p>
                    </div>

                    <!-- Step 4 -->
                    <div
                        class="bg-white border border-[#E2E8F0] rounded-2xl p-6 hover:shadow-md transition duration-200">
                        <div
                            class="w-12 h-12 rounded-xl bg-[#10B981]/10 text-[#10B981] flex items-center justify-center text-xl font-bold mb-6">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-[#1E293B] mb-2">4. Selesai & Evaluasi</h3>
                        <p class="text-sm text-[#1E293B]/70 leading-relaxed">Laporan dinyatakan selesai lengkap dengan
                            foto bukti pengerjaan, lalu pelapor dapat memberikan ulasan.</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 5: KATEGORI PENGADUAN POPULER      -->
        <!-- ========================================== -->
        <section class="py-20 bg-white border-y border-[#E2E8F0]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                    <h2 class="text-2xl sm:text-3xl font-bold text-[#1E293B]">Kategori Pengaduan Populer</h2>
                    <p class="text-sm sm:text-base text-[#1E293B]/70">Pilih kategori masalah yang ingin Anda laporkan.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">

                    <!-- Category 1 -->
                    <div
                        class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-2xl p-6 hover:border-[#2563EB] hover:scale-[1.02] transition duration-200 cursor-pointer text-center group">
                        <div
                            class="w-14 h-14 rounded-full bg-white border border-[#E2E8F0] text-[#2563EB] text-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-[#2563EB] group-hover:text-white transition duration-200">
                            <i class="fa-solid fa-road-bridge"></i>
                        </div>
                        <h4 class="text-base font-semibold text-[#1E293B] mb-1">Infrastruktur & Jalan</h4>
                        <p class="text-xs text-[#1E293B]/60">Jalan berlubang, penerangan jalan mati</p>
                    </div>

                    <!-- Category 2 -->
                    <div
                        class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-2xl p-6 hover:border-[#2563EB] hover:scale-[1.02] transition duration-200 cursor-pointer text-center group">
                        <div
                            class="w-14 h-14 rounded-full bg-white border border-[#E2E8F0] text-[#10B981] text-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-[#10B981] group-hover:text-white transition duration-200">
                            <i class="fa-solid fa-trash-can"></i>
                        </div>
                        <h4 class="text-base font-semibold text-[#1E293B] mb-1">Kebersihan & Lingkungan</h4>
                        <p class="text-xs text-[#1E293B]/60">Sampah menumpuk, saluran air tumpat</p>
                    </div>

                    <!-- Category 3 -->
                    <div
                        class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-2xl p-6 hover:border-[#2563EB] hover:scale-[1.02] transition duration-200 cursor-pointer text-center group">
                        <div
                            class="w-14 h-14 rounded-full bg-white border border-[#E2E8F0] text-[#F59E0B] text-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-[#F59E0B] group-hover:text-white transition duration-200">
                            <i class="fa-solid fa-shield"></i>
                        </div>
                        <h4 class="text-base font-semibold text-[#1E293B] mb-1">Ketertiban Umum</h4>
                        <p class="text-xs text-[#1E293B]/60">Gangguan ketertiban, pedagang liar</p>
                    </div>

                    <!-- Category 4 -->
                    <div
                        class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-2xl p-6 hover:border-[#2563EB] hover:scale-[1.02] transition duration-200 cursor-pointer text-center group">
                        <div
                            class="w-14 h-14 rounded-full bg-white border border-[#E2E8F0] text-[#3B82F6] text-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-[#3B82F6] group-hover:text-white transition duration-200">
                            <i class="fa-solid fa-hospital-user"></i>
                        </div>
                        <h4 class="text-base font-semibold text-[#1E293B] mb-1">Pelayanan Publik</h4>
                        <p class="text-xs text-[#1E293B]/60">Layanan administrasi, fasilitas kesehatan</p>
                    </div>

                    <!-- Category 5 -->
                    <div
                        class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-2xl p-6 hover:border-[#2563EB] hover:scale-[1.02] transition duration-200 cursor-pointer text-center group sm:col-span-2 lg:col-span-1">
                        <div
                            class="w-14 h-14 rounded-full bg-white border border-[#E2E8F0] text-[#1E293B] text-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-[#1E293B] group-hover:text-white transition duration-200">
                            <i class="fa-solid fa-comments"></i>
                        </div>
                        <h4 class="text-base font-semibold text-[#1E293B] mb-1">Lainnya / Aspirasi</h4>
                        <p class="text-xs text-[#1E293B]/60">Pertanyaan dan aspirasi umum warga</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 6: ADUAN PUBLIK TERBARU            -->
        <!-- ========================================== -->
        <section id="aduan-publik" class="py-20 bg-[#F8FAFC]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-[#1E293B] mb-2">Transparansi Aduan Publik
                            Terbaru</h2>
                        <p class="text-sm sm:text-base text-[#1E293B]/70">Laporan nyata dari masyarakat yang sedang dan
                            telah ditangani.</p>
                    </div>
                    <a href="#"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-[#2563EB] hover:underline">
                        Lihat Seluruh Laporan Publik <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div class="grid md:grid-cols-3 gap-6 mb-12">

                    <!-- Card 1 -->
                    <div
                        class="bg-white border border-[#E2E8F0] rounded-2xl p-6 hover:shadow-md transition duration-200 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-4">
                                <span
                                    class="px-3 py-1 rounded-full bg-[#2563EB]/10 text-[#2563EB] text-xs font-medium">Infrastruktur</span>
                                <span
                                    class="px-3 py-1 rounded-full bg-[#10B981]/10 text-[#10B981] text-xs font-semibold">Selesai</span>
                            </div>
                            <div class="text-xs text-[#1E293B]/50 font-medium mb-2">ADU-20260804-0012 • 4 Agu 2026
                            </div>
                            <h3 class="text-base font-semibold text-[#1E293B] mb-2 line-clamp-1">Perbaikan Lampu Jalan
                                Utama Blok A</h3>
                            <p class="text-sm text-[#1E293B]/70 line-clamp-2 mb-4">Lampu penerangan jalan padam sejak 2
                                hari lalu sehingga mengganggu kenyamanan dan keselamatan warga.</p>

                            <!-- Officer Response Snippet -->
                            <div
                                class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-3 text-xs text-[#1E293B]/80 mb-4">
                                <span class="font-semibold text-[#2563EB]">Tanggapan Petugas:</span> Lampu pengganti
                                telah dipasang oleh Tim Dinas Perhubungan.
                            </div>
                        </div>
                        <div
                            class="pt-4 border-t border-[#E2E8F0] flex items-center justify-between text-xs text-[#1E293B]/60">
                            <span>Pelapor: <strong>Anonim</strong></span>
                            <span><i class="fa-solid fa-location-dot text-[#EF4444]"></i> Mojokerto</span>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div
                        class="bg-white border border-[#E2E8F0] rounded-2xl p-6 hover:shadow-md transition duration-200 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-4">
                                <span
                                    class="px-3 py-1 rounded-full bg-[#10B981]/10 text-[#10B981] text-xs font-medium">Kebersihan</span>
                                <span
                                    class="px-3 py-1 rounded-full bg-[#F59E0B]/10 text-[#F59E0B] text-xs font-semibold">Diproses</span>
                            </div>
                            <div class="text-xs text-[#1E293B]/50 font-medium mb-2">ADU-20260804-0015 • 4 Agu 2026
                            </div>
                            <h3 class="text-base font-semibold text-[#1E293B] mb-2 line-clamp-1">Tumpukan Sampah Liar
                                di Jalan Raya</h3>
                            <p class="text-sm text-[#1E293B]/70 line-clamp-2 mb-4">Adanya tumpukan sampah liar yang
                                menumpuk di pinggir jalan dan menimbulkan bau tidak sedap.</p>

                            <!-- Officer Response Snippet -->
                            <div
                                class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-3 text-xs text-[#1E293B]/80 mb-4">
                                <span class="font-semibold text-[#2563EB]">Tanggapan Petugas:</span> Jadwal
                                pengangkutan armada kebersihan telah didisposisikan.
                            </div>
                        </div>
                        <div
                            class="pt-4 border-t border-[#E2E8F0] flex items-center justify-between text-xs text-[#1E293B]/60">
                            <span>Pelapor: <strong>Masyarakat</strong></span>
                            <span><i class="fa-solid fa-location-dot text-[#EF4444]"></i> Mojokerto</span>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div
                        class="bg-white border border-[#E2E8F0] rounded-2xl p-6 hover:shadow-md transition duration-200 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-4">
                                <span
                                    class="px-3 py-1 rounded-full bg-[#2563EB]/10 text-[#2563EB] text-xs font-medium">Infrastruktur</span>
                                <span
                                    class="px-3 py-1 rounded-full bg-[#10B981]/10 text-[#10B981] text-xs font-semibold">Selesai</span>
                            </div>
                            <div class="text-xs text-[#1E293B]/50 font-medium mb-2">ADU-20260803-0008 • 3 Agu 2026
                            </div>
                            <h3 class="text-base font-semibold text-[#1E293B] mb-2 line-clamp-1">Penutupan Lubang Jalan
                                Berbahaya</h3>
                            <p class="text-sm text-[#1E293B]/70 line-clamp-2 mb-4">Lubang cukup dalam di pertigaan
                                jalan utama yang berisiko menyebabkan kecelakaan berkendara.</p>

                            <!-- Officer Response Snippet -->
                            <div
                                class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-3 text-xs text-[#1E293B]/80 mb-4">
                                <span class="font-semibold text-[#2563EB]">Tanggapan Petugas:</span> Penambalan aspal
                                telah selesai dikerjakan oleh tim teknis.
                            </div>
                        </div>
                        <div
                            class="pt-4 border-t border-[#E2E8F0] flex items-center justify-between text-xs text-[#1E293B]/60">
                            <span>Pelapor: <strong>Anonim</strong></span>
                            <span><i class="fa-solid fa-location-dot text-[#EF4444]"></i> Mojokerto</span>
                        </div>
                    </div>

                </div>

                <div class="text-center">
                    <a href="#"
                        class="inline-flex items-center justify-center px-6 py-3 rounded-xl border border-[#2563EB] text-[#2563EB] font-medium text-sm hover:bg-[#2563EB] hover:text-white transition duration-200">
                        Lihat Seluruh Laporan Publik <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 7: KEUNGGULAN & JAMINAN            -->
        <!-- ========================================== -->
        <section class="py-20 bg-white border-t border-[#E2E8F0]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 gap-8">

                    <div class="flex gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-[#2563EB]/10 text-[#2563EB] flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-[#1E293B] mb-2">Jaminan Privasi & Kerahasiaan</h3>
                            <p class="text-sm text-[#1E293B]/70 leading-relaxed">Opsi anonim menjamin identitas pelapor
                                tidak dipublikasikan ke umum demi keamanan Anda.</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-[#F59E0B]/10 text-[#F59E0B] flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-bell"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-[#1E293B] mb-2">Notifikasi Real-time</h3>
                            <p class="text-sm text-[#1E293B]/70 leading-relaxed">Dapatkan pembaruan status laporan
                                secara langsung via Email setiap kali status diperbarui.</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-[#10B981]/10 text-[#10B981] flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-square-check"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-[#1E293B] mb-2">Akuntabilitas & Keterbukaan</h3>
                            <p class="text-sm text-[#1E293B]/70 leading-relaxed">Setiap riwayat tindak lanjut disertai
                                bukti foto pengerjaan transparan langsung dari tim lapangan.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 8: FAQ (ACCORDION)                 -->
        <!-- ========================================== -->
        <section id="faq" class="py-20 bg-[#F8FAFC]">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-16 space-y-3">
                    <h2 class="text-2xl sm:text-3xl font-bold text-[#1E293B]">Pertanyaan Sering Diajukan (FAQ)</h2>
                    <p class="text-sm sm:text-base text-[#1E293B]/70">Jawaban cepat untuk hal-hal yang sering
                        ditanyakan warga.</p>
                </div>

                <div class="space-y-4" x-data="{ active: null }">

                    <!-- FAQ Item 1 -->
                    <div class="bg-white border border-[#E2E8F0] rounded-xl overflow-hidden shadow-sm">
                        <button @click="active = (active === 1 ? null : 1)"
                            class="w-full p-5 text-left font-semibold text-[#1E293B] flex justify-between items-center hover:bg-[#F8FAFC] transition duration-200">
                            <span>Apakah laporan saya dipungut biaya?</span>
                            <i class="fa-solid fa-chevron-down text-xs transition duration-200"
                                :class="active === 1 ? 'rotate-180 text-[#2563EB]' : 'text-[#1E293B]/40'"></i>
                        </button>
                        <div x-show="active === 1" x-collapse
                            class="px-5 pb-5 text-sm text-[#1E293B]/70 leading-relaxed border-t border-[#E2E8F0]/60 pt-3">
                            Sama sekali tidak. Seluruh layanan pengaduan dan aspirasi masyarakat di platform E-Lapor
                            100% gratis.
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="bg-white border border-[#E2E8F0] rounded-xl overflow-hidden shadow-sm">
                        <button @click="active = (active === 2 ? null : 2)"
                            class="w-full p-5 text-left font-semibold text-[#1E293B] flex justify-between items-center hover:bg-[#F8FAFC] transition duration-200">
                            <span>Bagaimana jika saya takut identitas saya tersebar?</span>
                            <i class="fa-solid fa-chevron-down text-xs transition duration-200"
                                :class="active === 2 ? 'rotate-180 text-[#2563EB]' : 'text-[#1E293B]/40'"></i>
                        </button>
                        <div x-show="active === 2" x-collapse
                            class="px-5 pb-5 text-sm text-[#1E293B]/70 leading-relaxed border-t border-[#E2E8F0]/60 pt-3">
                            Tersedia fitur Centang Anonim saat membuat laporan. Nama dan data pribadi Anda akan
                            disembunyikan sepenuhnya dari publik.
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="bg-white border border-[#E2E8F0] rounded-xl overflow-hidden shadow-sm">
                        <button @click="active = (active === 3 ? null : 3)"
                            class="w-full p-5 text-left font-semibold text-[#1E293B] flex justify-between items-center hover:bg-[#F8FAFC] transition duration-200">
                            <span>Berapa lama laporan saya akan diproses?</span>
                            <i class="fa-solid fa-chevron-down text-xs transition duration-200"
                                :class="active === 3 ? 'rotate-180 text-[#2563EB]' : 'text-[#1E293B]/40'"></i>
                        </button>
                        <div x-show="active === 3" x-collapse
                            class="px-5 pb-5 text-sm text-[#1E293B]/70 leading-relaxed border-t border-[#E2E8F0]/60 pt-3">
                            Proses verifikasi laporan dilakukan maksimal 24 jam. Sedangkan estimasi penyelesaian masalah
                            berkisar antara 1 hingga 7 hari kerja tergantung tingkat kerumitan di lapangan.
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="bg-white border border-[#E2E8F0] rounded-xl overflow-hidden shadow-sm">
                        <button @click="active = (active === 4 ? null : 4)"
                            class="w-full p-5 text-left font-semibold text-[#1E293B] flex justify-between items-center hover:bg-[#F8FAFC] transition duration-200">
                            <span>Format dan ukuran foto apa saja yang didukung?</span>
                            <i class="fa-solid fa-chevron-down text-xs transition duration-200"
                                :class="active === 4 ? 'rotate-180 text-[#2563EB]' : 'text-[#1E293B]/40'"></i>
                        </button>
                        <div x-show="active === 4" x-collapse
                            class="px-5 pb-5 text-sm text-[#1E293B]/70 leading-relaxed border-t border-[#E2E8F0]/60 pt-3">
                            Sistem menerima berkas lampiran berformat JPEG, PNG, dan WebP dengan batas ukuran maksimum
                            5MB per berkas foto.
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION 9: CALL TO ACTION BANNER           -->
        <!-- ========================================== -->
        <section class="py-12 bg-[#F8FAFC]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-[#2563EB] rounded-2xl p-8 sm:p-12 text-center text-white shadow-lg space-y-6">
                    <h2 class="text-2xl sm:text-4xl font-bold leading-tight">Menemukan Masalah di Lingkungan Anda?</h2>
                    <p class="text-base sm:text-lg text-white/80 max-w-2xl mx-auto">Jangan ragu untuk melapor. Satu
                        laporan Anda sangat berarti untuk perubahan yang lebih baik.</p>
                    <div class="pt-2">
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center justify-center px-8 py-4 rounded-xl bg-white text-[#2563EB] font-bold text-base hover:bg-slate-100 shadow transition duration-200">
                            Laporkan Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ========================================== -->
    <!-- SECTION 10: FOOTER SECTION                 -->
    <!-- ========================================== -->
    <footer class="bg-white border-t border-[#E2E8F0] pt-16 pb-8 text-sm text-[#1E293B]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

                <!-- Column 1: Info Instansi -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 bg-[#2563EB] rounded-lg flex items-center justify-center text-white text-base">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>
                        <span class="text-lg font-bold text-[#2563EB]">E-Lapor</span>
                    </div>
                    <p class="text-xs text-[#1E293B]/70 leading-relaxed">
                        Sistem layanan pengaduan dan aspirasi publik digital berbasis web terintegrasi demi mewujudkan
                        transparansi pelayanan publik.
                    </p>
                    <div class="text-xs text-[#1E293B]/60 space-y-1">
                        <p><i class="fa-solid fa-location-dot mr-1 text-[#2563EB]"></i> Jl. Pemuda No. 1, Mojokerto,
                            Jawa Timur</p>
                    </div>
                </div>

                <!-- Column 2: Navigasi Cepat -->
                <div>
                    <h4 class="text-sm font-semibold text-[#1E293B] mb-4">Navigasi Cepat</h4>
                    <ul class="space-y-2.5 text-xs text-[#1E293B]/70">
                        <li><a href="#beranda" class="hover:text-[#2563EB] transition duration-200">Beranda</a></li>
                        <li><a href="#cara-kerja" class="hover:text-[#2563EB] transition duration-200">Cara Kerja</a>
                        </li>
                        <li><a href="#aduan-publik" class="hover:text-[#2563EB] transition duration-200">Aduan
                                Publik</a></li>
                        <li><a href="#" class="hover:text-[#2563EB] transition duration-200">Kebijakan
                                Privasi</a></li>
                        <li><a href="#" class="hover:text-[#2563EB] transition duration-200">Syarat &amp;
                                Ketentuan</a></li>
                    </ul>
                </div>

                <!-- Column 3: Kontak Layanan -->
                <div>
                    <h4 class="text-sm font-semibold text-[#1E293B] mb-4">Kontak Layanan</h4>
                    <ul class="space-y-2.5 text-xs text-[#1E293B]/70">
                        <li><i class="fa-solid fa-envelope mr-1 text-[#2563EB]"></i> support@elapor.go.id</li>
                        <li><i class="fa-solid fa-phone mr-1 text-[#2563EB]"></i> (0321) 123-4567 / WhatsApp</li>
                        <li><i class="fa-solid fa-clock mr-1 text-[#2563EB]"></i> Senin - Jumat (08.00 - 16.00 WIB)
                        </li>
                    </ul>
                </div>

                <!-- Column 4: Sosial Media -->
                <div>
                    <h4 class="text-sm font-semibold text-[#1E293B] mb-4">Sosial Media</h4>
                    <div class="flex gap-3">
                        <a href="#"
                            class="w-9 h-9 rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] flex items-center justify-center text-[#1E293B] hover:bg-[#2563EB] hover:text-white transition duration-200">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#"
                            class="w-9 h-9 rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] flex items-center justify-center text-[#1E293B] hover:bg-[#2563EB] hover:text-white transition duration-200">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                        <a href="#"
                            class="w-9 h-9 rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] flex items-center justify-center text-[#1E293B] hover:bg-[#2563EB] hover:text-white transition duration-200">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                        <a href="#"
                            class="w-9 h-9 rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] flex items-center justify-center text-[#1E293B] hover:bg-[#2563EB] hover:text-white transition duration-200">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </div>
                </div>

            </div>

            <div class="pt-8 border-t border-[#E2E8F0] text-center text-xs text-[#1E293B]/50">
                &copy; 2026 E-Lapor. Hak Cipta Dilindungi Undang-Undang.
            </div>
        </div>
    </footer>

</body>

</html>
