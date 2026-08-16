<x-admin-layout title="Master Desa">

    {{-- Page Header --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Master Desa
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola data seluruh desa dan kelurahan yang terdaftar di sistem.
            </p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Tombol Tambah Desa --}}
            <button type="button" @click="$dispatch('open-modal-tambah')"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-semibold text-white shadow-md shadow-blue-500/20 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition">
                <i class="fa-solid fa-plus text-sm"></i>
                <span>Tambah Desa</span>
            </button>
        </div>
    </div>

    {{-- Statistic Cards --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
        {{-- Card 1: Total Desa --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-500 truncate">Total Desa Terdaftar</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($totalDesa) }}</h3>
                    <p class="mt-2 text-xs font-medium text-emerald-600 flex items-center gap-1">
                        <i class="fa-solid fa-arrow-up"></i>
                        <span>+{{ number_format($desaBulanIni) }} Desa bulan ini</span>
                    </p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="fa-solid fa-map-location-dot text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Data Section --}}
    <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 min-w-0" x-data="{
        modalTambah: {{ $errors->any() && !old('_method') ? 'true' : 'false' }},
        modalEdit: {{ $errors->any() && old('_method') == 'PUT' ? 'true' : 'false' }},
        modalHapus: false,
        selectedDesa: {{ old('_method') == 'PUT'
            ? json_encode([
                'id' => old('desa_id'),
                'nama' => old('nama'),
            ])
            : 'null' }}
    }"
        @open-modal-tambah.window="modalTambah = true">

        {{-- Table Toolbar: Search & Filters --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-6">
            <div>
                <h2 class="text-base font-semibold text-slate-800">Daftar Desa</h2>
                <p class="mt-1 text-xs text-slate-400">Menampilkan seluruh data Desa terdaftar di sistem</p>
            </div>

            <form action="{{ route('admin.desa.index') }}" method="GET"
                class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                {{-- Search Bar --}}
                <div class="relative min-w-60">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Desa..."
                        class="w-full rounded-xl border border-slate-200 bg-white pl-9 pr-4 py-2 text-xs text-slate-700 placeholder-slate-400 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                </div>

                {{-- Tombol Reset --}}
                @if (request()->has('search'))
                    <a href="{{ route('admin.desa.index') }}"
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
                        <th scope="col" class="px-4 py-3.5 w-16">ID</th>
                        <th scope="col" class="px-4 py-3.5">Nama Desa</th>
                        <th scope="col" class="px-4 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($desas as $item)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-3.5 font-mono font-medium text-slate-600">
                                {{ $item->id }}
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold text-xs">
                                        <i class="fa-solid fa-building-columns"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-800">{{ $item->nama }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button type="button"
                                        @click="selectedDesa = {{ json_encode($item) }}; modalEdit = true"
                                        title="Edit Desa"
                                        class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-blue-600 transition">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button type="button"
                                        @click="selectedDesa = {{ json_encode($item) }}; modalHapus = true"
                                        title="Hapus Desa"
                                        class="rounded-lg p-1.5 text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-slate-400 text-sm">
                                Belum ada data Desa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($desas->hasPages())
            <div
                class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-t border-slate-100 pt-4 text-xs text-slate-500">
                <p>
                    Menampilkan <span class="font-semibold text-slate-700">{{ $desas->firstItem() ?? 0 }}</span>
                    sampai <span class="font-semibold text-slate-700">{{ $desas->lastItem() ?? 0 }}</span>
                    dari <span class="font-semibold text-slate-700">{{ number_format($desas->total()) }}</span> desa
                </p>

                <div class="flex items-center gap-1">
                    @if ($desas->onFirstPage())
                        <button type="button" disabled
                            class="rounded-lg border border-slate-200 px-3 py-1.5 font-medium text-slate-400 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed transition">
                            Sebelumnya
                        </button>
                    @else
                        <a href="{{ $desas->previousPageUrl() }}"
                            class="rounded-lg border border-slate-200 px-3 py-1.5 font-medium text-slate-600 hover:bg-slate-50 transition">
                            Sebelumnya
                        </a>
                    @endif

                    @foreach ($desas->links()->elements as $element)
                        @if (is_string($element))
                            <span class="px-1 text-slate-400">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $desas->currentPage())
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

                    @if ($desas->hasMorePages())
                        <a href="{{ $desas->nextPageUrl() }}"
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

        {{-- MODAL: Tambah Desa --}}
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
                        <h3 class="text-base font-bold text-slate-800">Tambah Data Desa</h3>
                        <button type="button" @click="modalTambah = false"
                            class="text-slate-400 hover:text-slate-600 transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.desa.store') }}" method="POST" class="p-6 space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Desa</label>
                            <input type="text" name="nama" value="{{ old('nama') }}"
                                placeholder="Masukkan nama desa"
                                class="w-full rounded-xl border @error('nama') border-rose-500 @else border-slate-200 @enderror bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" />
                            @error('nama')
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

        {{-- MODAL: Edit Desa --}}
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
                        <h3 class="text-base font-bold text-slate-800">Edit Data Desa</h3>
                        <button type="button" @click="modalEdit = false"
                            class="text-slate-400 hover:text-slate-600 transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form :action="'{{ url('/admin/desa') }}/' + (selectedDesa ? selectedDesa.id : '')" method="POST"
                        class="p-6 space-y-4">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="desa_id" :value="selectedDesa ? selectedDesa.id : ''">

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Desa</label>
                            <input type="text" name="nama" x-model="selectedDesa.nama"
                                placeholder="Masukkan nama desa"
                                class="w-full rounded-xl border @error('nama') border-rose-500 @else border-slate-200 @enderror bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" />
                            @error('nama')
                                <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-3 pt-2">
                            <button type="button" @click="modalEdit = false"
                                class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                            <button type="submit"
                                class="rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-700 shadow-md shadow-blue-500/20 transition">Perbarui
                                Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL: Hapus Desa --}}
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
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md p-6 text-center">

                    <div
                        class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-rose-100 text-rose-600">
                        <i class="fa-solid fa-trash-can text-lg"></i>
                    </div>

                    <h3 class="mt-4 text-base font-bold text-slate-800">Hapus Data Desa?</h3>
                    <p class="mt-2 text-xs text-slate-500">
                        Apakah Anda yakin ingin menghapus data desa <span class="font-semibold text-slate-700"
                            x-text="selectedDesa ? selectedDesa.nama : ''"></span>? Tindakan ini tidak dapat
                        dibatalkan.
                    </p>

                    <form :action="'{{ url('/admin/desa') }}/' + (selectedDesa ? selectedDesa.id : '')" method="POST"
                        class="mt-6 flex items-center justify-center gap-3">
                        @csrf
                        @method('DELETE')

                        <button type="button" @click="modalHapus = false"
                            class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="rounded-xl bg-rose-600 px-4 py-2 text-xs font-semibold text-white hover:bg-rose-700 shadow-md shadow-rose-500/20 transition">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</x-admin-layout>
