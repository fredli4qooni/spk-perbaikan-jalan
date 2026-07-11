@extends('layouts.guest')

@section('guest-title', 'Ajukan akun petugas dengan alur yang rapi.')
@section('guest-description', 'Permohonan akun masuk ke daftar admin untuk ditinjau, disetujui, atau ditolak secara terstruktur.')

@section('guest-content')
<div>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 flex justify-center items-center gap-2">
            <i class="bi bi-person-plus text-brand-purple"></i> Permohonan Akun Petugas
        </h2>
        <p class="text-sm text-gray-500 mt-2">Isi data berikut untuk mengajukan akses petugas.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-brand-red p-4 rounded-r-md">
            <div class="flex">
                <i class="bi bi-exclamation-circle text-brand-red mr-3 mt-0.5 text-lg"></i>
                <div class="text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('account-request.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-purple focus:border-brand-purple bg-gray-50 focus:bg-white transition-colors" value="{{ old('name') }}" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-purple focus:border-brand-purple bg-gray-50 focus:bg-white transition-colors" value="{{ old('email') }}" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
            <textarea name="notes" rows="4" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-purple focus:border-brand-purple bg-gray-50 focus:bg-white transition-colors" placeholder="Tuliskan alasan pengajuan akun (opsional)">{{ old('notes') }}</textarea>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Role yang diminta</label>
            <input type="text" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-100 text-gray-500 cursor-not-allowed" value="petugas" disabled>
        </div>
        
        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-brand-purple hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-purple transition-colors">
            Kirim Permohonan
        </button>
    </form>

    <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between">
        <div>
            <div class="text-sm font-bold text-gray-800">Butuh akses lebih dulu?</div>
            <div class="text-xs text-gray-500 mt-0.5">Kembali ke login jika akun sudah aktif.</div>
        </div>
        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-purple transition-colors">
            Login
        </a>
    </div>
</div>
@endsection