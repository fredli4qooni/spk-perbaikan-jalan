{{-- PWA Scripts, Service Worker & Install Prompt --}}
<!-- Floating Install Banner -->
<div 
    x-data="{ show: false }"
    @show-pwa-banner.window="show = true"
    @hide-pwa-banner.window="show = false"
    x-show="show"
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="opacity-0 translate-y-4 scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
    x-transition:leave="transition ease-in duration-200 transform"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 translate-y-4 scale-95"
    class="fixed bottom-20 lg:bottom-6 right-4 left-4 sm:left-auto sm:right-6 sm:w-96 z-40 bg-white/98 backdrop-blur-md rounded-2xl border border-gray-200 shadow-2xl p-3.5 sm:p-4 flex items-center gap-3.5"
    style="display: none;"
>
    <img src="{{ asset('images/logo-pupr.png') }}" alt="PUPR" class="w-11 h-11 object-contain bg-gray-50 rounded-xl p-1.5 border border-gray-200 flex-shrink-0 shadow-2xs">
    <div class="flex-1 min-w-0">
        <div class="flex items-center gap-1.5">
            <h4 class="text-xs sm:text-sm font-bold text-gray-900 leading-tight">Install PUPR MOORA</h4>
            <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-brand-purple text-white">App</span>
        </div>
        <p class="text-[11px] text-gray-500 mt-0.5 leading-snug">Akses cepat & navigasi offline dari layar utama</p>
    </div>
    <div class="flex items-center gap-1.5 flex-shrink-0">
        <button 
            type="button" 
            onclick="window.installPWA()"
            class="px-3 py-2 rounded-xl bg-brand-purple text-white text-xs font-semibold shadow-xs hover:bg-brand-purple-hover active:scale-95 transition-all cursor-pointer min-h-[38px]"
        >
            Install
        </button>
        <button 
            type="button" 
            @click="show = false; localStorage.setItem('pwa_banner_dismissed', Date.now())"
            class="w-8 h-8 rounded-xl flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors"
            title="Tutup Banner"
        >
            <i class="bi bi-x-lg text-xs"></i>
        </button>
    </div>
</div>

<script>
    // 1. Service Worker Registration
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then((registration) => {
                    registration.addEventListener('updatefound', () => {
                        const newWorker = registration.installing;
                        if (newWorker) {
                            newWorker.addEventListener('statechange', () => {
                                if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                    if (window.showToast) {
                                        window.showToast('Versi terbaru aplikasi tersedia. Muat ulang halaman untuk memperbarui.', 'info', 'Pembaruan Sistem');
                                    }
                                }
                            });
                        }
                    });
                })
                .catch((err) => {
                    console.warn('[PWA] Service Worker registration notice:', err);
                });
        });
    }

    // 2. Install Prompt Capturing & Global Helper
    window.__pwaDeferredPrompt = null;

    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent mini-infobar on mobile
        e.preventDefault();
        window.__pwaDeferredPrompt = e;
        window.dispatchEvent(new CustomEvent('pwa-ready-to-install'));

        // Check if banner was dismissed in the last 7 days
        const dismissedTime = localStorage.getItem('pwa_banner_dismissed');
        const now = Date.now();
        if (!dismissedTime || (now - parseInt(dismissedTime, 10)) > 7 * 24 * 60 * 60 * 1000) {
            // Delay banner slightly so user sees main screen first
            setTimeout(() => {
                window.dispatchEvent(new CustomEvent('show-pwa-banner'));
            }, 1800);
        }
    });

    window.installPWA = async function() {
        if (window.__pwaDeferredPrompt) {
            window.__pwaDeferredPrompt.prompt();
            const choice = await window.__pwaDeferredPrompt.userChoice;
            if (choice.outcome === 'accepted') {
                if (window.showToast) {
                    window.showToast('Terima kasih! Memulai proses pemasangan aplikasi PUPR MOORA.', 'success', 'Instalasi Berjalan');
                }
            }
            window.__pwaDeferredPrompt = null;
            window.dispatchEvent(new CustomEvent('hide-pwa-banner'));
        } else {
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
            if (isIOS) {
                if (window.showToast) {
                    window.showToast('Untuk install di iOS Safari: Tekan tombol Bagikan (Share) di bawah layar, lalu pilih "Tambah ke Layar Utama".', 'info', 'Panduan Instalasi iOS', 6500);
                }
            } else {
                if (window.showToast) {
                    window.showToast('Gunakan menu browser (ikon titik tiga atau tombol instal di address bar) untuk memasang aplikasi.', 'info', 'Instalasi Aplikasi');
                }
            }
        }
    };

    window.addEventListener('appinstalled', () => {
        window.__pwaDeferredPrompt = null;
        if (window.showToast) {
            window.showToast('Aplikasi PUPR MOORA berhasil dipasang di perangkat Anda.', 'success', 'Aplikasi Terpasang');
        }
        window.dispatchEvent(new CustomEvent('hide-pwa-banner'));
    });

    // 3. Online/Offline Network Status Notifications
    window.addEventListener('online', () => {
        if (window.showToast) {
            window.showToast('Koneksi internet terhubung kembali.', 'success', 'Koneksi Pulih');
        }
    });

    window.addEventListener('offline', () => {
        if (window.showToast) {
            window.showToast('Koneksi internet terputus. Mode offline aktif dengan cache lokal.', 'warning', 'Mode Offline');
        }
    });
</script>
