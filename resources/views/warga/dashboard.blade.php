<x-warga-layout title="Dashboard Warga">

    <div class="space-y-6">

        {{-- Welcome Banner --}}
        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 md:p-8 shadow-xs">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-1.5">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold">
                        <i class="fa-solid fa-building-flag text-xs" aria-hidden="true"></i>
                        Portal Layanan Publik Warga
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">
                        Selamat Datang, {{ auth()->user()->name ?? 'Warga' }}
                    </h1>
                    <p class="text-sm text-slate-600 max-w-2xl leading-relaxed">
                        Pantau progres pengaduan Anda atau ajukan laporan baru terkait fasilitas publik, kebersihan, dan
                        ketertiban di wilayah Anda secara transparan.
                    </p>
                </div>

                <div class="shrink-0">
                    <a href="{{ route('warga.pengaduan.create') }}"
                        class="inline-flex items-center justify-center gap-2.5 px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm transition-colors duration-150 shadow-xs focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 w-full md:w-auto">
                        <i class="fa-solid fa-plus text-xs" aria-hidden="true"></i>
                        <span>Buat Pengaduan Baru</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Metric Cards (Statistik Status Aduan) --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Pending --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 text-lg">
                    <i class="fa-solid fa-clock" aria-hidden="true"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Menunggu Verifikasi</p>
                    <p class="text-2xl font-bold text-slate-900 mt-0.5">
                        {{ $stats['pending'] ?? 0 }}
                    </p>
                </div>
            </div>

            {{-- Processed --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 text-lg">
                    <i class="fa-solid fa-spinner" aria-hidden="true"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Sedang Diproses</p>
                    <p class="text-2xl font-bold text-slate-900 mt-0.5">
                        {{ $stats['processed'] ?? 0 }}
                    </p>
                </div>
            </div>

            {{-- Completed --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 text-lg">
                    <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Selesai Ditangani</p>
                    <p class="text-2xl font-bold text-slate-900 mt-0.5">
                        {{ $stats['completed'] ?? 0 }}
                    </p>
                </div>
            </div>

            {{-- Rejected --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 text-lg">
                    <i class="fa-solid fa-circle-xmark" aria-hidden="true"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Ditolak</p>
                    <p class="text-2xl font-bold text-slate-900 mt-0.5">
                        {{ $stats['rejected'] ?? 0 }}
                    </p>
                </div>
            </div>

        </div>

        {{-- Table Section: Riwayat Aduan Saya --}}
        <div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden">

            {{-- Header Table & Filter --}}
            <div
                class="p-5 md:p-6 border-b border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Riwayat Pengaduan Saya</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar aduan yang pernah Anda ajukan beserta status
                        penanganannya.</p>
                </div>

                {{-- Filter & Search Form --}}
                <form method="GET" action="{{ route('warga.dashboard') }}" class="flex items-center gap-2">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nomor tiket / judul..."
                            class="w-full sm:w-64 pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-300 bg-white text-slate-800 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"
                            aria-hidden="true"></i>
                    </div>

                    <select name="status" onchange="this.form.submit()"
                        class="py-2 pl-3 pr-8 text-xs rounded-xl border border-slate-300 bg-white text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processed" {{ request('status') === 'processed' ? 'selected' : '' }}>Diproses
                        </option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai
                        </option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak
                        </option>
                    </select>
                </form>
            </div>

            {{-- Table Content --}}
            <div class="overflow-x-auto">
                @if (isset($aduans) && $aduans->count() > 0)
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50/80 border-b border-slate-200/80 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                <th scope="col" class="px-6 py-3.5">Kode Tiket & Judul</th>
                                <th scope="col" class="px-6 py-3.5">Kategori</th>
                                <th scope="col" class="px-6 py-3.5">Lokasi Kejadian</th>
                                <th scope="col" class="px-6 py-3.5">Tanggal Lapor</th>
                                <th scope="col" class="px-6 py-3.5">Status</th>
                                <th scope="col" class="px-6 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/80 text-sm">
                            @foreach ($aduans as $aduan)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    {{-- Tiket & Judul --}}
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-mono font-semibold text-blue-600">
                                                {{ $aduan->tiket }}
                                            </span>
                                            <span class="font-medium text-slate-900 mt-0.5 line-clamp-1">
                                                {{ $aduan->judul }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Kategori --}}
                                    <td class="px-6 py-4 text-slate-600 text-xs">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 font-medium">
                                            <i class="fa-solid fa-tag text-[10px] text-slate-400"
                                                aria-hidden="true"></i>
                                            {{ $aduan->kategori->nama ?? ($aduan->kategori->nama_kategori ?? 'Umum') }}
                                        </span>
                                    </td>

                                    {{-- Lokasi Kejadian --}}
                                    <td class="px-6 py-4 text-slate-600 text-xs">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-location-dot text-slate-400 text-xs"
                                                aria-hidden="true"></i>
                                            <span>{{ $aduan->desa->nama_desa ?? ($aduan->desa->nama ?? 'Wilayah Kutorejo') }}</span>
                                        </div>
                                    </td>

                                    {{-- Tanggal Lapor --}}
                                    <td class="px-6 py-4 text-slate-500 text-xs whitespace-nowrap">
                                        {{ $aduan->created_at->translatedFormat('d M Y, H:i') }}
                                    </td>

                                    {{-- Badge Status --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($aduan->status === 'Menunggu')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200/60">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Menunggu
                                            </span>
                                        @elseif($aduan->status === 'Diproses')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200/60">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                                Diproses
                                            </span>
                                        @elseif($aduan->status === 'Selesai')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Selesai
                                            </span>
                                        @elseif($aduan->status === 'Ditolak')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200/60">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Action Link --}}
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <a href="{{ route('warga.pengaduan.show', $aduan->id) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                            <span>Detail & Tracking</span>
                                            <i class="fa-solid fa-arrow-right text-[10px]" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    {{-- Empty State --}}
                    <div class="py-12 px-4 text-center">
                        <div
                            class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-folder-open" aria-hidden="true"></i>
                        </div>
                        <h3 class="text-base font-semibold text-slate-900">Belum Ada Aduan</h3>
                        <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                            Anda belum memiliki riwayat pengaduan. Kirimkan aduan pertama Anda jika terdapat masalah
                            fasilitas umum di sekitar Anda.
                        </p>
                        <div class="mt-5">
                            <a href="{{ route('warga.pengaduan.create') }}"
                                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-medium hover:bg-blue-700 transition-colors shadow-xs">
                                <i class="fa-solid fa-plus text-xs" aria-hidden="true"></i>
                                Buat Aduan Sekarang
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Table Pagination --}}
            @if (isset($aduans) && method_exists($aduans, 'hasPages') && $aduans->hasPages())
                <div class="p-4 border-t border-slate-200/80 bg-slate-50/50">
                    {{ $aduans->links() }}
                </div>
            @endif

        </div>

    </div>
</x-warga-layout>
