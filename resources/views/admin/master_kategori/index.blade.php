<x-admin-layout title="Master Kategori Aduan">

    {{-- Page Header --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Master Kategori Aduan
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola kategori dan klasifikasi pengaduan masyarakat beserta status keaktifannya.
            </p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Tombol Tambah Kategori --}}
            <button type="button" @click="$dispatch('open-modal-tambah')"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-semibold text-white shadow-md shadow-blue-500/20 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition">
                <i class="fa-solid fa-folder-plus text-sm"></i>
                <span>Tambah Kategori</span>
            </button>
        </div>
    </div>

    {{-- Statistic Cards --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
        {{-- Card 1: Total Kategori --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-500 truncate">Total Kategori</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($totalKategori) }}</h3>
                    <p class="mt-2 text-xs font-medium text-emerald-600 flex items-center gap-1">
                        <i class="fa-solid fa-arrow-up"></i>
                        <span>+{{ number_format($kategoriBulanIni ?? 0) }} Baru bulan ini</span>
                    </p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="fa-solid fa-layer-group text-lg"></i>
                </div>
            </div>
        </div>

        {{-- Card 2: Kategori Aktif --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-500 truncate">Kategori Aktif</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($kategoriAktif) }}</h3>
                    <p class="mt-2 text-xs font-medium text-emerald-600 flex items-center gap-1">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ $persenAktif ?? 0 }}% dapat digunakan</span>
                    </p>
                </div>
                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i class="fa-solid fa-check-double text-lg"></i>
                </div>
            </div>
        </div>

        {{-- Card 3: Kategori Nonaktif --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-500 truncate">Kategori Nonaktif</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($kategoriNonaktif) }}</h3>
                    <p class="mt-2 text-xs font-medium text-rose-600 flex items-center gap-1">
                        <i class="fa-solid fa-ban"></i>
                        <span>{{ $persenNonaktif ?? 0 }}% dinonaktifkan</span>
                    </p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                    <i class="fa-solid fa-folder-minus text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Data Section --}}
    <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 min-w-0" x-data="{
        modalTambah: {{ $errors->any() && !old('_method') ? 'true' : 'false' }},
        modalEdit: {{ $errors->any() && old('_method') == 'PUT' ? 'true' : 'false' }},
        modalStatus: false,
        modalHapus: false,
        selectedKategori: {{ old('_method') == 'PUT'
            ? json_encode([
                'id' => old('kategori_id'),
                'nama' => old('nama'),
                'deskripsi' => old('deskripsi'),
            ])
            : 'null' }},
        actionType: ''
    }"
        @open-modal-tambah.window="modalTambah = true">

        {{-- Table Toolbar: Search & Filters --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-6">
            <div>
                <h2 class="text-base font-semibold text-slate-800">Daftar Kategori Aduan</h2>
                <p class="mt-1 text-xs text-slate-400">Menampilkan seluruh data kategori aduan terdaftar di sistem</p>
            </div>

            <form action="{{ route('admin.kategori.aduan.index') }}" method="GET"
                class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                {{-- Search Bar --}}
                <div class="relative min-w-60">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau deskripsi..."
                        class="w-full rounded-xl border border-slate-200 bg-white pl-9 pr-4 py-2 text-xs text-slate-700 placeholder-slate-400 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                </div>

                {{-- Filter Status --}}
                <select name="status" onchange="this.form.submit()"
                    class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-600 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                {{-- Tombol Reset --}}
                @if (request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.kategori.aduan.index') }}"
                        class="flex items-center justify-center rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-medium text-slate-500 hover:bg-slate-100 transition">
                        <i class="fa-solid fa-rotate-left mr-1.5"></i> Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Table Scroll Container --}}
        <div class="overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full text-left text-xs">
                <thead
                    class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-100 uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="px-4 py-3.5 w-12 text-center">#</th>
                        <th scope="col" class="px-4 py-3.5">Nama Kategori</th>
                        <th scope="col" class="px-4 py-3.5">Deskripsi</th>
                        <th scope="col" class="px-4 py-3.5 text-center">Jumlah Aduan</th>
                        <th scope="col" class="px-4 py-3.5">Status</th>
                        <th scope="col" class="px-4 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($kategoriAduan as $index => $item)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-3.5 text-center font-medium text-slate-400">
                                {{ $kategoriAduan->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3.5">
                                <p class="font-semibold text-slate-800">{{ $item->nama }}</p>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600 max-w-xs truncate" title="{{ $item->deskripsi }}">
                                {{ $item->deskripsi ?? '-' }}
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <span
                                    class="inline-flex items-center justify-center rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">
                                    {{ number_format($aduan_count ?? 0) }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                @if ($item->is_active)
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Aktif
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-1 text-[11px] font-semibold text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button type="button"
                                        @click="selectedKategori = {{ json_encode($item) }}; modalEdit = true"
                                        title="Edit Kategori"
                                        class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-blue-600 transition">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    @if ($item->is_active)
                                        <button type="button"
                                            @click="selectedKategori = {{ json_encode($item) }}; actionType = 'nonaktifkan'; modalStatus = true"
                                            title="Nonaktifkan Kategori"
                                            class="rounded-lg p-1.5 text-slate-400 hover:bg-amber-50 hover:text-amber-600 transition">
                                            <i class="fa-solid fa-ban"></i>
                                        </button>
                                    @else
                                        <button type="button"
                                            @click="selectedKategori = {{ json_encode($item) }}; actionType = 'aktifkan'; modalStatus = true"
                                            title="Aktifkan Kategori"
                                            class="rounded-lg p-1.5 text-slate-400 hover:bg-emerald-50 hover:text-emerald-600 transition">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </button>
                                    @endif
                                    <button type="button"
                                        @click="selectedKategori = {{ json_encode($item) }}; modalHapus = true"
                                        title="Hapus Kategori"
                                        class="rounded-lg p-1.5 text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-400 text-sm">
                                Belum ada data Kategori Aduan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($kategoriAduan->hasPages())
            <div
                class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-t border-slate-100 pt-4 text-xs text-slate-500">
                <p>
                    Menampilkan <span
                        class="font-semibold text-slate-700">{{ $kategoriAduan->firstItem() ?? 0 }}</span>
                    sampai <span class="font-semibold text-slate-700">{{ $kategoriAduan->lastItem() ?? 0 }}</span>
                    dari <span
                        class="font-semibold text-slate-700">{{ number_format($kategoriAduan->total()) }}</span>
                    kategori
                </p>

                <div class="flex items-center gap-1">
                    {{-- Tombol Sebelumnya --}}
                    @if ($kategoriAduan->onFirstPage())
                        <button type="button" disabled
                            class="rounded-lg border border-slate-200 px-3 py-1.5 font-medium text-slate-400 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed transition">
                            Sebelumnya
                        </button>
                    @else
                        <a href="{{ $kategoriAduan->previousPageUrl() }}"
                            class="rounded-lg border border-slate-200 px-3 py-1.5 font-medium text-slate-600 hover:bg-slate-50 transition">
                            Sebelumnya
                        </a>
                    @endif

                    {{-- Nomor Halaman --}}
                    @foreach ($kategoriAduan->links()->elements as $element)
                        @if (is_string($element))
                            <span class="px-1 text-slate-400">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $kategoriAduan->currentPage())
                                    <button type="button"
                                        class="rounded-lg bg-blue-600 px-3 py-1.5 font-semibold text-white shadow-sm transition">
                                        {{ $page }}
                                    </button>
                                @else
                                    <a href="{{ $url }}"
                                        class="rounded-lg border border-slate-200 px-3 py-1.5 font-medium text-slate-600 hover:bg-slate-50 transition">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Tombol Selanjutnya --}}
                    @if ($kategoriAduan->hasMorePages())
                        <a href="{{ $kategoriAduan->nextPageUrl() }}"
                            class="rounded-lg border border-slate-200 px-3 py-1.5 font-medium text-slate-600 hover:bg-slate-50 transition">
                            Selanjutnya
                        </a>
                    @else
                        <button type="button" disabled
                            class="rounded-lg border border-slate-200 px-3 py-1.5 font-medium text-slate-400 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed transition">
                            Selanjutnya
                        </button>
                    @endif
                </div>
            </div>
        @endif

        {{-- MODAL: Tambah Kategori --}}
        <div x-show="modalTambah" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div x-show="modalTambah" x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" @click="modalTambah = false"
                    class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>

                <div x-show="modalTambah" x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                        <h3 class="text-base font-bold text-slate-800">Tambah Kategori Aduan</h3>
                        <button type="button" @click="modalTambah = false"
                            class="text-slate-400 hover:text-slate-600 transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.kategori.aduan.store') }}" method="POST"
                        class="p-6 space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Kategori</label>
                            <input type="text" name="nama" value="{{ old('nama') }}"
                                placeholder="Contoh: Infrastruktur / Keamanan"
                                class="w-full rounded-xl border @error('nama') border-rose-500 @else border-slate-200 @enderror bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" />
                            @error('nama')
                                <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Kategori</label>
                            <textarea name="deskripsi" rows="3" placeholder="Jelaskan cakupan laporan pada kategori ini..."
                                class="w-full rounded-xl border @error('deskripsi') border-rose-500 @else border-slate-200 @enderror bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-3 pt-2">
                            <button type="button" @click="modalTambah = false"
                                class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                            <button type="submit"
                                class="rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-700 shadow-md shadow-blue-500/20 transition">Simpan
                                Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL: Edit Kategori --}}
        <div x-show="modalEdit" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div x-show="modalEdit" x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" @click="modalEdit = false"
                    class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>

                <div x-show="modalEdit" x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                        <h3 class="text-base font-bold text-slate-800">Edit Kategori Aduan</h3>
                        <button type="button" @click="modalEdit = false"
                            class="text-slate-400 hover:text-slate-600 transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form
                        :action="'{{ url('/admin/kategori/aduan') }}/' + (selectedKategori ? selectedKategori.id : '')"
                        method="POST" class="p-6 space-y-4">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="kategori_id" :value="selectedKategori ? selectedKategori.id : ''">

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Kategori</label>
                            <input type="text" name="nama" x-model="selectedKategori.nama"
                                placeholder="Nama Kategori"
                                class="w-full rounded-xl border @error('nama') border-rose-500 @else border-slate-200 @enderror bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" />
                            @error('nama')
                                <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Kategori</label>
                            <textarea name="deskripsi" rows="3" x-model="selectedKategori.deskripsi" placeholder="Deskripsi Kategori"
                                class="w-full rounded-xl border @error('deskripsi') border-rose-500 @else border-slate-200 @enderror bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"></textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-3 pt-2">
                            <button type="button" @click="modalEdit = false"
                                class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                            <button type="submit"
                                class="rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-700 shadow-md shadow-blue-500/20 transition">Simpan
                                Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL: Ubah Status (Aktif / Nonaktif) --}}
        <div x-show="modalStatus" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div x-show="modalStatus" x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" @click="modalStatus = false"
                    class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>

                <div x-show="modalStatus" x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">

                    <div class="p-6 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full mb-4"
                            :class="actionType === 'nonaktifkan' ? 'bg-amber-100 text-amber-600' :
                                'bg-emerald-100 text-emerald-600'">
                            <i class="fa-solid text-xl"
                                :class="actionType === 'nonaktifkan' ? 'fa-ban' : 'fa-circle-check'"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-800"
                            x-text="actionType === 'nonaktifkan' ? 'Nonaktifkan Kategori?' : 'Aktifkan Kategori?'">
                        </h3>
                        <p class="mt-2 text-xs text-slate-500 leading-relaxed">
                            Apakah Anda yakin ingin <span class="font-semibold" x-text="actionType"></span> kategori
                            <span class="font-semibold text-slate-700"
                                x-text="selectedKategori ? selectedKategori.nama : ''"></span>?
                        </p>

                        <form
                            :action="'{{ url('/admin/kategori/aduan') }}/' + (selectedKategori ? selectedKategori.id : '') +
                            '/status'"
                            method="POST" class="mt-6 flex items-center justify-center gap-3">
                            @csrf
                            @method('PATCH')

                            <button type="button" @click="modalStatus = false"
                                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                                Batal
                            </button>
                            <button type="submit"
                                class="w-full rounded-xl px-4 py-2.5 text-xs font-semibold text-white shadow-md transition"
                                :class="actionType === 'nonaktifkan' ? 'bg-amber-600 hover:bg-amber-700 shadow-amber-500/20' :
                                    'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-500/20'">
                                Ya, <span x-text="actionType === 'nonaktifkan' ? 'Nonaktifkan' : 'Aktifkan'"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL: Hapus Kategori --}}
        <div x-show="modalHapus" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div x-show="modalHapus" x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" @click="modalHapus = false"
                    class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>

                <div x-show="modalHapus" x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">

                    <div class="p-6 text-center">
                        <div
                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-rose-100 text-rose-600 mb-4">
                            <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Hapus Data Kategori?</h3>
                        <p class="mt-2 text-xs text-slate-500 leading-relaxed">
                            Data kategori <span class="font-semibold text-slate-700"
                                x-text="selectedKategori ? selectedKategori.nama : ''"></span> akan dihapus permanen.
                            Tindakan ini tidak dapat dibatalkan.
                        </p>

                        <form
                            :action="'{{ url('/admin/kategori/aduan') }}/' + (selectedKategori ? selectedKategori.id : '')"
                            method="POST" class="mt-6 flex items-center justify-center gap-3">
                            @csrf
                            @method('DELETE')

                            <button type="button" @click="modalHapus = false"
                                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                                Batal
                            </button>
                            <button type="submit"
                                class="w-full rounded-xl bg-rose-600 px-4 py-2.5 text-xs font-semibold text-white shadow-md shadow-rose-500/20 hover:bg-rose-700 transition">
                                Ya, Hapus Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
