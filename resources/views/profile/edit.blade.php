@extends('layouts.app')

@section('content')
<!-- Header Halaman (Rata Kiri Presisi) -->
<div class="mb-5 sm:mb-6">
    <h2 class="text-xl sm:text-2xl font-black text-gray-900 leading-tight">
        Kelola Profil Akun
    </h2>
    <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
        Perbarui nama dan email kedinasan akun Anda.
    </p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6 lg:gap-8">
    <!-- Form Kelola Profil -->
    <div class="lg:col-span-7">
        <div class="bg-white shadow-xs rounded-2xl border border-gray-200 overflow-hidden h-full">
            <div class="p-5 sm:p-7 md:p-8">
                <!-- Banner Avatar Otomatis PUPR -->
                <div class="flex items-center gap-4 p-4 mb-6 rounded-xl bg-purple-50/70 border border-purple-100">
                    <div class="relative flex-shrink-0">
                        <img src="{{ asset('images/logo-pupr.png') }}" alt="Logo PUPR" class="w-14 h-14 sm:w-16 sm:h-16 rounded-full border-2 border-brand-purple bg-white object-contain p-1.5 shadow-xs">
                        <span class="absolute bottom-0 right-0 w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-full bg-green-500 border-2 border-white" title="Akun Aktif"></span>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-gray-900 flex items-center gap-1.5">
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
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="block w-full rounded-xl border border-gray-200 shadow-xs focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/20 text-sm py-2.5 px-3.5 bg-white transition-all min-h-[44px]" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div class="mb-5 sm:mb-6">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Alamat Email Kedinasan <span class="text-red-500">*</span></label>
                        <input type="email" name="email" class="block w-full rounded-xl border border-gray-200 shadow-xs focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/20 text-sm py-2.5 px-3.5 bg-white transition-all min-h-[44px]" value="{{ old('email', auth()->user()->email) }}" required>
                        <p class="text-[11px] sm:text-xs text-gray-400 mt-1.5">Alamat email ini digunakan untuk login dan menerima seluruh notifikasi aktivitas akun.</p>
                    </div>

                    <!-- Security Notice Box -->
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 mb-6">
                        <div class="flex items-start gap-2.5">
                            <i class="bi bi-shield-lock-fill text-brand-purple text-base mt-0.5 flex-shrink-0"></i>
                            <div>
                                <div class="text-xs font-bold text-gray-800">Keamanan Kata Sandi</div>
                                <div class="text-xs text-gray-500 mt-0.5 leading-relaxed">
                                    Perubahan kata sandi dilakukan secara terverifikasi melalui menu <strong>Lupa Password</strong> di halaman masuk dengan kode konfirmasi ke email resmi Anda.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-5 border-t border-gray-100">
                        <button type="submit" class="inline-flex justify-center items-center rounded-xl border border-transparent bg-brand-purple px-6 py-2.5 text-xs sm:text-sm font-bold text-white shadow-sm hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all min-h-[44px] cursor-pointer">
                            <i class="bi bi-check-lg mr-2 text-base"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('dashboard') }}" class="inline-flex justify-center items-center rounded-xl border border-gray-300 bg-white px-6 py-2.5 text-xs sm:text-sm font-semibold text-gray-700 shadow-xs hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all min-h-[44px]">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Informasi Akun -->
    <div class="lg:col-span-5">
        <div class="bg-white shadow-xs rounded-2xl border border-gray-200 overflow-hidden h-full">
            <div class="p-5 sm:p-7 md:p-8">
                <div class="mb-5">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 leading-tight">Informasi Akun</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Ringkasan identitas akun yang sedang aktif saat ini.</p>
                </div>

                <div class="flex items-center gap-3.5 p-4 rounded-xl bg-gray-50/80 border border-gray-200 mb-5">
                    <img src="{{ asset('images/logo-pupr.png') }}" alt="Logo PUPR" class="w-12 h-12 rounded-full border border-gray-200 bg-white object-contain p-1 shadow-2xs flex-shrink-0">
                    <div class="min-w-0">
                        <div class="font-bold text-gray-900 text-sm truncate">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="p-3.5 sm:p-4 rounded-xl bg-gray-50/60 border border-gray-200">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap</div>
                        <div class="font-bold text-gray-900 text-sm">{{ auth()->user()->name }}</div>
                    </div>
                    <div class="p-3.5 sm:p-4 rounded-xl bg-gray-50/60 border border-gray-200">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Email Terdaftar</div>
                        <div class="font-bold text-gray-900 text-sm break-all">{{ auth()->user()->email }}</div>
                    </div>
                    <div class="p-3.5 sm:p-4 rounded-xl bg-gray-50/60 border border-gray-200 flex items-center justify-between">
                        <div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Peran / Role</div>
                            <div class="font-bold text-gray-900 text-sm">{{ ucfirst(auth()->user()->role) }}</div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold {{ auth()->user()->role === 'admin' ? 'bg-purple-100 text-brand-purple border border-purple-200' : 'bg-blue-100 text-blue-800 border border-blue-200' }}">
                            {{ strtoupper(auth()->user()->role) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection