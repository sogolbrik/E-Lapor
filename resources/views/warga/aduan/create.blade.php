<x-warga-layout title="Buat Pengaduan Baru">

    <div class="max-w-4xl mx-auto space-y-6" x-data="createAduanForm()">

        {{-- Header Page --}}
        <div class="flex items-center justify-between gap-4">
            <div>
                <a href="{{ route('warga.dashboard') }}"
                    class="inline-flex items-center gap-2 text-xs font-medium text-slate-500 hover:text-blue-600 transition-colors mb-1">
                    <i class="fa-solid fa-arrow-left text-[10px]" aria-hidden="true"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Buat Pengaduan Baru</h1>
                <p class="text-xs text-slate-600 mt-0.5">Sampaikan laporan Anda terkait fasilitas dan layanan publik
                    secara akurat.</p>
            </div>
        </div>

        {{-- Display Global Validation Errors --}}
        @if ($errors->any())
            <div class="p-4 rounded-xl border border-rose-200 bg-rose-50 text-rose-700 text-xs space-y-1">
                <p class="font-bold flex items-center gap-1.5">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Mohon periksa kembali inputan Anda:</span>
                </p>
                <ul class="list-disc list-inside pl-2 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Step Progress Bar --}}
        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 sm:p-6 shadow-xs">
            <div class="flex items-center justify-between relative">
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-0.5 bg-slate-200 z-0"></div>
                <div class="absolute left-0 top-1/2 -translate-y-1/2 h-0.5 bg-blue-600 transition-all duration-300 z-0"
                    :style="`width: ${((step - 1) / 2) * 100}%`"></div>

                {{-- Step 1 --}}
                <div class="relative z-10 flex flex-col items-center gap-1.5 bg-white px-2">
                    <button type="button" @click="goToStep(1)"
                        :class="step >= 1 ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-400'"
                        class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs transition-colors shadow-xs">
                        <template x-if="step > 1">
                            <i class="fa-solid fa-check text-xs" aria-hidden="true"></i>
                        </template>
                        <template x-if="step <= 1">
                            <span>1</span>
                        </template>
                    </button>
                    <span class="text-[11px] font-semibold"
                        :class="step >= 1 ? 'text-blue-700' : 'text-slate-500'">Detail Aduan</span>
                </div>

                {{-- Step 2 --}}
                <div class="relative z-10 flex flex-col items-center gap-1.5 bg-white px-2">
                    <button type="button" @click="goToStep(2)"
                        :class="step >= 2 ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-400'"
                        class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs transition-colors shadow-xs">
                        <template x-if="step > 2">
                            <i class="fa-solid fa-check text-xs" aria-hidden="true"></i>
                        </template>
                        <template x-if="step <= 2">
                            <span>2</span>
                        </template>
                    </button>
                    <span class="text-[11px] font-semibold"
                        :class="step >= 2 ? 'text-blue-700' : 'text-slate-500'">Lokasi Kejadian</span>
                </div>

                {{-- Step 3 --}}
                <div class="relative z-10 flex flex-col items-center gap-1.5 bg-white px-2">
                    <button type="button" @click="goToStep(3)"
                        :class="step >= 3 ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-400'"
                        class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs transition-colors shadow-xs">
                        <span>3</span>
                    </button>
                    <span class="text-[11px] font-semibold"
                        :class="step >= 3 ? 'text-blue-700' : 'text-slate-500'">Bukti & Kirim</span>
                </div>
            </div>
        </div>

        {{-- Native Form Blade --}}
        <form action="{{ route('warga.pengaduan.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            {{-- STEP 1: INFORMASI ADUAN --}}
            <div x-show="step === 1" x-transition.opacity
                class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-200/80 pb-3">
                    <h2 class="text-base font-bold text-slate-900">Langkah 1: Informasi Aduan</h2>
                    <p class="text-xs text-slate-500">Jelaskan mengenai permasalahan yang ingin Anda laporkan.</p>
                </div>

                {{-- Judul Aduan --}}
                <div class="space-y-1.5">
                    <label for="judul" class="block text-xs font-semibold text-slate-700">
                        Judul Aduan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required
                        placeholder="Contoh: Lampu Jalan Rusak di Jl. Pemuda"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('judul') border-rose-500 @else border-slate-300 @enderror bg-white text-slate-800 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                    @error('judul')
                        <p class="text-[11px] text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori Aduan (Blade Loop From Database) --}}
                <div class="space-y-1.5">
                    <label for="kategori_id" class="block text-xs font-semibold text-slate-700">
                        Kategori Aduan <span class="text-rose-500">*</span>
                    </label>
                    <select id="kategori_id" name="kategori_id" required
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('kategori_id') border-rose-500 @else border-slate-300 @enderror bg-white text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoriAduan as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-[11px] text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi Aduan --}}
                <div class="space-y-1.5">
                    <label for="deskripsi" class="block text-xs font-semibold text-slate-700">
                        Deskripsi Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="deskripsi" name="deskripsi" rows="5" required
                        placeholder="Jelaskan secara detail kronologi atau kondisi permasalahan yang ditemukan..."
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('deskripsi') border-rose-500 @else border-slate-300 @enderror bg-white text-slate-800 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:border-blue-600">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-[11px] text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- STEP 2: LOKASI KEJADIAN & PETA LEAFLET --}}
            <div x-show="step === 2" x-transition.opacity
                class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-xs space-y-5">
                <div
                    class="border-b border-slate-200/80 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Langkah 2: Lokasi Kejadian</h2>
                        <p class="text-xs text-slate-500">Tandai titik koordinat pada peta dan isi lokasi spesifik.</p>
                    </div>
                    <button type="button" @click="getCurrentLocation()"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-300 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-medium transition-colors">
                        <i class="fa-solid fa-location-crosshairs text-blue-600" aria-hidden="true"></i>
                        <span>Gunakan Lokasi Saya</span>
                    </button>
                </div>

                {{-- Pilih Desa (Blade Loop From Database) --}}
                <div class="space-y-1.5">
                    <label for="desa_id" class="block text-xs font-semibold text-slate-700">
                        Pilih Desa / Wilayah <span class="text-rose-500">*</span>
                    </label>
                    <select id="desa_id" name="desa_id" required
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('desa_id') border-rose-500 @else border-slate-300 @enderror bg-white text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                        <option value="">-- Pilih Desa --</option>
                        @foreach ($desas as $desa)
                            <option value="{{ $desa->id }}"
                                {{ old('desa_id', auth()->user()->desa_id ?? '') == $desa->id ? 'selected' : '' }}>
                                {{ $desa->nama_desa ?? $desa->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('desa_id')
                        <p class="text-[11px] text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Map Container --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700">
                        Pilih Titik Lokasi pada Peta <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-[11px] text-slate-500 mb-2">Klik peta atau geser pin lokasi kejadian untuk
                        mendapatkan koordinat presisi.</p>
                    <div id="map" class="w-full h-72 rounded-xl border border-slate-300 overflow-hidden z-0">
                    </div>
                </div>

                {{-- Inputs Latitude & Longitude --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="latitude" class="block text-[11px] font-medium text-slate-500">Latitude</label>
                        <input type="text" id="latitude" name="latitude"
                            value="{{ old('latitude', '-7.5333') }}" readonly required
                            class="w-full px-3 py-2 text-xs rounded-lg border border-slate-200 bg-slate-50 text-slate-600 font-mono">
                    </div>
                    <div>
                        <label for="longitude" class="block text-[11px] font-medium text-slate-500">Longitude</label>
                        <input type="text" id="longitude" name="longitude"
                            value="{{ old('longitude', '112.5167') }}" readonly required
                            class="w-full px-3 py-2 text-xs rounded-lg border border-slate-200 bg-slate-50 text-slate-600 font-mono">
                    </div>
                </div>

                {{-- Detail Alamat Deskriptif --}}
                <div class="space-y-1.5">
                    <label for="detail_lokasi" class="block text-xs font-semibold text-slate-700">
                        Detail Alamat / Patokan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="detail_lokasi" name="detail_lokasi"
                        value="{{ old('detail_lokasi') }}" required
                        placeholder="Contoh: Depan Toko Berkah RT 02/RW 04, dekat tiang listrik"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border @error('detail_lokasi') border-rose-500 @else border-slate-300 @enderror bg-white text-slate-800 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                    @error('detail_lokasi')
                        <p class="text-[11px] text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- STEP 3: UPLOAD BUKTI FOTO & PRIVASI --}}
            <div x-show="step === 3" x-transition.opacity
                class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-xs space-y-5">
                <div class="border-b border-slate-200/80 pb-3">
                    <h2 class="text-base font-bold text-slate-900">Langkah 3: Bukti Foto & Opsi Privasi</h2>
                    <p class="text-xs text-slate-500">Unggah foto pendukung dan tentukan tingkat privasi laporan Anda.
                    </p>
                </div>

                {{-- Upload Foto --}}
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-slate-700">Foto Bukti Kejadian</label>

                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-5 text-center hover:bg-slate-50/50 transition-colors cursor-pointer relative"
                        @click="$refs.photoInput.click()">
                        <input type="file" id="foto" name="foto" x-ref="photoInput"
                            accept="image/png, image/jpeg, image/jpg, image/gif" @change="handlePhotoUpload($event)"
                            class="hidden">

                        <template x-if="!photoPreview">
                            <div class="space-y-2">
                                <div
                                    class="w-10 h-10 mx-auto rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                                    <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                                </div>
                                <div class="text-xs">
                                    <span class="font-medium text-blue-600">Klik untuk mengunggah</span> atau seret
                                    foto ke sini
                                </div>
                                <p class="text-[11px] text-slate-400">Format: JPG, PNG, GIF (Maksimal 2MB)</p>
                            </div>
                        </template>

                        <template x-if="photoPreview">
                            <div class="space-y-3">
                                <img :src="photoPreview"
                                    class="max-h-48 mx-auto rounded-lg object-cover border border-slate-200 shadow-xs">
                                <p class="text-xs font-medium text-slate-700" x-text="photoName"></p>
                                <button type="button" @click.stop="removePhoto()"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-rose-50 text-rose-600 hover:bg-rose-100 text-xs font-medium transition-colors">
                                    <i class="fa-solid fa-trash text-[10px]" aria-hidden="true"></i>
                                    <span>Hapus Foto</span>
                                </button>
                            </div>
                        </template>
                    </div>
                    @error('foto')
                        <p class="text-[11px] text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Option Anonim --}}
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-2">
                    <div class="flex items-start gap-3">
                        <input type="hidden" name="is_anonymous" value="0">
                        <input type="checkbox" id="is_anonymous" name="is_anonymous" value="1"
                            {{ old('is_anonymous') ? 'checked' : '' }}
                            class="mt-0.5 rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                        <div>
                            <label for="is_anonymous" class="text-xs font-semibold text-slate-900 cursor-pointer">
                                Kirim sebagai Laporan Anonim
                            </label>
                            <p class="text-[11px] text-slate-500 leading-relaxed mt-0.5">
                                Jika diaktifkan, identitas Anda disembunyikan secara publik di portal aduan.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Pernyataan Kebenaran Data --}}
                <div class="p-4 rounded-xl border border-blue-100 bg-blue-50/50 space-y-1.5 text-xs">
                    <p class="font-semibold text-blue-900 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-info text-blue-600" aria-hidden="true"></i>
                        <span>Pernyataan Kebenaran Data</span>
                    </p>
                    <p class="text-blue-800 leading-relaxed">
                        Dengan mengirimkan laporan ini, Anda menyatakan bahwa seluruh data yang disampaikan adalah
                        benar.
                    </p>
                </div>
            </div>

            {{-- Form Navigations Button --}}
            <div class="flex items-center justify-between gap-4 pt-2">
                <button type="button" x-show="step > 1" @click="prevStep()"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 text-xs font-medium transition-colors">
                    <i class="fa-solid fa-arrow-left text-[10px]" aria-hidden="true"></i>
                    <span>Kembali</span>
                </button>

                <div x-show="step === 1"></div>

                <button type="button" x-show="step < 3" @click="nextStep()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 text-white hover:bg-blue-700 text-xs font-medium transition-colors shadow-xs ml-auto">
                    <span>Langkah Selanjutnya</span>
                    <i class="fa-solid fa-arrow-right text-[10px]" aria-hidden="true"></i>
                </button>

                <button type="submit" x-show="step === 3"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 text-xs font-medium transition-colors shadow-xs ml-auto">
                    <i class="fa-solid fa-paper-plane text-xs" aria-hidden="true"></i>
                    <span>Kirim Pengaduan</span>
                </button>
            </div>

        </form>

    </div>

    {{-- Frontend Wizard UI & Leaflet Map Controller --}}
    <script>
        function createAduanForm() {
            return {
                step: {{ $errors->any() ? ($errors->has('foto') || $errors->has('is_anonymous') ? 3 : ($errors->has('desa_id') || $errors->has('detail_lokasi') || $errors->has('latitude') ? 2 : 1)) : 1 }},
                photoPreview: null,
                photoName: '',

                init() {
                    if (this.step === 2) {
                        this.$nextTick(() => this.initMap());
                    }
                },

                initMap() {
                    const latInput = document.getElementById('latitude');
                    const lngInput = document.getElementById('longitude');

                    // Koordinat Default Pusat Kecamatan Kutorejo, Mojokerto
                    const defaultLat = -7.5333;
                    const defaultLng = 112.5167;

                    const startLat = parseFloat(latInput.value) || defaultLat;
                    const startLng = parseFloat(lngInput.value) || defaultLng;

                    // Reset Map Instance jika sudah ada
                    if (window.leafletMap) {
                        window.leafletMap.remove();
                        window.leafletMap = null;
                        window.leafletMarker = null;
                    }

                    const map = L.map('map').setView([startLat, startLng], 14);
                    window.leafletMap = map;

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    // Buat Marker Tunggal
                    const marker = L.marker([startLat, startLng], {
                        draggable: true
                    }).addTo(map);
                    window.leafletMarker = marker;

                    const updateCoords = (lat, lng) => {
                        latInput.value = lat.toFixed(6);
                        lngInput.value = lng.toFixed(6);
                    };

                    // Inisialisasi awal nilai input jika masih kosong
                    if (!latInput.value || !lngInput.value) {
                        updateCoords(startLat, startLng);
                    }

                    // Event Drag Marker
                    marker.on('dragend', (e) => {
                        const pos = e.target.getLatLng();
                        updateCoords(pos.lat, pos.lng);
                    });

                    // Event Klik Peta
                    map.on('click', (e) => {
                        marker.setLatLng(e.latlng);
                        updateCoords(e.latlng.lat, e.latlng.lng);
                    });

                    setTimeout(() => {
                        map.invalidateSize();
                    }, 300);
                },

                getCurrentLocation() {
                    if (!navigator.geolocation) {
                        alert('Browser Anda tidak mendukung fitur Geolocation.');
                        return;
                    }

                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;

                            // Update value input HTML
                            document.getElementById('latitude').value = lat.toFixed(6);
                            document.getElementById('longitude').value = lng.toFixed(6);

                            if (window.leafletMap && window.leafletMarker) {
                                // Pindahkan marker yang sudah ada (bukan membuat marker baru)
                                window.leafletMarker.setLatLng([lat, lng]);
                                window.leafletMap.setView([lat, lng], 17);
                            }
                        },
                        (error) => {
                            alert(
                                'Gagal mendapatkan lokasi. Pastikan izin lokasi (GPS) pada browser sudah diaktifkan.'
                                );
                        }, {
                            enableHighAccuracy: true
                        }
                    );
                },

                handlePhotoUpload(event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file foto maksimal adalah 2MB.');
                        event.target.value = '';
                        return;
                    }

                    this.photoName = file.name;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.photoPreview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },

                removePhoto() {
                    this.photoPreview = null;
                    this.photoName = '';
                    if (this.$refs.photoInput) {
                        this.$refs.photoInput.value = '';
                    }
                },

                nextStep() {
                    if (this.step === 1) {
                        const judul = document.getElementById('judul').value;
                        const kategori = document.getElementById('kategori_id').value;
                        const deskripsi = document.getElementById('deskripsi').value;

                        if (!judul || !kategori || !deskripsi) {
                            alert('Mohon isi semua bidang wajib di Langkah 1.');
                            return;
                        }
                        this.step = 2;
                        this.$nextTick(() => this.initMap());
                    } else if (this.step === 2) {
                        const desa = document.getElementById('desa_id').value;
                        const detail = document.getElementById('detail_lokasi').value;

                        if (!desa || !detail) {
                            alert('Mohon pilih Desa dan isi Detail Alamat.');
                            return;
                        }
                        this.step = 3;
                    }
                },

                prevStep() {
                    if (this.step > 1) this.step--;
                },

                goToStep(targetStep) {
                    if (targetStep < this.step) {
                        this.step = targetStep;
                    } else if (targetStep === 2 && this.step === 1) {
                        this.nextStep();
                    } else if (targetStep === 3 && this.step === 2) {
                        this.nextStep();
                    }
                }
            }
        }
    </script>
</x-warga-layout>
