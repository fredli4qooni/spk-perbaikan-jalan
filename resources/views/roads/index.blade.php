@extends('layouts.app')

@section('content')
<div x-data="{ activePhoto: null, activeVideo: null }">
    <!-- Header Halaman (Rata Kiri Presisi) -->
    <div class="flex items-center justify-between gap-3 mb-5">
        <div class="min-w-0 flex-1">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">
                Data Ruas Jalan
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                Kelola data ruas jalan & parameter 5 kriteria MOORA.
            </p>
        </div>
        @if (auth()->user()->role === 'petugas')
            <a href="{{ route('roads.create') }}" class="inline-flex items-center justify-center rounded-xl bg-brand-purple px-3.5 py-2 sm:px-4 sm:py-2.5 text-xs sm:text-sm font-semibold text-white shadow-xs hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all flex-shrink-0">
                <i class="bi bi-plus-lg mr-1.5"></i> <span>Tambah Ruas</span>
            </a>
        @endif
    </div>

    <!-- Sub-bar: Total Ruas & Opsi Tampilan Per Halaman -->
    <div class="flex items-center justify-between gap-2 mb-4">
        <div class="flex items-center gap-1.5">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-purple-50 text-brand-purple border border-purple-200/80">
                <i class="bi bi-signpost-2 text-xs"></i>
                <span>{{ $roads->total() }} Ruas Terdata</span>
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
    <!-- TAMPILAN MOBILE & TABLET (< lg): CARD VIEW -->
    <!-- ========================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:hidden">
        @forelse ($roads as $road)
            <div class="bg-white rounded-2xl border border-gray-200/90 shadow-xs p-4 sm:p-5 flex flex-col justify-between space-y-3.5 h-full hover:border-gray-300 transition-colors">
                <div class="space-y-3">
                    <!-- Header Card: Status & Tahun (Symmetrical Top Bar) -->
                    <div class="flex items-center justify-between gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $road->damage_status['badge'] }} shadow-2xs">
                            <span class="w-1.5 h-1.5 rounded-full {{ $road->damage_status['dot'] }}"></span>
                            {{ $road->damage_status['label'] }}
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200/80">
                            <i class="bi bi-calendar3 text-[10px] text-gray-400"></i>
                            Survei {{ $road->survey_year }}
                        </span>
                    </div>

                    <!-- Judul Ruas & Lokasi Detail -->
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm sm:text-base leading-snug">
                            {{ $road->location }}
                        </h3>
                        <div class="flex items-center gap-1.5 text-xs text-gray-500 mt-1.5 flex-wrap">
                            <span class="inline-flex items-center gap-1 text-gray-600 font-medium">
                                <i class="bi bi-geo-alt text-brand-purple text-xs"></i>
                                {{ $road->kecamatan }}, {{ $road->kelurahan }}
                            </span>
                            @if ($road->latitude && $road->longitude)
                                <span class="text-gray-300">•</span>
                                <span class="font-mono text-[11px] text-gray-400">
                                    {{ number_format($road->latitude, 4) }}, {{ number_format($road->longitude, 4) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Parameter Metrik Kerusakan (Unified Specs Matrix) -->
                    <div class="bg-gray-50/90 rounded-xl p-3 border border-gray-200/80 space-y-2.5">
                        <!-- 4 Kriteria Fisik (Grid 2x2 Clean Tiles) -->
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="bg-white rounded-lg p-2 border border-gray-200/70 shadow-2xs">
                                <span class="text-[10px] font-medium text-gray-400 uppercase tracking-wider block">Panjang</span>
                                <span class="text-xs font-semibold text-gray-800 block truncate mt-0.5">{{ $road->c1_label }}</span>
                            </div>
                            <div class="bg-white rounded-lg p-2 border border-gray-200/70 shadow-2xs">
                                <span class="text-[10px] font-medium text-gray-400 uppercase tracking-wider block">Lebar</span>
                                <span class="text-xs font-semibold text-gray-800 block truncate mt-0.5">{{ $road->c2_label }}</span>
                            </div>
                            <div class="bg-white rounded-lg p-2 border border-gray-200/70 shadow-2xs">
                                <span class="text-[10px] font-medium text-gray-400 uppercase tracking-wider block">Kedalaman</span>
                                <span class="text-xs font-semibold text-gray-800 block truncate mt-0.5">{{ $road->c3_label }}</span>
                            </div>
                            <div class="bg-white rounded-lg p-2 border border-gray-200/70 shadow-2xs">
                                <span class="text-[10px] font-medium text-gray-400 uppercase tracking-wider block">Jml Lubang</span>
                                <span class="text-xs font-semibold text-gray-800 block truncate mt-0.5">{{ $road->c4_label }}</span>
                            </div>
                        </div>

                        <!-- C5: Kepentingan Fasilitas Umum (Satu Kesatuan) -->
                        <div class="pt-2 border-t border-gray-200/70 flex items-center justify-between gap-2 text-xs">
                            <span class="text-gray-500 font-medium flex items-center gap-1.5 text-[11px]">
                                <i class="bi bi-building text-brand-purple"></i>
                                <span>Kepentingan</span>
                            </span>
                            <span class="font-semibold text-brand-purple bg-purple-50 px-2.5 py-0.5 rounded-md border border-purple-200/70 text-[11px] truncate max-w-[170px]">
                                {{ $road->c5_label }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Footer Card: Petugas, Tanggal, Media & Aksi -->
                <div class="pt-3 border-t border-gray-100 flex items-center justify-between gap-2 mt-auto">
                    <!-- Petugas & Media -->
                    <div class="flex items-center gap-2.5 min-w-0">
                        @if ($road->photo)
                            <button @click="activePhoto = '{{ asset('storage/' . $road->photo) }}'" class="relative group w-9 h-9 rounded-xl overflow-hidden border border-gray-200 flex-shrink-0 shadow-2xs hover:border-brand-purple transition-all focus:outline-none focus:ring-2 focus:ring-brand-purple cursor-pointer" title="Lihat Foto Dokumentasi">
                                <img src="{{ asset('storage/' . $road->photo) }}" alt="Foto" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/50 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i class="bi bi-zoom-in text-xs"></i>
                                </div>
                            </button>
                        @endif
                        @if ($road->video)
                            <button @click="activeVideo = { src: '{{ asset('storage/' . $road->video) }}', title: '{{ addslashes($road->location) }}' }" class="w-9 h-9 rounded-xl bg-purple-50 text-brand-purple border border-purple-200/80 flex items-center justify-center flex-shrink-0 hover:bg-brand-purple hover:text-white transition-all focus:outline-none focus:ring-2 focus:ring-brand-purple cursor-pointer" title="Putar Video Kerusakan">
                                <i class="bi bi-play-circle-fill text-base"></i>
                            </button>
                        @endif
                        @if (!$road->photo && !$road->video)
                            <div class="w-9 h-9 rounded-xl bg-gray-100 text-gray-400 border border-gray-200 flex items-center justify-center text-sm flex-shrink-0">
                                <i class="bi bi-person"></i>
                            </div>
                        @endif
                        <div class="truncate text-xs">
                            <span class="font-semibold text-gray-800 block truncate leading-tight">{{ $road->user->name ?? 'Petugas PUPR' }}</span>
                            <span class="text-[10px] text-gray-400 leading-tight mt-0.5 block">{{ $road->created_at->translatedFormat('d M Y') }}</span>
                        </div>
                    </div>

                    <!-- Aksi Tombol (Ergonomis) -->
                    <div class="flex items-center gap-1.5 flex-shrink-0">
                        @if (auth()->user()->role === 'petugas')
                            <a href="{{ route('roads.edit', $road) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-amber-50 text-amber-800 border border-amber-200/80 hover:bg-amber-100 rounded-xl text-xs font-semibold transition-all min-h-[36px] shadow-2xs">
                                <i class="bi bi-pencil mr-1"></i> Edit
                            </a>
                            <form action="{{ route('roads.destroy', $road) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ruas jalan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-9 h-9 min-h-[36px] min-w-[36px] bg-red-50 text-red-600 border border-red-200/80 hover:bg-red-100 rounded-xl text-xs font-semibold transition-all shadow-2xs cursor-pointer" title="Hapus Ruas">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-700">
                                <i class="bi bi-check2-all text-brand-green mr-1"></i> Aktif
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-gray-200 p-8 text-center text-gray-500">
                <i class="bi bi-inbox text-4xl mb-2 block text-gray-300"></i>
                <p class="font-bold text-gray-700 text-sm">Belum ada data ruas jalan.</p>
                <p class="text-xs text-gray-400 mt-1">Klik tombol Tambah Ruas Jalan untuk menginput data baru.</p>
            </div>
        @endforelse
    </div>

    <!-- ========================================== -->
    <!-- TAMPILAN DESKTOP (>= lg): TABEL LEBAR     -->
    <!-- ========================================== -->
    <div class="hidden lg:block bg-white shadow-sm rounded-2xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"><i class="bi bi-geo-alt"></i> Lokasi Ruas Jalan</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"><i class="bi bi-speedometer2"></i> Kondisi & Metrik Kerusakan</th>
                        <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Tahun</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Diinput Oleh</th>
                        <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Media</th>
                        <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($roads as $road)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900 text-sm">{{ $road->location }}</div>
                                <div class="text-xs text-gray-400 mt-1 flex items-center gap-2">
                                    <span>{{ $road->kecamatan }}, {{ $road->kelurahan }}</span>
                                    @if ($road->latitude && $road->longitude)
                                        <span class="font-mono text-brand-purple">
                                            <i class="bi bi-pin-map"></i> {{ number_format($road->latitude, 4) }}, {{ number_format($road->longitude, 4) }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-2">
                                    <!-- Row 1: Status Tingkat Kerusakan (Opsi 1) & Fasilitas Umum (C5) -->
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $road->damage_status['badge'] }} shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $road->damage_status['dot'] }}"></span>
                                            {{ $road->damage_status['label'] }}
                                        </span>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-xs font-medium bg-purple-50 text-brand-purple border border-purple-100 shadow-2xs" title="Kepentingan: {{ $road->c5_label }}">
                                            <i class="bi bi-building text-[11px]"></i>
                                            <span class="truncate max-w-[170px]">{{ $road->c5_label }}</span>
                                        </span>
                                    </div>

                                    <!-- Row 2: Unified Matrix Strip Kapsul Metrik (Opsi 2: P, L, D, Jml) -->
                                    <div class="inline-flex items-center rounded-lg bg-gray-50 border border-gray-200 text-xs divide-x divide-gray-200 overflow-hidden shadow-2xs">
                                        <span class="px-2.5 py-1 text-gray-700 hover:bg-gray-100 transition-colors flex items-center gap-1" title="Panjang Rusak: {{ $road->c1_label }}">
                                            <span class="text-gray-400 font-medium">P:</span>
                                            <span class="font-normal text-gray-800">{{ $road->c1_label }}</span>
                                        </span>
                                        <span class="px-2.5 py-1 text-gray-700 hover:bg-gray-100 transition-colors flex items-center gap-1" title="Lebar Kerusakan: {{ $road->c2_label }}">
                                            <span class="text-gray-400 font-medium">L:</span>
                                            <span class="font-normal text-gray-800">{{ $road->c2_label }}</span>
                                        </span>
                                        <span class="px-2.5 py-1 text-gray-700 hover:bg-gray-100 transition-colors flex items-center gap-1" title="Kedalaman Rusak: {{ $road->c3_label }}">
                                            <span class="text-gray-400 font-medium">D:</span>
                                            <span class="font-normal text-gray-800">{{ $road->c3_label }}</span>
                                        </span>
                                        <span class="px-2.5 py-1 text-gray-700 hover:bg-gray-100 transition-colors flex items-center gap-1" title="Jumlah Lubang: {{ $road->c4_label }}">
                                            <span class="text-gray-400 font-medium">Jml:</span>
                                            <span class="font-normal text-gray-800">{{ $road->c4_label }}</span>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $road->survey_year }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('images/logo-pupr.png') }}" alt="PUPR" class="w-7 h-7 rounded-full object-contain border border-gray-200 bg-white p-0.5">
                                    <div>
                                        <div class="text-xs font-semibold text-gray-900">{{ $road->user->name ?? 'Petugas PUPR' }}</div>
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
                                        <button @click="activeVideo = { src: '{{ asset('storage/' . $road->video) }}', title: '{{ addslashes($road->location) }}' }" class="flex items-center justify-center w-9 h-9 rounded-md border border-brand-purple/30 bg-brand-purple/5 text-brand-purple hover:bg-brand-purple/15 focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all shadow-xs" title="Putar Video">
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
                                        <a href="{{ route('roads.edit', $road) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-amber-800 bg-amber-50 hover:bg-amber-100 border border-amber-200 transition-colors shadow-2xs" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('roads.destroy', $road) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ruas jalan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 transition-colors shadow-2xs cursor-pointer" title="Hapus Data">
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
    </div>

    <!-- Modals (Foto & Video) -->
    <!-- Photo Modal -->
    <div x-show="activePhoto" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;">
        <div x-show="activePhoto" @click="activePhoto = null" x-transition:enter="transition-opacity ease-linear duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80 backdrop-blur-xs"></div>
        
        <div x-show="activePhoto" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white rounded-2xl overflow-hidden shadow-2xl transform transition-all sm:max-w-2xl sm:w-full z-10 m-4">
            <div class="absolute top-3 right-3 z-20">
                <button @click="activePhoto = null" type="button" class="w-11 h-11 rounded-full bg-gray-900/90 text-white flex items-center justify-center hover:bg-black focus:outline-none focus:ring-2 focus:ring-white transition-all shadow-lg active:scale-95 cursor-pointer" aria-label="Tutup Foto">
                    <i class="bi bi-x-lg text-lg"></i>
                </button>
            </div>
            <div class="p-2 sm:p-3">
                <img :src="activePhoto" alt="Foto Kerusakan" class="w-full h-auto max-h-[80vh] object-contain rounded-xl">
            </div>
        </div>
    </div>

    <!-- Video Modal -->
    <div x-show="activeVideo" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;">
        <div x-show="activeVideo" @click="activeVideo = null" x-transition:enter="transition-opacity ease-linear duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/90 backdrop-blur-xs"></div>
        
        <div x-show="activeVideo" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-black rounded-2xl overflow-hidden shadow-2xl transform transition-all sm:max-w-4xl sm:w-full z-10 m-4">
            <div class="px-4 py-3 bg-gray-900 flex justify-between items-center border-b border-gray-800">
                <h3 class="text-sm font-bold text-white truncate" x-text="activeVideo ? 'Video: ' + activeVideo.title : ''"></h3>
                <button @click="activeVideo = null" type="button" class="w-10 h-10 rounded-xl bg-gray-800 text-gray-200 hover:bg-gray-700 hover:text-white flex items-center justify-center transition-all active:scale-95 ml-2 flex-shrink-0 cursor-pointer" aria-label="Tutup Video">
                    <i class="bi bi-x-lg text-base"></i>
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

<div class="mt-6">
    {{ $roads->links() }}
</div>
@endsection
