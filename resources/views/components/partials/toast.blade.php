<div x-data="{
    show: false,
    type: 'info',
    message: '',
    timeout: null,

    init() {
        // Menggunakan $nextTick agar Alpine selesai mount DOM sebelum meicu animasi enter
        this.$nextTick(() => {
            @if(session('success'))
            this.showToast('success', @js(session('success')));
            @elseif(session('error'))
            this.showToast('error', @js(session('error')));
            @elseif(session('warning'))
            this.showToast('warning', @js(session('warning')));
            @elseif(session('info'))
            this.showToast('info', @js(session('info')));
            @endif
        });
    },

    showToast(type, message) {
        this.type = type || 'info';
        this.message = message;

        // Reset jika ada toast yang sedang tampil
        this.show = false;
        clearTimeout(this.timeout);

        // Beri jeda 50ms agar status show benar-benar toggle false -> true untuk mentrigger animasi
        setTimeout(() => {
            this.show = true;

            this.timeout = setTimeout(() => {
                this.close();
            }, 4000);
        }, 50);
    },

    close() {
        this.show = false;
    },

    get config() {
        const presets = {
            success: {
                border: 'border-emerald-200',
                iconBg: 'bg-emerald-100 text-emerald-600',
                titleColor: 'text-emerald-800',
                progress: 'bg-emerald-500',
                icon: 'fa-solid fa-circle-check',
                defaultTitle: 'Berhasil'
            },
            error: {
                border: 'border-rose-200',
                iconBg: 'bg-rose-100 text-rose-600',
                titleColor: 'text-rose-800',
                progress: 'bg-rose-500',
                icon: 'fa-solid fa-circle-xmark',
                defaultTitle: 'Gagal'
            },
            warning: {
                border: 'border-amber-200',
                iconBg: 'bg-amber-100 text-amber-600',
                titleColor: 'text-amber-800',
                progress: 'bg-amber-500',
                icon: 'fa-solid fa-triangle-exclamation',
                defaultTitle: 'Peringatan'
            },
            info: {
                border: 'border-sky-200',
                iconBg: 'bg-sky-100 text-sky-600',
                titleColor: 'text-sky-800',
                progress: 'bg-sky-500',
                icon: 'fa-solid fa-circle-info',
                defaultTitle: 'Informasi'
            }
        };
        return presets[this.type] || presets.info;
    }
}" x-on:toast.window="showToast($event.detail.type, $event.detail.message)" x-cloak
    class="fixed bottom-5 right-5 z-50 w-full max-w-sm px-4 sm:px-0 pointer-events-none">

    {{-- Animasi dipasang di inner wrapper agar pembungkus fixed-nya tidak bentrok --}}
    <div x-show="show" x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
        class="pointer-events-auto relative overflow-hidden rounded-2xl border bg-white p-4 shadow-lg shadow-slate-200/60 transition-all"
        :class="config.border">

        <div class="flex items-start gap-3">
            {{-- Icon --}}
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-sm font-bold"
                :class="config.iconBg">
                <i :class="config.icon"></i>
            </div>

            {{-- Content --}}
            <div class="min-w-0 flex-1 pt-0.5">
                <h4 class="text-xs font-bold uppercase tracking-wider" :class="config.titleColor"
                    x-text="config.defaultTitle"></h4>
                <p class="mt-0.5 text-xs font-medium leading-relaxed text-slate-600" x-text="message"></p>
            </div>

            {{-- Close Button --}}
            <button type="button" @click="close()"
                class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>

        {{-- Progress Bar --}}
        <div class="absolute bottom-0 left-0 h-1 w-full bg-slate-100">
            <div class="h-full origin-left" :class="config.progress" x-show="show"
                x-transition:enter="transition-all duration-[4000ms] linear" x-transition:enter-start="w-full"
                x-transition:enter-end="w-0">
            </div>
        </div>
    </div>
</div>
