<x-admin-layout title="Profil Saya">

    {{-- Page Header --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Pengaturan Profil
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola informasi akun, foto profil, serta keamanan kata sandi Anda.
            </p>
        </div>
    </div>

    {{-- Flash Message Success --}}
    @if (session('success'))
        <div
            class="mb-6 flex items-center gap-3 rounded-2xl bg-emerald-50 p-4 border border-emerald-200 text-emerald-800 text-xs font-semibold">
            <i class="fa-solid fa-circle-check text-base text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3" x-data="{ modalHapusAkun: false }">

        {{-- Column Kiri: Ringkasan Card Profil --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 text-center">
                <div class="relative mx-auto h-24 w-24">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                            class="h-24 w-24 rounded-full object-cover ring-4 ring-blue-50 shadow-md">
                    @else
                        <div
                            class="flex h-24 w-24 items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold text-2xl ring-4 ring-blue-50 shadow-md">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                </div>

                <h2 class="mt-4 text-base font-bold text-slate-800">{{ $user->name }}</h2>
                <p class="text-xs text-slate-400 font-mono mt-0.5">{{ $user->email }}</p>

                <div class="mt-4 flex items-center justify-center gap-2">
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-[11px] font-semibold text-slate-700">
                        <i class="fa-solid fa-shield-halved text-blue-600"></i>
                        {{ $user->role }}
                    </span>
                    @if ($user->is_active)
                        <span
                            class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Aktif
                        </span>
                    @endif
                </div>

                <div class="mt-6 border-t border-slate-100 pt-4 text-left space-y-3 text-xs text-slate-600">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">NIK</span>
                        <span class="font-mono font-semibold text-slate-700">{{ $user->nik ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">No. WhatsApp / HP</span>
                        <span class="font-medium text-slate-700">{{ $user->no_hp ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Wilayah / Desa</span>
                        <span class="font-medium text-slate-700">{{ $user->desa->nama ?? '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- Card Hapus Akun (Zona Bahaya) --}}
            <div class="rounded-2xl bg-rose-50/50 p-6 shadow-sm ring-1 ring-rose-200/60">
                <h3 class="text-xs font-bold text-rose-800 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Zona Bahaya</span>
                </h3>
                <p class="mt-2 text-xs text-rose-600/80 leading-relaxed">
                    Menghapus akun Anda akan menghapus seluruh data terkait secara permanen dari sistem.
                </p>
                <button type="button" @click="modalHapusAkun = true"
                    class="mt-4 w-full rounded-xl bg-rose-600 px-4 py-2.5 text-xs font-semibold text-white shadow-md shadow-rose-500/20 hover:bg-rose-700 transition">
                    Hapus Akun Saya
                </button>
            </div>
        </div>

        {{-- Column Kanan: Form Edit Data & Password --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Form Informas Profil --}}
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60">
                <div class="border-b border-slate-100 pb-4 mb-6">
                    <h2 class="text-base font-semibold text-slate-800">Informasi Akun</h2>
                    <p class="mt-1 text-xs text-slate-400">Perbarui data pribadi dan foto profil Anda.</p>
                </div>

                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    @method('PUT')

                    {{-- Upload Avatar --}}
                    <div x-data="{ photoPreview: null }">
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Foto Profil</label>
                        <div class="flex items-center gap-4">
                            <div
                                class="h-16 w-16 shrink-0 rounded-full bg-slate-100 overflow-hidden ring-2 ring-slate-200">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="h-full w-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    @if ($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}"
                                            class="h-full w-full object-cover">
                                    @else
                                        <div
                                            class="flex h-full w-full items-center justify-center bg-blue-100 text-blue-600 font-bold text-sm">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                    @endif
                                </template>
                            </div>
                            <label
                                class="cursor-pointer rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs font-medium text-slate-600 hover:bg-slate-100 transition">
                                <i class="fa-solid fa-camera mr-1.5 text-slate-400"></i> Pilih Foto Baru
                                <input type="file" name="avatar" class="hidden" accept="image/*"
                                    @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL(file); }" />
                            </label>
                        </div>
                        @error('avatar')
                            <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">NIK (Nomor Induk
                                Kependudukan)</label>
                            <input type="text" name="nik" value="{{ old('nik', $user->nik) }}"
                                placeholder="16 digit NIK"
                                class="w-full rounded-xl border @error('nik') border-rose-500 @else border-slate-200 @enderror bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" />
                            @error('nik')
                                <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                placeholder="Nama lengkap"
                                class="w-full rounded-xl border @error('name') border-rose-500 @else border-slate-200 @enderror bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" />
                            @error('name')
                                <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                placeholder="contoh@email.com"
                                class="w-full rounded-xl border @error('email') border-rose-500 @else border-slate-200 @enderror bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" />
                            @error('email')
                                <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">No. WhatsApp / HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                placeholder="628xxxxxxxxxx"
                                class="w-full rounded-xl border @error('no_hp') border-rose-500 @else border-slate-200 @enderror bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" />
                            @error('no_hp')
                                <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Desa / Kelurahan</label>
                        <select name="desa_id"
                            class="w-full rounded-xl border @error('desa_id') border-rose-500 @else border-slate-200 @enderror bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                            <option value="">Pilih Desa</option>
                            @foreach ($desa as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('desa_id', $user->desa_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('desa_id')
                            <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6 flex items-center justify-end pt-2">
                        <button type="submit"
                            class="rounded-xl bg-blue-600 px-5 py-2.5 text-xs font-semibold text-white hover:bg-blue-700 shadow-md shadow-blue-500/20 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Form Ganti Password --}}
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60">
                <div class="border-b border-slate-100 pb-4 mb-6">
                    <h2 class="text-base font-semibold text-slate-800">Ubah Kata Sandi</h2>
                    <p class="mt-1 text-xs text-slate-400">Pastikan akun Anda menggunakan kata sandi yang kuat dan
                        aman.</p>
                </div>

                <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi Saat Ini</label>
                        <input type="password" name="current_password" placeholder="••••••••"
                            class="w-full rounded-xl border @error('current_password') border-rose-500 @else border-slate-200 @enderror bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" />
                        @error('current_password')
                            <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi Baru</label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter"
                                class="w-full rounded-xl border @error('password') border-rose-500 @else border-slate-200 @enderror bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" />
                            @error('password')
                                <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Kata Sandi
                                Baru</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" />
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end pt-2">
                        <button type="submit"
                            class="rounded-xl bg-blue-600 px-5 py-2.5 text-xs font-semibold text-white hover:bg-blue-700 shadow-md shadow-blue-500/20 transition">
                            Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

        </div>

        {{-- MODAL: Konfirmasi Hapus Akun Sendiri --}}
        <div x-show="modalHapusAkun" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div x-show="modalHapusAkun" x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" @click="modalHapusAkun = false"
                    class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>

                <div x-show="modalHapusAkun" x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md p-6 text-center">

                    <div
                        class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-rose-100 text-rose-600">
                        <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                    </div>

                    <h3 class="mt-4 text-base font-bold text-slate-800">Apakah Anda Yakin Ingin Menghapus Akun?</h3>
                    <p class="mt-2 text-xs text-slate-500 leading-relaxed">
                        Tindakan ini tidak dapat dibatalkan. Masukkan kata sandi Anda untuk mengonfirmasi penghapusan
                        akun permanen.
                    </p>

                    <form action="{{ route('admin.profile.destroy') }}" method="POST"
                        class="mt-6 text-left space-y-4">
                        @csrf
                        @method('DELETE')

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Kata
                                Sandi</label>
                            <input type="password" name="password" placeholder="Masukkan kata sandi Anda" required
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs text-slate-700 outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 transition" />
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button type="button" @click="modalHapusAkun = false"
                                class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                                Batal
                            </button>
                            <button type="submit"
                                class="rounded-xl bg-rose-600 px-4 py-2 text-xs font-semibold text-white hover:bg-rose-700 shadow-md shadow-rose-500/20 transition">
                                Ya, Hapus Akun Saya
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</x-admin-layout>
