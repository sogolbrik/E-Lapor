<x-warga-layout title="Profil Saya">
    <div class="space-y-6 max-w-6xl mx-auto">

        {{-- Bento Grid Container --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

            {{-- Tile 1: Header / Welcome Banner (12 Cols) --}}
            <div
                class="lg:col-span-12 bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold mb-1">
                        <i class="fa-solid fa-user-gear text-xs"></i>
                        Pengaturan Akun Warga
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">
                        Profil & Keamanan Akun
                    </h1>
                    <p class="text-xs md:text-sm text-slate-500 max-w-xl">
                        Kelola informasi identitas domisili, foto profil, serta kredensial keamanan akun E-Lapor Anda.
                    </p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200/60 text-xs font-medium">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Akun Aktif
                    </span>
                </div>
            </div>

            {{-- MAIN FORM: Profil & Avatar --}}
            <form method="POST" action="{{ route('warga.profile.update') }}" enctype="multipart/form-data"
                class="lg:col-span-12 grid grid-cols-1 lg:grid-cols-12 gap-5">
                @csrf
                @method('PUT')

                {{-- Tile 2: Avatar & Profile Card (4 Cols) --}}
                <div x-data="{ photoName: null, photoPreview: null }"
                    class="lg:col-span-4 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs flex flex-col items-center text-center justify-between h-full">
                    <div class="w-full space-y-4 flex flex-col items-center">
                        <div class="text-left w-full border-b border-slate-100 pb-3">
                            <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-camera text-blue-600"></i>
                                Foto Profil
                            </h2>
                        </div>

                        {{-- Avatar Preview --}}
                        <div class="relative group my-2">
                            <template x-if="!photoPreview">
                                @if ($user->avatar)
                                    <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}"
                                        class="w-32 h-32 rounded-3xl object-cover border-2 border-slate-100 shadow-md">
                                @else
                                    <div
                                        class="w-32 h-32 rounded-3xl bg-linear-to-br from-blue-500 to-indigo-600 text-white font-bold text-4xl flex items-center justify-center border-2 border-slate-100 shadow-md">
                                        {{ strtoupper(substr($user->name ?? 'W', 0, 1)) }}
                                    </div>
                                @endif
                            </template>

                            <template x-if="photoPreview">
                                <span
                                    class="block w-32 h-32 rounded-3xl bg-cover bg-no-repeat bg-center border-2 border-slate-100 shadow-md"
                                    :style="'background-image: url(\'' + photoPreview + '\');'">
                                </span>
                            </template>
                        </div>

                        <div class="space-y-1">
                            <h3 class="text-base font-bold text-slate-900">{{ $user->name }}</h3>
                            <p class="text-xs text-slate-500">{{ $user->email }}</p>
                        </div>

                        <input type="file" name="avatar" id="avatar" class="hidden" x-ref="avatar"
                            x-on:change="
                                photoName = $refs.avatar.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => { photoPreview = e.target.result; };
                                reader.readAsDataURL($refs.avatar.files[0]);
                            ">

                        <button type="button" x-on:click.prevent="$refs.avatar.click()"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-xs font-semibold text-slate-700 transition-colors shadow-2xs">
                            <i class="fa-solid fa-cloud-arrow-up text-slate-500"></i>
                            Unggah Foto Baru
                        </button>
                        <p class="text-[11px] text-slate-400">JPG, PNG, WEBP. Max 2MB.</p>
                        @error('avatar')
                            <p class="text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full pt-4 border-t border-slate-100 mt-4">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium transition-colors shadow-xs">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Simpan Profil
                        </button>
                    </div>
                </div>

                {{-- Tile 3: Personal Data Inputs (8 Cols) --}}
                <div
                    class="lg:col-span-8 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs flex flex-col justify-between">
                    <div class="space-y-5">
                        <div class="border-b border-slate-100 pb-3">
                            <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-id-card text-blue-600"></i>
                                Informasi Pribadi & Domisili
                            </h2>
                            <p class="text-xs text-slate-500 mt-0.5">Lengkapi data kependudukan Anda untuk validasi
                                laporan.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            {{-- NIK --}}
                            <div>
                                <label for="nik" class="block text-xs font-semibold text-slate-700 mb-1.5">NIK
                                    <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <input type="text" name="nik" id="nik"
                                        value="{{ old('nik', $user->nik) }}" required maxlength="16"
                                        placeholder="16 digit NIK"
                                        class="w-full pl-9 pr-3 py-2.5 text-xs rounded-xl border @error('nik') border-rose-500 bg-rose-50/20 @else border-slate-200 bg-slate-50/50 focus:bg-white @enderror text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-600">
                                    <i
                                        class="fa-solid fa-address-card absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                                </div>
                                @error('nik')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nama --}}
                            <div>
                                <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama
                                    Lengkap <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $user->name) }}" required placeholder="Nama lengkap"
                                        class="w-full pl-9 pr-3 py-2.5 text-xs rounded-xl border @error('name') border-rose-500 bg-rose-50/20 @else border-slate-200 bg-slate-50/50 focus:bg-white @enderror text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-600">
                                    <i
                                        class="fa-solid fa-user absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                                </div>
                                @error('name')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Email
                                    <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $user->email) }}" required placeholder="nama@email.com"
                                        class="w-full pl-9 pr-3 py-2.5 text-xs rounded-xl border @error('email') border-rose-500 bg-rose-50/20 @else border-slate-200 bg-slate-50/50 focus:bg-white @enderror text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-600">
                                    <i
                                        class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                                </div>
                                @error('email')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- No HP --}}
                            <div>
                                <label for="no_hp" class="block text-xs font-semibold text-slate-700 mb-1.5">No.
                                    WhatsApp / HP</label>
                                <div class="relative">
                                    <input type="text" name="no_hp" id="no_hp"
                                        value="{{ old('no_hp', $user->no_hp) }}" placeholder="08xxxxxxxxxx"
                                        class="w-full pl-9 pr-3 py-2.5 text-xs rounded-xl border @error('no_hp') border-rose-500 bg-rose-50/20 @else border-slate-200 bg-slate-50/50 focus:bg-white @enderror text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-600">
                                    <i
                                        class="fa-solid fa-phone absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                                </div>
                                @error('no_hp')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Desa --}}
                            <div class="md:col-span-2">
                                <label for="desa_id" class="block text-xs font-semibold text-slate-700 mb-1.5">Desa
                                    Domisili</label>
                                <div class="relative">
                                    <select name="desa_id" id="desa_id"
                                        class="w-full pl-9 pr-8 py-2.5 text-xs rounded-xl border @error('desa_id') border-rose-500 bg-rose-50/20 @else border-slate-200 bg-slate-50/50 focus:bg-white @enderror text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-600 appearance-none">
                                        <option value="">-- Pilih Desa --</option>
                                        @foreach ($desa as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('desa_id', $user->desa_id) == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_desa ?? ($item->nama ?? 'Desa ' . $item->id) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i
                                        class="fa-solid fa-location-dot absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                                    <i
                                        class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                                </div>
                                @error('desa_id')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="pt-4 mt-6 border-t border-slate-100 flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium transition-colors shadow-xs">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>

            {{-- Tile 4: Change Password (8 Cols) --}}
            <div
                class="lg:col-span-8 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs flex flex-col justify-between">
                <form method="POST" action="{{ route('warga.profile.password') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="border-b border-slate-100 pb-3">
                        <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-shield-halved text-blue-600"></i>
                            Ubah Kata Sandi
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Pastikan password minimal 8 karakter untuk keamanan
                            maksimal.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="current_password"
                                class="block text-xs font-semibold text-slate-700 mb-1.5">Password Saat Ini</label>
                            <div class="relative">
                                <input type="password" name="current_password" id="current_password" required
                                    placeholder="••••••••"
                                    class="w-full pl-9 pr-3 py-2.5 text-xs rounded-xl border @error('current_password', 'updatePassword') border-rose-500 bg-rose-50/20 @else border-slate-200 bg-slate-50/50 focus:bg-white @enderror text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-600">
                                <i
                                    class="fa-solid fa-key absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                            </div>
                            @error('current_password', 'updatePassword')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">Password
                                Baru</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required
                                    placeholder="Min 8 karakter"
                                    class="w-full pl-9 pr-3 py-2.5 text-xs rounded-xl border @error('password', 'updatePassword') border-rose-500 bg-rose-50/20 @else border-slate-200 bg-slate-50/50 focus:bg-white @enderror text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-600">
                                <i
                                    class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                            </div>
                            @error('password', 'updatePassword')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-xs font-semibold text-slate-700 mb-1.5">Konfirmasi Password</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    required placeholder="Ulangi password"
                                    class="w-full pl-9 pr-3 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-600">
                                <i
                                    class="fa-solid fa-circle-check absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-medium transition-colors shadow-xs">
                            <i class="fa-solid fa-key"></i>
                            Perbarui Password
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tile 5: Danger Zone Card (4 Cols) --}}
            <div x-data="{ openDeleteModal: false }"
                class="lg:col-span-4 bg-rose-50/60 border border-rose-200/80 rounded-3xl p-6 shadow-xs flex flex-col justify-between">
                <div class="space-y-3">
                    <div
                        class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-base font-bold">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-rose-900">Hapus Akun</h3>
                        <p class="text-xs text-rose-700/80 mt-1 leading-relaxed">
                            Tindakan ini permanen. Semua data profil dan riwayat laporan pengaduan Anda akan dihapus.
                        </p>
                    </div>
                </div>

                <div class="pt-4 mt-4 border-t border-rose-200/50">
                    <button type="button" @click="openDeleteModal = true"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-medium transition-colors shadow-xs">
                        <i class="fa-solid fa-trash-can"></i>
                        Hapus Akun Saya
                    </button>
                </div>

                {{-- Delete Confirmation Modal --}}
                <div x-show="openDeleteModal" x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs"
                    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                    <div @click.away="openDeleteModal = false"
                        class="bg-white border border-slate-200 rounded-3xl max-w-md w-full p-6 shadow-xl space-y-4"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                        <div class="flex items-center gap-3 text-rose-600">
                            <div
                                class="w-10 h-10 rounded-2xl bg-rose-100 flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Konfirmasi Hapus Akun</h3>
                                <p class="text-xs text-slate-500">Tindakan ini tidak dapat dibatalkan.</p>
                            </div>
                        </div>

                        <p class="text-xs text-slate-600 leading-relaxed">
                            Masukkan password akun Anda untuk mengonfirmasi penghapusan akun permanen.
                        </p>

                        <form method="POST" action="{{ route('warga.profile.destroy') }}" class="space-y-4">
                            @csrf
                            @method('DELETE')

                            <div>
                                <label for="delete_password"
                                    class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi
                                    Konfirmasi</label>
                                <input type="password" name="password" id="delete_password" required
                                    placeholder="Masukkan password Anda"
                                    class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 bg-white text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-rose-600">
                                @error('password', 'userDeletion')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                                <button type="button" @click="openDeleteModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-300 bg-white text-xs font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-medium transition-colors shadow-xs">
                                    Ya, Hapus Akun
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-warga-layout>
