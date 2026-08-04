<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Eighty Coffee Studio</title>

    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        /* Custom Illustrative Glass & Glow Utilities */
        .bg-gradient-light-blue {
            background: linear-gradient(135deg, #E0F2FE 0%, #EFF6FF 50%, #DBEAFE 100%);
        }

        .bg-gradient-hero {
            background: linear-gradient(135deg, #2563EB 0%, #3B82F6 45%, #60A5FA 100%);
        }

        .bg-gradient-card-blue {
            background: linear-gradient(180deg, #FFFFFF 0%, #F0F7FF 100%);
        }

        .shadow-soft-blue {
            box-shadow: 0 10px 30px -5px rgba(59, 130, 246, 0.15), 0 4px 12px -2px rgba(59, 130, 246, 0.08);
        }

        .shadow-glow-blue {
            box-shadow: 0 0 25px rgba(59, 130, 246, 0.35);
        }

        .border-blue-soft {
            border-color: #BFDBFE;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #F1F5F9;
            border-radius: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #93C5FD;
            border-radius: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #3B82F6;
        }
    </style>
</head>

<body class="h-full text-slate-800 bg-[#F4F8FF] antialiased selection:bg-blue-500 selection:text-white"
    x-data="{
        activeTab: 'overview',
        searchQuery: '',
        isModalOpen: false,
        storeOnline: true,
        selectedCategory: 'all',
        quickOrder: {
            customer: '',
            item: 'Eighty Signature Latte',
            sugar: 'Normal (100%)',
            ice: 'Normal Ice',
            qty: 1,
            price: 28000
        },
        orders: [
            { id: '#80-1042', customer: 'Budi Santoso', type: 'Dine-In', table: 'T-04', items: '2x Signature Latte, 1x Croissant', total: 'Rp 81.000', status: 'Brewing', time: '2 mins ago', badgeBg: 'bg-amber-100 text-amber-700 border-amber-300' },
            { id: '#80-1041', customer: 'Siti Rahma', type: 'Takeaway', table: '-', items: '1x Iced Americano Oat Milk', total: 'Rp 32.000', status: 'Ready', time: '6 mins ago', badgeBg: 'bg-emerald-100 text-emerald-700 border-emerald-300' },
            { id: '#80-1040', customer: 'Dimas Anggara', type: 'Gojek POS', table: 'G-12', items: '3x Caramel Macchiato, 2x Donut', total: 'Rp 145.000', status: 'Delivered', time: '14 mins ago', badgeBg: 'bg-blue-100 text-blue-700 border-blue-300' },
            { id: '#80-1039', customer: 'Jessica Tan', type: 'Dine-In', table: 'T-02', items: '1x Matcha Cold Foam, 1x Waffle', total: 'Rp 64.000', status: 'Brewing', time: '18 mins ago', badgeBg: 'bg-amber-100 text-amber-700 border-amber-300' }
        ],
        cart: [
            { name: 'Eighty Signature Latte', price: 28000, qty: 2, icon: '☕' },
            { name: 'Butter Croissant', price: 25000, qty: 1, icon: '🥐' }
        ],
        get cartTotal() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        },
        addToCart(name, price, icon) {
            let existing = this.cart.find(i => i.name === name);
            if (existing) {
                existing.qty++;
            } else {
                this.cart.push({ name, price, qty: 1, icon });
            }
        },
        removeCartItem(index) {
            this.cart.splice(index, 1);
        }
    }">

    <div class="flex h-screen overflow-hidden">

        <!-- ==================== SIDEBAR ==================== -->
        <aside class="w-64 bg-white border-r border-blue-100 flex flex-col justify-between z-20 shrink-0 shadow-sm">
            <div>
                <!-- Brand Header -->
                <div class="p-6 flex items-center gap-3 border-b border-slate-100">
                    <div
                        class="w-11 h-11 rounded-2xl bg-blue-600 flex items-center justify-center text-white shadow-soft-blue ring-4 ring-blue-50">
                        <!-- Custom Illustrative Coffee Cup SVG -->
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 8h1a4 4 0 1 1 0 8h-1"></path>
                            <path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"></path>
                            <line x1="6" y1="2" x2="6" y2="4"></line>
                            <line x1="10" y1="2" x2="10" y2="4"></line>
                            <line x1="14" y1="2" x2="14" y2="4"></line>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <h1 class="font-heading font-extrabold text-xl text-slate-900 tracking-tight">eighty<span
                                    class="text-blue-600">coffe</span></h1>
                        </div>
                        <p class="text-xs text-blue-600 font-medium">Coffee & Operations</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="p-4 space-y-1.5">
                    <div class="px-3 py-2 text-[11px] font-bold tracking-wider text-slate-400 uppercase">Main Menu</div>

                    <button @click="activeTab = 'overview'"
                        :class="activeTab === 'overview' ? 'bg-blue-50 text-blue-600 font-semibold shadow-sm' :
                            'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all duration-200 text-sm group">
                        <div class="flex items-center gap-3">
                            <div :class="activeTab === 'overview' ? 'bg-blue-600 text-white' :
                                'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600'"
                                class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <rect x="3" y="3" width="7" height="7" rx="2"></rect>
                                    <rect x="14" y="3" width="7" height="7" rx="2"></rect>
                                    <rect x="14" y="14" width="7" height="7" rx="2"></rect>
                                    <rect x="3" y="14" width="7" height="7" rx="2"></rect>
                                </svg>
                            </div>
                            <span>Dashboard</span>
                        </div>
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600" x-show="activeTab === 'overview'"></span>
                    </button>

                    <button @click="activeTab = 'orders'"
                        :class="activeTab === 'orders' ? 'bg-blue-50 text-blue-600 font-semibold shadow-sm' :
                            'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all duration-200 text-sm group">
                        <div class="flex items-center gap-3">
                            <div :class="activeTab === 'orders' ? 'bg-blue-600 text-white' :
                                'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600'"
                                class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <span>Pesanan Live</span>
                        </div>
                        <span class="px-2 py-0.5 text-xs font-bold bg-blue-100 text-blue-700 rounded-full">4
                            Active</span>
                    </button>

                    <button @click="activeTab = 'menu'"
                        :class="activeTab === 'menu' ? 'bg-blue-50 text-blue-600 font-semibold shadow-sm' :
                            'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all duration-200 text-sm group">
                        <div class="flex items-center gap-3">
                            <div :class="activeTab === 'menu' ? 'bg-blue-600 text-white' :
                                'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600'"
                                class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <span>Menu & Stok</span>
                        </div>
                    </button>

                    <button @click="activeTab = 'analytics'"
                        :class="activeTab === 'analytics' ? 'bg-blue-50 text-blue-600 font-semibold shadow-sm' :
                            'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all duration-200 text-sm group">
                        <div class="flex items-center gap-3">
                            <div :class="activeTab === 'analytics' ? 'bg-blue-600 text-white' :
                                'bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600'"
                                class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path d="M9 19v-6a2 2 0 012-2h2a2 2 0 012 2v6a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    <path d="M3 19v-10a2 2 0 012-2h2a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z">
                                    </path>
                                    <path d="M15 19v-14a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            </div>
                            <span>Laporan Penjualan</span>
                        </div>
                    </button>

                    <div class="pt-4 px-3 py-2 text-[11px] font-bold tracking-wider text-slate-400 uppercase">Manajemen
                        Outlet</div>

                    <a href="#customers"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all text-sm group">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600 flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <span>Pelanggan Loyalty</span>
                        </div>
                    </a>

                    <a href="#settings"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all text-sm group">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 group-hover:bg-blue-100 group-hover:text-blue-600 flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <span>Pengaturan Kafe</span>
                        </div>
                    </a>
                </nav>
            </div>

            <!-- Sidebar Footer / Illustrative Daily Goal Widget -->
            <div class="p-4 border-t border-slate-100">
                <div
                    class="bg-linear-to-br from-blue-50 to-indigo-50/80 p-4 rounded-2xl border border-blue-100 shadow-sm relative overflow-hidden">
                    <div class="absolute -right-3 -bottom-3 text-blue-200 opacity-40">
                        <!-- Decorative SVG background element -->
                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M2 21h18v-2H2v2M20 8h-2V5c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-3h2c1.1 0 2-.9 2-2v-2c0-1.1-.9-2-2-2m-2 4v-2h2v2h-2z" />
                        </svg>
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-blue-900 uppercase tracking-wide">Target Cangkir</span>
                            <span
                                class="px-2 py-0.5 bg-blue-600 text-white rounded-full text-[10px] font-bold">73%</span>
                        </div>
                        <p class="text-lg font-heading font-extrabold text-slate-900 mb-1">184 <span
                                class="text-xs font-normal text-slate-500">/ 250 Cups</span></p>

                        <!-- Progress Bar -->
                        <div class="w-full h-2.5 bg-blue-100 rounded-full overflow-hidden p-0.5">
                            <div class="bg-linear-to-r from-blue-500 to-indigo-600 h-full rounded-full transition-all duration-500 shadow-glow-blue"
                                style="width: 73%"></div>
                        </div>

                        <p class="text-[11px] text-slate-500 mt-2 font-medium">Semangat! Sisa 66 cangkir lagi untuk
                            capai bonus harimu 🚀</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ==================== MAIN CONTENT AREA ==================== -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <!-- Top Header Navbar -->
            <header
                class="h-20 bg-white border-b border-blue-100 px-8 flex items-center justify-between shrink-0 z-10">
                <!-- Search & Quick Info -->
                <div class="flex items-center gap-4 flex-1 max-w-lg">
                    <div class="relative w-full">
                        <div
                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" x-model="searchQuery"
                            placeholder="Cari pesanan, pelanggan, atau menu espresso..."
                            class="w-full pl-10 pr-12 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <kbd
                                class="px-2 py-0.5 text-[10px] font-semibold text-slate-400 bg-slate-200 rounded-md border border-slate-300">Ctrl
                                K</kbd>
                        </div>
                    </div>
                </div>

                <!-- Right Header Actions -->
                <div class="flex items-center gap-4">
                    <!-- Outlet Switcher & Status -->
                    <button @click="storeOnline = !storeOnline"
                        :class="storeOnline ? 'bg-emerald-50 text-emerald-700 border-emerald-200' :
                            'bg-rose-50 text-rose-700 border-rose-200'"
                        class="flex items-center gap-2 px-3 py-1.5 rounded-full border text-xs font-semibold transition-all">
                        <span class="w-2.5 h-2.5 rounded-full animate-pulse"
                            :class="storeOnline ? 'bg-emerald-500' : 'bg-rose-500'"></span>
                        <span x-text="storeOnline ? 'Outlet Open' : 'Outlet Closed'"></span>
                    </button>

                    <!-- Add Quick Order Button -->
                    <button @click="isModalOpen = true"
                        class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-semibold rounded-xl shadow-soft-blue transition-all text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2.5">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        <span>Buat Pesanan Baru</span>
                    </button>

                    <!-- Notification Bell -->
                    <button
                        class="relative w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-blue-600 rounded-full ring-2 ring-white"></span>
                    </button>

                    <!-- User Profile Avatar -->
                    <div class="flex items-center gap-3 pl-2 border-l border-slate-200">
                        <div
                            class="w-10 h-10 rounded-xl bg-blue-100 border-2 border-blue-400 p-0.5 overflow-hidden shadow-sm">
                            <!-- Mascot Avatar illustration -->
                            <svg class="w-full h-full text-blue-600" viewBox="0 0 36 36" fill="currentColor">
                                <circle cx="18" cy="12" r="7" fill="#3B82F6" />
                                <path d="M6 32c0-6.6 5.4-12 12-12s12 5.4 12 12H6z" fill="#2563EB" />
                            </svg>
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-bold text-slate-900 leading-tight">Alex Rivera</p>
                            <p class="text-xs text-blue-600 font-medium">Head Barista</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content Dashboard View -->
            <div class="flex-1 overflow-y-auto custom-scrollbar p-8 space-y-8">

                <!-- ==================== HERO ILLUSTRATIVE BANNER ==================== -->
                <div class="relative bg-gradient-hero rounded-3xl p-8 text-white shadow-soft-blue overflow-hidden">
                    <!-- Background Decorative Circles & Waves -->
                    <div
                        class="absolute -top-12 -right-12 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none">
                    </div>
                    <div
                        class="absolute -bottom-16 right-32 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl pointer-events-none">
                    </div>

                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="max-w-xl space-y-3">
                            <div
                                class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold tracking-wide text-blue-100 border border-white/20">
                                <span>☕ Outlet Ninety-Eight Surabaya</span>
                                <span>•</span>
                                <span>28 Juli 2026</span>
                            </div>
                            <h2 class="text-3xl sm:text-4xl font-heading font-extrabold tracking-tight leading-tight">
                                Selamat Pagi, Barista Team! ☕✨
                            </h2>
                            <p class="text-blue-100 text-sm leading-relaxed">
                                Pesanan pagi ini terpantau stabil. Resep favorit hari ini adalah <strong
                                    class="text-white underline decoration-blue-300">Sea Salt Caramel Cold
                                    Brew</strong>. Tetap sajikan senyuman hangat untuk setiap cangkir Eighty Coffee!
                            </p>
                            <div class="pt-2 flex flex-wrap items-center gap-3">
                                <span
                                    class="px-3 py-1.5 bg-white/15 backdrop-blur-sm rounded-xl text-xs font-medium text-white border border-white/10">
                                    ⚡ Shift Pagi (07.00 - 15.00)
                                </span>
                                <span
                                    class="px-3 py-1.5 bg-white/15 backdrop-blur-sm rounded-xl text-xs font-medium text-white border border-white/10">
                                    🔥 Waktu Puncak: 08:30 WIB
                                </span>
                            </div>
                        </div>

                        <!-- Hero Custom Coffee Illustration SVG -->
                        <div class="relative shrink-0 flex justify-center">
                            <div
                                class="w-44 h-44 bg-white/10 backdrop-blur-md rounded-3xl p-4 border border-white/20 flex flex-col items-center justify-center relative shadow-lg group hover:rotate-2 transition-transform duration-300">
                                <svg class="w-24 h-24 text-amber-300 filter drop-shadow-md" viewBox="0 0 64 64"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Cup Body -->
                                    <path d="M12 24C12 24 14 52 32 52C50 52 52 24 52 24H12Z" fill="#FFFFFF"
                                        stroke="#3B82F6" stroke-width="2" />
                                    <!-- Coffee Steam -->
                                    <path d="M22 14C22 14 24 10 22 8" stroke="#FDE047" stroke-width="3"
                                        stroke-linecap="round" />
                                    <path d="M32 16C32 16 34 10 32 6" stroke="#FDE047" stroke-width="3"
                                        stroke-linecap="round" />
                                    <path d="M42 14C42 14 44 10 42 8" stroke="#FDE047" stroke-width="3"
                                        stroke-linecap="round" />
                                    <!-- Coffee Foam Layer -->
                                    <ellipse cx="32" cy="24" rx="20" ry="4"
                                        fill="#F59E0B" />
                                    <!-- Handle -->
                                    <path d="M52 28C57 28 60 32 60 36C60 40 56 43 51 43" stroke="#FFFFFF"
                                        stroke-width="4" stroke-linecap="round" />
                                    <!-- Smile Face on Cup -->
                                    <circle cx="26" cy="34" r="2.5" fill="#1E3A8A" />
                                    <circle cx="38" cy="34" r="2.5" fill="#1E3A8A" />
                                    <path d="M29 40C30.5 42 33.5 42 35 40" stroke="#1E3A8A" stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>
                                <div class="mt-2 text-center">
                                    <span class="text-xs font-bold tracking-wider uppercase text-amber-200">Eighty
                                        Mascot</span>
                                    <p class="text-[11px] text-blue-100 font-medium">"Freshly Brewed Every Day"</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================== STATS METRICS GRID (4 CARDS) ==================== -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- Metric 1: Total Omset -->
                    <div
                        class="bg-white p-6 rounded-2xl border border-blue-100 shadow-soft-blue hover:-translate-y-1 transition-all duration-200 relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full transition-transform group-hover:scale-110">
                        </div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        stroke-width="2">
                                        <path
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 12v-2m0 0c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                                <span
                                    class="px-2.5 py-1 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-full text-xs font-bold flex items-center gap-1">
                                    <span>↑ 14.5%</span>
                                </span>
                            </div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pendapatan Hari
                                Ini</p>
                            <h3 class="text-2xl font-heading font-extrabold text-slate-900 mt-1">Rp 4.850.000</h3>
                            <p class="text-xs text-slate-400 mt-2 font-medium">vs Kemarin: <span
                                    class="text-slate-600 font-semibold">Rp 4.230.000</span></p>
                        </div>
                    </div>

                    <!-- Metric 2: Total Cups -->
                    <div
                        class="bg-white p-6 rounded-2xl border border-blue-100 shadow-soft-blue hover:-translate-y-1 transition-all duration-200 relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-24 h-24 bg-sky-50 rounded-bl-full transition-transform group-hover:scale-110">
                        </div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center font-bold">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        stroke-width="2">
                                        <path d="M17 8h1a4 4 0 1 1 0 8h-1M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z">
                                        </path>
                                    </svg>
                                </div>
                                <span
                                    class="px-2.5 py-1 bg-blue-50 text-blue-600 border border-blue-200 rounded-full text-xs font-bold">
                                    <span>+22 Cups</span>
                                </span>
                            </div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Cangkir
                                Terjual</p>
                            <h3 class="text-2xl font-heading font-extrabold text-slate-900 mt-1">184 Cups</h3>
                            <p class="text-xs text-slate-400 mt-2 font-medium">Rata-rata: <span
                                    class="text-slate-600 font-semibold">24 cups / jam</span></p>
                        </div>
                    </div>

                    <!-- Metric 3: Active Orders Queue -->
                    <div
                        class="bg-white p-6 rounded-2xl border border-blue-100 shadow-soft-blue hover:-translate-y-1 transition-all duration-200 relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-24 h-24 bg-amber-50 rounded-bl-full transition-transform group-hover:scale-110">
                        </div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center font-bold">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        stroke-width="2">
                                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span
                                    class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-xs font-bold">
                                    <span>Sedang Diseduh</span>
                                </span>
                            </div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Antrean Pesanan
                            </p>
                            <h3 class="text-2xl font-heading font-extrabold text-slate-900 mt-1">4 Pesanan</h3>
                            <p class="text-xs text-slate-400 mt-2 font-medium">Waktu tunggu: <span
                                    class="text-amber-600 font-semibold">~4.5 Menit</span></p>
                        </div>
                    </div>

                    <!-- Metric 4: Customer Satisfaction -->
                    <div
                        class="bg-white p-6 rounded-2xl border border-blue-100 shadow-soft-blue hover:-translate-y-1 transition-all duration-200 relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-24 h-24 bg-indigo-50 rounded-bl-full transition-transform group-hover:scale-110">
                        </div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        stroke-width="2">
                                        <path
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                        </path>
                                    </svg>
                                </div>
                                <span
                                    class="px-2.5 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full text-xs font-bold">
                                    <span>★ 4.9 / 5.0</span>
                                </span>
                            </div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Rating Kepuasan
                            </p>
                            <h3 class="text-2xl font-heading font-extrabold text-slate-900 mt-1">98.4%</h3>
                            <p class="text-xs text-slate-400 mt-2 font-medium">Berdasarkan <span
                                    class="text-slate-600 font-semibold">142 Ulasan Hari Ini</span></p>
                        </div>
                    </div>

                </div>

                <!-- ==================== MAIN CONTENT GRID (2 COLUMNS) ==================== -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    <!-- LEFT COLUMN (8 COLS): Sales Chart, Live Orders & Menu Grid -->
                    <div class="lg:col-span-8 space-y-8">

                        <!-- Weekly Sales Illustrative Chart Container -->
                        <div class="bg-white p-6 rounded-3xl border border-blue-100 shadow-soft-blue">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                                <div>
                                    <h3 class="text-lg font-heading font-bold text-slate-900 flex items-center gap-2">
                                        <span>📊 Grafik Penjualan Mingguan</span>
                                        <span
                                            class="px-2.5 py-0.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">Eighty
                                            Analytics</span>
                                    </h3>
                                    <p class="text-xs text-slate-500 mt-0.5">Perbandingan performa penjualan 7 hari
                                        terakhir</p>
                                </div>
                                <div class="flex items-center gap-2 bg-slate-100 p-1 rounded-xl">
                                    <button
                                        class="px-3 py-1.5 bg-white text-blue-600 font-bold rounded-lg shadow-sm text-xs">Minggu
                                        Ini</button>
                                    <button
                                        class="px-3 py-1.5 text-slate-500 font-medium rounded-lg hover:text-slate-900 text-xs">Bulan
                                        Ini</button>
                                </div>
                            </div>

                            <!-- Custom SVG / HTML Illustrative Bar Graph -->
                            <div class="space-y-4">
                                <div
                                    class="h-56 flex items-end justify-between gap-3 pt-6 px-2 border-b border-slate-100">

                                    <!-- Mon -->
                                    <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                                        <div
                                            class="text-[11px] font-bold text-slate-400 group-hover:text-blue-600 transition-colors opacity-0 group-hover:opacity-100">
                                            3.2M</div>
                                        <div class="w-full bg-blue-100 rounded-t-xl group-hover:bg-blue-500 transition-all duration-300 relative"
                                            style="height: 55%">
                                            <div
                                                class="absolute -top-2 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-blue-400 group-hover:scale-125 transition-transform">
                                            </div>
                                        </div>
                                        <span class="text-xs font-semibold text-slate-500">Sen</span>
                                    </div>

                                    <!-- Tue -->
                                    <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                                        <div
                                            class="text-[11px] font-bold text-slate-400 group-hover:text-blue-600 transition-colors opacity-0 group-hover:opacity-100">
                                            3.8M</div>
                                        <div class="w-full bg-blue-100 rounded-t-xl group-hover:bg-blue-500 transition-all duration-300 relative"
                                            style="height: 65%">
                                            <div
                                                class="absolute -top-2 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-blue-400 group-hover:scale-125 transition-transform">
                                            </div>
                                        </div>
                                        <span class="text-xs font-semibold text-slate-500">Sel</span>
                                    </div>

                                    <!-- Wed -->
                                    <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                                        <div
                                            class="text-[11px] font-bold text-slate-400 group-hover:text-blue-600 transition-colors opacity-0 group-hover:opacity-100">
                                            4.1M</div>
                                        <div class="w-full bg-blue-100 rounded-t-xl group-hover:bg-blue-500 transition-all duration-300 relative"
                                            style="height: 72%">
                                            <div
                                                class="absolute -top-2 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-blue-400 group-hover:scale-125 transition-transform">
                                            </div>
                                        </div>
                                        <span class="text-xs font-semibold text-slate-500">Rab</span>
                                    </div>

                                    <!-- Thu -->
                                    <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                                        <div
                                            class="text-[11px] font-bold text-slate-400 group-hover:text-blue-600 transition-colors opacity-0 group-hover:opacity-100">
                                            3.9M</div>
                                        <div class="w-full bg-blue-100 rounded-t-xl group-hover:bg-blue-500 transition-all duration-300 relative"
                                            style="height: 68%">
                                            <div
                                                class="absolute -top-2 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-blue-400 group-hover:scale-125 transition-transform">
                                            </div>
                                        </div>
                                        <span class="text-xs font-semibold text-slate-500">Kam</span>
                                    </div>

                                    <!-- Fri -->
                                    <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                                        <div
                                            class="text-[11px] font-bold text-slate-400 group-hover:text-blue-600 transition-colors opacity-0 group-hover:opacity-100">
                                            4.5M</div>
                                        <div class="w-full bg-blue-200 rounded-t-xl group-hover:bg-blue-500 transition-all duration-300 relative"
                                            style="height: 80%">
                                            <div
                                                class="absolute -top-2 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-blue-400 group-hover:scale-125 transition-transform">
                                            </div>
                                        </div>
                                        <span class="text-xs font-semibold text-slate-500">Jum</span>
                                    </div>

                                    <!-- Sat -->
                                    <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                                        <div
                                            class="text-[11px] font-bold text-slate-400 group-hover:text-blue-600 transition-colors opacity-0 group-hover:opacity-100">
                                            5.8M</div>
                                        <div class="w-full bg-blue-400 rounded-t-xl group-hover:bg-blue-600 transition-all duration-300 relative"
                                            style="height: 95%">
                                            <div
                                                class="absolute -top-2 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-blue-600 group-hover:scale-125 transition-transform">
                                            </div>
                                        </div>
                                        <span class="text-xs font-semibold text-blue-600">Sab</span>
                                    </div>

                                    <!-- Sun (Today) -->
                                    <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                                        <div class="text-[11px] font-bold text-blue-600">4.8M</div>
                                        <div class="w-full bg-linear-to-t from-blue-600 to-indigo-500 rounded-t-xl transition-all duration-300 relative shadow-glow-blue"
                                            style="height: 85%">
                                            <div
                                                class="absolute -top-3 left-1/2 -translate-x-1/2 px-1.5 py-0.5 bg-blue-600 text-white rounded text-[9px] font-extrabold shadow">
                                                TODAY</div>
                                        </div>
                                        <span class="text-xs font-bold text-blue-600">Min</span>
                                    </div>

                                </div>

                                <div class="flex items-center justify-between text-xs text-slate-500 pt-2 font-medium">
                                    <div class="flex items-center gap-4">
                                        <span class="flex items-center gap-1.5">
                                            <span class="w-3 h-3 rounded-full bg-blue-600"></span>
                                            Penjualan Kopi
                                        </span>
                                        <span class="flex items-center gap-1.5">
                                            <span class="w-3 h-3 rounded-full bg-blue-200"></span>
                                            Pastry & Non-Coffee
                                        </span>
                                    </div>
                                    <p>Peak Time: <strong class="text-slate-800">14:00 - 17:00 WIB</strong></p>
                                </div>
                            </div>
                        </div>

                        <!-- Live Order Queue Table / List -->
                        <div class="bg-white p-6 rounded-3xl border border-blue-100 shadow-soft-blue space-y-4">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                <div>
                                    <h3 class="text-lg font-heading font-bold text-slate-900 flex items-center gap-2">
                                        <span>☕ Daftar Pesanan Aktif</span>
                                        <span
                                            class="px-2 py-0.5 bg-amber-100 text-amber-800 rounded-full text-xs font-bold">4
                                            Pesanan Masuk</span>
                                    </h3>
                                    <p class="text-xs text-slate-500">Monitor & perbarui status seduhan barista secara
                                        real-time</p>
                                </div>
                                <button class="text-xs font-semibold text-blue-600 hover:text-blue-700 underline">Lihat
                                    Semua History →</button>
                            </div>

                            <!-- Table -->
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr
                                            class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                            <th class="py-3 px-3">No. Order</th>
                                            <th class="py-3 px-3">Pelanggan</th>
                                            <th class="py-3 px-3">Item Pesanan</th>
                                            <th class="py-3 px-3">Total</th>
                                            <th class="py-3 px-3">Status Seduh</th>
                                            <th class="py-3 px-3 text-right">Aksi Barista</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-sm">
                                        <template x-for="(order, index) in orders" :key="order.id">
                                            <tr class="hover:bg-blue-50/50 transition-colors">
                                                <td class="py-3.5 px-3 font-bold text-slate-900" x-text="order.id">
                                                </td>
                                                <td class="py-3.5 px-3">
                                                    <div class="font-semibold text-slate-800" x-text="order.customer">
                                                    </div>
                                                    <div class="text-xs text-slate-400"
                                                        x-text="order.type + ' • ' + order.table"></div>
                                                </td>
                                                <td class="py-3.5 px-3 font-medium text-slate-700 max-w-xs truncate"
                                                    x-text="order.items"></td>
                                                <td class="py-3.5 px-3 font-bold text-blue-600" x-text="order.total">
                                                </td>
                                                <td class="py-3.5 px-3">
                                                    <span :class="order.badgeBg"
                                                        class="px-2.5 py-1 rounded-full text-xs font-bold border inline-flex items-center gap-1">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                        <span x-text="order.status"></span>
                                                    </span>
                                                </td>
                                                <td class="py-3.5 px-3 text-right">
                                                    <button x-show="order.status === 'Brewing'"
                                                        @click="order.status = 'Ready'; order.badgeBg = 'bg-emerald-100 text-emerald-700 border-emerald-300'"
                                                        class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-all shadow-sm">
                                                        ✓ Tandai Ready
                                                    </button>
                                                    <button x-show="order.status === 'Ready'"
                                                        @click="order.status = 'Delivered'; order.badgeBg = 'bg-blue-100 text-blue-700 border-blue-300'"
                                                        class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition-all shadow-sm">
                                                        Take Away / Selesai
                                                    </button>
                                                    <span x-show="order.status === 'Delivered'"
                                                        class="text-xs font-medium text-slate-400 italic">Selesai</span>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Top Menu Best Sellers Illustrative Cards Grid -->
                        <div class="bg-white p-6 rounded-3xl border border-blue-100 shadow-soft-blue space-y-4">
                            <div
                                class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-4">
                                <div>
                                    <h3 class="text-lg font-heading font-bold text-slate-900">✨ Menu Terfavorit Eighty
                                        Coffee</h3>
                                    <p class="text-xs text-slate-500">Klik item untuk langsung tambahkan ke kasir cepat
                                    </p>
                                </div>

                                <!-- Category Filter Pills -->
                                <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-xl">
                                    <button @click="selectedCategory = 'all'"
                                        :class="selectedCategory === 'all' ?
                                            'bg-white text-blue-600 font-bold shadow-sm' : 'text-slate-500 font-medium'"
                                        class="px-3 py-1 rounded-lg text-xs transition-all">Semua</button>
                                    <button @click="selectedCategory = 'espresso'"
                                        :class="selectedCategory === 'espresso' ?
                                            'bg-white text-blue-600 font-bold shadow-sm' : 'text-slate-500 font-medium'"
                                        class="px-3 py-1 rounded-lg text-xs transition-all">Espresso</button>
                                    <button @click="selectedCategory = 'manual'"
                                        :class="selectedCategory === 'manual' ?
                                            'bg-white text-blue-600 font-bold shadow-sm' : 'text-slate-500 font-medium'"
                                        class="px-3 py-1 rounded-lg text-xs transition-all">Manual Brew</button>
                                    <button @click="selectedCategory = 'pastry'"
                                        :class="selectedCategory === 'pastry' ?
                                            'bg-white text-blue-600 font-bold shadow-sm' : 'text-slate-500 font-medium'"
                                        class="px-3 py-1 rounded-lg text-xs transition-all">Pastry</button>
                                </div>
                            </div>

                            <!-- Cards Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                                <!-- Menu Card 1 -->
                                <div
                                    class="bg-slate-50/70 p-4 rounded-2xl border border-blue-100 hover:border-blue-300 hover:bg-blue-50/30 transition-all duration-200 group flex flex-col justify-between">
                                    <div class="space-y-3">
                                        <div class="flex items-start justify-between">
                                            <div
                                                class="w-12 h-12 rounded-xl bg-linear-to-br from-amber-100 to-blue-100 flex items-center justify-center text-2xl shadow-sm group-hover:scale-110 transition-transform">
                                                ☕
                                            </div>
                                            <span
                                                class="px-2 py-0.5 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-full">Top
                                                #1 Best</span>
                                        </div>
                                        <div>
                                            <h4
                                                class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">
                                                Eighty Signature Latte</h4>
                                            <p class="text-xs text-slate-500 mt-0.5">House blend espresso, fresh milk,
                                                brown palm sugar</p>
                                        </div>
                                    </div>
                                    <div
                                        class="pt-4 flex items-center justify-between border-t border-slate-200/60 mt-3">
                                        <div>
                                            <span class="text-xs text-slate-400">Stok: 48 cups</span>
                                            <p class="text-sm font-extrabold text-blue-600">Rp 28.000</p>
                                        </div>
                                        <button @click="addToCart('Eighty Signature Latte', 28000, '☕')"
                                            class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold hover:bg-blue-700 active:scale-95 transition-all shadow-sm">
                                            +
                                        </button>
                                    </div>
                                </div>

                                <!-- Menu Card 2 -->
                                <div
                                    class="bg-slate-50/70 p-4 rounded-2xl border border-blue-100 hover:border-blue-300 hover:bg-blue-50/30 transition-all duration-200 group flex flex-col justify-between">
                                    <div class="space-y-3">
                                        <div class="flex items-start justify-between">
                                            <div
                                                class="w-12 h-12 rounded-xl bg-linear-to-br from-cyan-100 to-blue-100 flex items-center justify-center text-2xl shadow-sm group-hover:scale-110 transition-transform">
                                                🧊
                                            </div>
                                            <span
                                                class="px-2 py-0.5 bg-cyan-100 text-cyan-800 text-[10px] font-bold rounded-full">Refreshing</span>
                                        </div>
                                        <div>
                                            <h4
                                                class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">
                                                Sea Salt Caramel Cold Brew</h4>
                                            <p class="text-xs text-slate-500 mt-0.5">12hr steep cold brew with sea salt
                                                foam</p>
                                        </div>
                                    </div>
                                    <div
                                        class="pt-4 flex items-center justify-between border-t border-slate-200/60 mt-3">
                                        <div>
                                            <span class="text-xs text-slate-400">Stok: 22 cups</span>
                                            <p class="text-sm font-extrabold text-blue-600">Rp 34.000</p>
                                        </div>
                                        <button @click="addToCart('Sea Salt Caramel Cold Brew', 34000, '🧊')"
                                            class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold hover:bg-blue-700 active:scale-95 transition-all shadow-sm">
                                            +
                                        </button>
                                    </div>
                                </div>

                                <!-- Menu Card 3 -->
                                <div
                                    class="bg-slate-50/70 p-4 rounded-2xl border border-blue-100 hover:border-blue-300 hover:bg-blue-50/30 transition-all duration-200 group flex flex-col justify-between">
                                    <div class="space-y-3">
                                        <div class="flex items-start justify-between">
                                            <div
                                                class="w-12 h-12 rounded-xl bg-linear-to-br from-amber-100 to-amber-200 flex items-center justify-center text-2xl shadow-sm group-hover:scale-110 transition-transform">
                                                🥐
                                            </div>
                                            <span
                                                class="px-2 py-0.5 bg-amber-100 text-amber-800 text-[10px] font-bold rounded-full">Fresh
                                                Bakery</span>
                                        </div>
                                        <div>
                                            <h4
                                                class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">
                                                French Butter Croissant</h4>
                                            <p class="text-xs text-slate-500 mt-0.5">Flaky French butter croissant
                                                baked daily</p>
                                        </div>
                                    </div>
                                    <div
                                        class="pt-4 flex items-center justify-between border-t border-slate-200/60 mt-3">
                                        <div>
                                            <span class="text-xs text-slate-400">Stok: 14 pcs</span>
                                            <p class="text-sm font-extrabold text-blue-600">Rp 25.000</p>
                                        </div>
                                        <button @click="addToCart('Butter Croissant', 25000, '🥐')"
                                            class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold hover:bg-blue-700 active:scale-95 transition-all shadow-sm">
                                            +
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- RIGHT COLUMN (4 COLS): Quick POS / Cart Widget & Inventory Alert & Barista Notes -->
                    <div class="lg:col-span-4 space-y-8">

                        <!-- POS Kasir Cepat (Cart Widget) -->
                        <div
                            class="bg-white p-6 rounded-3xl border border-blue-100 shadow-soft-blue flex flex-col justify-between h-auto space-y-6">
                            <div>
                                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold">
                                            🛒</div>
                                        <div>
                                            <h3 class="font-heading font-bold text-slate-900 text-base">Kasir Cepat POS
                                            </h3>
                                            <p class="text-xs text-slate-400">Order kilat meja / takeaway</p>
                                        </div>
                                    </div>
                                    <button @click="cart = []"
                                        class="text-xs text-rose-500 hover:underline font-semibold"
                                        x-show="cart.length > 0">Reset</button>
                                </div>

                                <!-- Cart Items List -->
                                <div class="mt-4 space-y-3 max-h-60 overflow-y-auto custom-scrollbar pr-1">
                                    <template x-for="(item, index) in cart" :key="index">
                                        <div
                                            class="p-3 bg-blue-50/60 rounded-xl border border-blue-100 flex items-center justify-between text-xs">
                                            <div class="flex items-center gap-2.5">
                                                <span class="text-base" x-text="item.icon"></span>
                                                <div>
                                                    <p class="font-bold text-slate-900" x-text="item.name"></p>
                                                    <p class="text-slate-500 font-medium"
                                                        x-text="'Rp ' + item.price.toLocaleString() + ' x ' + item.qty">
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button @click="item.qty > 1 ? item.qty-- : removeCartItem(index)"
                                                    class="w-5 h-5 rounded bg-white text-slate-600 flex items-center justify-center font-bold border border-slate-200 hover:bg-slate-100">-</button>
                                                <span class="font-bold text-slate-800" x-text="item.qty"></span>
                                                <button @click="item.qty++"
                                                    class="w-5 h-5 rounded bg-white text-slate-600 flex items-center justify-center font-bold border border-slate-200 hover:bg-slate-100">+</button>
                                            </div>
                                        </div>
                                    </template>

                                    <div x-show="cart.length === 0" class="py-8 text-center text-slate-400">
                                        <svg class="w-10 h-10 mx-auto text-blue-200 mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        <p class="text-xs font-medium">Keranjang kasir masih kosong</p>
                                        <p class="text-[11px] text-slate-400 mt-1">Pilih menu di sebelah kiri untuk
                                            menambah item</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Total & Payment Buttons -->
                            <div class="pt-4 border-t border-slate-100 space-y-3">
                                <div class="space-y-1.5 text-xs">
                                    <div class="flex justify-between text-slate-500">
                                        <span>Subtotal</span>
                                        <span class="font-bold text-slate-800"
                                            x-text="'Rp ' + cartTotal.toLocaleString()"></span>
                                    </div>
                                    <div class="flex justify-between text-slate-500">
                                        <span>PB1 Pajak (10%)</span>
                                        <span class="font-bold text-slate-800"
                                            x-text="'Rp ' + (cartTotal * 0.1).toLocaleString()"></span>
                                    </div>
                                    <div
                                        class="flex justify-between text-base font-extrabold text-slate-900 pt-2 border-t border-slate-100">
                                        <span>Total Bayar</span>
                                        <span class="text-blue-600"
                                            x-text="'Rp ' + (cartTotal * 1.1).toLocaleString()"></span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2 pt-2">
                                    <button :disabled="cart.length === 0"
                                        @click="alert('Pembayaran QRIS berhasil! Tiket ditarik ke dapur.'); cart = []"
                                        :class="cart.length === 0 ? 'opacity-50 cursor-not-allowed' : ''"
                                        class="py-2.5 bg-blue-50 text-blue-700 font-bold rounded-xl border border-blue-200 text-xs hover:bg-blue-100 transition-colors flex items-center justify-center gap-1.5">
                                        <span>📱 QRIS / EDC</span>
                                    </button>

                                    <button :disabled="cart.length === 0"
                                        @click="alert('Pembayaran Tunai Diterima! Nota dicetak.'); cart = []"
                                        :class="cart.length === 0 ? 'opacity-50 cursor-not-allowed' : ''"
                                        class="py-2.5 bg-blue-600 text-white font-bold rounded-xl text-xs hover:bg-blue-700 shadow-soft-blue transition-colors flex items-center justify-center gap-1.5">
                                        <span>💵 Tunai</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Low Stock Inventory Illustrative Alert -->
                        <div class="bg-white p-6 rounded-3xl border border-blue-100 shadow-soft-blue space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="font-heading font-bold text-slate-900 text-base flex items-center gap-2">
                                    <span>⚠️ Peringatan Stok Bahan</span>
                                </h3>
                                <span
                                    class="px-2 py-0.5 bg-amber-100 text-amber-800 rounded-full text-[11px] font-bold">3
                                    Perlu Restok</span>
                            </div>

                            <div class="space-y-3 text-xs">
                                <!-- Item 1 -->
                                <div
                                    class="p-3 bg-amber-50/70 border border-amber-200 rounded-xl flex items-center justify-between">
                                    <div class="flex items-center gap-2.5">
                                        <span class="text-base">🥛</span>
                                        <div>
                                            <p class="font-bold text-slate-900">Oat Milk Barista Edition</p>
                                            <p class="text-amber-700 font-medium">Sisa 3.5 Liter (Batas: 5L)</p>
                                        </div>
                                    </div>
                                    <button
                                        class="px-2.5 py-1 bg-amber-600 text-white font-bold rounded-lg text-[10px]">Restok</button>
                                </div>

                                <!-- Item 2 -->
                                <div
                                    class="p-3 bg-amber-50/70 border border-amber-200 rounded-xl flex items-center justify-between">
                                    <div class="flex items-center gap-2.5">
                                        <span class="text-base">🫘</span>
                                        <div>
                                            <p class="font-bold text-slate-900">House Blend Espresso Beans</p>
                                            <p class="text-amber-700 font-medium">Sisa 1.8 Kg (Batas: 3Kg)</p>
                                        </div>
                                    </div>
                                    <button
                                        class="px-2.5 py-1 bg-amber-600 text-white font-bold rounded-lg text-[10px]">Restok</button>
                                </div>

                                <!-- Item 3 -->
                                <div
                                    class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between">
                                    <div class="flex items-center gap-2.5">
                                        <span class="text-base">🍯</span>
                                        <div>
                                            <p class="font-bold text-slate-900">Caramel Syrup Monin</p>
                                            <p class="text-slate-500 font-medium">Sisa 2 Botol</p>
                                        </div>
                                    </div>
                                    <span class="text-slate-400 font-medium">Aman</span>
                                </div>
                            </div>
                        </div>

                        <!-- Daily Promo Banner Card -->
                        <div
                            class="bg-linear-to-br from-indigo-600 to-blue-700 p-6 rounded-3xl text-white shadow-soft-blue relative overflow-hidden">
                            <div
                                class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-xl pointer-events-none">
                            </div>
                            <div class="relative z-10 space-y-3">
                                <span
                                    class="px-2.5 py-1 bg-amber-300 text-slate-900 text-[10px] font-extrabold rounded-full tracking-wider uppercase">Promosi
                                    Aktif</span>
                                <h4 class="font-heading font-extrabold text-xl leading-snug">Diskon 20% Member Eighty
                                    Loyalty</h4>
                                <p class="text-xs text-blue-100 leading-relaxed">Berlaku untuk pembayaran QRIS hingga
                                    akhir bulan ini. Kode voucher: <strong class="text-amber-200">EIGHTYLOVE</strong>
                                </p>
                                <button
                                    class="mt-2 w-full py-2 bg-white text-blue-700 font-bold rounded-xl text-xs hover:bg-blue-50 transition-colors shadow-sm">
                                    Bagikan QR Promo Kebijakan
                                </button>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Footer info -->
                <footer class="pt-6 border-t border-slate-200/80 text-center text-xs text-slate-400">
                    <p>© 2026 Eighty Coffee Studio • System Dashboard Management v2.4 • Crafted with Modern Light Blue
                        Design</p>
                </footer>

            </div>
        </main>

    </div>

    <!-- ==================== NEW QUICK ORDER MODAL ==================== -->
    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm"
        style="display: none;">

        <div @click.outside="isModalOpen = false"
            class="bg-white w-full max-w-lg rounded-3xl shadow-glow-blue border border-blue-100 p-6 space-y-6 transform transition-all">

            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xl">
                        ☕</div>
                    <div>
                        <h3 class="font-heading font-bold text-lg text-slate-900">Buat Pesanan Baru</h3>
                        <p class="text-xs text-slate-400">Input rincian cangkir & kustomisasi rasa</p>
                    </div>
                </div>
                <button @click="isModalOpen = false"
                    class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center font-bold text-sm">✕</button>
            </div>

            <!-- Form -->
            <div class="space-y-4 text-xs">

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Pelanggan / Meja</label>
                    <input type="text" x-model="quickOrder.customer" placeholder="Contoh: Rian (Meja T-05)"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Pilih Menu Cangkir</label>
                    <select x-model="quickOrder.item"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Eighty Signature Latte (Rp 28.000)</option>
                        <option>Sea Salt Caramel Cold Brew (Rp 34.000)</option>
                        <option>Americano Iced (Rp 22.000)</option>
                        <option>Matcha Oat Foam (Rp 32.000)</option>
                        <option>French Butter Croissant (Rp 25.000)</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Level Gula (Sugar)</label>
                        <select x-model="quickOrder.sugar"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Normal (100%)</option>
                            <option>Less Sugar (50%)</option>
                            <option>No Sugar (0%)</option>
                            <option>Extra Palm Sugar (+Rp 3k)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tingkat Es (Ice Level)</label>
                        <select x-model="quickOrder.ice"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Normal Ice</option>
                            <option>Less Ice</option>
                            <option>No Ice (Warm)</option>
                            <option>Hot Cup</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <span class="font-bold text-slate-700">Jumlah Cangkir</span>
                    <div class="flex items-center gap-3 bg-slate-100 p-1 rounded-xl">
                        <button @click="if(quickOrder.qty > 1) quickOrder.qty--"
                            class="w-7 h-7 rounded-lg bg-white font-bold text-slate-700 shadow-sm">-</button>
                        <span class="font-bold text-slate-900 text-sm px-2" x-text="quickOrder.qty"></span>
                        <button @click="quickOrder.qty++"
                            class="w-7 h-7 rounded-lg bg-white font-bold text-slate-700 shadow-sm">+</button>
                    </div>
                </div>

            </div>

            <!-- Modal Footer Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <button @click="isModalOpen = false"
                    class="px-4 py-2.5 text-slate-600 hover:bg-slate-100 font-bold rounded-xl text-xs transition-colors">Batal</button>
                <button
                    @click="
                    orders.unshift({
                        id: '#80-' + (1043 + orders.length),
                        customer: quickOrder.customer || 'Pelanggan Walk-In',
                        type: 'Dine-In',
                        table: 'T-0' + (orders.length + 1),
                        items: quickOrder.qty + 'x ' + quickOrder.item.split(' (')[0],
                        total: 'Rp ' + (28000 * quickOrder.qty).toLocaleString(),
                        status: 'Brewing',
                        time: 'Baru saja',
                        badgeBg: 'bg-amber-100 text-amber-700 border-amber-300'
                    });
                    isModalOpen = false;
                    quickOrder.customer = '';
                "
                    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs shadow-soft-blue transition-all">
                    Kirim Ke Barista ☕
                </button>
            </div>

        </div>
    </div>

</body>

</html>
