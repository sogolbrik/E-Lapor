<x-admin-layout title="Manajemen Seluruh Aduan">

    {{-- Page Header --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Manajemen Seluruh Aduan
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola, filter, dan tindak lanjuti seluruh aduan masuk dari warga.
            </p>
        </div>
    </div>

    {{-- Statistic Cards --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4 mb-8">
        {{-- Total Aduan --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Aduan</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($totalAduan) }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="fa-solid fa-inbox text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Menunggu --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Menunggu Verifikasi</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($totalMenunggu) }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <i class="fa-solid fa-clock text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Diproses --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Sedang Diproses</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($totalDiproses) }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="fa-solid fa-[#0B57D0] fa-spinner text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Selesai --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Telah Selesai</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($totalSelesai) }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Container --}}
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60" x-data="{ modalHapus: false, selectedAduan: null }">

        {{-- Flash Message --}}
        @if (session('success'))
            <div
                class="mb-6 rounded-xl bg-emerald-50 p-4 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20 flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Toolbar: Search & Filter --}}
        <form action="{{ route('admin.aduan.index') }}" method="GET"
            class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="relative flex-1 min-w-60">
                <i
                    class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari No. Tiket, Judul, Pelapor..."
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 pl-9 pr-4 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition">
            </div>

            <div class="flex flex-wrap items-center gap-3">
                {{-- Filter Kategori --}}
                <select name="kategori_id" onchange="this.form.submit()"
                    class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-600 outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 cursor-pointer transition">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategori as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter Status --}}
                <select name="status" onchange="this.form.submit()"
                    class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-600 outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 cursor-pointer transition">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>

                {{-- Filter Wilayah (Desa) --}}
                <select name="desa_id" onchange="this.form.submit()"
                    class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-600 outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 cursor-pointer transition">
                    <option value="">Semua Wilayah</option>
                    @foreach ($desa as $d)
                        <option value="{{ $d->id }}" {{ request('desa_id') == $d->id ? 'selected' : '' }}>
                            {{ $d->nama }}
                        </option>
                    @endforeach
                </select>

                {{-- Reset --}}
                @if (request()->hasAny(['search', 'kategori_id', 'status', 'desa_id']))
                    <a href="{{ route('admin.aduan.index') }}"
                        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-200 transition">
                        <i class="fa-solid fa-rotate-right"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto rounded-xl border border-slate-200/60">
            <table class="w-full text-left text-xs">
                <thead
                    class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-200/60">
                    <tr>
                        <th scope="col" class="px-4 py-3.5">No. Tiket</th>
                        <th scope="col" class="px-4 py-3.5">Pelapor</th>
                        <th scope="col" class="px-4 py-3.5">Judul & Kategori</th>
                        <th scope="col" class="px-4 py-3.5">Wilayah</th>
                        <th scope="col" class="px-4 py-3.5">Tanggal</th>
                        <th scope="col" class="px-4 py-3.5">Status</th>
                        <th scope="col" class="px-4 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($aduan as $item)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-3.5 font-bold text-blue-600">
                                <a href="{{ route('admin.aduan.show', $item->id) }}" class="hover:underline">
                                    {{ $item->tiket }}
                                </a>
                            </td>
                            <td class="px-4 py-3.5">
                                @if ($item->is_anonymous)
                                    <span class="inline-flex items-center gap-1 text-slate-500 italic">
                                        <i class="fa-solid fa-user-secret text-slate-400"></i> Anonim
                                    </span>
                                @else
                                    <span class="font-medium text-slate-800">{{ $item->user->name ?? '-' }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5">
                                <p class="font-semibold text-slate-800 line-clamp-1">{{ $item->judul }}</p>
                                <span class="text-[11px] text-slate-400">{{ $item->kategoriAduan->nama ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-slate-500">
                                {{ $item->desa->nama ?? '-' }}
                            </td>
                            <td class="px-4 py-3.5 text-slate-400">
                                {{ $item->created_at->translatedFormat('d M Y H:i') }}
                            </td>
                            <td class="px-4 py-3.5">
                                @php
                                    $statusStyle = match ($item->status) {
                                        'Menunggu' => 'bg-amber-50 text-amber-700 ring-amber-600/20 dot-bg-amber-500',
                                        'Diproses' => 'bg-blue-50 text-blue-700 ring-blue-600/20 dot-bg-blue-500',
                                        'Selesai'
                                            => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20 dot-bg-emerald-500',
                                        'Ditolak' => 'bg-rose-50 text-rose-700 ring-rose-600/20 dot-bg-rose-500',
                                    };
                                    $dotColor = match ($item->status) {
                                        'Menunggu' => 'bg-amber-500',
                                        'Diproses' => 'bg-blue-500',
                                        'Selesai' => 'bg-emerald-500',
                                        'Ditolak' => 'bg-rose-500',
                                    };
                                @endphp
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[11px] font-semibold ring-1 ring-inset {{ $statusStyle }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $dotColor }}"></span>
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.aduan.show', $item->id) }}" title="Detail Aduan"
                                        class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-blue-600 transition">
                                        <i class="fa-solid fa-eye text-sm"></i>
                                    </a>
                                    <button type="button"
                                        @click="selectedAduan = {{ json_encode($item) }}; modalHapus = true"
                                        title="Hapus Aduan"
                                        class="rounded-lg p-1.5 text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-400">
                                Tidak ada data aduan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($aduan->hasPages())
            <div class="mt-5 border-t border-slate-100 pt-4">
                {{ $aduan->links() }}
            </div>
        @endif

        {{-- Modal Hapus --}}
        <div x-show="modalHapus" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div x-show="modalHapus" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" @click="modalHapus = false"
                    class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>

                <div x-show="modalHapus" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white p-6 text-center shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">

                    <div
                        class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                        <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                    </div>

                    <h3 class="mt-4 text-base font-bold text-slate-800">Hapus Data Aduan?</h3>
                    <p class="mt-2 text-xs text-slate-500">
                        Apakah Anda yakin ingin menghapus aduan dengan tiket <span class="font-semibold text-slate-700"
                            x-text="selectedAduan ? selectedAduan.tiket : ''"></span>? Tindakan ini tidak dapat
                        dibatalkan.
                    </p>

                    <form :action="'{{ url('/admin/aduan') }}/' + (selectedAduan ? selectedAduan.id : '')"
                        method="POST" class="mt-6 flex items-center justify-center gap-3">
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
