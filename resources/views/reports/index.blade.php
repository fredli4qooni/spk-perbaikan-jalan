@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <i class="bi bi-file-earmark-text text-brand-purple"></i> Laporan Prioritas Perbaikan
        </h2>
        <p class="text-sm text-gray-500 mt-1">Urutan prioritas berdasarkan nilai MOORA tertinggi.</p>
    </div>
    <a href="{{ route('reports.export.csv') }}" class="inline-flex items-center justify-center rounded-md bg-brand-green px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-brand-green-hover focus:outline-none focus:ring-2 focus:ring-brand-green focus:ring-offset-2 transition-colors">
        <i class="bi bi-filetype-csv mr-2 text-lg"></i> Export CSV
    </a>
</div>

<div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-r-md">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="bi bi-info-circle text-blue-400 text-xl"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-blue-700 font-medium mt-0.5">
                Laporan ini menampilkan urutan prioritas berdasarkan nilai MOORA tertinggi. Berkas CSV dapat dibuka di Excel.
            </p>
        </div>
    </div>
</div>

<div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Rank</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ruas Jalan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai MOORA</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($results as $row)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $row['rank'] <= 3 ? 'bg-brand-yellow text-brand-purple' : 'bg-gray-100 text-gray-800' }}">
                                {{ $row['rank'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-bold text-gray-900">{{ $row['road']->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $row['road']->location }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="text-sm font-bold text-brand-purple">{{ number_format($row['result'], 6) }}</div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <i class="bi bi-inbox text-3xl mb-2 block text-gray-300"></i>
                            Belum ada data.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
