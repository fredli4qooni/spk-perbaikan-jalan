@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header Halaman (Rata Kiri Presisi) -->
    <div class="mb-5 sm:mb-6">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">
            Kelola Profil Akun
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
            Kelola informasi profil, email kedinasan, dan status akun Anda.
        </p>
    </div>

    <!-- Kartu Terpadu 2 Tab (Segmented Control) -->
    <div x-data="{ activeTab: 'edit' }" class="bg-white rounded-2xl shadow-xs border border-gray-200 overflow-hidden">
        <!-- Header Kartu: Segmented Control Tabs (50% / 50%) -->
        <div class="p-3 sm:px-5 sm:py-3.5 border-b border-gray-100 bg-gray-50/60">
            <div class="grid grid-cols-2 p-1 bg-gray-200/70 rounded-xl w-full">
                <!-- Tab 1: Edit Profil -->
                <button 
                    type="button" 
                    @click="activeTab = 'edit'"
                    class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg text-xs sm:text-sm font-semibold whitespace-nowrap transition-all cursor-pointer"
                    :class="activeTab === 'edit' ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-600 hover:text-gray-900'"
                >
                    <i class="bi bi-person-gear text-brand-purple text-sm"></i>
                    <span>Edit Profil</span>
                </button>

                <!-- Tab 2: Informasi Akun -->
                <button 
                    type="button" 
                    @click="activeTab = 'info'"
                    class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg text-xs sm:text-sm font-semibold whitespace-nowrap transition-all cursor-pointer"
                    :class="activeTab === 'info' ? 'bg-white text-gray-900 shadow-xs' : 'text-gray-600 hover:text-gray-900'"
                >
                    <i class="bi bi-shield-check text-emerald-600 text-sm"></i>
                    <span>Informasi Akun</span>
                </button>
            </div>
        </div>

        <!-- ISI TAB 1: FORM EDIT PROFIL -->
        <div x-show="activeTab === 'edit'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="p-5 sm:p-7 md:p-8">
            <!-- Banner Avatar Otomatis PUPR -->
            <div class="flex items-center gap-4 p-4 mb-6 rounded-xl bg-purple-50/70 border border-purple-100">
                <div class="relative flex-shrink-0">
                    <img src="{{ asset('images/logo-pupr.png') }}" alt="Logo PUPR" class="w-14 h-14 sm:w-16 sm:h-16 rounded-full border-2 border-brand-purple bg-white object-contain p-1.5 shadow-xs">
                    <span class="absolute bottom-0 right-0 w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-full bg-emerald-500 border-2 border-white" title="Akun Aktif"></span>
                </div>
                <div>
                    <div class="text-sm font-semibold text-gray-900 flex items-center gap-1.5">
                        Identitas Resmi Dinas PUPR
                        <i class="bi bi-patch-check-fill text-brand-purple text-base"></i>
                    </div>
                    <p class="text-xs text-gray-500 mt-0.5">Avatar akun ditetapkan secara otomatis menggunakan logo resmi Dinas PUPR.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-4 sm:mb-5">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        class="block w-full rounded-xl border border-gray-200 shadow-xs focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/20 text-sm py-2.5 px-3.5 bg-white transition-all min-h-[44px]" 
                        value="{{ old('name', auth()->user()->name) }}" 
                        required
                    >
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5 sm:mb-6">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5">
                        Alamat Email Kedinasan <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        class="block w-full rounded-xl border border-gray-200 shadow-xs focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/20 text-sm py-2.5 px-3.5 bg-white transition-all min-h-[44px]" 
                        value="{{ old('email', auth()->user()->email) }}" 
                        required
                    >
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-[11px] sm:text-xs text-gray-400 mt-1.5">
                        Alamat email ini digunakan untuk login dan menerima seluruh notifikasi aktivitas akun.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-5 border-t border-gray-100">
                    <button type="submit" class="inline-flex justify-center items-center rounded-xl border border-transparent bg-brand-purple px-6 py-2.5 text-xs sm:text-sm font-semibold text-white shadow-xs hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all min-h-[44px] cursor-pointer">
                        <i class="bi bi-check-lg mr-2 text-base"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('dashboard') }}" class="inline-flex justify-center items-center rounded-xl border border-gray-300 bg-white px-6 py-2.5 text-xs sm:text-sm font-medium text-gray-700 shadow-xs hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all min-h-[44px]">
                        Kembali ke Dashboard
                    </a>
                </div>
            </form>
        </div>

        <!-- ISI TAB 2: INFORMASI DETAIL AKUN -->
        <div x-show="activeTab === 'info'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="p-5 sm:p-7 md:p-8" style="display: none;">
            <!-- Hero Profil Singkat -->
            <div class="flex items-center gap-4 p-4 mb-6 rounded-xl bg-gray-50/80 border border-gray-200">
                <img src="{{ asset('images/logo-pupr.png') }}" alt="Logo PUPR" class="w-14 h-14 rounded-full border border-gray-200 bg-white object-contain p-1.5 shadow-2xs flex-shrink-0">
                <div class="min-w-0 flex-1">
                    <div class="font-bold text-gray-900 text-base sm:text-lg truncate leading-tight">{{ auth()->user()->name }}</div>
                    <div class="text-xs sm:text-sm text-gray-500 truncate mt-0.5">{{ auth()->user()->email }}</div>
                    <div class="mt-2 flex items-center gap-2 flex-wrap">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ auth()->user()->role === 'admin' ? 'bg-purple-100 text-brand-purple border border-purple-200' : 'bg-blue-100 text-blue-800 border border-blue-200' }}">
                            <i class="bi {{ auth()->user()->role === 'admin' ? 'bi-shield-shaded' : 'bi-person-badge' }}"></i>
                            {{ strtoupper(auth()->user()->role) }}
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Akun Aktif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Rincian Identitas Akun -->
            <div class="space-y-3">
                <div class="p-3.5 sm:p-4 rounded-xl bg-gray-50/60 border border-gray-200">
                    <div class="text-[10px] font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</div>
                    <div class="font-semibold text-gray-900 text-sm">{{ auth()->user()->name }}</div>
                </div>
                <div class="p-3.5 sm:p-4 rounded-xl bg-gray-50/60 border border-gray-200">
                    <div class="text-[10px] font-medium text-gray-500 uppercase tracking-wider mb-1">Email Kedinasan</div>
                    <div class="font-semibold text-gray-900 text-sm break-all">{{ auth()->user()->email }}</div>
                </div>
                <div class="p-3.5 sm:p-4 rounded-xl bg-gray-50/60 border border-gray-200 flex items-center justify-between">
                    <div>
                        <div class="text-[10px] font-medium text-gray-500 uppercase tracking-wider mb-1">Hak Akses / Peran</div>
                        <div class="font-semibold text-gray-900 text-sm">{{ ucfirst(auth()->user()->role) }} PUPR</div>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ auth()->user()->role === 'admin' ? 'bg-purple-100 text-brand-purple border border-purple-200' : 'bg-blue-100 text-blue-800 border border-blue-200' }}">
                        {{ strtoupper(auth()->user()->role) }}
                    </span>
                </div>
                @if (auth()->user()->created_at)
                    <div class="p-3.5 sm:p-4 rounded-xl bg-gray-50/60 border border-gray-200">
                        <div class="text-[10px] font-medium text-gray-500 uppercase tracking-wider mb-1">Terdaftar Sejak</div>
                        <div class="font-semibold text-gray-900 text-sm">{{ auth()->user()->created_at->translatedFormat('d F Y, H:i') }} WIB</div>
                    </div>
                @endif
            </div>

            <!-- Kotak Info Keamanan Kata Sandi -->
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 mt-6">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-brand-purple border border-purple-200/80 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="bi bi-shield-lock-fill text-base"></i>
                    </div>
                    <div>
                        <div class="text-xs sm:text-sm font-semibold text-gray-800">Keamanan Kata Sandi & Akses</div>
                        <div class="text-xs text-gray-500 mt-1 leading-relaxed">
                            Perubahan kata sandi dilakukan secara terverifikasi melalui menu <strong>Lupa Password</strong> di halaman masuk atau melalui konfirmasi Administrator Sistem.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection