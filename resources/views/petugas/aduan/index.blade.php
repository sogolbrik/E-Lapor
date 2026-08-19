<x-petugas-layout title="Daftar Aduan Ditugaskan">

    {{-- Page Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Daftar Aduan Ditugaskan</h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola aduan warga yang masuk di wilayah <span
                    class="font-semibold text-slate-700">{{ auth()->user()->desa->nama ?? 'Desa Anda' }}</span>.
            </p>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="mb-6 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200/60">
        <form method="GET" action="{{ route('petugas.aduan.index') }}"
            class="flex flex-col sm:flex-row gap-3 items-center justify-between">

            {{-- Tabs / Filter Status --}}
            <div class="flex flex-wrap items-center gap-1.5 w-full sm:w-auto">
                <a href="{{ route('petugas.aduan.index', request()->only('search')) }}"
                    class="rounded-xl px-3 py-1.5 text-xs font-semibold transition {{ !request('status') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    Semua
                </a>
                <a href="{{ route('petugas.aduan.index', array_merge(request()->only('search'), ['status' => 'Menunggu'])) }}"
                    class="rounded-xl px-3 py-1.5 text-xs font-semibold transition {{ request('status') == 'Menunggu' ? 'bg-amber-500 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    Menunggu
                </a>
                <a href="{{ route('petugas.aduan.index', array_merge(request()->only('search'), ['status' => 'Diproses'])) }}"
                    class="rounded-xl px-3 py-1.5 text-xs font-semibold transition {{ request('status') == 'Diproses' ? 'bg-blue-500 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    Diproses
                </a>
                <a href="{{ route('petugas.aduan.index', array_merge(request()->only('search'), ['status' => 'Selesai'])) }}"
                    class="rounded-xl px-3 py-1.5 text-xs font-semibold transition {{ request('status') == 'Selesai' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    Selesai
                </a>
                <a href="{{ route('petugas.aduan.index', array_merge(request()->only('search'), ['status' => 'Ditolak'])) }}"
                    class="rounded-xl px-3 py-1.5 text-xs font-semibold transition {{ request('status') == 'Ditolak' ? 'bg-rose-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    Ditolak
                </a>
            </div>

            {{-- Form Search --}}
            <div class="relative w-full sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari tiket, judul, pelapor..."
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2 pl-9 pr-4 text-xs text-slate-800 outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                @if (request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
            </div>

        </form>
    </div>

    {{-- Tabel Aduan --}}
    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead
                    class="bg-slate-50/80 text-[11px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Nomor Tiket</th>
                        <th class="px-6 py-4">Pelapor</th>
                        <th class="px-6 py-4">Judul & Kategori</th>
                        <th class="px-6 py-4">Lokasi Kejadian</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white font-medium">
                    @forelse ($aduans as $aduan)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4 font-mono font-bold text-blue-600">
                                {{ $aduan->tiket }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($aduan->is_anonymous)
                                    <span class="font-bold text-slate-800 block">Anonim</span>
                                    <span class="text-[10px] text-slate-400">Identitas Disembunyikan</span>
                                @else
                                    <span
                                        class="font-bold text-slate-800 block">{{ $aduan->user->name ?? 'Warga' }}</span>
                                    <span class="text-[10px] text-slate-400">NIK: {{ $aduan->user->nik ?? '-' }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-800 leading-snug">{{ $aduan->judul }}</p>
                                <span
                                    class="inline-block rounded bg-slate-100 px-1.5 py-0.5 text-[10px] font-semibold text-slate-600 mt-1">
                                    {{ $aduan->kategoriAduan->nama ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500 max-w-xs truncate">
                                {{ $aduan->detail_lokasi }}
                            </td>
                            <td class="px-6 py-4 text-slate-400 whitespace-nowrap">
                                {{ $aduan->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($aduan->status == 'Menunggu')
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-semibold text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Menunggu
                                    </span>
                                @elseif($aduan->status == 'Diproses')
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1 text-[11px] font-semibold text-blue-700 ring-1 ring-inset ring-blue-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span> Diproses
                                    </span>
                                @elseif($aduan->status == 'Selesai')
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Selesai
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-2.5 py-1 text-[11px] font-semibold text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('petugas.aduan.show', $aduan->id) }}"
                                    class="inline-flex items-center gap-1.5 rounded-xl bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-blue-700 transition">
                                    <i class="fa-solid fa-square-pen text-[10px]"></i>
                                    <span>Tindak Lanjut</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400">
                                <i class="fa-solid fa-inbox text-3xl mb-2"></i>
                                <p class="text-xs">Belum ada aduan yang ditugaskan untuk kriteria ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($aduans->hasPages())
            <div class="border-t border-slate-100 px-6 py-4">
                {{ $aduans->links() }}
            </div>
        @endif
    </div>

</x-petugas-layout>
