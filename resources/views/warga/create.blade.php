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

        {{-- Step Progress Bar --}}
        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 sm:p-6 shadow-xs">
            <div class="flex items-center justify-between relative">
                {{-- Connector Line --}}
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-0.5 bg-slate-200 z-0"></div>
                <div class="absolute left-0 top-1/2 -translate-y-1/2 h-0.5 bg-blue-600 transition-all duration-300 z-0"
                    :style="`width: ${((step - 1) / 2) * 100}%`"></div>

                {{-- Step 1 Indicator --}}
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

                {{-- Step 2 Indicator --}}
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

                {{-- Step 3 Indicator --}}
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

        {{-- Form Container --}}
        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                    <label for="title" class="block text-xs font-semibold text-slate-700">
                        Judul Aduan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" x-model="formData.title"
                        placeholder="Contoh: Lampu Jalan Rusak di Jl. Pemuda" required
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 bg-white text-slate-800 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                    <p class="text-[11px] text-slate-500">Tuliskan judul ringkas dan jelas yang menggambarkan masalah.
                    </p>
                </div>

                {{-- Kategori Aduan --}}
                <div class="space-y-1.5">
                    <label for="category_id" class="block text-xs font-semibold text-slate-700">
                        Kategori Aduan <span class="text-rose-500">*</span>
                    </label>
                    <select id="category_id" name="category_id" x-model="formData.category_id" required
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 bg-white text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="1">Infrastruktur & Jalan</option>
                        <option value="2">Kebersihan & Sampah</option>
                        <option value="3">Ketertiban Umum</option>
                        <option value="4">Layanan Administrasi Desa</option>
                        <option value="5">Fasilitas Kesehatan / Umum</option>
                    </select>
                </div>

                {{-- Deskripsi Aduan --}}
                <div class="space-y-1.5">
                    <label for="description" class="block text-xs font-semibold text-slate-700">
                        Deskripsi Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="5" x-model="formData.description"
                        placeholder="Jelaskan secara detail kronologi atau kondisi permasalahan yang ditemukan..." required
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 bg-white text-slate-800 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:border-blue-600"></textarea>
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

                {{-- Dropdown Desa --}}
                <div class="space-y-1.5">
                    <label for="desa_id" class="block text-xs font-semibold text-slate-700">
                        Pilih Desa / Wilayah <span class="text-rose-500">*</span>
                    </label>
                    <select id="desa_id" name="desa_id" x-model="formData.desa_id" required
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 bg-white text-slate-800 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                        <option value="">-- Pilih Desa --</option>
                        <option value="1">Desa Sukamaju</option>
                        <option value="2">Desa Murni Jaya</option>
                        <option value="3">Desa Margahayu</option>
                    </select>
                </div>

                {{-- Map Container --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700">
                        Pilih Titik Lokasi pada Peta <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-[11px] text-slate-500 mb-2">Klik pada peta di bawah ini untuk menggeser pin lokasi
                        kejadian.</p>
                    <div id="map" class="w-full h-72 rounded-xl border border-slate-300 overflow-hidden z-0">
                    </div>
                </div>

                {{-- Hidden Inputs for Latitude & Longitude --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="latitude" class="block text-[11px] font-medium text-slate-500">Latitude</label>
                        <input type="text" id="latitude" name="latitude" x-model="formData.latitude" readonly
                            class="w-full px-3 py-2 text-xs rounded-lg border border-slate-200 bg-slate-50 text-slate-600 font-mono">
                    </div>
                    <div>
                        <label for="longitude" class="block text-[11px] font-medium text-slate-500">Longitude</label>
                        <input type="text" id="longitude" name="longitude" x-model="formData.longitude" readonly
                            class="w-full px-3 py-2 text-xs rounded-lg border border-slate-200 bg-slate-50 text-slate-600 font-mono">
                    </div>
                </div>

                {{-- Detail Alamat Deskriptif --}}
                <div class="space-y-1.5">
                    <label for="location_details" class="block text-xs font-semibold text-slate-700">
                        Detail Alamat / Patokan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="location_details" name="location_details"
                        x-model="formData.location_details"
                        placeholder="Contoh: Depan Toko Berkah RT 02/RW 04, dekat tiang listrik" required
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 bg-white text-slate-800 placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
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
                    <label class="block text-xs font-semibold text-slate-700">
                        Foto Bukti Kejadian <span class="text-rose-500">*</span>
                    </label>

                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-5 text-center hover:bg-slate-50/50 transition-colors cursor-pointer relative"
                        @click="$refs.photoInput.click()">
                        <input type="file" id="photo" name="photo" x-ref="photoInput"
                            accept="image/png, image/jpeg, image/jpg, image/webp" @change="handlePhotoUpload($event)"
                            class="hidden" required>

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
                                <p class="text-[11px] text-slate-400">Format: JPG, PNG, WEBP (Maksimal 5MB)</p>
                            </div>
                        </template>

                        {{-- Preview Foto --}}
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
                </div>

                {{-- Option Anonim --}}
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-2">
                    <div class="flex items-start gap-3">
                        <input type="checkbox" id="is_anonymous" name="is_anonymous" value="1"
                            x-model="formData.is_anonymous"
                            class="mt-0.5 rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                        <div>
                            <label for="is_anonymous" class="text-xs font-semibold text-slate-900 cursor-pointer">
                                Kirim sebagai Laporan Anonim
                            </label>
                            <p class="text-[11px] text-slate-500 leading-relaxed mt-0.5">
                                Jika diaktifkan, nama Anda tidak akan ditampilkan secara publik pada papan aduan. Namun
                                petugas tetap dapat memverifikasi identitas Anda secara internal.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Konfirmasi Ringkasan Singkat --}}
                <div class="p-4 rounded-xl border border-blue-100 bg-blue-50/50 space-y-1.5 text-xs">
                    <p class="font-semibold text-blue-900 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-info text-blue-600" aria-hidden="true"></i>
                        <span>Pernyataan Kebenaran Data</span>
                    </p>
                    <p class="text-blue-800 leading-relaxed">
                        Dengan mengirimkan laporan ini, Anda menyatakan bahwa informasi yang disampaikan adalah benar
                        dan bertanggung jawab atas laporan tersebut.
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

                <div x-show="step === 1"></div> {{-- Spacer --}}

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

    {{-- Alpine Component Logic --}}
    <script>
        function createAduanForm() {
            return {
                step: 1,
                map: null,
                marker: null,
                photoPreview: null,
                photoName: '',
                formData: {
                    title: '',
                    category_id: '',
                    description: '',
                    desa_id: '',
                    latitude: '-7.4726', // Default koordinat Mojokerto
                    longitude: '112.4338',
                    location_details: '',
                    is_anonymous: false
                },

                initMap() {
                    if (this.map) return;

                    // Delay sedikit agar container DOM ter-render dengan sempurna oleh Alpine
                    setTimeout(() => {
                        const defaultLat = parseFloat(this.formData.latitude);
                        const defaultLng = parseFloat(this.formData.longitude);

                        this.map = L.map('map').setView([defaultLat, defaultLng], 13);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OpenStreetMap'
                        }).addTo(this.map);

                        this.marker = L.marker([defaultLat, defaultLng], {
                            draggable: true
                        }).addTo(this.map);

                        // Update koordinat saat marker digeser
                        this.marker.on('dragend', (e) => {
                            const position = e.target.getLatLng();
                            this.formData.latitude = position.lat.toFixed(6);
                            this.formData.longitude = position.lng.toFixed(6);
                        });

                        // Update marker saat peta diklik
                        this.map.on('click', (e) => {
                            const {
                                lat,
                                lng
                            } = e.latlng;
                            this.marker.setLatLng([lat, lng]);
                            this.formData.latitude = lat.toFixed(6);
                            this.formData.longitude = lng.toFixed(6);
                        });
                    }, 200);
                },

                getCurrentLocation() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                const lat = position.coords.latitude;
                                const lng = position.coords.longitude;
                                this.formData.latitude = lat.toFixed(6);
                                this.formData.longitude = lng.toFixed(6);

                                if (this.map && this.marker) {
                                    this.map.setView([lat, lng], 16);
                                    this.marker.setLatLng([lat, lng]);
                                }
                            },
                            (error) => {
                                alert('Gagal mengambil lokasi. Pastikan izin lokasi diaktifkan pada browser Anda.');
                            }
                        );
                    } else {
                        alert('Browser Anda tidak mendukung Geolocation.');
                    }
                },

                handlePhotoUpload(event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    // Validasi Ukuran (Max 5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('Ukuran file foto maksimal adalah 5MB.');
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
                        if (!this.formData.title || !this.formData.category_id || !this.formData.description) {
                            alert('Mohon lengkapi semua kolom wajib di Langkah 1.');
                            return;
                        }
                        this.step = 2;
                        this.initMap();
                    } else if (this.step === 2) {
                        if (!this.formData.desa_id || !this.formData.location_details) {
                            alert('Mohon pilih Desa dan isi Detail Alamat.');
                            return;
                        }
                        this.step = 3;
                    }
                },

                prevStep() {
                    if (this.step > 1) {
                        this.step--;
                    }
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
