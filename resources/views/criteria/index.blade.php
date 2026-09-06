@extends('layouts.app')

@section('content')
<!-- Header Halaman (Rata Kiri Presisi) -->
<div class="flex items-center justify-between gap-3 mb-5">
    <div class="min-w-0 flex-1">
        <h2 class="text-xl sm:text-2xl font-black text-gray-900 leading-tight">
            Data Kriteria
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
            Kelola kriteria, bobot, dan parameter metode MOORA.
        </p>
    </div>
    <a href="{{ route('criteria.create') }}" class="inline-flex items-center justify-center rounded-xl bg-brand-purple px-3.5 py-2 sm:px-4 sm:py-2.5 text-xs sm:text-sm font-bold text-white shadow-xs hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all flex-shrink-0">
        <i class="bi bi-plus-lg mr-1.5"></i> <span>Tambah Kriteria</span>
    </a>
</div>

<!-- ========================================== -->
<!-- TAMPILAN MOBILE & TABLET (< md): 2-COLUMN CARD GRID -->
<!-- ========================================== -->
<div class="grid grid-cols-2 gap-3 md:hidden">
    @forelse ($criteria as $criterion)
        <div class="bg-white rounded-2xl border border-gray-200 shadow-xs p-3.5 sm:p-4 flex flex-col justify-between space-y-3 h-full">
            <!-- Header Kartu: Kode & Tipe -->
            <div>
                <div class="flex items-center justify-between gap-1.5 mb-2">
                    <span class="w-8 h-8 rounded-xl bg-purple-50 text-brand-purple font-black text-xs flex items-center justify-center border border-purple-100 flex-shrink-0">
                        {{ $criterion->code }}
                    </span>
                    @if($criterion->type === 'cost')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-200">
                            Cost
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Benefit
                        </span>
                    @endif
                </div>

                <!-- Nama Kriteria & Satuan -->
                <h3 class="font-bold text-gray-900 text-xs sm:text-sm leading-snug line-clamp-2">{{ $criterion->name }}</h3>
                <span class="text-[11px] text-gray-400 block mt-1">Satuan: {{ $criterion->unit ?? '-' }}</span>
            </div>

            <!-- Detail Bobot & Tombol Aksi (Ergonomis) -->
            <div class="pt-2.5 border-t border-gray-100 flex items-center justify-between gap-2 mt-auto">
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 text-gray-800">
                    {{ $criterion->weight }}%
                </span>

                <div class="flex items-center gap-2">
                    <a href="{{ route('criteria.edit', $criterion) }}" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-amber-50 text-amber-800 border border-amber-200 hover:bg-amber-100 flex items-center justify-center text-sm font-semibold transition-all shadow-2xs focus:outline-none focus:ring-2 focus:ring-amber-400" title="Edit Kriteria">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('criteria.destroy', $criterion) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kriteria ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 flex items-center justify-center text-sm font-semibold transition-all shadow-2xs focus:outline-none focus:ring-2 focus:ring-red-400" title="Hapus Kriteria">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-2 bg-white rounded-2xl border border-gray-200 p-8 text-center text-gray-500">
            <i class="bi bi-inbox text-3xl mb-2 block text-gray-300"></i>
            <p class="font-bold text-gray-700 text-sm">Belum ada data kriteria.</p>
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
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-24"><i class="bi bi-tag"></i> Kode</th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Kriteria</th>
                    <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-28">Bobot</th>
                    <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-28">Tipe</th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-36">Satuan</th>
                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($criteria as $criterion)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-purple-50 text-brand-purple font-black text-xs border border-purple-100">
                                {{ $criterion->code }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $criterion->name }}</div>
                            @if(!empty($criterion->description))
                                <div class="text-xs text-gray-400 mt-0.5 truncate max-w-md">{{ $criterion->description }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">
                                {{ $criterion->weight }}%
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($criterion->type === 'cost')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">Cost</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Benefit</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $criterion->unit ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('criteria.edit', $criterion) }}" class="inline-flex items-center justify-center w-8 h-8 border border-amber-200 rounded-lg text-amber-700 bg-amber-50 hover:bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500 transition-all" title="Edit Kriteria">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('criteria.destroy', $criterion) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kriteria ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 border border-red-200 rounded-lg text-red-600 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all" title="Hapus Kriteria">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <i class="bi bi-inbox text-3xl mb-2 block text-gray-300"></i>
                            Belum ada data kriteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-5">
    {{ $criteria->links() }}
</div>
@endsection
