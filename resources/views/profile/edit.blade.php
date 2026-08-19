@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
        <i class="bi bi-person-gear text-brand-purple"></i> Kelola Profil Akun
    </h2>
    <p class="text-sm text-gray-500 mt-1">Perbarui foto profil, identitas akun, dan kata sandi Anda dengan mudah.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8" x-data="profileManager('{{ auth()->user()->profile_photo_url }}')">
    <div class="lg:col-span-7">
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden h-full">
            <div class="p-6 md:p-8">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Foto Profil -->
                    <div class="mb-6 p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <label class="block text-sm font-bold text-gray-800 mb-3">Foto Profil</label>
                        <div class="flex items-center gap-5">
                            <div class="relative group">
                                <img :src="photoPreview" alt="Foto profil" class="w-20 h-20 rounded-full border-2 border-brand-purple object-cover shadow-sm bg-white">
                                <div class="absolute inset-0 rounded-full bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none text-white text-xs font-semibold">
                                    Ganti Foto
                                </div>
                            </div>
                            <div class="flex-1">
                                <input 
                                    type="file" 
                                    name="profile_photo" 
                                    id="profile_photo" 
                                    @change="previewPhoto"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-brand-purple file:text-white hover:file:bg-brand-purple-hover file:cursor-pointer transition-colors" 
                                    accept="image/*"
                                >
                                <p class="text-xs text-gray-500 mt-2">Mendukung format JPG, PNG, atau WEBP (Maksimal 2 MB).</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2.5 border" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                        <input type="email" name="email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2.5 border" value="{{ old('email', auth()->user()->email) }}" required>
                        <p class="text-xs text-gray-400 mt-1">Email ini akan menerima notifikasi keamanan apabila terjadi perubahan kata sandi.</p>
                    </div>

                    <div class="border-t border-gray-100 pt-5 mt-6 mb-5">
                        <h4 class="font-bold text-gray-800 text-sm mb-1 flex items-center gap-1.5">
                            <i class="bi bi-shield-lock text-brand-purple"></i> Ubah Kata Sandi (Opsional)
                        </h4>
                        <p class="text-xs text-gray-500 mb-4">Kosongkan jika Anda tidak ingin mengganti kata sandi.</p>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                                <input type="password" name="password" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2.5 border" placeholder="Minimal 8 karakter">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2.5 border" placeholder="Ulangi password baru">
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
                    <img :src="photoPreview" alt="Foto profil" class="w-14 h-14 rounded-full border border-gray-200 bg-white object-cover">
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

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('profileManager', (initialPhoto) => ({
            photoPreview: initialPhoto,

            previewPhoto(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.photoPreview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
        }));
    });
</script>
@endsection