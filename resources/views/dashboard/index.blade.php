@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between gap-3 mb-5 sm:mb-6">
    <div class="min-w-0 flex-1">
        <h2 class="text-xl sm:text-2xl font-black text-gray-900 leading-tight">
            Dashboard Sistem
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
            Ringkasan data jalan & perangkingan prioritas MOORA.
        </p>
    </div>
    @if (auth()->user()->role === 'petugas')
        <a href="{{ route('roads.create') }}" class="inline-flex items-center justify-center rounded-xl bg-brand-purple px-3.5 py-2 sm:px-4 sm:py-2.5 text-xs sm:text-sm font-bold text-white shadow-xs hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all flex-shrink-0">
            <i class="bi bi-plus-lg mr-1.5"></i> <span>Input Jalan</span>
        </a>
    @endif
</div>

<div class="bg-brand-purple rounded-2xl p-4 sm:p-6 text-white shadow-sm mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div>
            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-white/20 text-white uppercase tracking-wider mb-1.5">
                Role: {{ ucfirst(auth()->user()->role) }}
            </span>
            <h3 class="text-base sm:text-xl font-bold leading-snug">
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
        @if(auth()->user()->role === 'petugas')
            <a href="{{ route('roads.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-brand-yellow text-purple-950 text-xs sm:text-sm font-black shadow-xs hover:bg-yellow-400 transition-all flex-shrink-0">
                <i class="bi bi-plus-circle-fill"></i> Tambah Data Survei
            </a>
        @endif
    </div>
</div>

<!-- 4 STAT CARDS (2-COLUMN DI MOBILE)         -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mb-6 sm:mb-8">
    <!-- Stat 1: Total Ruas Jalan -->
    <div class="bg-white rounded-2xl shadow-xs border border-gray-200 p-3.5 sm:p-5 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-[11px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider">Total Jalan</span>
            <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-purple-50 text-brand-purple flex items-center justify-center text-sm sm:text-base border border-purple-100 flex-shrink-0">
                <i class="bi bi-signpost-2"></i>
            </div>
        </div>
        <div class="mt-2 sm:mt-3">
            <div class="text-2xl sm:text-3xl font-black text-gray-900 leading-none">{{ $roadCount }}</div>
            <span class="text-[10px] sm:text-xs text-gray-400 mt-1 block">Ruas terdata</span>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-xs border border-gray-200 p-3.5 sm:p-5 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-[11px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider">Kriteria</span>
            <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm sm:text-base border border-blue-100 flex-shrink-0">
                <i class="bi bi-list-check"></i>
            </div>
        </div>
        <div class="mt-2 sm:mt-3">
            <div class="text-2xl sm:text-3xl font-black text-gray-900 leading-none">{{ $criterionCount }}</div>
            <span class="text-[10px] sm:text-xs text-gray-400 mt-1 block">Parameter MOORA</span>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-xs border border-amber-200 p-3.5 sm:p-5 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-[11px] sm:text-xs font-bold text-amber-900 uppercase tracking-wider flex items-center gap-1">
                <i class="bi bi-star-fill text-amber-500 text-[10px]"></i> Prioritas #1
            </span>
            <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-sm sm:text-base border border-amber-200 flex-shrink-0">
                <i class="bi bi-trophy-fill"></i>
            </div>
        </div>
        <div class="mt-2 sm:mt-3">
            <div class="text-xs sm:text-sm font-bold text-gray-900 line-clamp-2 leading-tight" title="{{ optional($ranking['road'] ?? null)->location ?? 'Belum ada' }}">
                {{ optional($ranking['road'] ?? null)->location ?? 'Belum ada data' }}
            </div>
            <span class="text-[10px] sm:text-xs text-amber-700 font-semibold mt-1 block truncate">
                {{ optional($ranking['road'] ?? null)->kecamatan ?? '-' }}
            </span>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-xs border border-gray-200 p-3.5 sm:p-5 flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <span class="text-[11px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider">Skor Tertinggi</span>
            <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm sm:text-base border border-emerald-100 flex-shrink-0">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
        </div>
        <div class="mt-2 sm:mt-3">
            <div class="text-xl sm:text-3xl font-black text-brand-purple font-mono leading-none">
                {{ isset($ranking['result']) ? number_format($ranking['result'], 4) : '-' }}
            </div>
            <span class="text-[10px] sm:text-xs text-gray-400 mt-1 block">Nilai optimalisasi Yi</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6 mb-8">
    <div class="lg:col-span-7">
        <div class="bg-white rounded-2xl shadow-xs border border-gray-200 h-full overflow-hidden flex flex-col">
            <div class="px-4 sm:px-5 py-3.5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h3 class="font-bold text-gray-900 text-xs sm:text-sm flex items-center gap-2">
                    <i class="bi bi-trophy text-amber-500"></i> Top 3 Prioritas Jalan
                </h3>
                <a href="{{ route('moora.index') }}" class="text-xs font-bold text-brand-purple hover:underline flex items-center gap-1">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="divide-y divide-gray-100 flex-1">
                @forelse ($topThree as $row)
                    <div class="p-3.5 sm:p-5 flex items-center justify-between gap-3 hover:bg-gray-50/80 transition-colors {{ $row['rank'] === 1 ? 'bg-amber-50/20' : '' }}">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-1.5 mb-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-black {{ $row['rank'] === 1 ? 'bg-amber-400 text-amber-950 ring-1 ring-amber-300' : ($row['rank'] === 2 ? 'bg-slate-200 text-slate-800' : 'bg-amber-700/20 text-amber-900') }}">
                                    #{{ $row['rank'] }}
                                </span>
                                <span class="text-[11px] text-gray-500 truncate">
                                    {{ $row['road']->kecamatan }}, {{ $row['road']->kelurahan }}
                                </span>
                            </div>
                            <h4 class="font-bold text-gray-900 text-xs sm:text-sm leading-snug line-clamp-2">{{ $row['road']->location }}</h4>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <div class="text-sm sm:text-lg font-black text-brand-purple font-mono">{{ number_format($row['result'], 4) }}</div>
                            <div class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Skor Yi</div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center my-auto">
                        <i class="bi bi-inbox text-3xl text-gray-300"></i>
                        <p class="mt-2 text-xs sm:text-sm text-gray-500 font-medium">Belum ada data hasil perhitungan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="lg:col-span-5">
        <div class="bg-white rounded-2xl shadow-xs border border-gray-200 h-full overflow-hidden flex flex-col">
            <div class="px-4 sm:px-5 py-3.5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h3 class="font-bold text-gray-900 text-xs sm:text-sm flex items-center gap-2">
                    <i class="bi bi-signpost-split text-brand-purple"></i> Ruas Jalan Terbaru
                </h3>
                <a href="{{ route('roads.index') }}" class="text-xs font-bold text-brand-purple hover:underline flex items-center gap-1">
                    Semua Jalan <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="divide-y divide-gray-100 flex-1">
                @forelse ($latestRoads as $road)
                    <div class="p-3.5 sm:px-5 sm:py-4 flex justify-between items-center gap-2 hover:bg-gray-50/80 transition-colors">
                        <div class="min-w-0 flex-1">
                            <div class="font-bold text-gray-900 text-xs sm:text-sm truncate">{{ $road->location }}</div>
                            <div class="text-[11px] text-gray-400 mt-0.5 truncate">
                                {{ $road->kecamatan }}, {{ $road->kelurahan }}
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0 text-[11px] text-gray-500">
                            <div class="font-bold text-gray-800 truncate">{{ $road->user->name ?? 'Petugas PUPR' }}</div>
                            <div class="text-[10px] text-gray-400">{{ $road->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center my-auto">
                        <i class="bi bi-inbox text-3xl text-gray-300"></i>
                        <p class="mt-2 text-xs sm:text-sm text-gray-500 font-medium">Belum ada data ruas jalan yang diinput.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@if(isset($latestActivities) && count($latestActivities) > 0 && auth()->user()->role === 'admin')
    <!-- Aktivitas Terkini (Khusus Admin) -->
    <div class="bg-white rounded-2xl shadow-xs border border-gray-200 overflow-hidden">
        <div class="px-4 sm:px-5 py-3.5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <h3 class="font-bold text-gray-900 text-xs sm:text-sm flex items-center gap-2">
                <i class="bi bi-clock-history text-brand-purple"></i> Log Aktivitas Terakhir
            </h3>
            <a href="{{ route('activity-logs.index') }}" class="text-xs font-bold text-brand-purple hover:underline flex items-center gap-1">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach($latestActivities as $act)
                <div class="px-4 sm:px-5 py-3 flex items-center justify-between gap-3 text-xs sm:text-sm hover:bg-gray-50/70 transition-colors">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="w-2 h-2 rounded-full bg-brand-purple flex-shrink-0"></span>
                        <span class="font-bold text-gray-900 flex-shrink-0">{{ $act->user->name ?? 'Pengguna' }}:</span>
                        <span class="text-gray-600 truncate">{{ $act->description }}</span>
                    </div>
                    <span class="text-[11px] text-gray-400 font-medium whitespace-nowrap flex-shrink-0">{{ $act->created_at->diffForHumans() }}</span>
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection

