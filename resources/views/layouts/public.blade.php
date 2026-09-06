<!doctype html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Portal Transparansi Prioritas Jalan - Dinas PUPR Kota Bandar Lampung' }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Leaflet CSS for Public Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('layouts.partials.pwa-head')
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col selection:bg-brand-purple selection:text-white" x-data="{ mobileNav: false }">

    <!-- Top Public Navbar (Selalu Berada Paling Atas & Tetap Menempel saat Scroll) -->
    <header class="sticky top-0 w-full z-[1100] bg-white/95 backdrop-blur-md border-b border-slate-200/90 shadow-2xs transition-all" style="position: sticky; top: 0; z-index: 9999;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                
                <!-- Brand Identitas Resmi -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('public.dashboard') }}" class="flex items-center gap-3 group focus:outline-none">
                        <img src="{{ asset('images/logo-pupr.png') }}" alt="Logo PUPR" class="h-10 w-10 sm:h-11 sm:w-11 object-contain bg-white rounded-xl p-1 border border-slate-200 shadow-2xs transition-transform group-hover:scale-105">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-extrabold text-base sm:text-lg tracking-wider text-brand-purple">PUPR MOORA</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-200">
                                    Publik
                                </span>
                            </div>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-medium hidden xs:block">Dinas PUPR Kota Bandar Lampung</p>
                        </div>
                    </a>
                </div>

                <!-- Navigasi Desktop -->
                <nav class="hidden md:flex items-center gap-1.5 lg:gap-2">
                    <a href="#metrik" class="px-3 py-2 rounded-xl text-xs lg:text-sm font-semibold text-slate-600 hover:text-brand-purple hover:bg-purple-50/60 transition-colors">
                        Ringkasan
                    </a>
                    <a href="#peta" class="px-3 py-2 rounded-xl text-xs lg:text-sm font-semibold text-slate-600 hover:text-brand-purple hover:bg-purple-50/60 transition-colors flex items-center gap-1.5">
                        <i class="bi bi-map-fill text-brand-purple"></i> Peta Sebaran
                    </a>
                    <a href="#prioritas" class="px-3 py-2 rounded-xl text-xs lg:text-sm font-semibold text-slate-600 hover:text-brand-purple hover:bg-purple-50/60 transition-colors flex items-center gap-1.5">
                        <i class="bi bi-trophy-fill text-amber-500"></i> Prioritas MOORA
                    </a>
                </nav>

                <!-- Tombol Aksi Kanan (Desktop & Mobile) -->
                <div class="flex items-center gap-2.5">
                    @auth
                        <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex items-center justify-center rounded-xl bg-brand-purple px-4 sm:px-5 py-2.5 text-xs sm:text-sm font-semibold text-white shadow-xs hover:bg-brand-purple-hover active:scale-95 transition-all min-h-[42px]">
                            <i class="bi bi-speedometer2 mr-2"></i> Dashboard Sistem
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 sm:px-5 py-2.5 text-xs sm:text-sm font-semibold text-slate-700 shadow-2xs hover:bg-slate-50 hover:text-brand-purple hover:border-brand-purple/40 active:scale-95 transition-all min-h-[42px]">
                            <i class="bi bi-lock-fill mr-1.5 text-brand-purple"></i> Login Petugas
                        </a>
                    @endauth

                    <!-- Mobile Hamburger Button -->
                    <button 
                        type="button" 
                        @click="mobileNav = !mobileNav" 
                        class="md:hidden w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-700 flex items-center justify-center hover:bg-slate-50 focus:outline-none transition-colors"
                        aria-label="Buka Menu"
                    >
                        <i class="bi text-lg" :class="mobileNav ? 'bi-x-lg' : 'bi-list'"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Drawer Menu -->
            <div 
                x-show="mobileNav" 
                @click.away="mobileNav = false" 
                x-transition:enter="transition ease-out duration-200" 
                x-transition:enter-start="opacity-0 -translate-y-2" 
                x-transition:enter-end="opacity-100 translate-y-0" 
                x-transition:leave="transition ease-in duration-150" 
                x-transition:leave-start="opacity-100 translate-y-0" 
                x-transition:leave-end="opacity-0 -translate-y-2" 
                class="md:hidden py-3 border-t border-slate-100 space-y-1.5 bg-white"
                style="display: none;"
            >
                <a @click="mobileNav = false" href="#metrik" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-purple-50/80 hover:text-brand-purple transition-colors">
                    <i class="bi bi-graph-up text-brand-purple"></i> Ringkasan Statistik
                </a>
                <a @click="mobileNav = false" href="#peta" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-purple-50/80 hover:text-brand-purple transition-colors">
                    <i class="bi bi-map text-brand-purple"></i> Peta Sebaran Ruas Jalan
                </a>
                <a @click="mobileNav = false" href="#prioritas" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-purple-50/80 hover:text-brand-purple transition-colors">
                    <i class="bi bi-trophy text-amber-600"></i> Daftar Prioritas MOORA
                </a>

                <div class="pt-2 pb-1 border-t border-slate-100">
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-brand-purple text-white text-sm font-semibold shadow-xs hover:bg-brand-purple-hover min-h-[44px]">
                            <i class="bi bi-speedometer2"></i> Masuk ke Dashboard Sistem
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-slate-900 text-white text-sm font-semibold shadow-xs hover:bg-slate-800 min-h-[44px]">
                            <i class="bi bi-lock-fill text-amber-400"></i> Login Petugas & Admin
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Public Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Public Footer -->
    <footer class="bg-slate-900 text-slate-300 border-t border-slate-800 mt-16 sm:mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 lg:gap-12">
                
                <!-- Info Kedinasan -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-pupr.png') }}" alt="Logo PUPR" class="h-10 w-10 object-contain bg-white rounded-xl p-1 shadow-xs">
                        <div>
                            <span class="font-extrabold text-white text-base tracking-wider uppercase">Dinas PUPR Kota Bandar Lampung</span>
                            <p class="text-xs text-slate-400">Sistem Pendukung Keputusan Penanganan Ruas Jalan</p>
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed max-w-lg">
                        Portal keterbukaan informasi penentuan prioritas perbaikan ruas jalan Kota Bandar Lampung menggunakan metode <em>Multi-Objective Optimization on the basis of Ratio Analysis</em> (MOORA) secara objektif dan ilmiah.
                    </p>
                    <div class="flex items-center gap-2 pt-2 flex-wrap">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-200 border border-slate-700">
                            <i class="bi bi-shield-check text-emerald-400"></i> Data Terverifikasi
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-200 border border-slate-700">
                            <i class="bi bi-cpu text-purple-400"></i> Algoritma MOORA
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-200 border border-slate-700">
                            <i class="bi bi-phone text-amber-400"></i> PWA Siap Pasang
                        </span>
                    </div>
                </div>

                <!-- Tautan Menu Navigasi -->
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Navigasi Portal</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li><a href="#metrik" class="text-slate-400 hover:text-white transition-colors">Ringkasan Statistik</a></li>
                        <li><a href="#peta" class="text-slate-400 hover:text-white transition-colors">Peta Sebaran Kerusakan</a></li>
                        <li><a href="#prioritas" class="text-slate-400 hover:text-white transition-colors">Daftar Peringkat MOORA</a></li>
                    </ul>
                </div>

                <!-- Akses Sistem & Instalasi -->
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Akses Kedinasan</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li>
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-brand-yellow hover:underline font-semibold">
                                <i class="bi bi-box-arrow-in-right"></i> Login Petugas Lapangan
                            </a>
                        </li>
                        <li>
                            <button type="button" onclick="window.installPWA()" class="inline-flex items-center gap-2 text-slate-300 hover:text-white cursor-pointer transition-colors">
                                <i class="bi bi-download text-emerald-400"></i> Pasang Aplikasi (PWA)
                            </button>
                        </li>
                        <li class="pt-3 text-[11px] text-slate-500">
                            Kota Bandar Lampung, Provinsi Lampung, Indonesia.
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 mt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Dinas PUPR Kota Bandar Lampung. Hak Cipta Dilindungi.</p>
                <p>Sistem Pendukung Keputusan Prioritas Perbaikan Jalan &bull; Metode MOORA</p>
            </div>
        </div>
    </footer>

    <!-- Leaflet JS Library -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    @include('layouts.partials.toast')
    @include('layouts.partials.pwa-scripts')
    @stack('scripts')
</body>
</html>
