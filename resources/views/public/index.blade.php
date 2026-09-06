@extends('layouts.public')

@push('styles')
<style>
    /* PUPR High-Precision Vector Needle Pin */
    .pupr-custom-div-icon {
        background: transparent !important;
        border: none !important;
        transition: none !important;
        transform-origin: 17px 42px !important;
        will-change: transform;
    }
    .pupr-marker-container {
        position: relative;
        width: 34px;
        height: 44px;
        cursor: pointer;
        transform-origin: 17px 42px;
        filter: drop-shadow(0 3px 6px rgba(15, 23, 42, 0.3));
    }
    .pupr-marker-container:hover .pupr-needle-svg {
        transform: scale(1.15);
        transform-origin: 17px 42px;
        filter: brightness(1.1);
        transition: transform 0.15s ease;
    }
    .pupr-needle-svg {
        display: block;
        width: 34px;
        height: 44px;
        overflow: visible;
        pointer-events: auto;
    }
    .pupr-pin-active {
        animation: needleBounce 0.5s ease-in-out 3 alternate;
        transform-origin: 17px 42px;
    }
    @keyframes needleBounce {
        0% { transform: translateY(0); }
        100% { transform: translateY(-10px); }
    }

    /* User Location Radar Pulse */
    .pupr-user-marker-icon {
        background: transparent !important;
        border: none !important;
    }
    .user-pulse-marker {
        position: relative;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .user-pulse-ring {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: rgba(37, 99, 235, 0.45);
        animation: userPulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    .user-pulse-dot {
        position: relative;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #2563EB;
        border: 2px solid #FFFFFF;
        box-shadow: 0 2px 6px rgba(0,0,0,0.35);
    }
    @keyframes userPulse {
        0% { transform: scale(0.8); opacity: 1; }
        100% { transform: scale(2.6); opacity: 0; }
    }

    /* Clean Modern Leaflet Popup */
    .leaflet-popup-content-wrapper {
        padding: 0 !important;
        border-radius: 18px !important;
        box-shadow: 0 20px 30px -10px rgba(15, 23, 42, 0.25), 0 10px 15px -5px rgba(15, 23, 42, 0.1) !important;
        border: 1px solid #E2E8F0 !important;
        overflow: hidden !important;
    }
    .leaflet-popup-content {
        margin: 0 !important;
        width: 310px !important;
        max-width: calc(100vw - 36px) !important;
        font-family: inherit !important;
    }
    .leaflet-popup-content a {
        color: inherit;
    }
    .leaflet-popup-content a.pupr-popup-btn,
    .leaflet-popup-content a.pupr-popup-btn * {
        color: #FFFFFF !important;
    }
    .leaflet-popup-tip {
        background: #FFFFFF !important;
    }
    .leaflet-container a.leaflet-popup-close-button {
        top: 8px !important;
        right: 8px !important;
        color: #FFFFFF !important;
        background: rgba(0, 0, 0, 0.25) !important;
        border-radius: 9999px !important;
        width: 22px !important;
        height: 22px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 !important;
        font-size: 13px !important;
        line-height: 1 !important;
        border: 1px solid rgba(255, 255, 255, 0.35) !important;
        text-shadow: none !important;
        transition: all 0.2s !important;
        z-index: 20 !important;
    }
    .leaflet-container a.leaflet-popup-close-button:hover {
        background: rgba(0, 0, 0, 0.55) !important;
        color: #FFFFFF !important;
    }

    /* Highlight Road Row Animation */
    .row-highlight-flash {
        animation: highlightFlash 2.5s ease-out;
    }
    @keyframes highlightFlash {
        0% { background-color: #FEF3C7; }
        50% { background-color: #FDE68A; }
        100% { background-color: transparent; }
    }

    /* Kecamatan Boundary Highlight & Floating Tooltip */
    .pupr-boundary-tooltip {
        background: rgba(29, 32, 98, 0.94) !important;
        border: 1.5px solid #FBBF24 !important;
        color: #FFFFFF !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        padding: 5px 11px !important;
        border-radius: 10px !important;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.35) !important;
        white-space: nowrap !important;
        backdrop-filter: blur(8px) !important;
        pointer-events: none !important;
    }
    .pupr-boundary-tooltip::before {
        border-top-color: rgba(29, 32, 98, 0.94) !important;
    }
    .pupr-boundary-hover-tooltip {
        background: rgba(15, 23, 42, 0.9) !important;
        border: 1px solid rgba(255, 255, 255, 0.25) !important;
        color: #F8FAFC !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        padding: 4px 9px !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
        pointer-events: none !important;
    }
    .pupr-kecamatan-outline {
        cursor: pointer !important;
        transition: all 0.2s ease !important;
    }
    .pupr-boundary-selected {
        filter: drop-shadow(0 0 8px rgba(37, 99, 235, 0.5));
    }

    /* Modern PUPR Leaflet Zoom Controls */
    .leaflet-top.leaflet-right {
        margin-top: 12px !important;
        margin-right: 12px !important;
    }
    .leaflet-control-zoom {
        border: 1px solid rgba(226, 232, 240, 0.9) !important;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.15) !important;
        border-radius: 12px !important;
        overflow: hidden !important;
        backdrop-filter: blur(8px) !important;
    }
    .leaflet-control-zoom a {
        background: rgba(255, 255, 255, 0.95) !important;
        color: #1D2062 !important;
        width: 36px !important;
        height: 36px !important;
        line-height: 36px !important;
        font-size: 16px !important;
        font-weight: 800 !important;
        transition: all 0.15s ease !important;
        border-bottom: 1px solid #E2E8F0 !important;
    }
    .leaflet-control-zoom a:last-child {
        border-bottom: none !important;
    }
    .leaflet-control-zoom a:hover {
        background: #F1F5F9 !important;
        color: #2563EB !important;
    }
    .leaflet-control-zoom a:active {
        background: #E2E8F0 !important;
    }

    /* Utilitas scrollbar tersembunyi untuk swipe horizontal di mobile */
    .no-scrollbar::-webkit-scrollbar {
        display: none !important;
    }
    .no-scrollbar {
        -ms-overflow-style: none !important;
        scrollbar-width: none !important;
        -webkit-overflow-scrolling: touch;
    }
</style>
@endpush

@section('content')
<div x-data="publicDashboard()" class="space-y-12 sm:space-y-16 lg:space-y-20 pb-16">

    <!-- 1. HERO BANNER RESMI PUPR -->
    <section class="relative bg-brand-purple text-white overflow-hidden py-14 sm:py-20 lg:py-24 border-b border-brand-purple/80">
        <!-- Dekorasi Latar Geometris -->
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white/5 pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 rounded-full bg-brand-yellow/10 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl space-y-5">
                
                <!-- Badge Resmi -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-brand-purple-200 border border-white/15 backdrop-blur-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Portal Keterbukaan Informasi Publik Dinas PUPR</span>
                </div>

                <!-- Judul Utama -->
                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight text-white">
                    Prioritas Penanganan Jalan Kota Bandar Lampung
                </h1>

                <!-- Deskripsi -->
                <p class="text-sm sm:text-base lg:text-lg text-brand-purple-200 leading-relaxed font-normal">
                    Masyarakat dapat memantau secara terbuka data hasil survei kondisi kerusakan ruas jalan dan penentuan urutan prioritas penanganan perbaikan jalan oleh Dinas PUPR secara objektif, terukur, dan berbasis metode ilmiah <strong>MOORA</strong>.
                </p>

                <!-- Tombol CTA -->
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="#peta" class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand-yellow px-5 py-3 text-xs sm:text-sm font-bold text-slate-900 shadow-sm hover:bg-yellow-400 active:scale-95 transition-all min-h-[44px]">
                        <i class="bi bi-map-fill"></i> Jelajahi Peta Sebaran
                    </a>
                    <a href="#prioritas" class="inline-flex items-center justify-center gap-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 px-5 py-3 text-xs sm:text-sm font-semibold text-white backdrop-blur-xs active:scale-95 transition-all min-h-[44px]">
                        <i class="bi bi-trophy-fill text-brand-yellow"></i> Daftar Ranking Prioritas
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. KPI METRIK STATISTIK TRANSPARANSI -->
    <section id="metrik" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 sm:-mt-12 relative z-20">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-5">
            
            <!-- Card 1: Total Ruas Jalan -->
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-sm flex flex-col justify-between hover:border-brand-purple/40 transition-colors">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Ruas</span>
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-purple-50 text-brand-purple border border-purple-100 flex items-center justify-center text-base sm:text-lg">
                        <i class="bi bi-signpost-2-fill"></i>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalRoads }}</div>
                    <div class="text-xs text-slate-500 mt-0.5">Ruas jalan terinventarisasi</div>
                </div>
            </div>

            <!-- Card 2: Prioritas Mendesak -->
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-sm flex flex-col justify-between hover:border-red-300 transition-colors">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Mendesak</span>
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-red-50 text-red-600 border border-red-100 flex items-center justify-center text-base sm:text-lg">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-extrabold text-red-600 tracking-tight">{{ $highPriorityCount }}</div>
                    <div class="text-xs text-slate-500 mt-0.5">Prioritas penanganan utama</div>
                </div>
            </div>

            <!-- Card 3: Sebaran Kecamatan -->
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-sm flex flex-col justify-between hover:border-emerald-300 transition-colors">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Cakupan</span>
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center text-base sm:text-lg">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $kecamatanCount }}</div>
                    <div class="text-xs text-slate-500 mt-0.5">Kecamatan Kota Bandar Lampung</div>
                </div>
            </div>

            <!-- Card 4: Tahun Anggaran -->
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-sm flex flex-col justify-between hover:border-blue-300 transition-colors">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tahun Survei</span>
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center text-base sm:text-lg">
                        <i class="bi bi-calendar2-check-fill"></i>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $latestSurveyYear }}</div>
                    <div class="text-xs text-slate-500 mt-0.5">Survei lapangan aktif</div>
                </div>
            </div>

        </div>
    </section>

    <!-- 3. PETA INTERAKTIF SEBARAN RUAS JALAN (LEAFLET.JS) -->
    <section id="peta" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24">
        
        <!-- Header & Toolbar Utama -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 sm:gap-4 mb-3 sm:mb-4">
            <div class="max-w-2xl min-w-0">
                <div class="inline-flex items-center gap-1.5 sm:gap-2 px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full bg-brand-purple/10 border border-brand-purple/20 text-brand-purple mb-1.5 sm:mb-2">
                    <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-brand-purple animate-pulse"></span>
                    <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-wider">Geografis & Titik Kerusakan Presisi</span>
                </div>
                <h2 class="text-lg sm:text-2xl font-bold text-slate-900 tracking-tight leading-snug">
                    Peta Interaktif Sebaran Ruas Jalan
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5 sm:mt-1 leading-relaxed">
                    Ujung jarum pin menunjuk koordinat GPS aktual hasil survei lapangan. Klik pin untuk info teknis, foto dokumentasi, dan rute navigasi.
                </p>
            </div>

            <!-- Toolbar Kontrol Peta Ramping (1 Baris Bersih di Mobile & Desktop) -->
            <div class="flex items-center gap-2 sm:gap-2.5 shrink-0 pt-0.5 sm:pt-0">
                <!-- Layer Switcher: Peta Jalan vs Satelit -->
                <div class="inline-flex items-center p-0.5 sm:p-1 rounded-xl bg-white border border-slate-200 shadow-2xs">
                    <button 
                        type="button" 
                        @click="setTileLayer('streets')" 
                        :class="activeLayer === 'streets' ? 'bg-brand-purple text-white shadow-xs font-bold' : 'text-slate-600 hover:text-brand-purple hover:bg-slate-50 font-medium'"
                        class="px-2.5 sm:px-3 py-1.5 rounded-lg text-xs transition-all flex items-center gap-1.5 cursor-pointer"
                        title="Tampilan Peta Jalan Vektor (OpenStreetMap)"
                    >
                        <i class="bi bi-map"></i>
                        <span>Peta Jalan</span>
                    </button>
                    <button 
                        type="button" 
                        @click="setTileLayer('satellite')" 
                        :class="activeLayer === 'satellite' ? 'bg-brand-purple text-white shadow-xs font-bold' : 'text-slate-600 hover:text-brand-purple hover:bg-slate-50 font-medium'"
                        class="px-2.5 sm:px-3 py-1.5 rounded-lg text-xs transition-all flex items-center gap-1.5 cursor-pointer"
                        title="Tampilan Citra Satelit Udara (ESRI World Imagery)"
                    >
                        <i class="bi bi-globe-americas"></i>
                        <span>Satelit</span>
                    </button>
                </div>

                <!-- Geolocation Posisi Saya -->
                <button 
                    type="button" 
                    @click="detectUserLocation(true)" 
                    :disabled="isLocating"
                    class="inline-flex items-center gap-1.5 px-3 sm:px-3.5 py-1.5 sm:py-2 rounded-xl bg-white border border-slate-200 shadow-2xs text-xs font-bold text-slate-700 hover:text-brand-purple hover:bg-slate-50 transition-all min-h-[36px] sm:min-h-[38px] cursor-pointer disabled:opacity-60 shrink-0"
                    title="Temukan posisi GPS Anda dan hitung jarak ke ruas jalan"
                >
                    <i class="bi" :class="isLocating ? 'bi-arrow-repeat animate-spin text-brand-purple' : 'bi-crosshair text-blue-600'"></i>
                    <span x-text="isLocating ? 'Mencari...' : 'Posisi Saya'"></span>
                </button>
            </div>
        </div>

        <!-- Filter Bar & Prioritas Pills Interaktif (Kompak & Horizontal Scroll di Mobile) -->
        <div class="bg-white rounded-2xl border border-slate-200 p-2.5 sm:p-4 shadow-xs mb-3 flex flex-col md:flex-row md:items-center justify-between gap-2.5 sm:gap-3">
            <!-- Filter Pills Prioritas (Scrollable Horizontal dengan No-Scrollbar di Mobile) -->
            <div class="flex items-center gap-1.5 sm:gap-2 overflow-x-auto no-scrollbar py-0.5 whitespace-nowrap text-xs">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mr-1 hidden sm:inline shrink-0">Filter:</span>
                
                <button 
                    type="button" 
                    @click="setPriorityFilter('all')" 
                    :class="priorityFilter === 'all' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                    class="px-2.5 py-1.5 rounded-xl font-bold transition-all flex items-center gap-1.5 cursor-pointer shrink-0"
                >
                    <span>Semua Titik</span>
                    <span class="px-1.5 py-0.2 rounded-md text-[10px]" :class="priorityFilter === 'all' ? 'bg-white/20 text-white' : 'bg-white text-slate-700'" x-text="markerCounts.all"></span>
                </button>

                <button 
                    type="button" 
                    @click="setPriorityFilter('urgent')" 
                    :class="priorityFilter === 'urgent' ? 'bg-red-600 text-white shadow-xs' : 'bg-red-50 text-red-700 hover:bg-red-100 border border-red-200/60'"
                    class="px-2.5 py-1.5 rounded-xl font-bold transition-all flex items-center gap-1.5 cursor-pointer shrink-0"
                >
                    <span class="w-2 h-2 rounded-full bg-red-500" :class="priorityFilter === 'urgent' ? 'bg-white' : ''"></span>
                    <span>1–5 Mendesak</span>
                    <span class="px-1.5 py-0.2 rounded-md text-[10px]" :class="priorityFilter === 'urgent' ? 'bg-white/20 text-white' : 'bg-white text-red-800'" x-text="markerCounts.urgent"></span>
                </button>

                <button 
                    type="button" 
                    @click="setPriorityFilter('medium')" 
                    :class="priorityFilter === 'medium' ? 'bg-amber-600 text-white shadow-xs' : 'bg-amber-50 text-amber-800 hover:bg-amber-100 border border-amber-200/60'"
                    class="px-2.5 py-1.5 rounded-xl font-bold transition-all flex items-center gap-1.5 cursor-pointer shrink-0"
                >
                    <span class="w-2 h-2 rounded-full bg-amber-500" :class="priorityFilter === 'medium' ? 'bg-white' : ''"></span>
                    <span>6–15 Sedang</span>
                    <span class="px-1.5 py-0.2 rounded-md text-[10px]" :class="priorityFilter === 'medium' ? 'bg-white/20 text-white' : 'bg-white text-amber-900'" x-text="markerCounts.medium"></span>
                </button>

                <button 
                    type="button" 
                    @click="setPriorityFilter('routine')" 
                    :class="priorityFilter === 'routine' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100 border border-emerald-200/60'"
                    class="px-2.5 py-1.5 rounded-xl font-bold transition-all flex items-center gap-1.5 cursor-pointer shrink-0"
                >
                    <span class="w-2 h-2 rounded-full bg-emerald-500" :class="priorityFilter === 'routine' ? 'bg-white' : ''"></span>
                    <span>>15 Berkala</span>
                    <span class="px-1.5 py-0.2 rounded-md text-[10px]" :class="priorityFilter === 'routine' ? 'bg-white/20 text-white' : 'bg-white text-emerald-900'" x-text="markerCounts.routine"></span>
                </button>
            </div>

            <!-- Filter Dropdown Kecamatan & Active Chip -->
            <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
                <template x-if="selectedKecamatan">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-blue-50 text-blue-900 border border-blue-200 text-xs font-semibold shadow-2xs animate-fade-in shrink-0">
                        <i class="bi bi-bounding-box text-blue-600"></i>
                        <span>Wilayah: <strong x-text="'Kec. ' + selectedKecamatan"></strong></span>
                        <button 
                            type="button" 
                            @click="resetKecamatanFilter()" 
                            class="ml-0.5 p-0.5 rounded-full hover:bg-blue-200 text-blue-700 hover:text-red-600 transition-colors cursor-pointer"
                            title="Hapus Batas Wilayah (Tampilkan Semua)"
                        >
                            <i class="bi bi-x-circle-fill text-xs"></i>
                        </button>
                    </div>
                </template>

                <select 
                    x-model="selectedKecamatan" 
                    @change="filterMap()"
                    class="w-full sm:w-auto rounded-xl border border-slate-300 bg-white px-3 py-1.5 text-xs sm:text-sm font-semibold text-slate-700 shadow-2xs focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/20 cursor-pointer min-h-[36px]"
                >
                    <option value="">Seluruh Wilayah ({{ count($mapMarkers) }} Titik)</option>
                    @foreach ($kecamatanList as $kec)
                        <option value="{{ $kec }}">Kec. {{ $kec }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Kontainer Kanvas Peta (Isolasi Stacking Context z-10 agar tidak menimpa Navbar Mobile z-[1100]) -->
        <div 
            :class="isFullscreenMap ? 'fixed inset-0 z-[99999] h-screen w-screen bg-slate-950 flex flex-col' : 'bg-white rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm overflow-hidden relative z-10'"
            :style="isFullscreenMap ? 'z-index: 99999;' : 'position: relative; z-index: 10;'"
        >
            <!-- Fullscreen Mode Top Bar (Responsif Mobile & Desktop) -->
            <div x-show="isFullscreenMap" class="bg-slate-900 text-white px-3 sm:px-4 py-2 sm:py-2.5 border-b border-slate-800 flex items-center justify-between gap-2 sm:gap-3 z-20 flex-shrink-0" x-cloak>
                <div class="flex items-center gap-2 min-w-0">
                    <img src="{{ asset('images/logo-pupr.png') }}" alt="PUPR" class="h-5 w-5 sm:h-6 sm:w-6 object-contain shrink-0">
                    <div class="leading-tight min-w-0">
                        <span class="font-bold text-xs sm:text-sm text-white truncate block">Peta Sebaran Jalan</span>
                        <span class="text-[10px] text-slate-400 hidden sm:inline">Mode Layar Penuh &bull; Tekan Esc untuk keluar</span>
                    </div>
                </div>
                <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                    <!-- Reset Posisi Peta di Fullscreen Mode -->
                    <button 
                        type="button" 
                        @click="resetMapView()" 
                        class="px-2 sm:px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-200 border border-slate-700 flex items-center gap-1 cursor-pointer"
                        title="Reset Posisi & Zoom Peta ke Bandar Lampung"
                    >
                        <i class="bi bi-arrow-counterclockwise text-xs"></i>
                        <span class="hidden sm:inline">Reset</span>
                    </button>

                    <!-- Toggle Layer di Fullscreen Mode -->
                    <button 
                        type="button" 
                        @click="setTileLayer(activeLayer === 'streets' ? 'satellite' : 'streets')" 
                        class="px-2 sm:px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-200 border border-slate-700 flex items-center gap-1 cursor-pointer"
                    >
                        <i class="bi" :class="activeLayer === 'streets' ? 'bi-globe-americas' : 'bi-map'"></i>
                        <span x-text="activeLayer === 'streets' ? 'Satelit' : 'Peta Jalan'"></span>
                    </button>

                    <!-- Tombol Tutup Layar Penuh -->
                    <button 
                        type="button" 
                        @click="toggleFullscreenMap()" 
                        class="px-2.5 sm:px-3 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-bold flex items-center gap-1 transition-colors cursor-pointer"
                    >
                        <i class="bi bi-fullscreen-exit"></i>
                        <span>Tutup</span>
                    </button>
                </div>
            </div>

            <!-- Legenda Floating Peta (Mode Inline) -->
            <div x-show="!isFullscreenMap" class="absolute bottom-4 right-4 z-30 bg-white/95 backdrop-blur-md p-2.5 sm:p-3 rounded-xl border border-slate-200/90 shadow-md text-xs space-y-1 hidden sm:block pointer-events-none select-none">
                <div class="font-bold text-slate-800 text-[10px] uppercase tracking-wider mb-1">Legenda Peta</div>
                <div class="flex items-center gap-2 text-slate-600 text-[11px]">
                    <span class="w-3 h-3 rounded-full bg-red-600 border border-white shadow-2xs"></span>
                    <span>Prioritas 1–5 (Mendesak)</span>
                </div>
                <div class="flex items-center gap-2 text-slate-600 text-[11px]">
                    <span class="w-3 h-3 rounded-full bg-amber-600 border border-white shadow-2xs"></span>
                    <span>Prioritas 6–15 (Sedang)</span>
                </div>
                <div class="flex items-center gap-2 text-slate-600 text-[11px]">
                    <span class="w-3 h-3 rounded-full bg-emerald-600 border border-white shadow-2xs"></span>
                    <span>Prioritas > 15 (Berkala)</span>
                </div>
                <div class="pt-1 mt-1 border-t border-slate-200/80 flex items-center gap-2 text-slate-600 text-[10px]">
                    <span class="w-3.5 h-2.5 rounded-xs border-2 border-dashed border-brand-purple bg-blue-500/20"></span>
                    <span>Batas Kecamatan (Klik Peta)</span>
                </div>
                <div class="pt-1 border-t border-slate-200/80 flex items-center gap-1.5 text-slate-500 text-[10px]">
                    <i class="bi bi-mouse text-brand-purple text-xs"></i>
                    <span>Scroll / Pinch Trackpad: Zoom Peta</span>
                </div>
            </div>

            <!-- Status Titik Aktif Badge & Indikator Wilayah pada Pojok Kiri Atas Peta -->
            <div 
                class="absolute left-3 z-30 flex flex-col gap-1.5 pointer-events-none transition-all"
                :class="isFullscreenMap ? 'top-14' : 'top-3'"
            >
                <div class="bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-xl border border-slate-200/80 shadow-xs text-xs font-medium text-slate-700 flex items-center gap-2 self-start">
                    <span class="w-2 h-2 rounded-full" :class="activeLayer === 'satellite' ? 'bg-amber-400 animate-pulse' : 'bg-emerald-500'"></span>
                    <span>
                        <strong class="font-bold text-slate-900" x-text="activeMarkerCount"></strong> titik ditampilkan
                    </span>
                    <span class="text-slate-400 text-[10px]" x-text="'(' + (activeLayer === 'satellite' ? 'Satelit' : 'Peta Jalan') + ')'"></span>
                </div>

                <!-- Floating Kecamatan Boundary Chip -->
                <template x-if="selectedKecamatan">
                    <div class="flex flex-col gap-1 pointer-events-auto self-start">
                        <div class="bg-brand-purple/95 backdrop-blur-md text-white px-3 py-1.5 rounded-xl border border-amber-400/50 shadow-md text-xs font-semibold flex items-center gap-2 animate-fade-in">
                            <i class="bi bi-bounding-box text-amber-400"></i>
                            <span>Wilayah: <strong class="text-amber-300" x-text="'Kec. ' + selectedKecamatan"></strong></span>
                            <span class="text-amber-200/80 text-[11px] font-normal" x-text="'(' + markerCounts.all + ' ruas)'"></span>
                            <button 
                                type="button" 
                                @click="resetKecamatanFilter()"
                                class="ml-1 p-0.5 rounded-full hover:bg-white/20 text-white/80 hover:text-white transition-colors cursor-pointer"
                                title="Hapus Batas Wilayah (Tampilkan Semua)"
                            >
                                <i class="bi bi-x-circle-fill text-xs"></i>
                            </button>
                        </div>
                        <template x-if="markerCounts.all === 0">
                            <div class="bg-amber-500/90 backdrop-blur-md text-slate-950 px-2.5 py-1 rounded-lg text-[10px] font-bold flex items-center gap-1.5 shadow-sm animate-fade-in">
                                <i class="bi bi-info-circle-fill text-amber-900"></i>
                                <span>Belum ada survei jalan di wilayah ini (titik lain tetap tampak)</span>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            <!-- Floating Map Tool Controls (Pojok Kanan Atas Kanvas Peta, tepat di bawah tombol Zoom - Sembunyikan di Fullscreen) -->
            <div 
                x-show="!isFullscreenMap"
                class="absolute top-[92px] right-3 z-30 flex flex-col rounded-xl overflow-hidden border border-slate-200/90 shadow-md bg-white/95 backdrop-blur-md"
            >
                <!-- Reset Posisi Peta -->
                <button 
                    type="button" 
                    @click="resetMapView()" 
                    class="w-9 h-9 flex items-center justify-center text-slate-700 hover:text-brand-purple hover:bg-slate-100 active:bg-slate-200 transition-colors border-b border-slate-200/80 cursor-pointer"
                    title="Reset Posisi & Zoom Peta ke Bandar Lampung"
                >
                    <i class="bi bi-arrow-counterclockwise text-sm"></i>
                </button>

                <!-- Tombol Mode Layar Penuh -->
                <button 
                    type="button" 
                    @click="toggleFullscreenMap()" 
                    class="w-9 h-9 flex items-center justify-center text-slate-700 hover:text-brand-purple hover:bg-slate-100 active:bg-slate-200 transition-colors cursor-pointer"
                    title="Perbesar Peta ke Mode Layar Penuh (Esc untuk keluar)"
                >
                    <i class="bi" :class="isFullscreenMap ? 'bi-fullscreen-exit text-red-600' : 'bi-arrows-fullscreen text-sm'"></i>
            </div>

            <!-- Canvas Peta Leaflet -->
            <div 
                id="public-map" 
                :class="isFullscreenMap ? 'flex-1 w-full h-full' : 'w-full h-[460px] sm:h-[540px] lg:h-[620px]'"
                class="z-10"
            ></div>
        </div>
    </section>

    <!-- 4. DAFTAR PERINGKAT PRIORITAS MOORA TERBUKA -->
    <section id="prioritas" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Seksi -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                    <span class="text-xs font-bold text-amber-700 uppercase tracking-wider">Hasil Perhitungan Algoritma</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                    Daftar Prioritas Perbaikan Ruas Jalan
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    Urutan prioritas penanganan disusun berdasarkan nilai optimasi tertinggi ($Y_i$) metode MOORA.
                </p>
            </div>

            <!-- Live Filter Box -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
                <!-- Search Input -->
                <div class="relative min-w-[220px]">
                    <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input 
                        type="text" 
                        x-model="searchQuery" 
                        placeholder="Cari nama jalan / lokasi..."
                        class="w-full rounded-xl border border-slate-300 bg-white pl-9 pr-3 py-2 text-xs sm:text-sm font-medium text-slate-800 placeholder:text-slate-400 shadow-2xs focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/20 min-h-[40px]"
                    >
                </div>

                <!-- Dropdown Filter Kecamatan -->
                <select 
                    x-model="tableKecamatan"
                    class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs sm:text-sm font-medium text-slate-700 shadow-2xs focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/20 cursor-pointer min-h-[40px]"
                >
                    <option value="">Semua Kecamatan</option>
                    @foreach ($kecamatanList as $kec)
                        <option value="{{ $kec }}">{{ $kec }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- PODIUM TOP 3 PRIORITAS UTAMA -->
        @if (count($topThree) >= 3)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                @foreach ($topThree as $index => $top)
                    @php
                        $road = $top['road'];
                        $isFirst = ($index === 0);
                        $badgeColor = $isFirst ? 'bg-amber-100 text-amber-900 border-amber-300' : ($index === 1 ? 'bg-slate-100 text-slate-800 border-slate-300' : 'bg-orange-100 text-orange-900 border-orange-300');
                        $cardBorder = $isFirst ? 'border-amber-300 ring-2 ring-amber-400/20 shadow-md' : 'border-slate-200 shadow-sm';
                    @endphp
                    <div class="bg-white rounded-2xl border {{ $cardBorder }} p-5 flex flex-col justify-between relative overflow-hidden transition-all hover:-translate-y-1">
                        @if ($isFirst)
                            <div class="absolute -right-8 -top-8 w-24 h-24 bg-amber-400/10 rounded-full pointer-events-none"></div>
                        @endif

                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold {{ $badgeColor }} border">
                                    <i class="bi bi-trophy-fill"></i> Peringkat #{{ $top['rank'] }}
                                </span>
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-md bg-slate-100 text-slate-600">
                                    Skor {{ number_format($top['result'], 4) }}
                                </span>
                            </div>

                            <h3 class="text-base font-bold text-slate-900 leading-snug line-clamp-2">
                                {{ $road->name }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                <i class="bi bi-geo-alt text-brand-purple"></i>
                                <span>{{ $road->kecamatan }}, {{ $road->kelurahan }}</span>
                            </p>

                            <!-- Parameter Singkat -->
                            <div class="mt-4 pt-3 border-t border-slate-100 grid grid-cols-2 gap-2 text-xs">
                                <div class="bg-slate-50 p-2 rounded-xl border border-slate-100">
                                    <span class="text-slate-400 text-[10px] block">Kerusakan</span>
                                    <span class="font-semibold text-slate-800">{{ $road->damage_status['label'] }}</span>
                                </div>
                                <div class="bg-slate-50 p-2 rounded-xl border border-slate-100">
                                    <span class="text-slate-400 text-[10px] block">Kawasan (C5)</span>
                                    <span class="font-semibold text-slate-800 truncate block">{{ $road->c5_label }}</span>
                                </div>
                            </div>
                        </div>

                        @if (!empty($road->latitude) && !empty($road->longitude))
                            <button 
                                type="button" 
                                @click="focusMarker({{ $road->id }}, {{ $road->latitude }}, {{ $road->longitude }})"
                                class="mt-4 w-full flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-purple-50 hover:bg-purple-100 text-brand-purple text-xs font-bold border border-purple-200 transition-colors min-h-[38px] cursor-pointer"
                            >
                                <i class="bi bi-geo-fill"></i> Lihat Posisi di Peta
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <!-- TABEL & MOBILE CARDS DAFTAR PRIORITAS LENGKAP -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-xs sm:text-sm">
                    <thead class="bg-slate-50 text-slate-500 font-semibold uppercase text-[11px] tracking-wider">
                        <tr>
                            <th class="px-5 py-3.5 text-center w-16">Peringkat</th>
                            <th class="px-5 py-3.5">Nama Ruas Jalan & Lokasi</th>
                            <th class="px-5 py-3.5">Kecamatan</th>
                            <th class="px-5 py-3.5 text-center">Status Kerusakan</th>
                            <th class="px-5 py-3.5 text-center">Fasilitas (C5)</th>
                            <th class="px-5 py-3.5 text-center">Nilai MOORA ($Y_i$)</th>
                            <th class="px-5 py-3.5 text-center w-28">Peta</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        <template x-for="item in filteredResults" :key="item.road.id">
                            <tr :id="'road-row-' + item.road.id" class="hover:bg-slate-50/80 transition-colors">
                                <!-- Ranking Badge -->
                                <td class="px-5 py-4 text-center">
                                    <span 
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full font-bold text-xs"
                                        :class="{
                                            'bg-amber-100 text-amber-900 border border-amber-300 font-extrabold': item.rank === 1,
                                            'bg-slate-100 text-slate-800 border border-slate-300': item.rank === 2,
                                            'bg-orange-100 text-orange-900 border border-orange-300': item.rank === 3,
                                            'bg-slate-50 text-slate-600 border border-slate-200': item.rank > 3
                                        }"
                                        x-text="'#' + item.rank"
                                    ></span>
                                </td>

                                <!-- Nama Ruas Jalan -->
                                <td class="px-5 py-4">
                                    <div class="font-bold text-slate-900" x-text="item.road.name"></div>
                                    <div class="text-xs text-slate-500 mt-0.5" x-text="item.road.location"></div>
                                </td>

                                <!-- Kecamatan & Kelurahan -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <button 
                                        type="button" 
                                        @click="selectKecamatan(item.road.kecamatan)"
                                        class="font-semibold text-slate-800 hover:text-brand-purple flex items-center gap-1.5 transition-colors cursor-pointer group text-left"
                                        title="Klik untuk arahkan peta ke wilayah kecamatan ini"
                                    >
                                        <i class="bi bi-geo-alt-fill text-brand-purple/70 group-hover:text-brand-purple text-xs transition-colors"></i>
                                        <span class="group-hover:underline" x-text="item.road.kecamatan || '-'"></span>
                                    </button>
                                    <div class="text-xs text-slate-400 pl-4" x-text="item.road.kelurahan || '-'"></div>
                                </td>

                                <!-- Status Kerusakan -->
                                <td class="px-5 py-4 text-center whitespace-nowrap">
                                    <span 
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border"
                                        :class="item.damageBadgeClass"
                                    >
                                        <span class="w-1.5 h-1.5 rounded-full" :class="item.damageDotClass"></span>
                                        <span x-text="item.damageLabel"></span>
                                    </span>
                                </td>

                                <!-- Fasilitas Sekitar (C5) -->
                                <td class="px-5 py-4 text-center whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700" x-text="item.c5Label"></span>
                                </td>

                                <!-- Nilai MOORA -->
                                <td class="px-5 py-4 text-center whitespace-nowrap">
                                    <span class="font-mono font-bold text-brand-purple text-sm" x-text="item.resultFormatted"></span>
                                </td>

                                <!-- Tombol Fokus Peta -->
                                <td class="px-5 py-4 text-center whitespace-nowrap">
                                    <template x-if="item.road.latitude && item.road.longitude">
                                        <button 
                                            type="button" 
                                            @click="focusMarker(item.road.id, item.road.latitude, item.road.longitude)"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-purple-50 text-brand-purple hover:bg-purple-100 border border-purple-200/80 text-xs font-bold transition-all shadow-2xs cursor-pointer active:scale-95"
                                            title="Fokuskan Titik Presisi di Peta"
                                        >
                                            <i class="bi bi-geo-alt-fill text-brand-purple"></i>
                                            <span>Peta</span>
                                        </button>
                                    </template>
                                    <template x-if="!item.road.latitude || !item.road.longitude">
                                        <span class="text-slate-400 text-xs">-</span>
                                    </template>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="filteredResults.length === 0">
                            <td colspan="7" class="px-5 py-10 text-center text-slate-500 text-sm">
                                Tidak ada data ruas jalan yang cocok dengan kata kunci pencarian Anda.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card List View -->
            <div class="md:hidden divide-y divide-slate-100">
                <template x-for="item in filteredResults" :key="item.road.id">
                    <div :id="'road-card-' + item.road.id" class="p-4 space-y-3 transition-colors">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <span 
                                    class="inline-flex items-center justify-center w-7 h-7 rounded-full font-bold text-xs"
                                    :class="{
                                        'bg-amber-100 text-amber-900 border border-amber-300 font-extrabold': item.rank === 1,
                                        'bg-slate-100 text-slate-800 border border-slate-300': item.rank === 2,
                                        'bg-orange-100 text-orange-900 border border-orange-300': item.rank === 3,
                                        'bg-slate-50 text-slate-600 border border-slate-200': item.rank > 3
                                    }"
                                    x-text="'#' + item.rank"
                                ></span>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm leading-snug" x-text="item.road.name"></h4>
                                    <p class="text-xs text-slate-500 flex items-center gap-1 flex-wrap mt-0.5">
                                        <button type="button" @click="selectKecamatan(item.road.kecamatan)" class="hover:text-brand-purple font-medium underline decoration-dotted cursor-pointer text-left" x-text="'Kec. ' + (item.road.kecamatan || '-')"></button>
                                        <span x-text="'• ' + (item.road.kelurahan || '-')"></span>
                                    </p>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <span class="text-[10px] text-slate-400 block">Nilai Yi</span>
                                <span class="font-mono font-bold text-brand-purple text-xs" x-text="item.resultFormatted"></span>
                            </div>
                        </div>

                        <!-- Pill Status & C5 -->
                        <div class="flex items-center gap-2 flex-wrap text-xs">
                            <span 
                                class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-semibold border"
                                :class="item.damageBadgeClass"
                            >
                                <span class="w-1.5 h-1.5 rounded-full" :class="item.damageDotClass"></span>
                                <span x-text="item.damageLabel"></span>
                            </span>
                            <span class="px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 text-slate-700" x-text="'Kawasan: ' + item.c5Label"></span>
                        </div>

                        <!-- Lokasi & Tombol Aksi -->
                        <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-slate-500 truncate max-w-[190px]" x-text="item.road.location"></span>
                            <template x-if="item.road.latitude && item.road.longitude">
                                <button 
                                    type="button" 
                                    @click="focusMarker(item.road.id, item.road.latitude, item.road.longitude)"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-purple-50 text-brand-purple hover:bg-purple-100 border border-purple-200/80 text-xs font-bold transition-all shadow-2xs cursor-pointer active:scale-95"
                                >
                                    <i class="bi bi-geo-alt-fill"></i> Peta
                                </button>
                            </template>
                        </div>
                    </div>
                </template>
                <div x-show="filteredResults.length === 0" class="p-8 text-center text-slate-500 text-xs">
                    Tidak ada data ruas jalan yang cocok.
                </div>
            </div>

            <!-- Footer Card Counter -->
            <div class="p-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Menampilkan <strong class="text-slate-900" x-text="filteredResults.length"></strong> dari <strong class="text-slate-900">{{ count($results) }}</strong> ruas jalan</span>
                <span class="text-slate-400 hidden sm:inline">Data diperbarui secara realtime</span>
            </div>
        </div>
    </section>

</div>

@push('scripts')
<script>
    // Data JSON untuk Leaflet Map dan Filter Tabel
    window.__publicMapMarkers = @json($mapMarkers);
    window.__publicResults = [
        @foreach ($results as $item)
            @php
                $r = $item['road'];
                $ds = $r->damage_status;
            @endphp
            {
                rank: {{ $item['rank'] }},
                result: {{ $item['result'] }},
                resultFormatted: '{{ number_format($item['result'], 4) }}',
                damageLabel: '{{ $ds['label'] }}',
                damageBadgeClass: '{{ $ds['badge'] }}',
                damageDotClass: '{{ $ds['dot'] }}',
                c5Label: '{{ $r->c5_label }}',
                road: {
                    id: {{ $r->id }},
                    name: @json($r->name),
                    location: @json($r->location),
                    kecamatan: @json($r->kecamatan),
                    kelurahan: @json($r->kelurahan),
                    latitude: {{ !empty($r->latitude) ? $r->latitude : 'null' }},
                    longitude: {{ !empty($r->longitude) ? $r->longitude : 'null' }}
                }
            },
        @endforeach
    ];

    function publicDashboard() {
        return {
            map: null,
            streetLayer: null,
            satelliteLayer: null,
            activeLayer: 'streets',
            markersLayer: null,
            userLocationGroup: null,
            markerInstances: {},
            selectedKecamatan: '',
            priorityFilter: 'all', // 'all' | 'urgent' | 'medium' | 'routine'
            searchQuery: '',
            tableKecamatan: '',
            isFullscreenMap: false,
            isLocating: false,
            userCoords: null,
            kecamatanGeoJsonData: null,
            boundariesLayer: null,
            highlightLayer: null,
            isLoadingBoundaries: false,

            init() {
                this.$nextTick(() => {
                    this.initMap();
                });

                // Tutup mode layar penuh bila tombol Esc ditekan
                window.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && this.isFullscreenMap) {
                        this.toggleFullscreenMap();
                    }
                });

                // Tangani resize jendela & rotasi layar secara adaptif
                let resizeTimer;
                window.addEventListener('resize', () => {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(() => {
                        if (this.map) this.map.invalidateSize();
                    }, 150);
                });

                window.addEventListener('orientationchange', () => {
                    setTimeout(() => {
                        if (this.map) this.map.invalidateSize();
                    }, 300);
                });

                // Helper global untuk tombol di popup peta
                window.__publicScrollToTable = (roadId) => {
                    this.scrollToTableRow(roadId);
                };
            },

            get markerCounts() {
                const all = window.__publicMapMarkers || [];
                const selKec = (this.selectedKecamatan || '').trim().toLowerCase();
                const filteredByKec = selKec 
                    ? all.filter(m => (m.kecamatan || '').trim().toLowerCase() === selKec)
                    : all;
                return {
                    all: filteredByKec.length,
                    urgent: filteredByKec.filter(m => m.rank <= 5).length,
                    medium: filteredByKec.filter(m => m.rank > 5 && m.rank <= 15).length,
                    routine: filteredByKec.filter(m => m.rank > 15).length
                };
            },

            get activeMarkerCount() {
                return Object.keys(this.markerInstances).length;
            },

            get filteredResults() {
                return window.__publicResults.filter(item => {
                    const matchesSearch = !this.searchQuery || 
                        (item.road.name && item.road.name.toLowerCase().includes(this.searchQuery.toLowerCase())) ||
                        (item.road.location && item.road.location.toLowerCase().includes(this.searchQuery.toLowerCase()));

                    const matchesKecamatan = !this.tableKecamatan || 
                        (item.road.kecamatan && item.road.kecamatan.trim().toLowerCase() === this.tableKecamatan.trim().toLowerCase());

                    return matchesSearch && matchesKecamatan;
                });
            },

            initMap() {
                const mapEl = document.getElementById('public-map');
                if (!mapEl || this.map) return;

                // Pusat default: Pusat Kota Bandar Lampung [-5.4297, 105.2625]
                // Aktifkan interaksi zoom lengkap: Trackpad gesture, Mouse Scroll Wheel, Double Click & Box Zoom
                this.map = L.map('public-map', {
                    scrollWheelZoom: true,
                    wheelDebounceTime: 40,
                    wheelPxPerZoomLevel: 60,
                    doubleClickZoom: true,
                    touchZoom: true,
                    boxZoom: true,
                    keyboard: true,
                    zoomControl: false,
                    tap: true,
                    minZoom: 10,
                    maxZoom: 19
                }).setView([-5.4297, 105.2625], 13);

                // Tambahkan kontrol tombol zoom modern di pojok kanan atas
                L.control.zoom({
                    position: 'topright',
                    zoomInTitle: 'Perbesar Peta (+)',
                    zoomOutTitle: 'Perkecil Peta (-)'
                }).addTo(this.map);

                // Lapisan Peta Jalan Vektor (OpenStreetMap)
                this.streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors | Dinas PUPR Kota Bandar Lampung'
                });

                // Lapisan Citra Satelit Resolusi Tinggi (ESRI World Imagery)
                this.satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 19,
                    attribution: 'Tiles &copy; Esri &mdash; Sumber: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
                });

                this.streetLayer.addTo(this.map);

                this.markersLayer = L.featureGroup().addTo(this.map);
                this.userLocationGroup = L.featureGroup().addTo(this.map);

                // Kunci posisi seluruh marker 100% presisi setiap kali zoom in/out (mouse/trackpad/button) selesai
                this.map.on('zoomend moveend', () => {
                    if (this.markersLayer) {
                        this.markersLayer.eachLayer(layer => {
                            if (layer.update) layer.update();
                        });
                    }
                });

                this.renderMapMarkers();
                this.loadKecamatanGeoJson();

                if (this.markersLayer.getLayers().length > 0) {
                    this.map.fitBounds(this.markersLayer.getBounds(), { padding: [40, 40], maxZoom: 15 });
                }

                // Pastikan kanvas peta merender sempurna tanpa grey-box
                setTimeout(() => { this.map?.invalidateSize({ pan: false }); }, 200);
                setTimeout(() => { this.map?.invalidateSize({ pan: false }); }, 600);
            },

            async loadKecamatanGeoJson() {
                try {
                    this.isLoadingBoundaries = true;
                    const res = await fetch('/data/bandar_lampung_kecamatan.geojson');
                    if (!res.ok) throw new Error('Gagal mengunduh batas wilayah');
                    this.kecamatanGeoJsonData = await res.json();
                    this.renderAllBoundaries();
                    if (this.selectedKecamatan) {
                        this.updateBoundaryHighlight(this.selectedKecamatan, true);
                    }
                } catch (err) {
                    console.warn('GeoJSON boundary warning:', err);
                } finally {
                    this.isLoadingBoundaries = false;
                }
            },

            renderAllBoundaries() {
                if (!this.map || !this.kecamatanGeoJsonData) return;
                if (this.boundariesLayer) {
                    this.map.removeLayer(this.boundariesLayer);
                }

                this.boundariesLayer = L.geoJSON(this.kecamatanGeoJsonData, {
                    style: () => ({
                        color: '#475569',
                        weight: 1.2,
                        opacity: 0.45,
                        dashArray: '4, 4',
                        fillColor: '#3B82F6',
                        fillOpacity: 0.02,
                        className: 'pupr-kecamatan-outline'
                    }),
                    onEachFeature: (feature, layer) => {
                        const name = feature.properties.name;
                        const roadCount = (window.__publicMapMarkers || []).filter(
                            m => (m.kecamatan || '').trim().toLowerCase() === name.trim().toLowerCase()
                        ).length;

                        const tooltipText = roadCount > 0
                            ? `🏛️ Kec. ${name} (${roadCount} Ruas) <span style="font-size:10px; opacity:0.85;">(Klik untuk arahkan kamera peta)</span>`
                            : `🏛️ Kec. ${name} <span style="font-size:10px; opacity:0.85;">(Klik untuk arahkan kamera peta)</span>`;

                        layer.bindTooltip(tooltipText, {
                            sticky: true,
                            className: 'pupr-boundary-hover-tooltip',
                            direction: 'top',
                            offset: [0, -8]
                        });

                        layer.on({
                            mouseover: (e) => {
                                const l = e.target;
                                if ((this.selectedKecamatan || '').toLowerCase() !== name.toLowerCase()) {
                                    l.setStyle({
                                        weight: 2.2,
                                        opacity: 0.85,
                                        color: '#1D2062',
                                        fillOpacity: 0.1
                                    });
                                }
                            },
                            mouseout: (e) => {
                                const l = e.target;
                                if ((this.selectedKecamatan || '').toLowerCase() !== name.toLowerCase()) {
                                    this.boundariesLayer.resetStyle(l);
                                }
                            },
                            click: (e) => {
                                L.DomEvent.stopPropagation(e);
                                this.selectKecamatan(name, true);
                            }
                        });
                    }
                }).addTo(this.map);

                this.boundariesLayer.bringToBack();
            },

            updateBoundaryHighlight(kecName, skipFitBounds = false) {
                if (!this.map) return;

                // Bersihkan sorotan sebelumnya jika ada
                if (this.highlightLayer) {
                    this.map.removeLayer(this.highlightLayer);
                    this.highlightLayer = null;
                }

                if (!kecName || !this.kecamatanGeoJsonData) {
                    return;
                }

                // Cari feature GeoJSON untuk kecamatan terkait
                const feature = this.kecamatanGeoJsonData.features.find(
                    f => (f.properties.name || '').trim().toLowerCase() === kecName.trim().toLowerCase()
                );

                if (!feature) return;

                // Hitung jumlah ruas jalan yang ada di kecamatan ini
                const countRoads = (window.__publicMapMarkers || []).filter(
                    m => (m.kecamatan || '').trim().toLowerCase() === kecName.trim().toLowerCase()
                ).length;

                this.highlightLayer = L.geoJSON(feature, {
                    style: {
                        color: '#1D2062',        // Deep PUPR Navy
                        weight: 3.5,
                        opacity: 0.95,
                        dashArray: '6, 6',
                        fillColor: '#3B82F6',    // Vibrant Blue
                        fillOpacity: 0.20,
                        className: 'pupr-boundary-selected'
                    }
                }).addTo(this.map);

                // Floating label/badge tooltip di tengah poligon
                const tooltipHtml = `
                    <div style="display:flex; align-items:center; gap:6px;">
                        <span style="color:#FBBF24;">🏛️</span>
                        <span>Kecamatan ${feature.properties.name}</span>
                        <span style="opacity:0.85; font-size:10px; font-weight:normal;">(${countRoads} Ruas)</span>
                    </div>
                `;

                this.highlightLayer.bindTooltip(tooltipHtml, {
                    permanent: true,
                    direction: 'center',
                    className: 'pupr-boundary-tooltip'
                }).openTooltip();

                // Cegah event bubbling jika poligon yang sudah tersorot diklik kembali
                this.highlightLayer.on('click', (e) => {
                    L.DomEvent.stopPropagation(e);
                });

                // Pastikan layer berada di belakang marker pin agar marker tetap klik-able
                this.highlightLayer.bringToBack();
                if (this.boundariesLayer) {
                    this.boundariesLayer.bringToBack();
                }

                // Arahkan kamera peta ke batas wilayah kecamatan secara otomatis
                if (!skipFitBounds) {
                    const targetBounds = this.highlightLayer.getBounds();
                    if (targetBounds && targetBounds.isValid()) {
                        this.map.stop();
                        this.map.invalidateSize({ pan: false });
                        this.map.fitBounds(targetBounds, { 
                            padding: [45, 45], 
                            maxZoom: 15, 
                            animate: true,
                            duration: 0.6 
                        });

                        // Sinkronisasi ulang posisi marker setelah kamera berhenti bergerak
                        this.map.once('moveend', () => {
                            if (this.markersLayer) {
                                this.markersLayer.eachLayer(layer => {
                                    if (layer.update) layer.update();
                                });
                            }
                        });
                    }
                }
            },

            selectKecamatan(name, fromMapClick = false) {
                if (!name) return;

                // Hanya gulir halaman ke area peta jika dipicu dari luar area peta (tabel / card)
                if (!fromMapClick) {
                    const mapSection = document.getElementById('peta');
                    if (mapSection) {
                        const rect = mapSection.getBoundingClientRect();
                        if (rect.top < -50 || rect.bottom > window.innerHeight + 150) {
                            mapSection.scrollIntoView({ behavior: 'smooth' });
                        }
                    }
                }

                if (this.map) {
                    this.map.stop();
                }

                this.selectedKecamatan = name;
                this.renderMapMarkers();
                this.updateBoundaryHighlight(name);

                const count = (window.__publicMapMarkers || []).filter(
                    m => (m.kecamatan || '').trim().toLowerCase() === name.trim().toLowerCase()
                ).length;

                if (window.showToast) {
                    if (count > 0) {
                        window.showToast(`Mengarahkan kamera peta ke wilayah Kec. ${name} (${count} ruas jalan terdata).`, 'info', 'Wilayah Dipilih');
                    } else {
                        window.showToast(`Mengarahkan kamera peta ke wilayah Kec. ${name}. Belum ada survei jalan di wilayah ini (titik lain tetap ditampilkan).`, 'info', 'Wilayah Dipilih');
                    }
                }
            },

            resetKecamatanFilter() {
                if (this.map) this.map.stop();
                this.selectedKecamatan = '';
                this.renderMapMarkers();
                this.updateBoundaryHighlight('');
                this.map?.invalidateSize({ pan: false });
                if (this.map && this.markersLayer.getLayers().length > 0) {
                    this.map.fitBounds(this.markersLayer.getBounds(), { padding: [40, 40], maxZoom: 15, animate: true, duration: 0.6 });
                    this.map.once('moveend', () => {
                        this.markersLayer?.eachLayer(layer => { if (layer.update) layer.update(); });
                    });
                } else if (this.map) {
                    this.map.setView([-5.4297, 105.2625], 13);
                }
                if (window.showToast) {
                    window.showToast('Filter batas wilayah dinonaktifkan.', 'info', 'Seluruh Wilayah');
                }
            },

            setTileLayer(type) {
                if (this.activeLayer === type || !this.map) return;
                this.activeLayer = type;
                if (type === 'satellite') {
                    this.map.removeLayer(this.streetLayer);
                    this.satelliteLayer.addTo(this.map);
                } else {
                    this.map.removeLayer(this.satelliteLayer);
                    this.streetLayer.addTo(this.map);
                }
            },

            toggleFullscreenMap() {
                this.isFullscreenMap = !this.isFullscreenMap;
                if (this.isFullscreenMap) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
                setTimeout(() => {
                    if (this.map) {
                        this.map.invalidateSize({ pan: false });
                    }
                }, 250);
            },

            setPriorityFilter(filter) {
                if (this.map) this.map.stop();
                this.priorityFilter = filter;
                this.renderMapMarkers();
                if (this.selectedKecamatan) {
                    this.updateBoundaryHighlight(this.selectedKecamatan, true);
                } else if (this.markersLayer && this.markersLayer.getLayers().length > 0) {
                    this.map.fitBounds(this.markersLayer.getBounds(), { padding: [40, 40], maxZoom: 15, animate: true, duration: 0.6 });
                    this.map.once('moveend', () => {
                        this.markersLayer?.eachLayer(layer => { if (layer.update) layer.update(); });
                    });
                }
            },

            filterMap() {
                if (this.map) this.map.stop();
                this.renderMapMarkers();
                if (this.selectedKecamatan) {
                    this.updateBoundaryHighlight(this.selectedKecamatan);
                } else {
                    this.updateBoundaryHighlight('');
                    this.map?.invalidateSize({ pan: false });
                    if (this.markersLayer && this.markersLayer.getLayers().length > 0) {
                        this.map.fitBounds(this.markersLayer.getBounds(), { padding: [40, 40], maxZoom: 15, animate: true, duration: 0.6 });
                        this.map.once('moveend', () => {
                            this.markersLayer?.eachLayer(layer => { if (layer.update) layer.update(); });
                        });
                    } else if (this.map) {
                        this.map.setView([-5.4297, 105.2625], 13);
                    }
                }
            },

            resetMapView() {
                if (this.map) this.map.stop();
                this.selectedKecamatan = '';
                this.priorityFilter = 'all';
                this.renderMapMarkers();
                this.updateBoundaryHighlight('');
                this.map?.invalidateSize({ pan: false });
                if (this.map && this.markersLayer.getLayers().length > 0) {
                    this.map.fitBounds(this.markersLayer.getBounds(), { padding: [40, 40], maxZoom: 15, animate: true, duration: 0.6 });
                    this.map.once('moveend', () => {
                        this.markersLayer?.eachLayer(layer => { if (layer.update) layer.update(); });
                    });
                } else if (this.map) {
                    this.map.setView([-5.4297, 105.2625], 13);
                }
                if (window.showToast) {
                    window.showToast('Tampilan peta telah diatur ulang ke posisi awal.', 'info', 'Peta Direset');
                }
            },

            detectUserLocation(manual = false) {
                if (!navigator.geolocation) {
                    if (window.showToast) {
                        window.showToast('Browser perangkat Anda tidak mendukung fitur GPS.', 'error', 'GPS Tidak Didukung');
                    }
                    return;
                }

                this.isLocating = true;

                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        this.isLocating = false;
                        const lat = pos.coords.latitude;
                        const lng = pos.coords.longitude;
                        const accuracy = pos.coords.accuracy;
                        this.userCoords = { lat, lng, accuracy };

                        this.renderUserLocationMarker(lat, lng, accuracy);
                        this.renderMapMarkers(); // update popups dengan jarak aktual

                        if (manual && window.showToast) {
                            window.showToast(`Lokasi GPS Anda terdeteksi (akurasi: ±${Math.round(accuracy)}m).`, 'success', 'GPS Terdeteksi');
                        }
                    },
                    (err) => {
                        this.isLocating = false;
                        console.warn('Geolocation error:', err.message);
                        if (manual && window.showToast) {
                            window.showToast('Gagal mendeteksi lokasi GPS. Pastikan izin akses lokasi aktif di browser Anda.', 'warning', 'Akses Lokasi');
                        }
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 30000 }
                );
            },

            renderUserLocationMarker(lat, lng, accuracy) {
                if (!this.map || !this.userLocationGroup) return;
                this.userLocationGroup.clearLayers();

                // Radar pulse marker
                const userIcon = L.divIcon({
                    className: 'pupr-user-marker-icon',
                    html: `
                        <div class="user-pulse-marker">
                            <div class="user-pulse-ring"></div>
                            <div class="user-pulse-dot"></div>
                        </div>
                    `,
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });

                const marker = L.marker([lat, lng], { icon: userIcon, zIndexOffset: 2000 });
                marker.bindPopup(`
                    <div style="font-family: inherit; padding: 6px 8px; text-align: center;">
                        <div style="font-weight: 800; font-size: 12px; color: #1D2062;">📍 Lokasi Anda Saat Ini</div>
                        <div style="font-size: 11px; color: #64748B; margin-top: 2px;">Akurasi GPS: ±${Math.round(accuracy)} meter</div>
                    </div>
                `);
                this.userLocationGroup.addLayer(marker);

                // Lingkaran akurasi GPS
                const circle = L.circle([lat, lng], {
                    radius: Math.min(accuracy, 500),
                    color: '#2563EB',
                    fillColor: '#3B82F6',
                    fillOpacity: 0.15,
                    weight: 1.5
                });
                this.userLocationGroup.addLayer(circle);

                this.map.setView([lat, lng], 15, { animate: true });
            },

            calculateDistance(lat1, lon1, lat2, lon2) {
                const R = 6371; // Radius bumi dalam km
                const dLat = (lat2 - lat1) * Math.PI / 180;
                const dLon = (lon2 - lon1) * Math.PI / 180;
                const a = 
                    Math.sin(dLat/2) * Math.sin(dLat/2) +
                    Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
                    Math.sin(dLon/2) * Math.sin(dLon/2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                return R * c; // Hasil dalam km
            },

            renderMapMarkers() {
                if (!this.markersLayer) return;
                this.markersLayer.clearLayers();
                this.markerInstances = {};

                const markersData = window.__publicMapMarkers;
                if (!markersData || markersData.length === 0) return;

                const selKec = (this.selectedKecamatan || '').trim().toLowerCase();

                // Cek apakah kecamatan yang dipilih memiliki data ruas jalan
                const kecHasRoads = !selKec || markersData.some(m => 
                    (m.kecamatan || '').trim().toLowerCase() === selKec
                );

                markersData.forEach(item => {
                    const itemKec = (item.kecamatan || '').trim().toLowerCase();

                    // Filter Kecamatan: jika kecamatan memiliki data jalan, filter hanya untuk kecamatan tersebut
                    // Jika kecamatan yang diklik belum memiliki data survei jalan, biarkan titik ruas jalan lain tetap tampak
                    // agar peta tidak mendadak kosong dan pengguna tetap memahami sebaran titik di wilayah lain!
                    if (selKec && kecHasRoads) {
                        if (itemKec !== selKec) {
                            return;
                        }
                    }

                    // Filter Prioritas
                    if (this.priorityFilter === 'urgent' && item.rank > 5) return;
                    if (this.priorityFilter === 'medium' && (item.rank <= 5 || item.rank > 15)) return;
                    if (this.priorityFilter === 'routine' && item.rank <= 15) return;

                    // Tentukan warna pin marker berdasarkan ranking MOORA
                    let markerBg = '#059669'; // Hijau Emerald (Berkala > 15)
                    let priorityLabel = 'Berkala';
                    if (item.rank <= 5) {
                        markerBg = '#DC2626'; // Merah (Mendesak 1-5)
                        priorityLabel = 'Mendesak';
                    } else if (item.rank <= 15) {
                        markerBg = '#D97706'; // Kuning Amber (Sedang 6-15)
                        priorityLabel = 'Sedang';
                    }

                    // Pin Vektor Presisi Tinggi (SVG Teardrop Needle Pin)
                    // Anchor [17, 42] menancap 100% presisi pada ujung jarum di koordinat GPS
                    const customIcon = L.divIcon({
                        className: 'pupr-custom-div-icon',
                        html: `
                            <div class="pupr-marker-container" id="marker-pin-${item.id}">
                                <svg class="pupr-needle-svg" width="34" height="44" viewBox="0 0 34 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <ellipse cx="17" cy="43" rx="6.5" ry="2" fill="rgba(15, 23, 42, 0.4)" />
                                    <path d="M17 42 C16 37 4 25 4 16 C4 8.8 9.8 3 17 3 C24.2 3 30 8.8 30 16 C30 25 18 37 17 42 Z" fill="${markerBg}" stroke="#FFFFFF" stroke-width="2.2" stroke-linejoin="round" />
                                    <circle cx="17" cy="16" r="9.5" fill="rgba(255, 255, 255, 0.22)" />
                                    <text x="17" y="19.5" text-anchor="middle" fill="#FFFFFF" font-size="10.5" font-weight="900" font-family="system-ui, -apple-system, sans-serif" letter-spacing="-0.5px">#${item.rank}</text>
                                </svg>
                            </div>
                        `,
                        iconSize: [34, 44],
                        iconAnchor: [17, 42],
                        popupAnchor: [0, -42]
                    });

                    const marker = L.marker([item.lat, item.lng], { icon: customIcon });

                    // Hitung jarak ke posisi GPS pengguna jika aktif
                    let distanceHtml = '';
                    if (this.userCoords) {
                        const dist = this.calculateDistance(this.userCoords.lat, this.userCoords.lng, item.lat, item.lng);
                        const distFormatted = dist < 1 ? `${Math.round(dist * 1000)} meter` : `${dist.toFixed(1)} km`;
                        distanceHtml = `
                            <div class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-blue-50 border border-blue-100 text-blue-800 text-[11px] font-semibold">
                                <i class="bi bi-geo-alt-fill text-blue-600"></i>
                                <span>Jarak dari lokasi Anda: <strong>${distFormatted}</strong></span>
                            </div>
                        `;
                    }

                    // Thumbnail foto ruas jalan (hanya ditampilkan jika ada)
                    const photoHtml = item.photo 
                        ? `<div style="height: 135px; width: 100%; overflow: hidden; background: #0f172a; position: relative;">
                            <img src="${item.photo}" style="width: 100%; height: 100%; object-fit: cover;" alt="Foto Jalan">
                            <span style="position: absolute; bottom: 6px; left: 8px; background: rgba(15, 23, 42, 0.75); color: #ffffff; padding: 2px 7px; border-radius: 6px; font-size: 10px; font-weight: 600;">
                                <i class="bi bi-camera-fill" style="color: #FBBF24;"></i> Dokumentasi Lapangan
                            </span>
                           </div>` 
                        : '';

                    // Popup Card Resmi Dinas PUPR yang Bersih & Presisi
                    const popupContent = `
                        <div style="font-family: inherit; width: 100%;" class="bg-white text-slate-800">
                            <!-- Banner Status Prioritas -->
                            <div style="background-color: ${markerBg}; padding-right: 36px !important;" class="px-3.5 py-2.5 text-white flex items-center justify-between gap-2">
                                <div class="flex items-center gap-1.5 min-w-0">
                                    <span class="bg-white/20 px-2 py-0.5 rounded text-[11px] font-black tracking-wider uppercase whitespace-nowrap">
                                        #${item.rank}
                                    </span>
                                    <span class="text-xs font-bold whitespace-nowrap truncate">
                                        Prioritas ${priorityLabel}
                                    </span>
                                </div>
                                <div class="text-[11px] font-mono font-bold bg-black/25 px-2 py-0.5 rounded text-white/95 whitespace-nowrap flex-shrink-0">
                                    Yi: ${item.score}
                                </div>
                            </div>

                            ${photoHtml}

                            <div class="p-3.5 space-y-3">
                                <div>
                                    <h4 class="font-bold text-sm text-slate-900 leading-snug m-0">${item.name}</h4>
                                    <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-1">
                                        <i class="bi bi-geo-alt-fill text-brand-purple text-xs flex-shrink-0"></i>
                                        <span class="truncate">Kec. ${item.kecamatan}, Kel. ${item.kelurahan}</span>
                                    </div>
                                    <div class="inline-flex items-center gap-1 px-2 py-0.5 mt-1.5 rounded-md bg-slate-100 text-slate-600 font-mono text-[10px]">
                                        <i class="bi bi-crosshair text-slate-400"></i>
                                        <span>${item.lat.toFixed(6)}, ${item.lng.toFixed(6)}</span>
                                    </div>
                                </div>

                                <!-- Grid 2x2 Parameter Teknis -->
                                <div class="grid grid-cols-2 gap-2 text-xs bg-slate-50 p-2.5 rounded-xl border border-slate-200/80">
                                    <div>
                                        <span class="text-slate-400 block text-[10px] font-medium">Panjang (C1)</span>
                                        <span class="font-bold text-slate-800 text-xs">${item.c1 || '-'}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px] font-medium">Lebar (C2)</span>
                                        <span class="font-bold text-slate-800 text-xs">${item.c2 || '-'}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px] font-medium">Tingkat Kerusakan</span>
                                        <span class="font-bold text-xs ${item.damage_label && item.damage_label.includes('Berat') ? 'text-red-600' : (item.damage_label && item.damage_label.includes('Sedang') ? 'text-amber-600' : 'text-emerald-600')}">
                                            ${item.damage_label || '-'}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px] font-medium">Fasilitas (C5)</span>
                                        <span class="font-bold text-slate-800 text-xs truncate block">${item.c5 || '-'}</span>
                                    </div>
                                </div>

                                ${distanceHtml}

                                <!-- Tombol Aksi Navigasi & Tabel -->
                                <div class="pt-0.5 flex items-center gap-2">
                                    <a href="https://www.google.com/maps/dir/?api=1&destination=${item.lat},${item.lng}" target="_blank" rel="noopener noreferrer" 
                                       class="pupr-popup-btn flex-1 inline-flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl bg-brand-purple hover:bg-brand-purple-hover text-white text-xs font-bold shadow-xs transition-all active:scale-95" 
                                       style="color: #FFFFFF !important; text-decoration: none; background-color: #1D2062;">
                                        <i class="bi bi-compass-fill" style="color: #FBBF24; font-size: 13px;"></i>
                                        <span style="color: #FFFFFF !important;">Petunjuk Arah</span>
                                    </a>
                                    <button type="button" onclick="window.__publicScrollToTable(${item.id})"
                                            class="inline-flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold border border-slate-200 transition-all cursor-pointer active:scale-95"
                                            title="Fokuskan ke Baris Tabel Prioritas">
                                        <i class="bi bi-table text-slate-600"></i>
                                        <span>Tabel</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;

                    marker.bindPopup(popupContent);
                    this.markersLayer.addLayer(marker);
                    this.markerInstances[item.id] = marker;
                });
            },

            focusMarker(roadId, lat, lng) {
                const mapSection = document.getElementById('peta');
                if (mapSection) {
                    mapSection.scrollIntoView({ behavior: 'smooth' });
                }

                // Jika marker saat ini tersembunyi karena filter, buka filternya agar pin muncul
                const markerData = (window.__publicMapMarkers || []).find(m => m.id === roadId);
                if (markerData) {
                    let needRerender = false;
                    // Sorot batasan wilayah kecamatan ruas jalan ini (skip fitBounds agar flyTo berlangsung mulus)
                    if (markerData.kecamatan && (this.selectedKecamatan || '').toLowerCase() !== markerData.kecamatan.toLowerCase()) {
                        this.selectedKecamatan = markerData.kecamatan;
                        this.updateBoundaryHighlight(markerData.kecamatan, true);
                        needRerender = true;
                    }
                    if (this.priorityFilter !== 'all') {
                        if (this.priorityFilter === 'urgent' && markerData.rank > 5) { this.priorityFilter = 'all'; needRerender = true; }
                        if (this.priorityFilter === 'medium' && (markerData.rank <= 5 || markerData.rank > 15)) { this.priorityFilter = 'all'; needRerender = true; }
                        if (this.priorityFilter === 'routine' && markerData.rank <= 15) { this.priorityFilter = 'all'; needRerender = true; }
                    }
                    if (needRerender) {
                        this.renderMapMarkers();
                    }
                }

                setTimeout(() => {
                    if (this.map) {
                        this.map.stop();
                        this.map.flyTo([lat, lng], 17, { duration: 0.7 });
                        this.map.once('moveend', () => {
                            const marker = this.markerInstances[roadId];
                            if (marker) {
                                marker.openPopup();
                                // Berikan efek pantulan pin agar mudah dikenali
                                const pinEl = document.getElementById(`marker-pin-${roadId}`);
                                if (pinEl) {
                                    pinEl.classList.add('pupr-pin-active');
                                    setTimeout(() => pinEl.classList.remove('pupr-pin-active'), 2000);
                                }
                            }
                        });
                    }
                }, 300);
            },

            scrollToTableRow(roadId) {
                const targetRow = document.getElementById(`road-row-${roadId}`) || document.getElementById(`road-card-${roadId}`);
                if (targetRow) {
                    targetRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    targetRow.classList.add('row-highlight-flash');
                    setTimeout(() => {
                        targetRow.classList.remove('row-highlight-flash');
                    }, 2600);
                } else {
                    const prioritasSection = document.getElementById('prioritas');
                    if (prioritasSection) {
                        prioritasSection.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            }
        };
    }
</script>
@endpush
@endsection
