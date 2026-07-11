@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
        <i class="bi bi-speedometer2 text-brand-purple"></i> Dashboard
    </h2>
    <p class="text-sm text-gray-500 mt-1">Ringkasan sistem MOORA</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500">Total Ruas Jalan</div>
                <div class="text-3xl font-bold text-gray-900 mt-1">{{ $roadCount }}</div>
            </div>
            <div class="text-5xl text-brand-purple opacity-20">
                <i class="bi bi-road-lane"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500">Total Kriteria</div>
                <div class="text-3xl font-bold text-gray-900 mt-1">{{ $criterionCount }}</div>
            </div>
            <div class="text-5xl text-blue-500 opacity-20">
                <i class="bi bi-list-check"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500">Prioritas 1</div>
                <div class="text-lg font-bold text-gray-900 mt-1 leading-tight">{{ optional($ranking['road'] ?? null)->name ?? 'Belum ada' }}</div>
            </div>
            <div class="text-5xl text-brand-green opacity-20">
                <i class="bi bi-check-circle"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500">Nilai Tertinggi</div>
                <div class="text-3xl font-bold text-gray-900 mt-1">{{ isset($ranking['result']) ? number_format($ranking['result'], 4) : '-' }}</div>
            </div>
            <div class="text-5xl text-brand-yellow opacity-40">
                <i class="bi bi-graph-up"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500">Terverifikasi</div>
                <div class="text-3xl font-bold text-brand-green mt-1">{{ $verifiedCount }}</div>
            </div>
            <div class="text-5xl text-brand-green opacity-20">
                <i class="bi bi-check2-circle"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500">Menunggu Verifikasi</div>
                <div class="text-3xl font-bold text-brand-yellow mt-1">{{ $pendingCount }}</div>
            </div>
            <div class="text-5xl text-brand-yellow opacity-40">
                <i class="bi bi-hourglass-split"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <div class="lg:col-span-7">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 h-full overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h5 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="bi bi-trophy text-brand-yellow"></i> Top 3 Prioritas Perbaikan
                </h5>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    MOORA
                </span>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($topThree as $row)
                    <div class="p-6 flex justify-between items-center hover:bg-gray-50 transition-colors">
                        <div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-purple text-white mb-2">
                                Rank {{ $row['rank'] }}
                            </span>
                            <h6 class="font-bold text-gray-900 text-lg">{{ $row['road']->name }}</h6>
                            <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                                <i class="bi bi-geo-alt"></i> {{ $row['road']->location }}
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-black text-brand-green">{{ number_format($row['result'], 4) }}</div>
                            <div class="text-xs font-medium text-gray-500 uppercase tracking-wider mt-1">Nilai MOORA</div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <i class="bi bi-inbox text-4xl text-gray-300"></i>
                        <p class="mt-4 text-gray-500 font-medium">Belum ada data untuk ditampilkan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="lg:col-span-5">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 h-full overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h5 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="bi bi-shield-check text-brand-green"></i> Status Verifikasi Terbaru
                </h5>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($latestRoads as $road)
                    <div class="px-6 py-4 flex justify-between items-center hover:bg-gray-50 transition-colors">
                        <div>
                            <div class="font-semibold text-gray-900">{{ $road->name }}</div>
                            <div class="text-sm text-gray-500 mt-0.5">{{ $road->location }}</div>
                        </div>
                        <div>
                            @if ($road->is_verified)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Terverifikasi
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Menunggu
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <i class="bi bi-inbox text-4xl text-gray-300"></i>
                        <p class="mt-4 text-gray-500 font-medium">Belum ada data ruas jalan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
