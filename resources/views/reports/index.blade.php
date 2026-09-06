@extends('layouts.app')

@section('content')
<!-- Header Halaman (Rata Kiri Presisi) -->
<div class="flex items-center justify-between gap-3 mb-5">
    <div class="min-w-0 flex-1">
        <h2 class="text-xl sm:text-2xl font-black text-gray-900 leading-tight">
            Laporan Prioritas
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
            Urutan prioritas penanganan berdasarkan nilai akhir optimalisasi MOORA.
        </p>
    </div>
    <a href="{{ route('reports.export.csv') }}" class="inline-flex items-center justify-center rounded-xl bg-brand-green px-3.5 py-2 sm:px-4 sm:py-2.5 text-xs sm:text-sm font-bold text-white shadow-xs hover:bg-brand-green-hover focus:outline-none focus:ring-2 focus:ring-brand-green transition-all flex-shrink-0">
        <i class="bi bi-filetype-csv mr-1.5 text-sm sm:text-base"></i> <span>Export CSV</span>
    </a>
</div>

<!-- Info Banner (Ringkas) -->
<div class="flex items-center gap-2.5 bg-blue-50/80 border border-blue-200/80 px-3.5 py-2.5 mb-5 rounded-xl text-xs text-blue-800 shadow-2xs">
    <i class="bi bi-info-circle-fill text-blue-600 text-sm flex-shrink-0"></i>
    <p class="leading-tight">
        Urutan prioritas berdasarkan nilai MOORA tertinggi (Peringkat #1 paling mendesak).
    </p>
</div>

<!-- ========================================== -->
<!-- TAMPILAN MOBILE (< md): 2-COLUMN REPORT CARDS -->
<!-- ========================================== -->
<div class="grid grid-cols-2 gap-2.5 sm:gap-3.5 md:hidden">
    @forelse ($results as $row)
        @php
            $isRank1 = $row['rank'] === 1;
            $isTop3 = $row['rank'] <= 3;
        @endphp
        <div class="bg-white rounded-2xl border border-gray-200 shadow-xs p-3.5 sm:p-4 flex flex-col justify-between space-y-3 h-full {{ $isRank1 ? 'border-amber-300 ring-2 ring-amber-200/60 bg-amber-50/25' : ($isTop3 ? 'border-purple-200/90' : 'border-gray-200') }}">
            <div class="space-y-2">
                <div class="flex items-center justify-between gap-1.5">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl font-black text-xs flex-shrink-0 {{ $isRank1 ? 'bg-amber-400 text-amber-950 ring-1 ring-amber-300' : ($isTop3 ? 'bg-purple-100 text-brand-purple' : 'bg-gray-100 text-gray-700') }}">
                        #{{ $row['rank'] }}
                    </span>
                    @if($isRank1)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                            <i class="bi bi-star-fill text-amber-500 mr-1 text-[9px]"></i> Utama
                        </span>
                    @elseif($isTop3)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-200">
                            Mendesak
                        </span>
                    @elseif($row['rank'] <= 7)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                            Prioritas
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-800 border border-blue-200">
                            Berkala
                        </span>
                    @endif
                </div>

                <div>
                    <h3 class="font-bold text-gray-900 text-xs sm:text-sm leading-snug line-clamp-2">{{ $row['road']->location }}</h3>
                    <p class="text-[10px] sm:text-[11px] text-gray-400 mt-0.5 truncate flex items-center gap-1">
                        <i class="bi bi-geo-alt text-brand-purple text-[9px]"></i>
                        {{ $row['road']->kecamatan }}
                    </p>
                </div>

                <!-- Context Chips -->
                <div class="flex items-center gap-1.5 pt-1 flex-wrap">
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-blue-50 text-blue-700 border border-blue-100 flex-shrink-0">
                        {{ $row['road']->survey_year }}
                    </span>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-semibold bg-purple-50 text-brand-purple border border-purple-100 truncate max-w-full">
                        {{ $row['road']->c5_label }}
                    </span>
                </div>
            </div>

            <!-- Footer Card: Nilai Akhir (Yi) (Pinned Bottom) -->
            <div class="pt-2.5 border-t border-gray-100 flex items-center justify-between mt-auto">
                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Nilai Yi</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-mono font-bold {{ $isTop3 ? 'bg-brand-purple text-white shadow-2xs' : 'bg-gray-100 text-gray-800' }}">
                    {{ number_format($row['result'], 4) }}
                </span>
            </div>
        </div>
    @empty
        <div class="col-span-2 bg-white rounded-2xl border border-gray-200 p-8 text-center text-gray-500">
            <i class="bi bi-inbox text-4xl mb-2 block text-gray-300"></i>
            <p class="font-bold text-gray-700 text-sm">Belum ada data hasil perhitungan.</p>
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
                    <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-24">Peringkat</th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Lokasi Ruas Jalan</th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Wilayah (Kec/Kel)</th>
                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider w-44">Nilai MOORA (Yi)</th>
                    <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-40">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($results as $row)
                    <tr class="hover:bg-gray-50 transition-colors {{ $row['rank'] === 1 ? 'bg-amber-50/40' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold {{ $row['rank'] <= 3 ? 'bg-amber-400 text-amber-950 ring-2 ring-amber-100' : 'bg-gray-100 text-gray-800' }}">
                                #{{ $row['rank'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-900 text-sm">
                            {{ $row['road']->location }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $row['road']->kecamatan }}, {{ $row['road']->kelurahan }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-mono font-bold bg-brand-purple text-white">
                                {{ number_format($row['result'], 6) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($row['rank'] <= 3)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                    Sangat Mendesak
                                </span>
                            @elseif ($row['rank'] <= 7)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                    Mendesak
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                    Berkala
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="bi bi-inbox text-3xl mb-2 block text-gray-300"></i>
                            Belum ada data hasil perhitungan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
