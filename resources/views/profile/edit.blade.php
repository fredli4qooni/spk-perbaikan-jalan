@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
        <i class="bi bi-person-gear text-brand-purple"></i> Kelola Profil Akun
    </h2>
    <p class="text-sm text-gray-500 mt-1">Perbarui nama dan email kedinasan akun Anda.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <div class="lg:col-span-7">
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden h-full">
            <div class="p-6 md:p-8">
                <!-- Banner Avatar Otomatis PUPR -->
                <div class="flex items-center gap-4 p-4 mb-6 rounded-xl bg-purple-50/50 border border-purple-100">
                    <div class="relative">
                        <img src="{{ asset('images/logo-pupr.png') }}" alt="Logo PUPR" class="w-16 h-16 rounded-full border-2 border-brand-purple bg-white object-contain p-1.5 shadow-xs">
                        <span class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-green-500 border-2 border-white" title="Akun Aktif"></span>
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

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2.5 border" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email Kedinasan</label>
                        <input type="email" name="email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2.5 border" value="{{ old('email', auth()->user()->email) }}" required>
                        <p class="text-xs text-gray-400 mt-1.5">Alamat email ini digunakan untuk login dan menerima seluruh notifikasi aktivitas akun.</p>
                    </div>

                    <!-- Security Notice Box -->
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 mb-6">
                        <div class="flex items-start gap-2.5">
                            <i class="bi bi-shield-lock-fill text-brand-purple text-base mt-0.5"></i>
                            <div>
                                <div class="text-xs font-bold text-gray-800">Keamanan Kata Sandi</div>
                                <div class="text-xs text-gray-500 mt-0.5 leading-relaxed">
                                    Perubahan kata sandi dilakukan secara terverifikasi melalui menu <strong>Lupa Password</strong> di halaman masuk dengan kode konfirmasi ke email resmi Anda.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-5 border-t border-gray-100">
                        <button type="submit" class="inline-flex justify-center items-center rounded-md border border-transparent bg-brand-purple px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-brand-purple focus:ring-offset-2 transition-colors">
                            <i class="bi bi-check-lg mr-2 text-lg"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('dashboard') }}" class="inline-flex justify-center items-center rounded-md border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-purple focus:ring-offset-2 transition-colors">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Informasi Akun -->
    <div class="lg:col-span-5">
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden h-full">
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-2 mb-2 text-xl font-bold text-gray-900">
                    <i class="bi bi-person-badge text-brand-purple"></i> Informasi Akun
                </div>
                <p class="text-sm text-gray-500 mb-6">Ringkasan identitas akun yang sedang aktif saat ini.</p>

                <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 border border-gray-100 mb-6">
                    <img src="{{ asset('images/logo-pupr.png') }}" alt="Logo PUPR" class="w-14 h-14 rounded-full border border-gray-200 bg-white object-contain p-1 shadow-xs">
                    <div>
                        <div class="font-bold text-gray-900">{{ auth()->user()->name }}</div>
                        <div class="text-sm text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="p-4 rounded-xl bg-white border border-gray-100 shadow-sm">
                        <div class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</div>
                        <div class="font-bold text-gray-900">{{ auth()->user()->name }}</div>
                    </div>
                    <div class="p-4 rounded-xl bg-white border border-gray-100 shadow-sm">
                        <div class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Email Terdaftar</div>
                        <div class="font-bold text-gray-900">{{ auth()->user()->email }}</div>
                    </div>
                    <div class="p-4 rounded-xl bg-white border border-gray-100 shadow-sm">
                        <div class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Peran / Role</div>
                        <div class="font-bold text-brand-purple">
                            {{ ucfirst(auth()->user()->role) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection