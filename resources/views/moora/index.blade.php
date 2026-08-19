@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <i class="bi bi-bar-chart-line-fill text-brand-purple"></i> Hasil Perhitungan & Perangkingan MOORA
        </h2>
        <p class="text-sm text-gray-500 mt-1">Perankingan prioritas penanganan dan perbaikan infrastruktur jalan.</p>
    </div>
    @if(isset($results) && count($results) > 0)
        <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg shadow-sm hover:bg-gray-50 hover:text-brand-purple transition-all">
            <i class="bi bi-printer"></i> Lihat Laporan Lengkap
        </a>
    @endif
</div>

<!-- Keterangan Prioritas MOORA -->
<div class="bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-200 p-5 mb-6 rounded-xl shadow-xs">
    <div class="flex items-start gap-3.5">
        <div class="w-9 h-9 rounded-lg bg-brand-purple text-white flex items-center justify-center flex-shrink-0 text-lg shadow-sm">
            <i class="bi bi-info-circle-fill"></i>
        </div>
        <div>
            <h4 class="text-sm font-bold text-gray-900 mb-1">Pedoman Prioritas Hasil Perhitungan</h4>
            <p class="text-sm text-gray-700 leading-relaxed">
                Tabel di bawah ini menampilkan hasil optimalisasi metode <strong>MOORA (Multi-Objective Optimization on the basis of Ratio Analysis)</strong>. 
                <span class="font-bold text-brand-purple underline decoration-brand-yellow decoration-2 underline-offset-2">Urutan paling atas (Rank 1) adalah urutan prioritas perbaikan jalan tertinggi</span> yang paling mendesak dan memiliki dampak strategis terbesar untuk segera diperbaiki.
            </p>
        </div>
    </div>
</div>

<div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-24">Peringkat</th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Ruas Jalan & Lokasi</th>
                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total Benefit (+)</th>
                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total Cost (-)</th>
                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Nilai Akhir (Yi)</th>
                    <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-36">Status Prioritas</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($results as $row)
                    <tr class="hover:bg-gray-50 transition-colors {{ $row['rank'] === 1 ? 'bg-amber-50/40' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($row['rank'] === 1)
                                <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-amber-400 text-amber-950 font-black text-sm shadow-sm ring-4 ring-amber-100">
                                    #1
                                </span>
                            @elseif ($row['rank'] === 2)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-200 text-slate-800 font-bold text-xs shadow-xs">
                                    #2
                                </span>
                            @elseif ($row['rank'] === 3)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-700/20 text-amber-900 font-bold text-xs">
                                    #3
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 text-gray-600 font-semibold text-xs">
                                    {{ $row['rank'] }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-bold text-gray-900 text-sm flex items-center gap-2">
                                {{ $row['road']->name }}
                                @if ($row['rank'] === 1)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                        <i class="bi bi-star-fill text-amber-500 mr-1"></i> Prioritas Utama
                                    </span>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                                <i class="bi bi-geo-alt"></i> {{ $row['road']->location }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-mono text-green-700 font-semibold">
                            +{{ number_format($row['benefit_total'], 6) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-mono text-red-600 font-semibold">
                            -{{ number_format($row['cost_total'], 6) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-mono font-bold {{ $row['rank'] <= 3 ? 'bg-brand-purple text-white shadow-xs' : 'bg-gray-100 text-gray-800' }}">
                                {{ number_format($row['result'], 6) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($row['rank'] <= 3)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                    Sangat Mendesak
                                </span>
                            @elseif ($row['rank'] <= 7)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
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
                        <td colspan="6" class="px-6 py-16 text-center text-gray-500">
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
@endsection
