@extends('layouts.app')

@section('content')
<!-- Header Halaman (Rata Kiri Presisi) -->
<div class="mb-5 sm:mb-6">
    <h2 class="text-xl sm:text-2xl font-black text-gray-900 leading-tight">
        Tambah Petugas
    </h2>
    <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
        Admin dapat mendaftarkan akun baru untuk petugas survei lapangan PUPR.
    </p>
</div>

<div class="bg-white shadow-xs rounded-2xl border border-gray-200 overflow-hidden">
    <div class="p-5 sm:p-8">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" class="block w-full rounded-xl border-gray-300 shadow-2xs focus:border-brand-purple focus:ring-brand-purple text-sm p-3 border" placeholder="Contoh: Budi Santoso" value="{{ old('name') }}" required>
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Alamat Email Kedinasan</label>
                    <input type="email" name="email" class="block w-full rounded-xl border-gray-300 shadow-2xs focus:border-brand-purple focus:ring-brand-purple text-sm p-3 border" placeholder="petugas@pupr.test" value="{{ old('email') }}" required>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Password</label>
                    <input type="password" name="password" class="block w-full rounded-xl border-gray-300 shadow-2xs focus:border-brand-purple focus:ring-brand-purple text-sm p-3 border" placeholder="Minimal 6 karakter" required>
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="block w-full rounded-xl border-gray-300 shadow-2xs focus:border-brand-purple focus:ring-brand-purple text-sm p-3 border" placeholder="Ulangi password" required>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Role / Peran Sistem</label>
                <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-xl border border-gray-200">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                        Petugas
                    </span>
                    <span class="text-xs text-gray-500">Akun baru otomatis memiliki role sebagai petugas lapangan.</span>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-5 border-t border-gray-100">
                <a href="{{ route('users.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-xs sm:text-sm font-bold text-gray-700 shadow-2xs hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all">
                    Kembali
                </a>
                <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl border border-transparent bg-brand-purple px-6 py-2.5 text-xs sm:text-sm font-bold text-white shadow-xs hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all">
                    <i class="bi bi-save mr-2"></i> Simpan Petugas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection