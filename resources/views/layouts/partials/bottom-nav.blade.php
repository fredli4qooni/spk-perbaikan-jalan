@php
    $isRoadsActive = request()->routeIs('roads.*');
    $isDashboardActive = request()->routeIs('dashboard');
    $isMooraActive = request()->routeIs('moora.*');
    $isReportsActive = request()->routeIs('reports.*');
    $isCriteriaActive = request()->routeIs('criteria.*');
    $isUsersActive = request()->routeIs('users.*');
    $isLogsActive = request()->routeIs('activity-logs.*');
    $isProfileActive = request()->routeIs('profile.*');

    if (auth()->user()->role === 'petugas') {
        $isMoreActive = $isReportsActive || $isCriteriaActive || $isProfileActive;
    } else {
        $isMoreActive = $isUsersActive || $isLogsActive || $isCriteriaActive || $isProfileActive;
    }

    $activeTab = 'text-brand-purple font-semibold';
    $inactiveTab = 'text-gray-500 hover:text-gray-900 font-medium';
@endphp

<div x-data="{ moreMenuOpen: false }" class="lg:hidden">
    <!-- ==================================================== -->
    <!-- BAR NAVIGASI BAWAH TETAP (FIXED BOTTOM BAR)          -->
    <!-- ==================================================== -->
    <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-200 shadow-lg px-2 pt-1 pb-2 sm:pb-3" aria-label="Navigasi Bawah">
        <div class="max-w-md sm:max-w-xl mx-auto grid grid-cols-5 items-center justify-items-center">
            
            @if (auth()->user()->role === 'petugas')
                <!-- PETUGAS NAV: Beranda | Data Jalan | [➕ INPUT] | MOORA | Lainnya -->
                
                <!-- 1. Beranda -->
                <a href="{{ route('dashboard') }}" class="w-full flex flex-col items-center justify-center py-1 rounded-xl transition-all {{ $isDashboardActive ? $activeTab : $inactiveTab }}">
                    <i class="bi bi-grid-1x2-fill text-lg sm:text-xl"></i>
                    <span class="text-[10px] sm:text-xs mt-0.5">Beranda</span>
                    @if ($isDashboardActive)
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-purple mt-0.5"></span>
                    @endif
                </a>

                <!-- 2. Data Ruas Jalan -->
                <a href="{{ route('roads.index') }}" class="w-full flex flex-col items-center justify-center py-1 rounded-xl transition-all {{ $isRoadsActive && !request()->routeIs('roads.create') ? $activeTab : $inactiveTab }}">
                    <i class="bi bi-signpost-split-fill text-lg sm:text-xl"></i>
                    <span class="text-[10px] sm:text-xs mt-0.5 truncate max-w-[56px] text-center">Data Jalan</span>
                    @if ($isRoadsActive && !request()->routeIs('roads.create'))
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-purple mt-0.5"></span>
                    @endif
                </a>

                <!-- 3. ELEVATED HERO ACTION BUTTON: Input Ruas Jalan -->
                <a href="{{ route('roads.create') }}" class="group -mt-5 sm:-mt-6 flex flex-col items-center focus:outline-none" title="Tambah Ruas Jalan Baru">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-brand-purple text-white flex items-center justify-center shadow-lg shadow-brand-purple/30 border-4 border-white hover:bg-brand-purple-hover active:scale-95 transition-all">
                        <i class="bi bi-plus-lg text-xl font-bold"></i>
                    </div>
                    <span class="text-[10px] font-semibold text-brand-purple mt-0.5 tracking-tight">Input</span>
                </a>

                <!-- 4. Hasil MOORA -->
                <a href="{{ route('moora.index') }}" class="w-full flex flex-col items-center justify-center py-1 rounded-xl transition-all {{ $isMooraActive ? $activeTab : $inactiveTab }}">
                    <i class="bi bi-bar-chart-line-fill text-lg sm:text-xl"></i>
                    <span class="text-[10px] sm:text-xs mt-0.5">MOORA</span>
                    @if ($isMooraActive)
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-purple mt-0.5"></span>
                    @endif
                </a>

                <!-- 5. Menu Lainnya (Memicu Bottom Sheet) -->
                <button @click="moreMenuOpen = true" type="button" class="w-full flex flex-col items-center justify-center py-1 rounded-xl transition-all cursor-pointer {{ $isMoreActive ? $activeTab : $inactiveTab }}">
                    <i class="bi bi-grid-fill text-lg sm:text-xl"></i>
                    <span class="text-[10px] sm:text-xs mt-0.5">Lainnya</span>
                    @if ($isMoreActive)
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-purple mt-0.5"></span>
                    @endif
                </button>

            @else
                <!-- ADMIN NAV: Beranda | Data Jalan | MOORA | Laporan | Menu Admin -->

                <!-- 1. Beranda -->
                <a href="{{ route('dashboard') }}" class="w-full flex flex-col items-center justify-center py-1 rounded-xl transition-all {{ $isDashboardActive ? $activeTab : $inactiveTab }}">
                    <i class="bi bi-grid-1x2-fill text-lg sm:text-xl"></i>
                    <span class="text-[10px] sm:text-xs mt-0.5">Beranda</span>
                    @if ($isDashboardActive)
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-purple mt-0.5"></span>
                    @endif
                </a>

                <!-- 2. Data Ruas Jalan -->
                <a href="{{ route('roads.index') }}" class="w-full flex flex-col items-center justify-center py-1 rounded-xl transition-all {{ $isRoadsActive ? $activeTab : $inactiveTab }}">
                    <i class="bi bi-signpost-split-fill text-lg sm:text-xl"></i>
                    <span class="text-[10px] sm:text-xs mt-0.5 truncate max-w-[56px] text-center">Data Jalan</span>
                    @if ($isRoadsActive)
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-purple mt-0.5"></span>
                    @endif
                </a>

                <!-- 3. Hasil MOORA -->
                <a href="{{ route('moora.index') }}" class="w-full flex flex-col items-center justify-center py-1 rounded-xl transition-all {{ $isMooraActive ? $activeTab : $inactiveTab }}">
                    <i class="bi bi-bar-chart-line-fill text-lg sm:text-xl"></i>
                    <span class="text-[10px] sm:text-xs mt-0.5">MOORA</span>
                    @if ($isMooraActive)
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-purple mt-0.5"></span>
                    @endif
                </a>

                <!-- 4. Laporan Prioritas -->
                <a href="{{ route('reports.index') }}" class="w-full flex flex-col items-center justify-center py-1 rounded-xl transition-all {{ $isReportsActive ? $activeTab : $inactiveTab }}">
                    <i class="bi bi-file-earmark-bar-graph-fill text-lg sm:text-xl"></i>
                    <span class="text-[10px] sm:text-xs mt-0.5">Laporan</span>
                    @if ($isReportsActive)
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-purple mt-0.5"></span>
                    @endif
                </a>

                <!-- 5. Menu Admin (Memicu Bottom Sheet) -->
                <button @click="moreMenuOpen = true" type="button" class="w-full flex flex-col items-center justify-center py-1 rounded-xl transition-all cursor-pointer {{ $isMoreActive ? $activeTab : $inactiveTab }}">
                    <i class="bi bi-grid-fill text-lg sm:text-xl"></i>
                    <span class="text-[10px] sm:text-xs mt-0.5">Lainnya</span>
                    @if ($isMoreActive)
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-purple mt-0.5"></span>
                    @endif
                </button>
            @endif

        </div>
    </nav>

    <!-- ==================================================== -->
    <!-- BOTTOM SHEET DRAWER (LACI MENU LAINNYA & ADMIN)      -->
    <!-- ==================================================== -->
    <div x-show="moreMenuOpen" class="fixed inset-0 z-50 flex flex-col justify-end" style="display: none;" role="dialog" aria-modal="true">
        <!-- Backdrop Overlay -->
        <div x-show="moreMenuOpen" 
             @click="moreMenuOpen = false" 
             x-transition:enter="transition-opacity ease-out duration-250" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition-opacity ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs"></div>

        <!-- Sheet Modal Panel -->
        <div x-show="moreMenuOpen" 
             x-transition:enter="transition ease-out duration-300 transform" 
             x-transition:enter-start="translate-y-full" 
             x-transition:enter-end="translate-y-0" 
             x-transition:leave="transition ease-in duration-200 transform" 
             x-transition:leave-start="translate-y-0" 
             x-transition:leave-end="translate-y-full" 
             class="relative bg-white rounded-t-3xl border-t border-gray-200 shadow-2xl z-10 p-5 sm:p-6 max-w-lg sm:max-w-xl mx-auto w-full max-h-[85vh] overflow-y-auto">
             
            <!-- Pill Gagang Penarik -->
            <div class="w-12 h-1.5 bg-gray-300 rounded-full mx-auto mb-4"></div>

            <!-- Header Laci: Akun & Tombol Tutup -->
            <div class="flex items-center justify-between pb-3.5 border-b border-gray-100 mb-4">
                <div class="flex items-center gap-3 min-w-0">
                    <img class="h-10 w-10 rounded-full object-cover border border-gray-200 bg-gray-50" src="{{ auth()->user()->profile_photo_url }}" alt="">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wide {{ auth()->user()->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ucfirst(auth()->user()->role) }} PUPR
                        </span>
                    </div>
                </div>
                <button @click="moreMenuOpen = false" type="button" class="w-9 h-9 rounded-xl bg-gray-100 text-gray-500 hover:bg-gray-200 flex items-center justify-center transition-all cursor-pointer active:scale-95" aria-label="Tutup Menu">
                    <i class="bi bi-x-lg text-sm font-bold"></i>
                </button>
            </div>

            <!-- List Menu Tambahan -->
            <div class="space-y-2">
                @if (auth()->user()->role === 'petugas')
                    <!-- Menu Tambahan Petugas -->
                    <a href="{{ route('reports.index') }}" class="flex items-center justify-between p-3 rounded-2xl border border-gray-200 hover:border-brand-purple/50 bg-gray-50/70 hover:bg-white transition-all shadow-2xs {{ $isReportsActive ? 'ring-2 ring-brand-purple bg-white' : '' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 text-brand-purple flex items-center justify-center flex-shrink-0 text-lg border border-purple-100">
                                <i class="bi bi-file-earmark-bar-graph-fill"></i>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm font-semibold text-gray-900">Laporan Prioritas</p>
                                <p class="text-[11px] text-gray-500">Rekomendasi prioritas & cetak dokumen</p>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-xs text-gray-400"></i>
                    </a>

                    <a href="{{ route('criteria.index') }}" class="flex items-center justify-between p-3 rounded-2xl border border-gray-200 hover:border-brand-purple/50 bg-gray-50/70 hover:bg-white transition-all shadow-2xs {{ $isCriteriaActive ? 'ring-2 ring-brand-purple bg-white' : '' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0 text-lg border border-blue-100">
                                <i class="bi bi-ui-checks-grid"></i>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm font-semibold text-gray-900">Data Kriteria</p>
                                <p class="text-[11px] text-gray-500">Bobot & skala 5 kriteria MOORA</p>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-xs text-gray-400"></i>
                    </a>

                @else
                    <!-- Menu Tambahan Admin -->
                    <a href="{{ route('users.index') }}" class="flex items-center justify-between p-3 rounded-2xl border border-gray-200 hover:border-brand-purple/50 bg-gray-50/70 hover:bg-white transition-all shadow-2xs {{ $isUsersActive ? 'ring-2 ring-brand-purple bg-white' : '' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 text-brand-purple flex items-center justify-center flex-shrink-0 text-lg border border-purple-100">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm font-semibold text-gray-900">Daftar User & Petugas</p>
                                <p class="text-[11px] text-gray-500">Kelola akun dinas dan hak akses</p>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-xs text-gray-400"></i>
                    </a>

                    <a href="{{ route('activity-logs.index') }}" class="flex items-center justify-between p-3 rounded-2xl border border-gray-200 hover:border-brand-purple/50 bg-gray-50/70 hover:bg-white transition-all shadow-2xs {{ $isLogsActive ? 'ring-2 ring-brand-purple bg-white' : '' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0 text-lg border border-blue-100">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm font-semibold text-gray-900">Riwayat Aktivitas Log</p>
                                <p class="text-[11px] text-gray-500">Audit trail dan rekam jejak sistem</p>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-xs text-gray-400"></i>
                    </a>

                    <a href="{{ route('criteria.index') }}" class="flex items-center justify-between p-3 rounded-2xl border border-gray-200 hover:border-brand-purple/50 bg-gray-50/70 hover:bg-white transition-all shadow-2xs {{ $isCriteriaActive ? 'ring-2 ring-brand-purple bg-white' : '' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center flex-shrink-0 text-lg border border-emerald-100">
                                <i class="bi bi-ui-checks-grid"></i>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm font-semibold text-gray-900">Data Kriteria</p>
                                <p class="text-[11px] text-gray-500">Kelola bobot dan kriteria MOORA</p>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-xs text-gray-400"></i>
                    </a>
                @endif

                <!-- Menu Umum: Kelola Profil -->
                <a href="{{ route('profile.edit') }}" class="flex items-center justify-between p-3 rounded-2xl border border-gray-200 hover:border-brand-purple/50 bg-gray-50/70 hover:bg-white transition-all shadow-2xs {{ $isProfileActive ? 'ring-2 ring-brand-purple bg-white' : '' }}">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center flex-shrink-0 text-lg border border-amber-100">
                            <i class="bi bi-person-gear"></i>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-semibold text-gray-900">Kelola Profil Akun</p>
                            <p class="text-[11px] text-gray-500">Perbarui profil dan kata sandi</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right text-xs text-gray-400"></i>
                </a>

                <!-- Tombol Pasang Aplikasi PWA -->
                <button 
                    type="button" 
                    onclick="window.installPWA()" 
                    class="w-full flex items-center justify-between p-3 rounded-2xl border border-indigo-200/90 bg-indigo-50/60 hover:bg-indigo-100/70 transition-all shadow-2xs text-left cursor-pointer"
                >
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white text-brand-purple flex items-center justify-center flex-shrink-0 text-lg border border-indigo-200/80 shadow-2xs">
                            <i class="bi bi-download"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-1.5">
                                <p class="text-xs sm:text-sm font-semibold text-gray-900">Install Aplikasi</p>
                                <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-brand-purple text-white">PWA</span>
                            </div>
                            <p class="text-[11px] text-gray-500">Pasang di layar utama perangkat</p>
                        </div>
                    </div>
                    <i class="bi bi-arrow-down-circle text-base text-brand-purple"></i>
                </button>

                <!-- Tombol Logout -->
                <form method="POST" action="{{ route('logout') }}" class="w-full pt-1">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-2xl bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 text-xs sm:text-sm font-semibold transition-all shadow-2xs active:scale-98 cursor-pointer">
                        <i class="bi bi-box-arrow-right text-base"></i>
                        <span>Logout dari Sistem</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
