<x-warga-layout title="Detail & Tracking Pengaduan">

    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Header Page --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('warga.dashboard') }}"
                    class="inline-flex items-center gap-2 text-xs font-medium text-slate-500 hover:text-blue-600 transition-colors mb-1">
                    <i class="fa-solid fa-arrow-left text-[10px]" aria-hidden="true"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Detail & Tracking Aduan</h1>
                    <span class="px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 font-mono font-bold text-xs">
                        {{ $aduan->tiket }}
                    </span>
                </div>
            </div>

            {{-- Badge Status Utama --}}
            <div>
                @if ($aduan->status === 'Menunggu')
                    <span
                        class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        Menunggu Verifikasi
                    </span>
                @elseif($aduan->status === 'Diproses')
                    <span
                        class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                        <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                        Sedang Diproses
                    </span>
                @elseif($aduan->status === 'Selesai')
                    <span
                        class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Selesai Ditangani
                    </span>
                @elseif($aduan->status === 'Ditolak')
                    <span
                        class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                        Laporan Ditolak
                    </span>
                @endif
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kolom Kiri (2 Col): Detail Content & Map --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Card Informaasi Aduan --}}
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-xs space-y-5">
                    <div class="border-b border-slate-200/80 pb-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span
                                class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-700 font-medium text-xs">
                                <i class="fa-solid fa-tag text-[10px] text-slate-400"></i>
                                {{ $aduan->kategori->nama ?? ($aduan->kategori->nama_kategori ?? 'Umum') }}
                            </span>
                            @if ($aduan->is_anonymous)
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-slate-800 text-slate-100 font-medium text-xs">
                                    <i class="fa-solid fa-user-secret text-[10px]"></i>
                                    Laporan Anonim
                                </span>
                            @endif
                        </div>
                        <h2 class="text-xl font-bold text-slate-900 leading-snug">{{ $aduan->judul }}</h2>
                        <p class="text-xs text-slate-400 mt-1">
                            <i class="fa-regular fa-clock mr-1"></i>
                            Dilaporkan pada {{ $aduan->created_at->translatedFormat('d F Y, H:i') }} WIB
                        </p>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="space-y-1.5">
                        <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Deskripsi Laporan</h3>
                        <p
                            class="text-sm text-slate-700 whitespace-pre-line leading-relaxed bg-slate-50/50 p-4 rounded-xl border border-slate-100">
                            {{ $aduan->deskripsi }}
                        </p>
                    </div>

                    {{-- Foto Lampiran Warga --}}
                    @if ($aduan->foto)
                        <div class="space-y-1.5">
                            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Foto Lampiran Pelapor
                            </h3>
                            <a href="{{ asset('storage/' . $aduan->foto) }}" target="_blank"
                                class="block group relative overflow-hidden rounded-xl border border-slate-200 bg-slate-100">
                                <img src="{{ asset('storage/' . $aduan->foto) }}" alt="Foto Bukti Aduan"
                                    class="w-full max-h-80 object-cover group-hover:scale-105 transition-transform duration-300">
                                <div
                                    class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-medium gap-2">
                                    <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                                    <span>Klik untuk memperbesar</span>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Card Lokasi Kejadian --}}
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-200/80 pb-3">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-map-location-dot text-blue-600"></i>
                            <span>Lokasi Kejadian</span>
                        </h3>
                        <span class="text-xs font-medium text-slate-600 bg-slate-100 px-2.5 py-1 rounded-md">
                            {{ $aduan->desa->nama_desa ?? ($aduan->desa->nama ?? 'Wilayah Kutorejo') }}
                        </span>
                    </div>

                    <p class="text-xs text-slate-600">
                        <strong class="text-slate-800">Detail Alamat / Patokan:</strong> {{ $aduan->detail_lokasi }}
                    </p>

                    {{-- Map View --}}
                    <div id="trackingMap" class="w-full h-64 rounded-xl border border-slate-200 overflow-hidden z-0">
                    </div>

                    <div class="flex items-center justify-between text-[11px] font-mono text-slate-500 pt-1">
                        <span>Lat: {{ $aduan->latitude }}</span>
                        <span>Lng: {{ $aduan->longitude }}</span>
                    </div>
                </div>

                {{-- Hasil Penanganan / Foto Bukti Selesai (Jika Status Selesai) --}}
                @if ($aduan->status === 'Selesai')
                    <div class="bg-emerald-50/50 border border-emerald-200/80 rounded-2xl p-6 shadow-xs space-y-4">
                        <div class="flex items-center gap-2 text-emerald-800 border-b border-emerald-200/60 pb-3">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                            <h3 class="text-base font-bold">Bukti Pengerjaan / Tindak Lanjut</h3>
                        </div>

                        {{-- Ambil tanggapan terakhir atau foto penanganan --}}
                        @php
                            $tanggapanSelesai = $aduan->tanggapan->last();
                        @endphp

                        @if ($tanggapanSelesai)
                            <div class="space-y-3">
                                <p class="text-xs text-slate-700 leading-relaxed">
                                    <strong>Catatan Petugas:</strong>
                                    {{ $tanggapanSelesai->tanggapan ?? 'Laporan telah selesai ditindaklanjuti oleh tim terkait.' }}
                                </p>

                                @if (isset($tanggapanSelesai->foto_bukti))
                                    <div class="space-y-1.5">
                                        <span class="text-[11px] font-bold text-emerald-900 uppercase">Foto Hasil
                                            Pengerjaan:</span>
                                        <a href="{{ asset('storage/' . $tanggapanSelesai->foto_bukti) }}"
                                            target="_blank"
                                            class="block group relative overflow-hidden rounded-xl border border-emerald-200 bg-white">
                                            <img src="{{ asset('storage/' . $tanggapanSelesai->foto_bukti) }}"
                                                alt="Foto Bukti Selesai" class="w-full max-h-72 object-cover">
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @else
                            <p class="text-xs text-slate-600 italic">Pekerjaan telah diselesaikan oleh petugas teknis
                                lapangan.</p>
                        @endif
                    </div>
                @endif

            </div>

            {{-- Kolom Kanan (1 Col): Timeline Tracking Progres --}}
            <div class="space-y-6">
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-xs space-y-5">
                    <div class="border-b border-slate-200/80 pb-3">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-route text-blue-600"></i>
                            <span>Timeline Tracking Progres</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Riwayat update status & tanggapan petugas.</p>
                    </div>

                    {{-- Vertical Timeline List --}}
                    <div
                        class="relative pl-6 space-y-6 before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">

                        {{-- 1. Step Pengaduan Dikirim --}}
                        <div class="relative">
                            <span
                                class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px]">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <div class="space-y-0.5">
                                <h4 class="text-xs font-bold text-slate-900">Pengaduan Dikirim</h4>
                                <p class="text-[11px] text-slate-500">Laporan berhasil dibuat oleh warga.</p>
                                <span class="text-[10px] text-slate-400 font-mono block pt-0.5">
                                    {{ $aduan->created_at->translatedFormat('d M Y, H:i') }}
                                </span>
                            </div>
                        </div>

                        {{-- Tanggapan / Log Perubahan Status dari Database --}}
                        @if ($aduan->tanggapan && $aduan->tanggapan->count() > 0)
                            @foreach ($aduan->tanggapan as $item)
                                <div class="relative">
                                    <span
                                        class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">
                                        <i class="fa-solid fa-comment-dots"></i>
                                    </span>
                                    <div class="space-y-1 bg-slate-50 p-3 rounded-xl border border-slate-200/80">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-bold text-slate-900">
                                                {{ $item->user->name ?? 'Petugas Kec. Kutorejo' }}
                                            </span>
                                            <span class="text-[10px] text-slate-400 font-mono">
                                                {{ $item->created_at->translatedFormat('d M Y, H:i') }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-slate-700 leading-relaxed">
                                            {{ $item->tanggapan }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{-- State default jika belum ada tanggapan petugas --}}
                            <div class="relative">
                                <span
                                    class="absolute -left-6 top-0.5 w-5 h-5 rounded-full bg-amber-400 text-white flex items-center justify-center text-[10px]">
                                    <i class="fa-solid fa-hourglass-half"></i>
                                </span>
                                <div class="space-y-0.5">
                                    <h4 class="text-xs font-bold text-slate-800">Menunggu Verifikasi Petugas</h4>
                                    <p class="text-[11px] text-slate-500">Laporan sedang ditinjau oleh pihak Kecamatan
                                        Kutorejo.</p>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- Render Map Leaflet Read-only --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lat = {{ $aduan->latitude }};
            const lng = {{ $aduan->longitude }};

            const map = L.map('trackingMap', {
                dragging: false,
                touchZoom: false,
                scrollWheelZoom: false,
                doubleClickZoom: false,
                boxZoom: false,
                tap: false
            }).setView([lat, lng], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map)
                .bindPopup("<b>Lokasi Kejadian</b><br>{{ $aduan->detail_lokasi }}")
                .openPopup();
        });
    </script>
</x-warga-layout>
