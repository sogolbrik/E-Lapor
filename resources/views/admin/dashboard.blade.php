<x-admin-layout title="Dashboard Admin">

    {{-- Page Header --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Dashboard
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Ringkasan aktivitas dan kondisi sistem E-Lapor.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <span
                class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Sistem Aktif
            </span>
        </div>
    </div>

    {{-- Statistic Cards --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
        {{-- Card 1: Total Pengaduan --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-500 truncate">Total Pengaduan</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($totalAduan) }}</h3>
                    <p class="mt-2 text-xs font-medium text-emerald-600 flex items-center gap-1">
                        <i class="fa-solid fa-file-lines"></i>
                        <span>Keseluruhan laporan</span>
                    </p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="fa-solid fa-file-circle-exclamation text-lg"></i>
                </div>
            </div>
        </div>

        {{-- Card 2: Sedang Diproses --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-500 truncate">Sedang Diproses</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($sedangDiproses) }}</h3>
                    <p class="mt-2 text-xs font-medium text-amber-600 flex items-center gap-1">
                        <i class="fa-solid fa-clock"></i>
                        <span>Membutuhkan tindak lanjut</span>
                    </p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-500">
                    <i class="fa-solid fa-spinner text-lg"></i>
                </div>
            </div>
        </div>

        {{-- Card 3: Pengaduan Selesai --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-500 truncate">Pengaduan Selesai</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($pengaduanSelesai) }}</h3>
                    <p class="mt-2 text-xs font-medium text-emerald-600 flex items-center gap-1">
                        <i class="fa-solid fa-check"></i>
                        <span>{{ $persenSelesai }}% dari total</span>
                    </p>
                </div>
                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-500">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                </div>
            </div>
        </div>

        {{-- Card 4: Total Pengguna --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 transition hover:shadow-md">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-500 truncate">Total Pengguna</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($totalPengguna) }}</h3>
                    <p class="mt-2 text-xs font-medium text-blue-600 flex items-center gap-1">
                        <i class="fa-solid fa-users"></i>
                        <span>Warga & Petugas</span>
                    </p>
                </div>
                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Dashboard Grid --}}
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
        {{-- Chart --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 xl:col-span-2 min-w-0">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-base font-semibold text-slate-800">Perkembangan Pengaduan</h2>
                    <p class="mt-1 text-xs text-slate-400">Jumlah pengaduan berdasarkan bulan</p>
                </div>
                <form method="GET" action="{{ route('admin.dashboard') }}">
                    <select name="year" onchange="this.form.submit()"
                        class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-600 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 cursor-pointer">
                        @foreach ($years as $y)
                            <option value="{{ $y }}" {{ $y == $selectedYear ? 'selected' : '' }}>
                                Tahun {{ $y }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            {{-- Responsive Scroll Container for Chart --}}
            <div class="mt-8 overflow-x-auto pb-2 min-w-0">
                <div class="min-w-125 sm:min-w-0">
                    <div class="flex h-64 items-end gap-2 sm:gap-3 border-b border-slate-100 px-2">
                        @foreach ($chartData as $item)
                            <div class="group relative flex h-full flex-1 flex-col justify-end items-center">
                                {{-- Hover Tooltip Badge --}}
                                <div
                                    class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 absolute -top-8 bg-slate-800 text-white text-[10px] font-semibold py-1 px-2 rounded-md shadow pointer-events-none z-10 whitespace-nowrap">
                                    {{ $item['val'] }} Laporan
                                </div>
                                <div class="w-full rounded-t-lg bg-blue-500 transition duration-200 group-hover:bg-blue-600"
                                    style="height: {{ $item['val'] > 0 ? max($item['percentage'], 4) : 0 }}%;"></div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3 grid grid-cols-12 text-center text-xs font-medium text-slate-400">
                        @foreach ($chartData as $item)
                            <span>{{ $item['month'] }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Progress --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 min-w-0 flex flex-col justify-between">
            <div>
                <h2 class="text-base font-semibold text-slate-800">Status Pengaduan</h2>
                <p class="mt-1 text-xs text-slate-400">Ringkasan persentase status saat ini</p>

                <div class="mt-8 space-y-5">
                    {{-- Selesai --}}
                    <div>
                        <div class="mb-2 flex justify-between text-xs font-medium">
                            <span class="text-slate-600 flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span> Selesai
                            </span>
                            <span class="font-bold text-slate-700">{{ $statusSummary['Selesai']['percent'] }}%
                                ({{ $statusSummary['Selesai']['count'] }})</span>
                        </div>
                        <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-emerald-500 transition-all duration-500"
                                style="width: {{ $statusSummary['Selesai']['percent'] }}%;"></div>
                        </div>
                    </div>

                    {{-- Diproses --}}
                    <div>
                        <div class="mb-2 flex justify-between text-xs font-medium">
                            <span class="text-slate-600 flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span> Diproses
                            </span>
                            <span class="font-bold text-slate-700">{{ $statusSummary['Diproses']['percent'] }}%
                                ({{ $statusSummary['Diproses']['count'] }})</span>
                        </div>
                        <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-amber-500 transition-all duration-500"
                                style="width: {{ $statusSummary['Diproses']['percent'] }}%;"></div>
                        </div>
                    </div>

                    {{-- Menunggu --}}
                    <div>
                        <div class="mb-2 flex justify-between text-xs font-medium">
                            <span class="text-slate-600 flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span> Menunggu
                            </span>
                            <span class="font-bold text-slate-700">{{ $statusSummary['Menunggu']['percent'] }}%
                                ({{ $statusSummary['Menunggu']['count'] }})</span>
                        </div>
                        <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-blue-500 transition-all duration-500"
                                style="width: {{ $statusSummary['Menunggu']['percent'] }}%;"></div>
                        </div>
                    </div>

                    {{-- Ditolak --}}
                    <div>
                        <div class="mb-2 flex justify-between text-xs font-medium">
                            <span class="text-slate-600 flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-rose-500"></span> Ditolak
                            </span>
                            <span class="font-bold text-slate-700">{{ $statusSummary['Ditolak']['percent'] }}%
                                ({{ $statusSummary['Ditolak']['count'] }})</span>
                        </div>
                        <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-rose-500 transition-all duration-500"
                                style="width: {{ $statusSummary['Ditolak']['percent'] }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 border-t border-slate-100 pt-4 flex items-center justify-between text-xs text-slate-500">
                <span>Total Diperbarui</span>
                <span class="font-semibold text-slate-700">{{ now()->translatedFormat('d M Y, H:i') }}</span>
            </div>
        </div>
    </div>

    {{-- Recent Reports Table Section --}}
    <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/60 min-w-0">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h2 class="text-base font-semibold text-slate-800">Laporan Terbaru</h2>
                <p class="mt-1 text-xs text-slate-400">Daftar pengaduan terkini yang masuk dari masyarakat</p>
            </div>
            <a href="#"
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 transition">
                <span>Lihat Semua Pengaduan</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        {{-- Table Scroll Container --}}
        <div class="overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full text-left text-xs">
                <thead
                    class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-100 uppercase tracking-wider">
                    <tr>
                        <th scope="col" class="px-4 py-3.5">Kode Tiket</th>
                        <th scope="col" class="px-4 py-3.5">Pelapor</th>
                        <th scope="col" class="px-4 py-3.5">Kategori</th>
                        <th scope="col" class="px-4 py-3.5">Lokasi Kejadian</th>
                        <th scope="col" class="px-4 py-3.5">Tanggal</th>
                        <th scope="col" class="px-4 py-3.5">Status</th>
                        <th scope="col" class="px-4 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($laporanTerbaru as $aduan)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-3.5 font-bold text-blue-600">{{ $aduan->tiket }}</td>
                            <td class="px-4 py-3.5 font-medium">
                                {{ $aduan->is_anonymous ? 'Anonim' : $aduan->user->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3.5">{{ $aduan->kategoriAduan->nama ?? '-' }}</td>
                            <td class="px-4 py-3.5 text-slate-500">{{ $aduan->desa->nama ?? '-' }}</td>
                            <td class="px-4 py-3.5 text-slate-400">{{ $aduan->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3.5">
                                @if ($aduan->status === 'Diproses')
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-semibold text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Diproses
                                    </span>
                                @elseif ($aduan->status === 'Menunggu')
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2.5 py-1 text-[11px] font-semibold text-blue-700 ring-1 ring-inset ring-blue-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span> Menunggu
                                    </span>
                                @elseif ($aduan->status === 'Selesai')
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Selesai
                                    </span>
                                @elseif ($aduan->status === 'Ditolak')
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-1 text-[11px] font-semibold text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <button type="button"
                                    class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-slate-400">
                                Belum ada laporan pengaduan masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>
