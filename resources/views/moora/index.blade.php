@extends('layouts.app')

@section('content')
<!-- Header Halaman (Rata Kiri Presisi) -->
<div class="flex items-center justify-between gap-3 mb-5">
    <div class="min-w-0 flex-1">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">
            Hasil MOORA
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
            Perankingan prioritas penanganan dan perbaikan infrastruktur jalan.
        </p>
    </div>
    @if(isset($results) && count($results) > 0)
        <a href="{{ route('reports.index') }}" class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 sm:px-4 sm:py-2.5 bg-white border border-gray-200 text-gray-700 text-xs sm:text-sm font-semibold rounded-xl shadow-xs hover:bg-gray-50 hover:text-brand-purple hover:border-brand-purple/30 transition-all flex-shrink-0">
            <i class="bi bi-printer text-sm sm:text-base"></i> <span>Laporan</span>
        </a>
    @endif
</div>

<!-- Pedoman Prioritas MOORA Info Bar (Ringkas & Efisien) -->
<div class="flex items-center gap-2.5 bg-purple-50/80 border border-purple-200/80 px-3.5 py-2.5 mb-4 rounded-xl text-xs text-gray-700 shadow-2xs">
    <i class="bi bi-info-circle-fill text-brand-purple text-sm flex-shrink-0"></i>
    <p class="leading-tight">
        <strong class="font-semibold text-gray-900">Peringkat #1</strong> adalah prioritas perbaikan tertinggi (paling mendesak) metode MOORA.
    </p>
</div>

<!-- Sub-bar: Total Terhitung & Opsi Tampilan Per Halaman -->
<div class="flex items-center justify-between gap-2 mb-4">
    <div class="flex items-center gap-1.5">
        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-purple-50 text-brand-purple border border-purple-200/80">
            <i class="bi bi-bar-chart-line text-xs"></i>
            <span>{{ $results->total() }} Ruas Terhitung</span>
        </span>
    </div>
    <div class="flex items-center gap-1.5 text-xs text-gray-500 font-medium">
        <span class="hidden sm:inline text-gray-400 text-[11px]">Tampilkan per hal:</span>
        <div class="inline-flex items-center p-0.5 bg-gray-100 rounded-lg border border-gray-200/80">
            <a href="{{ request()->fullUrlWithQuery(['per_page' => 5, 'page' => 1]) }}" class="px-2.5 py-0.5 rounded-md text-xs font-semibold transition-all {{ request('per_page', 5) == 5 ? 'bg-white text-gray-900 shadow-2xs' : 'text-gray-500 hover:text-gray-900' }}">5</a>
            <a href="{{ request()->fullUrlWithQuery(['per_page' => 10, 'page' => 1]) }}" class="px-2.5 py-0.5 rounded-md text-xs font-semibold transition-all {{ request('per_page', 5) == 10 ? 'bg-white text-gray-900 shadow-2xs' : 'text-gray-500 hover:text-gray-900' }}">10</a>
            <a href="{{ request()->fullUrlWithQuery(['per_page' => 25, 'page' => 1]) }}" class="px-2.5 py-0.5 rounded-md text-xs font-semibold transition-all {{ request('per_page', 5) == 25 ? 'bg-white text-gray-900 shadow-2xs' : 'text-gray-500 hover:text-gray-900' }}">25</a>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- TAMPILAN MOBILE (< md): 2-COLUMN RANKING CARDS -->
<!-- ========================================== -->
<div class="grid grid-cols-2 gap-2.5 sm:gap-3.5 md:hidden">
    @forelse ($results as $row)
        @php
            $isRank1 = $row['rank'] === 1;
            $isRank2 = $row['rank'] === 2;
            $isRank3 = $row['rank'] === 3;
            $isTop3 = $row['rank'] <= 3;
        @endphp
        <div class="bg-white rounded-2xl border transition-all duration-200 shadow-xs p-3.5 sm:p-4 flex flex-col justify-between space-y-3 h-full {{ $isRank1 ? 'border-amber-300 ring-2 ring-amber-200/60 bg-amber-50/25' : ($isTop3 ? 'border-purple-200/90' : 'border-gray-200') }}">
            <!-- Header Kartu: Peringkat & Status -->
            <div class="space-y-2">
                <div class="flex items-center justify-between gap-1.5">
                    @if ($isRank1)
                        <span class="w-8 h-8 rounded-xl bg-amber-400 text-amber-950 font-bold text-xs flex items-center justify-center shadow-xs ring-1 ring-amber-300 flex-shrink-0">
                            #1
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-100 text-amber-900 border border-amber-300 truncate">
                            <i class="bi bi-star-fill text-amber-500 mr-1 text-[9px]"></i> Utama
                        </span>
                    @elseif ($isRank2)
                        <span class="w-8 h-8 rounded-xl bg-slate-200 text-slate-800 font-bold text-xs flex items-center justify-center shadow-xs border border-slate-300 flex-shrink-0">
                            #2
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-50 text-red-700 border border-red-200">
                            Mendesak
                        </span>
                    @elseif ($isRank3)
                        <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-900 font-bold text-xs flex items-center justify-center shadow-xs border border-amber-200 flex-shrink-0">
                            #3
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-50 text-red-700 border border-red-200">
                            Mendesak
                        </span>
                    @else
                        <span class="w-8 h-8 rounded-xl bg-gray-100 text-gray-700 font-semibold text-xs flex items-center justify-center border border-gray-200 flex-shrink-0">
                            #{{ $row['rank'] }}
                        </span>
                        @if ($row['rank'] <= 7)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                Prioritas
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-800 border border-blue-200">
                                Berkala
                            </span>
                        @endif
                    @endif
                </div>

                <!-- Nama Ruas Jalan & Wilayah -->
                <div>
                    <h3 class="font-semibold text-gray-900 text-xs sm:text-sm leading-snug line-clamp-2">{{ $row['road']->location }}</h3>
                    <span class="text-[10px] sm:text-[11px] text-gray-400 block mt-0.5 truncate">
                        <i class="bi bi-geo-alt text-brand-purple text-[9px]"></i> {{ $row['road']->kecamatan }}
                    </span>
                </div>

                <!-- Context Chips: Tahun & Fasilitas -->
                <div class="flex items-center gap-1.5 pt-1 flex-wrap">
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-semibold bg-blue-50 text-blue-700 border border-blue-100 flex-shrink-0">
                        {{ $row['road']->survey_year }}
                    </span>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-medium bg-purple-50 text-brand-purple border border-purple-100 truncate max-w-full">
                        {{ $row['road']->c5_label }}
                    </span>
                </div>
            </div>

            <!-- Footer Card: Nilai Akhir (Yi) (Pinned Bottom) -->
            <div class="pt-2.5 border-t border-gray-100 flex items-center justify-between mt-auto">
                <span class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Nilai Yi</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-mono font-semibold {{ $isTop3 ? 'bg-brand-purple text-white shadow-2xs' : 'bg-gray-100 text-gray-800' }}">
                    {{ number_format($row['result'], 4) }}
                </span>
            </div>
        </div>
    @empty
        <div class="col-span-2 bg-white rounded-2xl border border-gray-200 p-8 text-center text-gray-500">
            <i class="bi bi-inbox text-4xl mb-2 block text-gray-300"></i>
            <p class="font-semibold text-gray-700 text-sm">Belum ada data ruas jalan untuk dihitung.</p>
            <p class="text-xs text-gray-400 mt-1">Tambahkan data ruas jalan terlebih dahulu.</p>
        </div>
    @endforelse
</div>

<!-- ========================================== -->
<!-- TAMPILAN DESKTOP (>= md): TABEL MODERN    -->
<!-- ========================================== -->
<div class="hidden md:block bg-white shadow-sm rounded-2xl border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-24">Peringkat</th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lokasi Ruas Jalan</th>
                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider w-48">Nilai Akhir MOORA (Yi)</th>
                    <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-44">Status Prioritas</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($results as $row)
                    <tr class="hover:bg-gray-50 transition-colors {{ $row['rank'] === 1 ? 'bg-amber-50/40' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($row['rank'] === 1)
                                <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-amber-400 text-amber-950 font-bold text-sm shadow-sm ring-4 ring-amber-100">
                                    #1
                                </span>
                            @elseif ($row['rank'] === 2)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-200 text-slate-800 font-semibold text-xs shadow-xs">
                                    #2
                                </span>
                            @elseif ($row['rank'] === 3)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 text-amber-900 font-semibold text-xs">
                                    #3
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 text-gray-600 font-semibold text-xs">
                                    #{{ $row['rank'] }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900 text-sm flex items-center gap-2">
                                {{ $row['road']->location }}
                                @if ($row['rank'] === 1)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-100 text-amber-800 border border-amber-200">
                                        <i class="bi bi-star-fill text-amber-500 mr-1"></i> Prioritas Utama
                                    </span>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                                <span>{{ $row['road']->kecamatan }}, {{ $row['road']->kelurahan }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-mono font-semibold {{ $row['rank'] <= 3 ? 'bg-brand-purple text-white shadow-xs' : 'bg-gray-100 text-gray-800' }}">
                                {{ number_format($row['result'], 6) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($row['rank'] <= 3)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                    Sangat Mendesak
                                </span>
                            @elseif ($row['rank'] <= 7)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">
                                    Mendesak
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                    Berkala
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center text-gray-500">
                            <i class="bi bi-inbox text-4xl mb-3 block text-gray-300"></i>
                            <p class="font-semibold text-gray-600">Belum ada data ruas jalan untuk dihitung.</p>
                            <p class="text-xs text-gray-400 mt-1">Tambahkan data ruas jalan terlebih dahulu untuk melihat hasil perangkingan MOORA.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $results->links() }}
</div>
@endsection

