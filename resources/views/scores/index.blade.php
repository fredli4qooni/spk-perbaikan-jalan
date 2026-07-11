@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
        <i class="bi bi-card-checklist text-brand-purple"></i> Input Nilai Alternatif
    </h2>
    <p class="text-sm text-gray-500 mt-1">Isi nilai untuk setiap ruas jalan dan kriteria dengan skala numerik yang konsisten.</p>
</div>

@if ($roads->isEmpty() || $criteria->isEmpty())
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-r-md">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="bi bi-exclamation-triangle text-yellow-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700 font-medium mt-0.5">
                    Data ruas jalan dan kriteria harus tersedia terlebih dahulu.
                </p>
            </div>
        </div>
    </div>
@else
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-r-md">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="bi bi-info-circle text-blue-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700 font-medium mt-0.5">
                    Isi nilai untuk setiap ruas jalan dan kriteria. Untuk tingkat kerusakan, gunakan skala numerik yang konsisten, misalnya 1 = ringan, 2 = sedang, 3 = berat.
                </p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('scores.store') }}">
        @csrf
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10 border-r border-gray-200">
                                Ruas Jalan
                            </th>
                            @foreach ($criteria as $criterion)
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="font-bold text-gray-800">{{ $criterion->code }}</div>
                                    <div class="text-gray-500 mt-1">{{ $criterion->name }}</div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($roads as $road)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap sticky left-0 bg-white hover:bg-gray-50 z-10 border-r border-gray-200 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.05)]">
                                    <div class="font-bold text-gray-900">{{ $road->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $road->location }}</div>
                                </td>
                                @foreach ($criteria as $criterion)
                                    @php
                                        $current = old('scores.' . $road->id . '.' . $criterion->id, optional($road->scores->firstWhere('criterion_id', $criterion->id))->value);
                                    @endphp
                                    <td class="px-6 py-4 whitespace-nowrap" style="min-width: 150px;">
                                        <input type="number" step="0.01" min="0" name="scores[{{ $road->id }}][{{ $criterion->id }}]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2 border text-center" value="{{ $current }}">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="inline-flex justify-center items-center rounded-md border border-transparent bg-brand-purple px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-brand-purple focus:ring-offset-2 transition-colors">
                <i class="bi bi-save mr-2"></i> Simpan Nilai
            </button>
        </div>
    </form>
@endif
@endsection
