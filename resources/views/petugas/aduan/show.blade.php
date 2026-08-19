<x-petugas-layout title="Detail Aduan - {{ $aduan->tiket }}">

    {{-- Breadcrumb & Header --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('petugas.aduan.index') }}" class="hover:text-blue-600 transition">Daftar Aduan</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
            <span class="font-semibold text-slate-700">{{ $aduan->tiket }}</span>
        </div>
        <a href="{{ route('petugas.aduan.index') }}"
            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    {{-- Flash Success Message --}}
    @if (session('success'))
        <div
            class="mb-6 rounded-2xl bg-emerald-50 p-4 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20 flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-base text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kolom Kiri: Detail Informasi & Map --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Card Detail Aduan --}}
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60">
                <div class="flex items-start justify-between border-b border-slate-100 pb-4 mb-4 gap-4">
                    <div>
                        <span class="font-mono text-xs font-bold text-blue-600">{{ $aduan->tiket }}</span>
                        <h1 class="text-lg font-bold text-slate-800 mt-1">{{ $aduan->judul }}</h1>
                        <p class="text-xs text-slate-400 mt-0.5">Dilaporkan pada:
                            {{ $aduan->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                    </div>
                    <div>
                        @if ($aduan->status == 'Menunggu')
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                <span class="h-2 w-2 rounded-full bg-amber-500"></span> Menunggu
                            </span>
                        @elseif($aduan->status == 'Diproses')
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-600/20">
                                <span class="h-2 w-2 rounded-full bg-blue-500"></span> Diproses
                            </span>
                        @elseif($aduan->status == 'Selesai')
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Selesai
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                <span class="h-2 w-2 rounded-full bg-rose-500"></span> Ditolak
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Deskripsi Aduan --}}
                <div class="mb-6">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Deskripsi Laporan</h3>
                    <p
                        class="text-xs text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100 whitespace-pre-line">
                        {{ $aduan->deskripsi }}
                    </p>
                </div>

                {{-- Foto Pelaporan Warga --}}
                @if ($aduan->foto)
                    <div class="mb-6">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Foto Lampiran Pelapor
                        </h3>
                        <a href="{{ asset('storage/' . $aduan->foto) }}" target="_blank"
                            class="inline-block group relative rounded-xl overflow-hidden border border-slate-200">
                            <img src="{{ asset('storage/' . $aduan->foto) }}" alt="Foto Lampiran"
                                class="max-h-72 w-full object-cover group-hover:scale-105 transition duration-300">
                            <div
                                class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-semibold gap-2">
                                <i class="fa-solid fa-up-right-and-down-left-from-center"></i> Perbesar Foto
                            </div>
                        </a>
                    </div>
                @endif

                {{-- Peta Lokasi Kejadian (LeafletJS) --}}
                <div x-data="detailMap()" x-init="initMap()" class="w-full">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Lokasi Kejadian</h3>
                    <p class="text-xs font-semibold text-slate-700 mb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-location-dot text-rose-500"></i>
                        <span>{{ $aduan->detail_lokasi }} (Desa {{ $aduan->desa->nama }})</span>
                    </p>
                    <div id="map" class="h-48 w-full rounded-xl border border-slate-200 z-0"></div>
                </div>
            </div>

            {{-- Histori Tanggapan & Penanganan --}}
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60">
                <h2 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-blue-600"></i>
                    <span>Riwayat Penanganan & Tanggapan</span>
                </h2>

                <div class="space-y-4">
                    @forelse ($aduan->tanggapan as $item)
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex flex-col gap-2">
                            <div class="flex items-center justify-between border-b border-slate-200/60 pb-2">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-xs font-bold text-slate-800">{{ $item->user->name ?? 'Petugas' }}</span>
                                    <span
                                        class="rounded bg-blue-100 px-1.5 py-0.5 text-[10px] font-semibold text-blue-700">
                                        {{ $item->user->role ?? 'Petugas' }}
                                    </span>
                                </div>
                                <span
                                    class="text-[10px] text-slate-400">{{ $item->created_at->format('d M Y, H:i') }}</span>
                            </div>

                            <p class="text-xs text-slate-700 whitespace-pre-line">{{ $item->tanggapan }}</p>

                            @if ($item->foto_bukti)
                                <div class="mt-2">
                                    <p class="text-[10px] font-bold text-slate-400 mb-1">Foto Bukti Penanganan:</p>
                                    <a href="{{ asset('storage/' . $item->foto_bukti) }}" target="_blank"
                                        class="inline-block">
                                        <img src="{{ asset('storage/' . $item->foto_bukti) }}" alt="Bukti Pengerjaan"
                                            class="h-24 w-36 object-cover rounded-lg border border-slate-200 hover:opacity-90 transition">
                                    </a>
                                </div>
                            @endif

                            @if ($item->status_sebelumnya && $item->status_setelahnya)
                                <div class="mt-1 flex items-center gap-2 text-[10px] text-slate-500 font-medium">
                                    <span>Status diubah:</span>
                                    <span class="font-bold text-slate-600">{{ $item->status_sebelumnya }}</span>
                                    <i class="fa-solid fa-arrow-right text-[8px]"></i>
                                    <span class="font-bold text-blue-600">{{ $item->status_setelahnya }}</span>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400">
                            <p class="text-xs">Belum ada tanggapan atau tindakan untuk aduan ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Kolom Kanan: Info Pelapor & Form Update --}}
        <div class="space-y-6">

            {{-- Informasil Pelapor --}}
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Informasi Pelapor</h2>

                @if ($aduan->is_anonymous)
                    <div class="flex items-center gap-3 p-3 bg-amber-50 rounded-xl border border-amber-200/60">
                        <i class="fa-solid fa-user-secret text-xl text-amber-600"></i>
                        <div>
                            <p class="text-xs font-bold text-amber-900">Pelapor Anonim</p>
                            <p class="text-[10px] text-amber-700">Identitas disembunyikan oleh pelapor.</p>
                        </div>
                    </div>
                @else
                    <div class="space-y-3 text-xs">
                        <div>
                            <span class="text-slate-400 block text-[10px] font-medium">Nama Lengkap</span>
                            <span class="font-bold text-slate-800">{{ $aduan->user->name ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] font-medium">NIK</span>
                            <span class="font-mono font-semibold text-slate-700">{{ $aduan->user->nik ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] font-medium">No. Telepon / Whatsapp</span>
                            <span class="font-semibold text-slate-700">{{ $aduan->user->no_hp ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] font-medium">Email</span>
                            <span class="font-semibold text-slate-700">{{ $aduan->user->email ?? '-' }}</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Form Tanggapan & Update Status --}}
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60">
                <h2 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-reply-all text-blue-600"></i>
                    <span>Beri Tanggapan & Update Status</span>
                </h2>

                <form action="{{ route('petugas.aduan.tanggapan.store', $aduan->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    {{-- Ubah Status Aduan --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Update Status Aduan</label>
                        <select name="status"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 p-2.5 text-xs text-slate-800 outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition font-medium">
                            <option value="Menunggu"
                                {{ old('status', $aduan->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Diproses"
                                {{ old('status', $aduan->status) == 'Diproses' ? 'selected' : '' }}>Diproses (Sedang
                                Dikerjakan)</option>
                            <option value="Selesai"
                                {{ old('status', $aduan->status) == 'Selesai' ? 'selected' : '' }}>
                                Selesai (Penanganan
                                Tuntas)</option>
                            <option value="Ditolak"
                                {{ old('status', $aduan->status) == 'Ditolak' ? 'selected' : '' }}>
                                Ditolak (Tidak
                                Sesuai / Invalid)</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-[10px] text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Isi Tanggapan --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggapan / Catatan
                            Lapangan</label>
                        <textarea name="tanggapan" rows="4"
                            placeholder="Tuliskan perkembangan tindakan, alasan penolakan, atau instruksi selanjutnya..."
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 p-3 text-xs text-slate-800 outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition">{{ old('tanggapan') }}</textarea>
                        @error('tanggapan')
                            <p class="mt-1 text-[10px] text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Upload Foto Bukti Pengerjaan --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Upload Foto Bukti
                            (Opsional)</label>
                        <input type="file" name="foto_bukti" accept="image/*"
                            class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                        <p class="mt-1 text-[10px] text-slate-400">Format: JPG, JPEG, PNG (Maks 2MB)</p>
                        @error('foto_bukti')
                            <p class="mt-1 text-[10px] text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-semibold text-white shadow-md shadow-blue-500/20 hover:bg-blue-700 transition">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Kirim Tanggapan & Update</span>
                    </button>
                </form>
            </div>

        </div>

    </div>

    @push('scripts')
        <script>
            function detailMap() {
                return {
                    initMap() {
                        const lat = {{ $aduan->latitude ?? -7.5333 }};
                        const lng = {{ $aduan->longitude ?? 112.5167 }};

                        const map = L.map('map').setView([lat, lng], 15);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; OpenStreetMap contributors'
                        }).addTo(map);

                        L.marker([lat, lng]).addTo(map)
                            .bindPopup('<b>{{ addslashes($aduan->judul) }}</b><br>{{ addslashes($aduan->detail_lokasi) }}')
                            .openPopup();

                        setTimeout(() => {
                            map.invalidateSize();
                        }, 300);
                    }
                }
            }
        </script>
    @endpush

</x-petugas-layout>
