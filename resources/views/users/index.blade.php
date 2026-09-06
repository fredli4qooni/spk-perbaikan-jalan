@extends('layouts.app')

@section('content')
<!-- Header Halaman (Rata Kiri Presisi) -->
<div class="flex items-center justify-between gap-3 mb-5">
    <div class="min-w-0 flex-1">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">
            Daftar User
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
            Kelola data akun admin dan petugas yang terdaftar di sistem.
        </p>
    </div>
    <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center rounded-xl bg-brand-purple px-3.5 py-2 sm:px-4 sm:py-2.5 text-xs sm:text-sm font-semibold text-white shadow-xs hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all flex-shrink-0">
        <i class="bi bi-person-plus mr-1.5"></i> <span>Tambah Petugas</span>
    </a>
</div>

<!-- ========================================== -->
<!-- TAMPILAN MOBILE (< md): USER CARDS         -->
<!-- ========================================== -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:hidden">
    @forelse ($users as $user)
        <div class="bg-white rounded-2xl border border-gray-200 shadow-xs p-4 flex flex-col justify-between space-y-3">
            <div class="flex items-start justify-between gap-2.5">
                <div class="flex items-center gap-3 min-w-0">
                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full bg-gray-100 border border-gray-200 object-cover flex-shrink-0">
                    <div class="min-w-0">
                        <h3 class="font-semibold text-gray-900 text-sm truncate leading-snug">{{ $user->name }}</h3>
                        <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                    </div>
                </div>
                @if ($user->role === 'admin')
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-brand-purple text-white flex-shrink-0">
                        Admin
                    </span>
                @else
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-200 flex-shrink-0">
                        Petugas
                    </span>
                @endif
            </div>

            <div class="pt-2.5 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400">
                <span>Terdaftar:</span>
                <span class="font-medium text-gray-600">{{ $user->created_at?->translatedFormat('d M Y') }}</span>
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white rounded-2xl border border-gray-200 p-8 text-center text-gray-500">
            <i class="bi bi-people text-4xl mb-2 block text-gray-300"></i>
            <p class="font-medium text-gray-700 text-sm">Belum ada data user.</p>
        </div>
    @endforelse
</div>

<!-- ========================================== -->
<!-- TAMPILAN DESKTOP (>= md): TABEL MODERN    -->
<!-- ========================================== -->
<div class="hidden md:block bg-white shadow-sm rounded-2xl border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Pengguna</th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-32">Role</th>
                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider w-44">Waktu Dibuat</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-semibold text-gray-900 flex items-center gap-3">
                                <img src="{{ $user->profile_photo_url }}" alt="" class="w-8 h-8 rounded-full bg-gray-100 border border-gray-200 object-cover">
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500 font-mono">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($user->role === 'admin')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-brand-purple text-white shadow-2xs">Admin</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">Petugas</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs text-gray-500">
                            {{ $user->created_at?->translatedFormat('d M Y, H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <i class="bi bi-inbox text-3xl mb-2 block text-gray-300"></i>
                            Belum ada user.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-5">
    {{ $users->links() }}
</div>
@endsection