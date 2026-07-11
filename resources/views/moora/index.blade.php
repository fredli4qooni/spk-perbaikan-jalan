@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
        <i class="bi bi-graph-up text-brand-purple"></i> Hasil Perhitungan MOORA
    </h2>
    <p class="text-sm text-gray-500 mt-1">Nilai benefit dikurangi cost untuk menentukan prioritas perbaikan.</p>
</div>

<div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-r-md">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="bi bi-info-circle text-blue-400 text-xl"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-blue-700 font-bold mt-0.5 mb-1">Rumus singkat:</p>
            <p class="text-lg font-mono bg-white/50 inline-block px-2 py-1 rounded text-blue-800 border border-blue-200 mb-2">
                Y<sub>i</sub> = &sum; w<sub>j</sub> x<sub>ij</sub> (Benefit) - &sum; w<sub>j</sub> x<sub>ij</sub> (Cost)
            </p>
            <p class="text-xs text-blue-600">Benefit dijumlahkan, cost dikurangkan.</p>
        </div>
    </div>
</div>

<div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Rank</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ruas Jalan</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Benefit</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Cost</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Akhir</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($results as $row)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $row['rank'] <= 3 ? 'bg-brand-yellow text-brand-purple font-black' : 'bg-gray-100 text-gray-600 font-bold' }}">
                                {{ $row['rank'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-bold text-gray-900">{{ $row['road']->name }}</div>
                            <div class="text-sm text-gray-500">{{ $row['road']->location }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-green-600 font-medium">
                            +{{ number_format($row['benefit_total'], 6) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-red-600 font-medium">
                            -{{ number_format($row['cost_total'], 6) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-brand-purple text-white">
                                {{ number_format($row['result'], 6) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="bi bi-inbox text-3xl mb-2 block text-gray-300"></i>
                            Belum ada data untuk dihitung.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
