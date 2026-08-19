@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <i class="bi bi-road-lane text-brand-purple"></i> Data Ruas Jalan
        </h2>
        <p class="text-sm text-gray-500 mt-1">Daftar seluruh data ruas jalan yang telah diinput dan siap dianalisis.</p>
    </div>
    @if (auth()->user()->role === 'petugas')
        <a href="{{ route('roads.create') }}" class="inline-flex items-center justify-center rounded-md bg-brand-purple px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-brand-purple focus:ring-offset-2">
            <i class="bi bi-plus-lg mr-2"></i> Tambah Ruas Jalan
        </a>
    @endif
</div>

<div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden" x-data="{ activePhoto: null, activeVideo: null }">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider"><i class="bi bi-file-text"></i> Nama Ruas</th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider"><i class="bi bi-geo-alt"></i> Lokasi</th>
                    <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tahun</th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Diinput Oleh</th>
                    <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Media</th>
                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($roads as $road)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-bold text-gray-900">{{ $road->name }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">
                                {{ $road->holes_count ?? 0 }} Lubang &bull; Panjang: {{ $road->length }} m
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                            {{ $road->location }}
                            @if ($road->latitude && $road->longitude)
                                <div class="text-xs font-mono text-brand-purple mt-0.5">
                                    <i class="bi bi-pin-map"></i> {{ number_format($road->latitude, 4) }}, {{ number_format($road->longitude, 4) }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $road->survey_year }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-brand-purple/10 text-brand-purple flex items-center justify-center font-bold text-xs">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-gray-900">{{ $road->user->name ?? 'Petugas' }}</div>
                                    <div class="text-[10px] text-gray-400">{{ $road->created_at->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex justify-center gap-2">
                                @if ($road->photo)
                                    <button @click="activePhoto = '{{ asset('storage/' . $road->photo) }}'" class="overflow-hidden rounded-md border border-gray-200 hover:border-brand-purple focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all shadow-xs" title="Lihat Foto">
                                        <img src="{{ asset('storage/' . $road->photo) }}" alt="foto" class="w-9 h-9 object-cover">
                                    </button>
                                @endif
                                @if ($road->video)
                                    <button @click="activeVideo = { src: '{{ asset('storage/' . $road->video) }}', title: '{{ addslashes($road->name) }}' }" class="flex items-center justify-center w-9 h-9 rounded-md border border-brand-purple/30 bg-brand-purple/5 text-brand-purple hover:bg-brand-purple/15 focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all shadow-xs" title="Putar Video">
                                        <i class="bi bi-play-circle-fill text-lg"></i>
                                    </button>
                                @endif
                                @if (!$road->photo && !$road->video)
                                    <span class="text-gray-300">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if (auth()->user()->role === 'petugas')
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('roads.edit', $road) }}" class="inline-flex items-center p-1.5 border border-transparent rounded-md text-yellow-600 bg-yellow-50 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500" title="Edit Data">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('roads.destroy', $road) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ruas jalan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center p-1.5 border border-transparent rounded-md text-red-600 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" title="Hapus Data">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="flex justify-end">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-700">
                                        <i class="bi bi-check2-all text-brand-green mr-1"></i> Data Aktif
                                    </span>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-500">
                            <i class="bi bi-inbox text-4xl mb-3 block text-gray-300"></i>
                            <p class="font-semibold text-gray-600">Belum ada data ruas jalan yang diinput.</p>
                            @if (auth()->user()->role === 'petugas')
                                <p class="text-xs text-gray-400 mt-1">Silakan klik tombol "Tambah Ruas Jalan" di atas untuk mulai menambahkan data.</p>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modals powered by Alpine.js -->
    
    <!-- Photo Modal -->
    <div x-show="activePhoto" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;">
        <div x-show="activePhoto" @click="activePhoto = null" x-transition:enter="transition-opacity ease-linear duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900 bg-opacity-75"></div>
        
        <div x-show="activePhoto" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-2xl sm:w-full z-10 m-4">
            <div class="absolute top-0 right-0 pt-4 pr-4 z-20">
                <button @click="activePhoto = null" type="button" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-purple">
                    <span class="sr-only">Tutup</span>
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="p-1">
                <img :src="activePhoto" alt="Foto" class="w-full h-auto max-h-[80vh] object-contain">
            </div>
        </div>
    </div>

    <!-- Video Modal -->
    <div x-show="activeVideo" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;">
        <div x-show="activeVideo" @click="activeVideo = null" x-transition:enter="transition-opacity ease-linear duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900 bg-opacity-90"></div>
        
        <div x-show="activeVideo" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-black rounded-lg overflow-hidden shadow-2xl transform transition-all sm:max-w-4xl sm:w-full z-10 m-4">
            <div class="px-4 py-3 bg-gray-900 flex justify-between items-center border-b border-gray-800">
                <h3 class="text-sm font-medium text-white truncate" x-text="activeVideo ? 'Video Dokumentasi: ' + activeVideo.title : ''"></h3>
                <button @click="activeVideo = null" type="button" class="text-gray-400 hover:text-white focus:outline-none">
                    <span class="sr-only">Tutup</span>
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="bg-black flex justify-center items-center">
                <template x-if="activeVideo">
                    <video controls autoplay class="w-full max-h-[75vh]" :src="activeVideo.src">
                        Browser Anda tidak mendukung tag video.
                    </video>
                </template>
            </div>
        </div>
    </div>
</div>

<div class="mt-5">
    {{ $roads->links() }}
</div>
@endsection
