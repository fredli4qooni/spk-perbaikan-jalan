@extends('layouts.app')

@section('content')
<div class="bg-brand-purple rounded-2xl p-4 sm:p-6 text-white shadow-sm mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div>
            <h3 class="text-base sm:text-xl font-semibold leading-snug">
                Halo, {{ auth()->user()->name }}! 👋
            </h3>
            <p class="text-xs sm:text-sm text-purple-100 mt-0.5 max-w-xl">
                @if(auth()->user()->role === 'petugas')
                    Pantau data survei lapangan dan hasil perangkingan prioritas perbaikan jalan secara real-time.
                @else
                    Kelola data ruas jalan, kriteria MOORA, dan pantau log aktivitas sistem.
                @endif
            </p>
        </div>
    </div>
</div>

<!-- 4 STAT CARDS (2-COLUMN DI MOBILE)         -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mb-6 sm:mb-8">
    <!-- Stat 1: Total Ruas Jalan -->
    <div class="bg-white rounded-2xl shadow-xs border border-gray-200 p-3.5 sm:p-5 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-[11px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Jalan</span>
            <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-purple-50 text-brand-purple flex items-center justify-center text-sm sm:text-base border border-purple-100 flex-shrink-0">
                <i class="bi bi-signpost-2"></i>
            </div>
        </div>
        <div class="mt-2 sm:mt-3">
            <div class="text-2xl sm:text-3xl font-bold text-gray-900 leading-none">{{ $roadCount }}</div>
            <span class="text-[10px] sm:text-xs text-gray-400 mt-1 block">Ruas terdata</span>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-xs border border-gray-200 p-3.5 sm:p-5 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-[11px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider">Kriteria</span>
            <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm sm:text-base border border-blue-100 flex-shrink-0">
                <i class="bi bi-list-check"></i>
            </div>
        </div>
        <div class="mt-2 sm:mt-3">
            <div class="text-2xl sm:text-3xl font-bold text-gray-900 leading-none">{{ $criterionCount }}</div>
            <span class="text-[10px] sm:text-xs text-gray-400 mt-1 block">Parameter MOORA</span>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-xs border border-amber-200 p-3.5 sm:p-5 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-[11px] sm:text-xs font-semibold text-amber-900 uppercase tracking-wider flex items-center gap-1">
                <i class="bi bi-star-fill text-amber-500 text-[10px]"></i> Prioritas #1
            </span>
            <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-sm sm:text-base border border-amber-200 flex-shrink-0">
                <i class="bi bi-trophy-fill"></i>
            </div>
        </div>
        <div class="mt-2 sm:mt-3">
            <div class="text-xs sm:text-sm font-semibold text-gray-900 line-clamp-2 leading-tight" title="{{ optional($ranking['road'] ?? null)->location ?? 'Belum ada' }}">
                {{ optional($ranking['road'] ?? null)->location ?? 'Belum ada data' }}
            </div>
            <span class="text-[10px] sm:text-xs text-amber-700 font-medium mt-1 block truncate">
                {{ optional($ranking['road'] ?? null)->kecamatan ?? '-' }}
            </span>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-xs border border-gray-200 p-3.5 sm:p-5 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-[11px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider">Skor Tertinggi</span>
            <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm sm:text-base border border-emerald-100 flex-shrink-0">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
        </div>
        <div class="mt-2 sm:mt-3">
            <div class="text-xl sm:text-3xl font-bold text-brand-purple font-mono leading-none">
                {{ isset($ranking['result']) ? number_format($ranking['result'], 4) : '-' }}
            </div>
            <span class="text-[10px] sm:text-xs text-gray-400 mt-1 block">Nilai optimalisasi Yi</span>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MENU PINTAS CEPAT (BRImo-Style Quick Action Shortcuts)    -->
<!-- ======================================================== -->
<div class="bg-white rounded-2xl shadow-xs border border-gray-200 p-4 sm:p-5 mb-6 sm:mb-8">
    <div class="flex items-center justify-between gap-2 mb-3.5 pb-2.5 border-b border-gray-100">
        <h3 class="text-xs sm:text-sm font-semibold text-gray-900 flex items-center gap-2">
            <i class="bi bi-lightning-charge-fill text-amber-500 text-sm sm:text-base"></i>
            <span>Aksi Cepat Sistem</span>
        </h3>
        <span class="text-[11px] text-gray-400 font-medium">Akses operasional instan</span>
    </div>

    @if (auth()->user()->role === 'petugas')
        <!-- Menu Pintas Petugas Lapangan (4-kolom mobile / 6-kolom desktop) -->
        <div class="grid grid-cols-4 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-6 gap-2.5 sm:gap-3.5">
            <!-- 1. Input Ruas Baru (Hero Priority) -->
            <a href="{{ route('roads.create') }}" class="group flex flex-col items-center text-center p-2 rounded-xl hover:bg-purple-50/50 transition-all cursor-pointer">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-brand-purple text-white flex items-center justify-center text-lg sm:text-xl shadow-xs group-hover:bg-brand-purple-hover group-hover:scale-105 group-active:scale-95 transition-all">
                    <i class="bi bi-plus-lg"></i>
                </div>
                <span class="text-[11px] sm:text-xs font-semibold text-gray-800 group-hover:text-brand-purple mt-2 leading-tight">
                    Input Jalan
                </span>
            </a>

            <!-- 2. Data Ruas Jalan -->
            <a href="{{ route('roads.index') }}" class="group flex flex-col items-center text-center p-2 rounded-xl hover:bg-blue-50/50 transition-all cursor-pointer">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-blue-50 text-blue-700 border border-blue-200/80 flex items-center justify-center text-lg sm:text-xl group-hover:bg-blue-600 group-hover:text-white group-hover:scale-105 group-active:scale-95 transition-all">
                    <i class="bi bi-signpost-split-fill"></i>
                </div>
                <span class="text-[11px] sm:text-xs font-semibold text-gray-800 group-hover:text-blue-700 mt-2 leading-tight">
                    Data Jalan
                </span>
            </a>

            <!-- 3. Hasil MOORA -->
            <a href="{{ route('moora.index') }}" class="group flex flex-col items-center text-center p-2 rounded-xl hover:bg-indigo-50/50 transition-all cursor-pointer">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-indigo-50 text-indigo-700 border border-indigo-200/80 flex items-center justify-center text-lg sm:text-xl group-hover:bg-indigo-600 group-hover:text-white group-hover:scale-105 group-active:scale-95 transition-all">
                    <i class="bi bi-bar-chart-line-fill"></i>
                </div>
                <span class="text-[11px] sm:text-xs font-semibold text-gray-800 group-hover:text-indigo-700 mt-2 leading-tight">
                    Hasil MOORA
                </span>
            </a>

            <!-- 4. Laporan Prioritas -->
            <a href="{{ route('reports.index') }}" class="group flex flex-col items-center text-center p-2 rounded-xl hover:bg-emerald-50/50 transition-all cursor-pointer">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 flex items-center justify-center text-lg sm:text-xl group-hover:bg-brand-green group-hover:text-white group-hover:scale-105 group-active:scale-95 transition-all">
                    <i class="bi bi-file-earmark-check-fill"></i>
                </div>
                <span class="text-[11px] sm:text-xs font-semibold text-gray-800 group-hover:text-brand-green mt-2 leading-tight">
                    Laporan
                </span>
            </a>

            <!-- 5. Unduh CSV -->
            <a href="{{ route('reports.export.csv') }}" class="group flex flex-col items-center text-center p-2 rounded-xl hover:bg-teal-50/50 transition-all cursor-pointer">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-teal-50 text-teal-700 border border-teal-200/80 flex items-center justify-center text-lg sm:text-xl group-hover:bg-teal-600 group-hover:text-white group-hover:scale-105 group-active:scale-95 transition-all">
                    <i class="bi bi-filetype-csv"></i>
                </div>
                <span class="text-[11px] sm:text-xs font-semibold text-gray-800 group-hover:text-teal-700 mt-2 leading-tight">
                    Unduh CSV
                </span>
            </a>

            <!-- 6. Profil Akun -->
            <a href="{{ route('profile.edit') }}" class="group flex flex-col items-center text-center p-2 rounded-xl hover:bg-gray-100 transition-all cursor-pointer">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gray-100 text-gray-700 border border-gray-200/80 flex items-center justify-center text-lg sm:text-xl group-hover:bg-gray-800 group-hover:text-white group-hover:scale-105 group-active:scale-95 transition-all">
                    <i class="bi bi-person-gear"></i>
                </div>
                <span class="text-[11px] sm:text-xs font-semibold text-gray-800 group-hover:text-gray-900 mt-2 leading-tight">
                    Profil Saya
                </span>
            </a>
        </div>
    @else
        <!-- Menu Pintas Admin PUPR (4-kolom mobile / 6-kolom desktop) -->
        <div class="grid grid-cols-4 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-6 gap-2.5 sm:gap-3.5">
            <!-- 1. Data Ruas Jalan -->
            <a href="{{ route('roads.index') }}" class="group flex flex-col items-center text-center p-2 rounded-xl hover:bg-blue-50/50 transition-all cursor-pointer">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-blue-50 text-blue-700 border border-blue-200/80 flex items-center justify-center text-lg sm:text-xl group-hover:bg-blue-600 group-hover:text-white group-hover:scale-105 group-active:scale-95 transition-all">
                    <i class="bi bi-signpost-split-fill"></i>
                </div>
                <span class="text-[11px] sm:text-xs font-semibold text-gray-800 group-hover:text-blue-700 mt-2 leading-tight">
                    Data Jalan
                </span>
            </a>

            <!-- 2. Hitung MOORA -->
            <a href="{{ route('moora.index') }}" class="group flex flex-col items-center text-center p-2 rounded-xl hover:bg-purple-50/50 transition-all cursor-pointer">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-purple-50 text-brand-purple border border-purple-200/80 flex items-center justify-center text-lg sm:text-xl group-hover:bg-brand-purple group-hover:text-white group-hover:scale-105 group-active:scale-95 transition-all">
                    <i class="bi bi-calculator-fill"></i>
                </div>
                <span class="text-[11px] sm:text-xs font-semibold text-gray-800 group-hover:text-brand-purple mt-2 leading-tight">
                    Hitung MOORA
                </span>
            </a>

            <!-- 3. Laporan Prioritas -->
            <a href="{{ route('reports.index') }}" class="group flex flex-col items-center text-center p-2 rounded-xl hover:bg-emerald-50/50 transition-all cursor-pointer">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 flex items-center justify-center text-lg sm:text-xl group-hover:bg-brand-green group-hover:text-white group-hover:scale-105 group-active:scale-95 transition-all">
                    <i class="bi bi-file-earmark-check-fill"></i>
                </div>
                <span class="text-[11px] sm:text-xs font-semibold text-gray-800 group-hover:text-brand-green mt-2 leading-tight">
                    Laporan
                </span>
            </a>

            <!-- 4. Export CSV -->
            <a href="{{ route('reports.export.csv') }}" class="group flex flex-col items-center text-center p-2 rounded-xl hover:bg-teal-50/50 transition-all cursor-pointer">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-teal-50 text-teal-700 border border-teal-200/80 flex items-center justify-center text-lg sm:text-xl group-hover:bg-teal-600 group-hover:text-white group-hover:scale-105 group-active:scale-95 transition-all">
                    <i class="bi bi-filetype-csv"></i>
                </div>
                <span class="text-[11px] sm:text-xs font-semibold text-gray-800 group-hover:text-teal-700 mt-2 leading-tight">
                    Export CSV
                </span>
            </a>

            <!-- 5. Kriteria & Bobot -->
            <a href="{{ route('criteria.index') }}" class="group flex flex-col items-center text-center p-2 rounded-xl hover:bg-amber-50/50 transition-all cursor-pointer">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-amber-50 text-amber-800 border border-amber-200/80 flex items-center justify-center text-lg sm:text-xl group-hover:bg-amber-500 group-hover:text-white group-hover:scale-105 group-active:scale-95 transition-all">
                    <i class="bi bi-sliders"></i>
                </div>
                <span class="text-[11px] sm:text-xs font-semibold text-gray-800 group-hover:text-amber-800 mt-2 leading-tight">
                    Kriteria
                </span>
            </a>

            <!-- 6. Kelola User -->
            <a href="{{ route('users.index') }}" class="group flex flex-col items-center text-center p-2 rounded-xl hover:bg-indigo-50/50 transition-all cursor-pointer">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-indigo-50 text-indigo-700 border border-indigo-200/80 flex items-center justify-center text-lg sm:text-xl group-hover:bg-indigo-600 group-hover:text-white group-hover:scale-105 group-active:scale-95 transition-all">
                    <i class="bi bi-people-fill"></i>
                </div>
                <span class="text-[11px] sm:text-xs font-semibold text-gray-800 group-hover:text-indigo-700 mt-2 leading-tight">
                    Kelola User
                </span>
            </a>
        </div>
    @endif
</div>

<!-- ======================================================== -->
<!-- TABBED LIST: TOP 3 PRIORITAS & RUAS JALAN TERBARU         -->
<!-- ======================================================== -->
<div x-data="{ activeListTab: 'prioritas' }" class="bg-white rounded-2xl shadow-xs border border-gray-200 overflow-hidden mb-8">
    <!-- Header Kartu: Segmented Control Tabs & Link Aksi -->
    <div class="p-3 sm:px-5 sm:py-3.5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gray-50/50">
        <!-- Segmented Tab Pills (Full width 50/50 di mobile, auto di desktop) -->
        <div class="grid grid-cols-2 sm:inline-flex p-1 bg-gray-200/70 rounded-xl w-full sm:w-auto">
            <button 
                type="button" 
                @click="activeListTab = 'prioritas'"
                class="flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition-all cursor-pointer"
                :class="activeListTab === 'prioritas' ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-600 hover:text-gray-900'"
            >
                <i class="bi bi-trophy-fill text-amber-500 text-xs"></i>
                <span>Prioritas MOORA</span>
            </button>

            <button 
                type="button" 
                @click="activeListTab = 'terbaru'"
                class="flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition-all cursor-pointer"
                :class="activeListTab === 'terbaru' ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-600 hover:text-gray-900'"
            >
                <i class="bi bi-clock-history text-brand-purple text-xs"></i>
                <span>Jalan Terbaru</span>
            </button>
        </div>

        <!-- Tautan Kontekstual Desktop (>= sm) -->
        <div class="hidden sm:flex items-center flex-shrink-0">
            <a 
                :href="activeListTab === 'prioritas' ? '{{ route('moora.index') }}' : '{{ route('roads.index') }}'"
                class="text-xs font-semibold text-brand-purple hover:underline flex items-center gap-1"
            >
                <span x-text="activeListTab === 'prioritas' ? 'Semua Ranking MOORA' : 'Semua Ruas Jalan'"></span>
                <i class="bi bi-arrow-right text-[11px]"></i>
            </a>
        </div>
    </div>

    <!-- Isi Tab 1: Top 3 Prioritas Jalan -->
    <div x-show="activeListTab === 'prioritas'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="divide-y divide-gray-100">
        @forelse ($topThree as $row)
            <div class="p-3.5 sm:p-4 flex items-center justify-between gap-3 hover:bg-gray-50/80 transition-colors {{ $row['rank'] === 1 ? 'bg-amber-50/25' : '' }}">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold {{ $row['rank'] === 1 ? 'bg-amber-400 text-amber-950 ring-1 ring-amber-300' : ($row['rank'] === 2 ? 'bg-slate-200 text-slate-800' : 'bg-amber-700/20 text-amber-900') }}">
                            #{{ $row['rank'] }}
                        </span>
                        <span class="text-xs text-gray-500 truncate flex items-center gap-1">
                            <i class="bi bi-geo-alt text-[10px] text-brand-purple"></i>
                            {{ $row['road']->kecamatan }}, {{ $row['road']->kelurahan }}
                        </span>
                    </div>
                    <h4 class="font-semibold text-gray-900 text-xs sm:text-sm leading-snug line-clamp-2">
                        {{ $row['road']->location }}
                    </h4>
                </div>
                <div class="text-right flex-shrink-0 pl-2">
                    <div class="text-sm sm:text-base font-bold text-brand-purple font-mono">
                        {{ number_format($row['result'], 4) }}
                    </div>
                    <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Skor Yi</div>
                </div>
            </div>
        @empty
            <div class="p-8 text-center my-auto">
                <i class="bi bi-inbox text-3xl text-gray-300"></i>
                <p class="mt-2 text-xs sm:text-sm text-gray-500 font-medium">Belum ada data hasil perhitungan.</p>
            </div>
        @endforelse
    </div>

    <!-- Isi Tab 2: Ruas Jalan Terbaru -->
    <div x-show="activeListTab === 'terbaru'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="divide-y divide-gray-100" style="display: none;">
        @forelse ($latestRoads as $road)
            <div class="p-3.5 sm:p-4 flex justify-between items-center gap-3 hover:bg-gray-50/80 transition-colors">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-purple-50 text-brand-purple border border-purple-100">
                            {{ $road->survey_year }}
                        </span>
                        <span class="text-xs text-gray-500 truncate flex items-center gap-1">
                            <i class="bi bi-geo-alt text-[10px] text-brand-purple"></i>
                            {{ $road->kecamatan }}, {{ $road->kelurahan }}
                        </span>
                    </div>
                    <h4 class="font-semibold text-gray-900 text-xs sm:text-sm leading-snug truncate">
                        {{ $road->location }}
                    </h4>
                </div>
                <div class="text-right flex-shrink-0 pl-2 text-[11px] text-gray-500">
                    <div class="font-medium text-gray-800 truncate flex items-center justify-end gap-1">
                        <i class="bi bi-person text-[11px] text-gray-400"></i>
                        <span>{{ $road->user->name ?? 'Petugas PUPR' }}</span>
                    </div>
                    <div class="text-[10px] text-gray-400 mt-0.5">{{ $road->created_at->translatedFormat('d M Y') }}</div>
                </div>
            </div>
        @empty
            <div class="p-8 text-center my-auto">
                <i class="bi bi-inbox text-3xl text-gray-300"></i>
                <p class="mt-2 text-xs sm:text-sm text-gray-500 font-medium">Belum ada data ruas jalan yang diinput.</p>
            </div>
        @endforelse
    </div>

    <!-- Tautan Footer Khusus Mobile (< sm) -->
    <div class="sm:hidden p-3 border-t border-gray-100 bg-gray-50/60 text-center">
        <a 
            :href="activeListTab === 'prioritas' ? '{{ route('moora.index') }}' : '{{ route('roads.index') }}'"
            class="text-xs font-semibold text-brand-purple hover:underline inline-flex items-center justify-center gap-1.5 py-1 px-3"
        >
            <span x-text="activeListTab === 'prioritas' ? 'Lihat Semua Ranking MOORA' : 'Lihat Semua Ruas Jalan'"></span>
            <i class="bi bi-arrow-right text-[11px]"></i>
        </a>
    </div>
</div>

@if(isset($latestActivities) && count($latestActivities) > 0 && auth()->user()->role === 'admin')
    <!-- Aktivitas Terkini (Khusus Admin) -->
    <div class="bg-white rounded-2xl shadow-xs border border-gray-200 overflow-hidden">
        <div class="px-4 sm:px-5 py-3.5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <h3 class="font-semibold text-gray-900 text-xs sm:text-sm flex items-center gap-2">
                <i class="bi bi-clock-history text-brand-purple"></i> Log Aktivitas Terakhir
            </h3>
            <a href="{{ route('activity-logs.index') }}" class="text-xs font-semibold text-brand-purple hover:underline flex items-center gap-1">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach($latestActivities as $act)
                <div class="px-4 sm:px-5 py-3 flex items-center justify-between gap-3 text-xs sm:text-sm hover:bg-gray-50/70 transition-colors">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="w-2 h-2 rounded-full bg-brand-purple flex-shrink-0"></span>
                        <span class="font-semibold text-gray-900 flex-shrink-0">{{ $act->user->name ?? 'Pengguna' }}:</span>
                        <span class="text-gray-600 truncate">{{ $act->description }}</span>
                    </div>
                    <span class="text-[11px] text-gray-400 font-medium whitespace-nowrap flex-shrink-0">{{ $act->created_at->diffForHumans() }}</span>
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection

