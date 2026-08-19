<x-petugas-layout title="Dashboard Petugas">

    {{-- Page Header --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Dashboard Petugas
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Ringkasan aduan dan penanganan wilayah kerja <span
                    class="font-semibold text-slate-700">{{ $namaDesa }}</span>.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <span
                class="inline-flex items-center gap-1.5 rounded-xl bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-600/20">
                <i class="fa-solid fa-building-user text-xs"></i>
                Wilayah: {{ $namaDesa }}
            </span>
            <span
                class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Petugas Aktif
            </span>
        </div>
    </div>

    {{-- Statistic Cards --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Card 1: Total Aduan Masuk Wilayah --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Aduan Wilayah</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($totalAduan) }}</h3>
                    <p class="mt-2 flex items-center gap-1 text-xs text-slate-500">
                        <span class="font-semibold text-blue-600">Laporan di desa ini</span>
                    </p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                    <i class="fa-solid fa-inbox text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Card 2: Menunggu Tindakan (Perlu Diproses) --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Menunggu Tindakan</p>
                    <h3 class="mt-2 text-3xl font-bold text-amber-600">{{ number_format($menungguTindakan) }}</h3>
                    <p class="mt-2 flex items-center gap-1 text-xs text-amber-600 font-medium">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>Perlu segera direspon</span>
                    </p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                    <i class="fa-solid fa-clock-rotate-left text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Card 3: Sedang Diproses --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Sedang Diproses</p>
                    <h3 class="mt-2 text-3xl font-bold text-indigo-600">{{ number_format($sedangDiproses) }}</h3>
                    <p class="mt-2 flex items-center gap-1 text-xs text-slate-500">
                        <span>Pengerjaan lapangan</span>
                    </p>
                </div>
                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                    <i class="fa-solid fa-person-digging text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Card 4: Selesai Ditangani --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Selesai Ditangani</p>
                    <h3 class="mt-2 text-3xl font-bold text-emerald-600">{{ number_format($selesaiDitangani) }}</h3>
                    <p class="mt-2 flex items-center gap-1 text-xs text-emerald-600 font-medium">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Tindakan tuntas</span>
                    </p>
                </div>
                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                    <i class="fa-solid fa-square-check text-xl"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- Alert Tindakan Cepat --}}
    @if ($menungguTindakan > 0)
        <div
            class="mt-8 rounded-2xl bg-amber-50/80 p-4 ring-1 ring-amber-500/20 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-white font-bold">
                    <i class="fa-solid fa-bell"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-amber-900">Ada {{ $menungguTindakan }} Aduan Masuk Membutuhkan
                        Tanggapan Anda</h4>
                    <p class="text-xs text-amber-700 mt-0.5">Segera beri kepastian status (Diproses / Ditolak) agar
                        warga mendapatkan pembaruan.</p>
                </div>
            </div>
            <a href="{{ route('petugas.aduan.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-600 px-3.5 py-2 text-xs font-semibold text-white shadow-sm hover:bg-amber-700 transition shrink-0">
                <span>Lihat Aduan</span>
                <i class="fa-solid fa-arrow-down text-[10px]"></i>
            </a>
        </div>
    @endif

    {{-- Section: Daftar Aduan Perlu Diproses & Tindakan Cepat --}}
    <div id="tabel-aduan-perlu-tindakan"
        class="mt-8 rounded-2xl bg-white shadow-sm ring-1 ring-slate-200/60 overflow-hidden">
        <div class="flex flex-col gap-4 border-b border-slate-100 p-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-blue-600"></i>
                    <span>Aduan Perlu Diproses & Ditindaklanjuti</span>
                </h2>
                <p class="mt-1 text-xs text-slate-500">
                    Daftar laporan masyarakat di {{ $namaDesa }} yang belum selesai penanganannya.
                </p>
            </div>
            <a href="{{ route('petugas.aduan.index') }}"
                class="inline-flex items-center gap-2 text-xs font-semibold text-blue-600 hover:text-blue-700 transition">
                <span>Lihat Semua Aduan</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        {{-- Table Container --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead
                    class="bg-slate-50/80 text-[11px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                    <tr>
                        <th scope="col" class="px-6 py-4">Nomor Tiket</th>
                        <th scope="col" class="px-6 py-4">Pelapor</th>
                        <th scope="col" class="px-6 py-4">Judul & Kategori</th>
                        <th scope="col" class="px-6 py-4">Lokasi Kejadian</th>
                        <th scope="col" class="px-6 py-4">Tanggal Masuk</th>
                        <th scope="col" class="px-6 py-4">Status</th>
                        <th scope="col" class="px-6 py-4 text-right">Aksi Penanganan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white font-medium">
                    @forelse ($aduanPerluTindakan as $aduan)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4 font-mono font-bold text-blue-600">{{ $aduan->tiket }}</td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-800 block">
                                    {{ $aduan->is_anonymous ? 'Anonim' : $aduan->user->name ?? '-' }}
                                </span>
                                <span class="text-[10px] text-slate-400">
                                    {{ $aduan->is_anonymous ? 'Identitas Disembunyikan' : $aduan->user->no_hp ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-800">{{ $aduan->judul }}</p>
                                <span
                                    class="inline-block rounded bg-slate-100 px-1.5 py-0.5 text-[10px] font-semibold text-slate-600 mt-1">
                                    {{ $aduan->kategoriAduan->nama ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                <span>{{ $aduan->detail_lokasi }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-400">
                                {{ $aduan->created_at->translatedFormat('d M Y, H:i') }}</td>
                            <td class="px-6 py-4">
                                @if ($aduan->status === 'Menunggu')
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-semibold text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Menunggu
                                    </span>
                                @elseif ($aduan->status === 'Diproses')
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1 text-[11px] font-semibold text-blue-700 ring-1 ring-inset ring-blue-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span> Diproses
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if ($aduan->status === 'Menunggu')
                                    <a href="{{ route('petugas.aduan.show', $aduan->id) }}"
                                        class="inline-flex items-center gap-1.5 rounded-xl bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-blue-700 transition">
                                        <i class="fa-solid fa-reply text-[10px]"></i>
                                        <span>Tindak Lanjut</span>
                                    </a>
                                @else
                                    <a href="{{ route('petugas.aduan.show', $aduan->id) }}"
                                        class="inline-flex items-center gap-1.5 rounded-xl bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-200 transition">
                                        <i class="fa-solid fa-eye text-[10px]"></i>
                                        <span>Update / Detail</span>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400 font-normal">
                                Tidak ada aduan yang perlu ditindaklanjuti saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-petugas-layout>
