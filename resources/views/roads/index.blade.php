@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <i class="bi bi-road-lane text-brand-purple"></i> Data Ruas Jalan
        </h2>
        <p class="text-sm text-gray-500 mt-1">Kelola data ruas jalan yang akan dianalisis.</p>
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
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><i class="bi bi-file-text"></i> Nama Ruas</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><i class="bi bi-geo-alt"></i> Lokasi</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Media</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($roads as $road)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-bold text-gray-900">{{ $road->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $road->location }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $road->survey_year }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex justify-center gap-2">
                                @if ($road->photo)
                                    <button @click="activePhoto = '{{ asset('storage/' . $road->photo) }}'" class="overflow-hidden rounded-md border border-gray-200 hover:border-brand-purple focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all" title="Lihat Foto">
                                        <img src="{{ asset('storage/' . $road->photo) }}" alt="foto" class="w-10 h-10 object-cover">
                                    </button>
                                @endif
                                @if ($road->video)
                                    <button @click="activeVideo = { src: '{{ asset('storage/' . $road->video) }}', title: '{{ addslashes($road->name) }}' }" class="flex items-center justify-center w-10 h-10 rounded-md border border-brand-purple/30 bg-brand-purple/5 text-brand-purple hover:bg-brand-purple/10 focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all" title="Putar Video">
                                        <i class="bi bi-play-circle-fill text-xl"></i>
                                    </button>
                                @endif
                                @if (!$road->photo && !$road->video)
                                    <span class="text-gray-400">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($road->is_verified)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Terverifikasi</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Menunggu</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $road->scores_count }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if (auth()->user()->role === 'petugas')
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('roads.edit', $road) }}" class="inline-flex items-center p-1.5 border border-transparent rounded-md text-yellow-600 bg-yellow-50 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('roads.destroy', $road) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center p-1.5 border border-transparent rounded-md text-red-600 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                @if (! $road->is_verified)
                                    <form action="{{ route('roads.verify', $road) }}" method="POST" class="inline" onsubmit="return confirm('Verifikasi data ruas jalan ini?')">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md text-sm text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <i class="bi bi-check-circle mr-1"></i> Verifikasi
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-gray-500">Diverifikasi {{ $road->verified_at?->format('d-m-Y H:i') }}</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="bi bi-inbox text-3xl mb-2 block text-gray-300"></i>
                            Belum ada data ruas jalan.
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

<div class="mt-4">
    {{ $roads->links() }}
</div>
@endsection
