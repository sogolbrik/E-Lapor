<x-admin-layout title="Detail Aduan - {{ $aduan->tiket }}">

    {{-- Breadcrumb & Top Bar --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('admin.aduan.index') }}" class="hover:text-blue-600 transition">Manajemen Aduan</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
            <span class="font-semibold text-slate-700">{{ $aduan->tiket }}</span>
        </div>
        <a href="{{ route('admin.aduan.index') }}"
            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    {{-- Flash Message --}}
    @if (session('success'))
        <div
            class="mb-6 rounded-xl bg-emerald-50 p-4 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20 flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3" x-data="{ tab: 'detail', modalEdit: {{ $errors->has('judul') || $errors->has('detail_lokasi') || $errors->has('deskripsi') ? 'true' : 'false' }} }">

        {{-- Kolom Kiri: Detail Aduan & Riwayat Tanggapan --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Information Card --}}
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60">
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-slate-100 pb-5">
                    <div>
                        <span class="text-xs font-mono font-bold text-blue-600">{{ $aduan->tiket }}</span>
                        <h2 class="mt-1 text-xl font-bold text-slate-800">{{ $aduan->judul }}</h2>
                        <div class="mt-2 flex flex-wrap items-center gap-3 text-xs text-slate-500">
                            <span><i
                                    class="fa-solid fa-folder text-slate-400 mr-1"></i>{{ $aduan->kategoriAduan->nama ?? '-' }}</span>
                            <span>•</span>
                            <span><i
                                    class="fa-solid fa-location-dot text-slate-400 mr-1"></i>{{ $aduan->desa->nama ?? '-' }}</span>
                            <span>•</span>
                            <span><i
                                    class="fa-solid fa-calendar text-slate-400 mr-1"></i>{{ $aduan->created_at->translatedFormat('d F Y H:i') }}</span>
                        </div>
                    </div>
                    <div>
                        @php
                            $statusStyle = match ($aduan->status) {
                                'Menunggu' => 'bg-amber-50 text-amber-700 ring-amber-600/20 dot-bg-amber-500',
                                'Diproses' => 'bg-blue-50 text-blue-700 ring-blue-600/20 dot-bg-blue-500',
                                'Selesai' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20 dot-bg-emerald-500',
                                'Ditolak' => 'bg-rose-50 text-rose-700 ring-rose-600/20 dot-bg-rose-500',
                            };
                            $dotColor = match ($aduan->status) {
                                'Menunggu' => 'bg-amber-500',
                                'Diproses' => 'bg-blue-500',
                                'Selesai' => 'bg-emerald-500',
                                'Ditolak' => 'bg-rose-500',
                            };
                        @endphp
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold ring-1 ring-inset {{ $statusStyle }}">
                            <span class="h-2 w-2 rounded-full {{ $dotColor }}"></span>
                            {{ $aduan->status }}
                        </span>
                    </div>
                </div>

                {{-- Pelapor Info --}}
                <div class="mt-5 rounded-xl bg-slate-50 p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold text-sm">
                            <i class="fa-solid {{ $aduan->is_anonymous ? 'fa-user-secret' : 'fa-user' }}"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Pelapor</p>
                            <p class="text-xs font-bold text-slate-800">
                                {{ $aduan->is_anonymous ? 'Anonim (Disembunyikan)' : $aduan->user->name ?? '-' }}
                            </p>
                        </div>
                    </div>
                    @if (!$aduan->is_anonymous && $aduan->user)
                        <div class="text-right text-xs">
                            <p class="text-slate-500">NIK: {{ $aduan->user->nik ?? '-' }}</p>
                            <p class="text-slate-500">HP: {{ $aduan->user->no_hp ?? '-' }}</p>
                        </div>
                    @endif
                </div>

                {{-- Deskripsi & Foto --}}
                <div class="mt-6 space-y-4">
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Detail Lokasi</h4>
                        <p class="text-xs font-medium text-slate-700">{{ $aduan->detail_lokasi }} (Lat:
                            {{ $aduan->latitude }}, Long: {{ $aduan->longitude }})</p>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Deskripsi Aduan</h4>
                        <p class="text-xs leading-relaxed text-slate-700 whitespace-pre-line">{{ $aduan->deskripsi }}
                        </p>
                    </div>

                    @if ($aduan->foto)
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Foto Lampiran
                            </h4>
                            <a href="{{ asset('storage/' . $aduan->foto) }}" target="_blank"
                                class="inline-block group relative overflow-hidden rounded-xl border border-slate-200">
                                <img src="{{ asset('storage/' . $aduan->foto) }}" alt="Foto Aduan"
                                    class="h-48 w-full object-cover group-hover:scale-105 transition duration-300">
                                <div
                                    class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-semibold">
                                    <i class="fa-solid fa-magnifying-glass-plus mr-1"></i> Lihat Ukuran Penuh
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Riwayat Tanggapan & Pembaruan --}}
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60">
                <h3 class="text-base font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-blue-600"></i>
                    <span>Riwayat Penanganan & Tanggapan</span>
                </h3>

                <div class="relative border-l-2 border-slate-100 pl-6 space-y-6">
                    @forelse ($aduan->tanggapan as $item)
                        <div class="relative">
                            {{-- Point Icon --}}
                            <div
                                class="absolute -left-7.75 top-0 flex h-6 w-6 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-4 ring-white text-[10px]">
                                <i class="fa-solid fa-comment-dots"></i>
                            </div>

                            <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                                <div class="flex items-center justify-between border-b border-slate-100 pb-2 mb-2">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="text-xs font-bold text-slate-800">{{ $item->user->name ?? 'Petugas/Admin' }}</span>
                                        <span
                                            class="rounded bg-blue-100 px-1.5 py-0.5 text-[10px] font-semibold text-blue-700">{{ $item->user->role ?? 'Admin' }}</span>
                                    </div>
                                    <span
                                        class="text-[11px] text-slate-400">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</span>
                                </div>

                                <p class="text-xs text-slate-700 whitespace-pre-line">{{ $item->tanggapan }}</p>

                                @if ($item->status_sebelumnya && $item->status_setelahnya)
                                    <div
                                        class="mt-3 flex items-center gap-2 text-[11px] text-slate-500 bg-white p-2 rounded-lg border border-slate-100">
                                        <span>Status diubah:</span>
                                        <span
                                            class="font-semibold text-slate-600">{{ $item->status_sebelumnya }}</span>
                                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                        <span class="font-bold text-blue-600">{{ $item->status_setelahnya }}</span>
                                    </div>
                                @endif

                                @if ($item->foto_bukti)
                                    <div class="mt-3">
                                        <a href="{{ asset('storage/' . $item->foto_bukti) }}" target="_blank"
                                            class="inline-block">
                                            <img src="{{ asset('storage/' . $item->foto_bukti) }}"
                                                alt="Bukti Pengerjaan"
                                                class="h-24 rounded-lg border border-slate-200 object-cover">
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic">Belum ada riwayat tanggapan untuk aduan ini.</p>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Kolom Kanan: Action Panel (Tanggapan & Edit Data) --}}
        <div class="space-y-6">

            {{-- Form Tanggapan & Update Status --}}
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60">
                <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-reply text-blue-600"></i>
                    <span>Beri Tanggapan</span>
                </h3>

                <form action="{{ route('admin.aduan.tanggapan.store', $aduan->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Ubah Status Aduan</label>
                        <select name="status"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-xs font-semibold text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition">
                            <option value="Menunggu" {{ $aduan->status == 'Menunggu' ? 'selected' : '' }}>Menunggu
                            </option>
                            <option value="Diproses" {{ $aduan->status == 'Diproses' ? 'selected' : '' }}>Diproses
                            </option>
                            <option value="Selesai" {{ $aduan->status == 'Selesai' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="Ditolak" {{ $aduan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Pesan Tanggapan</label>
                        <textarea name="tanggapan" rows="4" placeholder="Tulis tanggapan atau instruksi tindak lanjut..."
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 p-3.5 text-xs text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition"></textarea>
                        @error('tanggapan')
                            <p class="mt-1 text-[11px] text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Foto Bukti (Opsional)</label>
                        <input type="file" name="foto_bukti"
                            class="w-full text-xs text-slate-500 file:mr-3 file:rounded-xl file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-blue-600 hover:file:bg-blue-100 transition">
                        @error('foto_bukti')
                            <p class="mt-1 text-[11px] text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full rounded-xl bg-blue-600 py-2.5 text-xs font-semibold text-white shadow-md shadow-blue-500/20 hover:bg-blue-700 transition">
                        Kirim Tanggapan
                    </button>
                </form>
            </div>

            {{-- Akses Edit Data Aduan (Bila diperlukan koreksi) --}}
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60">
                <h3 class="text-base font-bold text-slate-800 mb-2">Koreksi Data</h3>
                <p class="text-xs text-slate-500 mb-4">Gunakan tombol di bawah jika terdapat kesalahan pada informasi
                    judul, lokasi, atau deskripsi aduan.</p>

                <button type="button" @click="modalEdit = true"
                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-slate-50 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">
                    <i class="fa-solid fa-pen-to-square text-blue-600"></i>
                    <span>Edit Informasi Aduan</span>
                </button>
            </div>

        </div>

        {{-- MODAL EDIT DATA ADUAN --}}
        <div x-show="modalEdit" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div x-show="modalEdit" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" @click="modalEdit = false"
                    class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>

                <div x-show="modalEdit" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                        <h3 class="text-base font-bold text-slate-800">Edit Informasi Aduan</h3>
                        <button type="button" @click="modalEdit = false"
                            class="text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.aduan.update', $aduan->id) }}" method="POST"
                        class="p-6 space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Judul Aduan</label>
                            <input type="text" name="judul" value="{{ old('judul', $aduan->judul) }}"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs text-slate-800 outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition">
                            @error('judul')
                                <p class="mt-1 text-[11px] text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Kategori</label>
                                <select name="kategori_id"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs text-slate-800 outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition">
                                    @foreach ($kategori as $kat)
                                        <option value="{{ $kat->id }}"
                                            {{ old('kategori_id', $aduan->kategori_id) == $kat->id ? 'selected' : '' }}>
                                            {{ $kat->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Wilayah (Desa)</label>
                                <select name="desa_id"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs text-slate-800 outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition">
                                    @foreach ($desa as $d)
                                        <option value="{{ $d->id }}"
                                            {{ old('desa_id', $aduan->desa_id) == $d->id ? 'selected' : '' }}>
                                            {{ $d->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status</label>
                            <select name="status"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs text-slate-800 outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition">
                                <option value="Menunggu"
                                    {{ old('status', $aduan->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu
                                </option>
                                <option value="Diproses"
                                    {{ old('status', $aduan->status) == 'Diproses' ? 'selected' : '' }}>Diproses
                                </option>
                                <option value="Selesai"
                                    {{ old('status', $aduan->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Ditolak"
                                    {{ old('status', $aduan->status) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Detail Lokasi</label>
                            <input type="text" name="detail_lokasi"
                                value="{{ old('detail_lokasi', $aduan->detail_lokasi) }}"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs text-slate-800 outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Deskripsi</label>
                            <textarea name="deskripsi" rows="4"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 p-3.5 text-xs text-slate-800 outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition">{{ old('deskripsi', $aduan->deskripsi) }}</textarea>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-3 pt-2">
                            <button type="button" @click="modalEdit = false"
                                class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                                Batal
                            </button>
                            <button type="submit"
                                class="rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-700 shadow-md shadow-blue-500/20 transition">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</x-admin-layout>
