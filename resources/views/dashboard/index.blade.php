@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
        <i class="bi bi-speedometer2 text-brand-purple"></i> Dashboard Sistem
    </h2>
    <p class="text-sm text-gray-500 mt-1">Ringkasan analitik data jalan dan perangkingan prioritas metode MOORA.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 flex items-center justify-between">
            <div>
                <div class="text-sm font-semibold text-gray-500">Total Ruas Jalan</div>
                <div class="text-3xl font-black text-gray-900 mt-1">{{ $roadCount }}</div>
            </div>
            <div class="text-5xl text-brand-purple opacity-20">
                <i class="bi bi-road-lane"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 flex items-center justify-between">
            <div>
                <div class="text-sm font-semibold text-gray-500">Kriteria Penilaian</div>
                <div class="text-3xl font-black text-gray-900 mt-1">{{ $criterionCount }}</div>
            </div>
            <div class="text-5xl text-blue-500 opacity-20">
                <i class="bi bi-list-check"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 flex items-center justify-between">
            <div>
                <div class="text-sm font-semibold text-gray-500">Prioritas #1 Teratas</div>
                <div class="text-lg font-bold text-gray-900 mt-1 truncate max-w-[180px]" title="{{ optional($ranking['road'] ?? null)->name ?? 'Belum ada' }}">
                    {{ optional($ranking['road'] ?? null)->name ?? 'Belum ada data' }}
                </div>
            </div>
            <div class="text-5xl text-amber-500 opacity-30">
                <i class="bi bi-trophy-fill"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 flex items-center justify-between">
            <div>
                <div class="text-sm font-semibold text-gray-500">Nilai MOORA Tertinggi</div>
                <div class="text-3xl font-black text-brand-purple mt-1">{{ isset($ranking['result']) ? number_format($ranking['result'], 4) : '-' }}</div>
            </div>
            <div class="text-5xl text-brand-yellow opacity-40">
                <i class="bi bi-graph-up"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
    <!-- Top 3 Prioritas -->
    <div class="lg:col-span-7">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 h-full overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h5 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="bi bi-trophy text-amber-500"></i> Top 3 Prioritas Perbaikan Jalan
                </h5>
                <a href="{{ route('moora.index') }}" class="text-xs font-bold text-brand-purple hover:underline flex items-center gap-1">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="divide-y divide-gray-100 flex-1">
                @forelse ($topThree as $row)
                    <div class="p-6 flex justify-between items-center hover:bg-gray-50 transition-colors">
                        <div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-black {{ $row['rank'] === 1 ? 'bg-amber-400 text-amber-950 ring-2 ring-amber-200' : ($row['rank'] === 2 ? 'bg-slate-200 text-slate-800' : 'bg-amber-700/20 text-amber-900') }} mb-2">
                                Peringkat #{{ $row['rank'] }}
                            </span>
                            <h6 class="font-bold text-gray-900 text-lg">{{ $row['road']->name }}</h6>
                            <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                                <i class="bi bi-geo-alt text-brand-purple"></i> {{ $row['road']->location }}
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-black text-brand-purple font-mono">{{ number_format($row['result'], 4) }}</div>
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mt-0.5">Skor MOORA</div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center my-auto">
                        <i class="bi bi-inbox text-4xl text-gray-300"></i>
                        <p class="mt-4 text-gray-500 font-medium">Belum ada data hasil perhitungan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Ruas Jalan Terbaru & Petugas Penginput -->
    <div class="lg:col-span-5">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 h-full overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h5 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="bi bi-signpost-split-fill text-brand-purple"></i> Data Ruas Jalan Terbaru
                </h5>
                <a href="{{ route('roads.index') }}" class="text-xs font-bold text-brand-purple hover:underline flex items-center gap-1">
                    Semua Jalan <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="divide-y divide-gray-100 flex-1">
                @forelse ($latestRoads as $road)
                    <div class="px-6 py-4 flex justify-between items-center hover:bg-gray-50 transition-colors">
                        <div>
                            <div class="font-bold text-gray-900 text-sm">{{ $road->name }}</div>
                            <div class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                                <i class="bi bi-geo-alt"></i> {{ $road->location }}
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-bold text-brand-purple flex items-center justify-end gap-1">
                                <i class="bi bi-person-circle"></i> {{ $road->user->name ?? 'Petugas' }}
                            </div>
                            <div class="text-[10px] text-gray-400 mt-0.5">
                                {{ $road->created_at->translatedFormat('d M Y') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center my-auto">
                        <i class="bi bi-inbox text-4xl text-gray-300"></i>
                        <p class="mt-4 text-gray-500 font-medium">Belum ada data ruas jalan yang diinput.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@if(isset($latestActivities) && count($latestActivities) > 0 && auth()->user()->role === 'admin')
    <!-- Aktivitas Terkini (Khusus Admin) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <h5 class="font-bold text-gray-800 flex items-center gap-2">
                <i class="bi bi-clock-history text-brand-purple"></i> Log Aktivitas Terakhir
            </h5>
            <a href="{{ route('activity-logs.index') }}" class="text-xs font-bold text-brand-purple hover:underline flex items-center gap-1">
                Lihat Semua Riwayat <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach($latestActivities as $act)
                <div class="px-6 py-3.5 flex items-center justify-between text-sm hover:bg-gray-50/70 transition-colors">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-brand-purple"></span>
                        <span class="font-bold text-gray-900">{{ $act->user->name ?? 'Pengguna' }}:</span>
                        <span class="text-gray-600">{{ $act->description }}</span>
                    </div>
                    <span class="text-xs text-gray-400 font-medium whitespace-nowrap">{{ $act->created_at->diffForHumans() }}</span>
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection
