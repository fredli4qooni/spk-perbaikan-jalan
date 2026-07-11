@extends('layouts.guest')

@section('guest-title', 'Prioritas perbaikan jalan yang lebih cepat, rapi, dan terukur.')
@section('guest-description', 'Masuk sebagai admin atau petugas untuk mengelola data jalan, verifikasi, dan hasil MOORA dalam satu sistem.')

@section('guest-content')
<div>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 flex justify-center items-center gap-2">
            <i class="bi bi-diagram-3 text-brand-purple"></i> Masuk ke Sistem
        </h2>
        <p class="text-sm text-gray-500 mt-2">Gunakan akun admin atau petugas untuk mengakses fitur sesuai role.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-brand-red p-4 rounded-r-md">
            <div class="flex">
                <i class="bi bi-exclamation-circle text-brand-red mr-3 mt-0.5 text-lg"></i>
                <div class="text-sm text-red-700">
                    <p class="font-bold">Gagal!</p>
                    <p>Email atau password salah.</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-brand-green p-4 rounded-r-md">
            <div class="flex">
                <i class="bi bi-check-circle text-brand-green mr-3 mt-0.5 text-lg"></i>
                <div class="text-sm text-green-700">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-2">
                <i class="bi bi-envelope text-gray-400"></i> Email
            </label>
            <input type="email" name="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-purple focus:border-brand-purple transition-colors bg-gray-50 focus:bg-white" value="{{ old('email') }}" placeholder="admin@pupr.test" required autofocus>
        </div>
        
        <div class="mb-5" x-data="{ showPassword: false }">
            <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-2">
                <i class="bi bi-lock text-gray-400"></i> Password
            </label>
            <div class="relative">
                <input :type="showPassword ? 'text' : 'password'" name="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-purple focus:border-brand-purple transition-colors bg-gray-50 focus:bg-white pr-10" placeholder="Masukkan password" required>
                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-brand-purple focus:outline-none transition-colors">
                    <i class="bi text-lg" :class="showPassword ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                </button>
            </div>
        </div>
        
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-brand-purple focus:ring-brand-purple border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">
                    Ingat saya
                </label>
            </div>
            
            <a href="{{ route('password.request') }}" class="text-sm font-medium text-brand-purple hover:text-brand-purple-hover">
                Lupa password?
            </a>
        </div>
        
        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-brand-purple hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-purple transition-colors">
            Masuk
        </button>
    </form>

    <div class="mt-4">
        <a href="{{ route('account-request.create') }}" class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-purple transition-colors">
            <i class="bi bi-person-plus mr-2"></i> Permohonan Akun
        </a>
    </div>


</div>
@endsection