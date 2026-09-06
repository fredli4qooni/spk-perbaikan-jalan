{{-- Toast Notification System (PUPR Modern Design) --}}
<div 
    x-data="toastManager()" 
    @toast.window="add($event.detail)"
    class="fixed top-3.5 sm:top-5 left-1/2 -translate-x-1/2 sm:left-auto sm:right-5 sm:translate-x-0 z-[99999] flex flex-col gap-2.5 w-[calc(100%-2rem)] max-w-sm sm:max-w-md pointer-events-none items-center sm:items-end"
    style="display: none;"
    x-show="toasts.length > 0"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div 
            x-show="toast.visible"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 -translate-y-4 sm:translate-y-0 sm:translate-x-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 -translate-y-3 sm:translate-y-0 sm:translate-x-4 scale-95"
            class="pointer-events-auto w-full bg-white/98 backdrop-blur-md rounded-2xl border border-gray-200/90 shadow-xl shadow-gray-900/15 p-3.5 sm:p-4 flex items-start gap-3 transition-all relative overflow-hidden"
            @mouseenter="pauseTimer(toast)"
            @mouseleave="resumeTimer(toast)"
        >
            <!-- Vertical Accent Indicator (Clean Pill - No Corner Splicing) -->
            <div 
                class="absolute left-1 top-2.5 bottom-2.5 w-1 rounded-full"
                :class="{
                    'bg-emerald-500': toast.type === 'success',
                    'bg-amber-500': toast.type === 'warning',
                    'bg-red-500': toast.type === 'error',
                    'bg-brand-purple': toast.type === 'info'
                }"
            ></div>

            <!-- Toast Icon Badges -->
            <div class="flex-shrink-0 pl-1">
                <template x-if="toast.type === 'success'">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-200/80 flex items-center justify-center shadow-2xs">
                        <i class="bi bi-check-circle-fill text-lg"></i>
                    </div>
                </template>
                <template x-if="toast.type === 'warning'">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 border border-amber-200/80 flex items-center justify-center shadow-2xs">
                        <i class="bi bi-exclamation-triangle-fill text-base"></i>
                    </div>
                </template>
                <template x-if="toast.type === 'error'">
                    <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 border border-red-200/80 flex items-center justify-center shadow-2xs">
                        <i class="bi bi-x-circle-fill text-lg"></i>
                    </div>
                </template>
                <template x-if="toast.type === 'info'">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-brand-purple border border-indigo-200/80 flex items-center justify-center shadow-2xs">
                        <i class="bi bi-info-circle-fill text-lg"></i>
                    </div>
                </template>
            </div>

            <!-- Toast Content -->
            <div class="flex-1 min-w-0 pr-1 pt-0.5">
                <h4 class="text-xs sm:text-sm font-bold text-gray-900 leading-tight tracking-tight" x-text="toast.title"></h4>
                <p class="text-xs text-gray-600 mt-1 leading-relaxed break-words" x-text="toast.message"></p>
            </div>

            <!-- Close Button -->
            <button 
                type="button" 
                @click="remove(toast.id)"
                class="flex-shrink-0 w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-700 hover:bg-gray-100 active:bg-gray-200 transition-colors -mr-1 -mt-0.5"
                title="Tutup Notifikasi"
            >
                <i class="bi bi-x-lg text-xs"></i>
            </button>
        </div>
    </template>
</div>

<script>
    // Toast Manager Definition
    window.__toastQueue = window.__toastQueue || [];
    window.__toastManagerInstance = null;

    function toastManager() {
        return {
            toasts: [],
            init() {
                window.__toastManagerInstance = this;
                // Process any toasts queued before Alpine initialization
                if (window.__toastQueue && window.__toastQueue.length) {
                    while (window.__toastQueue.length) {
                        this.add(window.__toastQueue.shift());
                    }
                }
            },
            add(detail) {
                const id = Date.now() + Math.random().toString(36).substr(2, 5);
                const duration = detail.duration !== undefined ? detail.duration : 4500;
                const toast = {
                    id: id,
                    message: detail.message || '',
                    type: detail.type || 'info',
                    title: detail.title || this.getDefaultTitle(detail.type),
                    visible: true,
                    duration: duration,
                    remaining: duration,
                    timer: null,
                    startTime: Date.now()
                };

                this.toasts.push(toast);

                if (duration > 0) {
                    this.startTimer(toast);
                }
            },
            getDefaultTitle(type) {
                switch(type) {
                    case 'success': return 'Berhasil';
                    case 'warning': return 'Peringatan';
                    case 'error': return 'Terjadi Kesalahan';
                    default: return 'Informasi';
                }
            },
            startTimer(toast) {
                toast.startTime = Date.now();
                toast.timer = setTimeout(() => {
                    this.remove(toast.id);
                }, toast.remaining);
            },
            pauseTimer(toast) {
                if (toast.timer) {
                    clearTimeout(toast.timer);
                    toast.remaining -= (Date.now() - toast.startTime);
                    if (toast.remaining < 500) toast.remaining = 500;
                }
            },
            resumeTimer(toast) {
                if (toast.duration > 0 && toast.remaining > 0) {
                    this.startTimer(toast);
                }
            },
            remove(id) {
                const target = this.toasts.find(t => t.id === id);
                if (target) {
                    target.visible = false;
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, 220);
                }
            }
        };
    }

    // Global JS API Helper
    window.showToast = function(message, type = 'info', title = null, duration = 4500) {
        const detail = { message, type, title, duration };
        if (window.__toastManagerInstance) {
            window.__toastManagerInstance.add(detail);
        } else {
            window.__toastQueue.push(detail);
            window.dispatchEvent(new CustomEvent('toast', { detail }));
        }
    };

    window.toast = {
        success: (msg, title, duration) => window.showToast(msg, 'success', title, duration),
        warning: (msg, title, duration) => window.showToast(msg, 'warning', title, duration),
        error: (msg, title, duration) => window.showToast(msg, 'error', title, duration),
        info: (msg, title, duration) => window.showToast(msg, 'info', title, duration)
    };

    // Global Browser HTML5 Validation Interceptor
    // Automatically catches required, pattern, email, min, max errors and displays elegant Toasts instead of browser popups
    (function() {
        let lastInvalidToastTime = 0;
        document.addEventListener('invalid', function(e) {
            // Block default browser validation tooltip balloon
            e.preventDefault();

            const now = Date.now();
            if (now - lastInvalidToastTime < 400) return;
            lastInvalidToastTime = now;

            const input = e.target;
            let label = '';

            if (input.id) {
                const lbl = document.querySelector(`label[for="${input.id}"]`);
                if (lbl) label = lbl.innerText;
            }
            if (!label) {
                const container = input.closest('div, td, tr, .form-group');
                const lbl = container?.querySelector('label');
                if (lbl) label = lbl.innerText;
            }
            if (!label) {
                label = input.getAttribute('aria-label') || input.getAttribute('placeholder') || input.name || 'bidang ini';
            }

            label = label.replace(/[*:\n\r\t]/g, ' ').replace(/\s+/g, ' ').trim();

            let message = `Harap lengkapi ${label} terlebih dahulu.`;
            if (input.validity.typeMismatch && input.type === 'email') {
                message = `Format email pada ${label} tidak valid.`;
            } else if (input.validity.tooShort) {
                message = `${label} minimal ${input.minLength} karakter.`;
            } else if (input.validity.rangeUnderflow) {
                message = `Nilai ${label} minimal ${input.min}.`;
            } else if (input.validity.rangeOverflow) {
                message = `Nilai ${label} maksimal ${input.max}.`;
            }

            window.showToast(message, 'warning', 'Validasi Form');

            input.classList.add('!border-red-500', 'ring-2', 'ring-red-200');
            setTimeout(() => {
                try { input.focus(); } catch (err) {}
            }, 50);

            const clearHighlight = () => {
                input.classList.remove('!border-red-500', 'ring-2', 'ring-red-200');
                input.removeEventListener('input', clearHighlight);
                input.removeEventListener('change', clearHighlight);
            };
            input.addEventListener('input', clearHighlight, { once: true });
            input.addEventListener('change', clearHighlight, { once: true });
        }, true);
    })();
</script>

{{-- Automatic Laravel Flash Sessions & Validation Errors --}}
<script>
    (function() {
        function triggerSessionToasts() {
            @if (session('success'))
                window.showToast(@json(session('success')), 'success', 'Berhasil');
            @endif

            @if (session('error'))
                window.showToast(@json(session('error')), 'error', 'Terjadi Kesalahan');
            @endif

            @if (isset($errors) && $errors->any())
                @foreach ($errors->all() as $error)
                    window.showToast(@json($error), 'error', 'Validasi Gagal');
                @endforeach
            @endif
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', triggerSessionToasts);
        } else {
            triggerSessionToasts();
        }
    })();
</script>
