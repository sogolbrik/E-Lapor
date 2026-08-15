<x-admin-layout title="Master User">

    {{-- Page Header --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Master User
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola data seluruh pengguna, serta status keaktifan setiap akun.
            </p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Tombol Tambah User --}}
            <button type="button" @click="$dispatch('open-modal-tambah')"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-semibold text-white shadow-md shadow-blue-500/20 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition">
                <i class="fa-solid fa-user-plus text-sm"></i>
                <span>Tambah User</span>
            </button>
        </div>
    </div>

    {{-- Statistic Cards --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
        {{-- Card 1: Total User --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-500 truncate">Total User Terdaftar</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($totalUser) }}</h3>
                    <p class="mt-2 text-xs font-medium text-emerald-600 flex items-center gap-1">
                        <i class="fa-solid fa-arrow-up"></i>
                        <span>+{{ number_format($userBulanIni) }} User bulan ini</span>
                    </p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>
            </div>
        </div>

        {{-- Card 2: Akun Aktif --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-500 truncate">Akun Aktif</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($akunAktif) }}</h3>
                    <p class="mt-2 text-xs font-medium text-emerald-600 flex items-center gap-1">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ $persenAktif }}% terverifikasi</span>
                    </p>
                </div>
                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i class="fa-solid fa-user-check text-lg"></i>
                </div>
            </div>
        </div>

        {{-- Card 3: Akun Nonaktif --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-500 truncate">Akun Nonaktif</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($akunNonaktif) }}</h3>
                    <p class="mt-2 text-xs font-medium text-rose-600 flex items-center gap-1">
                        <i class="fa-solid fa-user-slash"></i>
                        <span>{{ $persenNonaktif }}% dibekukan / ditangguhkan</span>
                    </p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                    <i class="fa-solid fa-user-xmark text-lg"></i>
                </div>
            </div>
        </div>

        {{-- Card 4: Total Desa --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-500 truncate">Cakupan Wilayah</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($totalDesa) }}</h3>
                    <p class="mt-2 text-xs font-medium text-violet-600 flex items-center gap-1">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Desa / Kelurahan</span>
                    </p>
                </div>
                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                    <i class="fa-solid fa-map-location-dot text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Data Section --}}
    <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 min-w-0" x-data="{
        modalTambah: false,
        modalEdit: false,
        modalStatus: false,
        modalHapus: false,
        selectedUser: null,
        actionType: ''
    }"
        @open-modal-tambah.window="modalTambah = true">

        {{-- Table Toolbar: Search & Filters --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-6">
            <div>
                <h2 class="text-base font-semibold text-slate-800">Daftar User</h2>
                <p class="mt-1 text-xs text-slate-400">Menampilkan seluruh data User terdaftar di sistem</p>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                {{-- Search Bar --}}
                <div class="relative min-w-60">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" placeholder="Cari NIK, Nama, No. HP..."
                        class="w-full rounded-xl border border-slate-200 bg-white pl-9 pr-4 py-2 text-xs text-slate-700 placeholder-slate-400 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                </div>

                {{-- Filter Desa --}}
                <select
                    class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-600 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                    <option value="">Semua Desa</option>
                    <option value="sukamaju">Desa Sukamaju</option>
                    <option value="harapan">Desa Harapan</option>
                    <option value="makmur">Desa Makmur</option>
                    <option value="sejahtera">Desa Sejahtera</option>
                </select>

                {{-- Filter Status --}}
                <select
                    class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-600 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
        </div>

        {{-- Table Scroll Container --}}
        <div class="overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full text-left text-xs">
                <thead
                    class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-100 uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="px-4 py-3.5">NIK</th>
                        <th scope="col" class="px-4 py-3.5">Nama User</th>
                        <th scope="col" class="px-4 py-3.5">Desa</th>
                        <th scope="col" class="px-4 py-3.5">Kontak</th>
                        <th scope="col" class="px-4 py-3.5">Role</th>
                        <th scope="col" class="px-4 py-3.5">Status Akun</th>
                        <th scope="col" class="px-4 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($user as $item)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-3.5 font-mono font-medium text-slate-600">
                                {{ $item->nik ?? '-' }}
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold text-xs">
                                        {{ strtoupper(substr($item->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-800">{{ $item->name }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $item->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600">
                                {{ $item->desa->nama ?? '-' }}
                            </td>
                            <td class="px-4 py-3.5 text-slate-600">
                                {{ $item->no_hp ?? '-' }}
                            </td>
                            <td class="px-4 py-3.5 text-slate-400">
                                @php
                                    $roleConfig = match ($item->role) {
                                        'Admin' => [
                                            'bg' => 'bg-slate-100',
                                            'text' => 'text-slate-700',
                                            'icon' => 'fa-shield-halved',
                                            'label' => 'Admin',
                                        ],
                                        'Petugas' => [
                                            'bg' => 'bg-blue-100',
                                            'text' => 'text-blue-700',
                                            'icon' => 'fa-user-tie',
                                            'label' => 'Petugas',
                                        ],
                                        default => [
                                            'bg' => 'bg-slate-100',
                                            'text' => 'text-slate-600',
                                            'icon' => 'fa-user',
                                            'label' => 'Warga',
                                        ],
                                    };
                                @endphp
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full {{ $roleConfig['bg'] }} px-2.5 py-1 text-[11px] font-semibold {{ $roleConfig['text'] }}">
                                    <i class="fa-solid {{ $roleConfig['icon'] }}"></i>
                                    {{ $roleConfig['label'] }}
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
                            @if ($item->role !== 'Admin')
                                <td class="px-4 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button type="button"
                                            @click="selectedUser = {{ json_encode($item) }}; modalEdit = true"
                                            title="Edit User"
                                            class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-blue-600 transition">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        @if ($item->is_active)
                                            <button type="button"
                                                @click="selectedUser = {{ json_encode($item) }}; actionType = 'nonaktifkan'; modalStatus = true"
                                                title="Nonaktifkan Akun"
                                                class="rounded-lg p-1.5 text-slate-400 hover:bg-amber-50 hover:text-amber-600 transition">
                                                <i class="fa-solid fa-user-slash"></i>
                                            </button>
                                        @else
                                            <button type="button"
                                                @click="selectedUser = {{ json_encode($item) }}; actionType = 'aktifkan'; modalStatus = true"
                                                title="Aktifkan Akun"
                                                class="rounded-lg p-1.5 text-slate-400 hover:bg-emerald-50 hover:text-emerald-600 transition">
                                                <i class="fa-solid fa-user-check"></i>
                                            </button>
                                        @endif
                                        <button type="button"
                                            @click="selectedUser = {{ json_encode($item) }}; modalHapus = true"
                                            title="Hapus User"
                                            class="rounded-lg p-1.5 text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-400 text-sm">
                                Belum ada data User.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div
            class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-t border-slate-100 pt-4 text-xs text-slate-500">
            <p>Menampilkan <span class="font-semibold text-slate-700">1</span> sampai <span
                    class="font-semibold text-slate-700">5</span> dari <span
                    class="font-semibold text-slate-700">2,845</span> user</p>
            <div class="flex items-center gap-1">
                <button type="button" disabled
                    class="rounded-lg border border-slate-200 px-3 py-1.5 font-medium text-slate-400 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed transition">
                    Sebelumnya
                </button>
                <button type="button"
                    class="rounded-lg bg-blue-600 px-3 py-1.5 font-semibold text-white shadow-sm transition">1</button>
                <button type="button"
                    class="rounded-lg border border-slate-200 px-3 py-1.5 font-medium text-slate-600 hover:bg-slate-50 transition">2</button>
                <button type="button"
                    class="rounded-lg border border-slate-200 px-3 py-1.5 font-medium text-slate-600 hover:bg-slate-50 transition">3</button>
                <span class="px-1 text-slate-400">...</span>
                <button type="button"
                    class="rounded-lg border border-slate-200 px-3 py-1.5 font-medium text-slate-600 hover:bg-slate-50 transition">570</button>
                <button type="button"
                    class="rounded-lg border border-slate-200 px-3 py-1.5 font-medium text-slate-600 hover:bg-slate-50 transition">
                    Selanjutnya
                </button>
            </div>
        </div>

        {{-- MODAL: Tambah User --}}
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
                        <h3 class="text-base font-bold text-slate-800">Tambah Data User</h3>
                        <button type="button" @click="modalTambah = false"
                            class="text-slate-400 hover:text-slate-600 transition"><i
                                class="fa-solid fa-xmark text-lg"></i></button>
                    </div>
                    <form action="{{ route('admin.user.store') }}" method="POST" class="p-6 space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">NIK (Nomor Induk
                                Kependudukan)</label>
                            <input type="text" name="nik" value="{{ old('nik') }}"
                                placeholder="Masukkan 16 digit NIK"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                                required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                placeholder="Masukkan nama lengkap user"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                                required />
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    placeholder="contoh@email.com"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                                    required />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">No. WhatsApp /
                                    HP</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                    placeholder="628xxxxxxxxxx"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                                    required />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
                                <input type="password" name="password" value="{{ old('password') }}"
                                    placeholder="Buat password user"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                                    required />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Role</label>
                                <select name="role"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                                    required>
                                    <option selected disabled>Pilih Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Petugas">Petugas</option>
                                    <option value="Warga">Warga</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Desa / Kelurahan</label>
                            <select name="desa_id"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                                required>
                                <option selected disabled>Pilih Desa</option>
                                @foreach ($desa as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
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

        {{-- MODAL: Edit User --}}
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
                        <h3 class="text-base font-bold text-slate-800">Edit Data User</h3>
                        <button type="button" @click="modalEdit = false"
                            class="text-slate-400 hover:text-slate-600 transition"><i
                                class="fa-solid fa-xmark text-lg"></i></button>
                    </div>
                    <form @submit.prevent="modalEdit = false" class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">NIK</label>
                            <input type="text" value="3515081204950001"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs text-slate-500 outline-none cursor-not-allowed"
                                disabled />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                            <input type="text" x-bind:value="selectedUser"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                                required />
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                                <input type="email" value="user@gmail.com"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                                    required />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">No. WhatsApp /
                                    HP</label>
                                <input type="text" value="081234567890"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                                    required />
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Desa / Kelurahan</label>
                            <select
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                                <option value="1" selected>Desa Sukamaju</option>
                                <option value="2">Desa Harapan</option>
                                <option value="3">Desa Makmur</option>
                            </select>
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

        {{-- MODAL: Konfirmasi Status Akun (Aktifkan / Nonaktifkan) --}}
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
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md p-6 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full"
                        :class="actionType === 'aktifkan' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600'">
                        <i class="fa-solid text-lg"
                            :class="actionType === 'aktifkan' ? 'fa-user-check' : 'fa-user-slash'"></i>
                    </div>
                    <h3 class="mt-4 text-base font-bold text-slate-800"
                        x-text="actionType === 'aktifkan' ? 'Aktifkan Akun User?' : 'Nonaktifkan Akun User?'"></h3>
                    <p class="mt-2 text-xs text-slate-500">
                        Apakah Anda yakin ingin <span class="font-semibold text-slate-700" x-text="actionType"></span>
                        akun atas nama <span class="font-semibold text-slate-700" x-text="selectedUser"></span>?
                    </p>
                    <div class="mt-6 flex items-center justify-center gap-3">
                        <button type="button" @click="modalStatus = false"
                            class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                        <button type="button" @click="modalStatus = false"
                            class="rounded-xl px-4 py-2 text-xs font-semibold text-white shadow-md transition"
                            :class="actionType === 'aktifkan' ? 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-500/20' :
                                'bg-amber-600 hover:bg-amber-700 shadow-amber-500/20'">
                            Ya, Konfirmasi
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL: Hapus User --}}
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
                    <h3 class="mt-4 text-base font-bold text-slate-800">Hapus Data User?</h3>
                    <p class="mt-2 text-xs text-slate-500">
                        Apakah Anda yakin ingin menghapus data user <span class="font-semibold text-slate-700"
                            x-text="selectedUser"></span>? Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <div class="mt-6 flex items-center justify-center gap-3">
                        <button type="button" @click="modalHapus = false"
                            class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">Batal</button>
                        <button type="button" @click="modalHapus = false"
                            class="rounded-xl bg-rose-600 px-4 py-2 text-xs font-semibold text-white hover:bg-rose-700 shadow-md shadow-rose-500/20 transition">
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-admin-layout>
