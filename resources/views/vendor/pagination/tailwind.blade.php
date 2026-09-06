@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="bg-white rounded-2xl border border-gray-200/90 p-3 sm:p-4 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-3">
        <!-- Informasi Data & Halaman Aktif -->
        <div class="text-xs text-gray-500 font-medium text-center sm:text-left flex items-center gap-1.5 flex-wrap justify-center sm:justify-start">
            <span>Menampilkan</span>
            <span class="font-semibold text-gray-900">{{ $paginator->firstItem() ?? 0 }}</span>
            <span>–</span>
            <span class="font-semibold text-gray-900">{{ $paginator->lastItem() ?? 0 }}</span>
            <span>dari total</span>
            <span class="font-semibold text-gray-900">{{ $paginator->total() }}</span>
            <span>data</span>
        </div>

        <!-- Tombol Aksi & Penomoran Halaman (Thumb-Friendly) -->
        <div class="flex items-center gap-1 sm:gap-1.5 flex-wrap justify-center">
            {{-- Tombol Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center justify-center gap-1 px-3 py-2 text-xs font-semibold text-gray-300 bg-gray-50 rounded-xl border border-gray-100 cursor-not-allowed min-h-[38px] select-none">
                    <i class="bi bi-chevron-left text-[10px]"></i>
                    <span class="hidden sm:inline">Sebelumnya</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center gap-1 px-3 py-2 text-xs font-semibold text-gray-700 bg-white hover:bg-gray-50 rounded-xl border border-gray-200/90 shadow-2xs transition-all min-h-[38px] active:scale-95" aria-label="Halaman Sebelumnya">
                    <i class="bi bi-chevron-left text-[10px]"></i>
                    <span class="hidden sm:inline">Sebelumnya</span>
                </a>
            @endif

            {{-- Elemen Nomor Halaman --}}
            @foreach ($elements as $element)
                {{-- Separator "..." --}}
                @if (is_string($element))
                    <span class="w-8 h-9 inline-flex items-center justify-center text-xs font-semibold text-gray-400 select-none">
                        {{ $element }}
                    </span>
                @endif

                {{-- Nomor Halaman --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-9 h-9 inline-flex items-center justify-center text-xs font-bold text-white bg-brand-purple rounded-xl shadow-xs border border-brand-purple select-none" aria-current="page">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="w-9 h-9 inline-flex items-center justify-center text-xs font-semibold text-gray-700 bg-white hover:bg-gray-100 rounded-xl border border-gray-200/80 transition-all shadow-2xs active:scale-95" aria-label="Ke halaman {{ $page }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Berikutnya --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center gap-1 px-3 py-2 text-xs font-semibold text-gray-700 bg-white hover:bg-gray-50 rounded-xl border border-gray-200/90 shadow-2xs transition-all min-h-[38px] active:scale-95" aria-label="Halaman Berikutnya">
                    <span class="hidden sm:inline">Berikutnya</span>
                    <i class="bi bi-chevron-right text-[10px]"></i>
                </a>
            @else
                <span class="inline-flex items-center justify-center gap-1 px-3 py-2 text-xs font-semibold text-gray-300 bg-gray-50 rounded-xl border border-gray-100 cursor-not-allowed min-h-[38px] select-none">
                    <span class="hidden sm:inline">Berikutnya</span>
                    <i class="bi bi-chevron-right text-[10px]"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
