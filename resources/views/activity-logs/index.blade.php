@extends('layouts.app')

@section('content')
<!-- Header Halaman (Rata Kiri Presisi) -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5">
    <div class="min-w-0 flex-1">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">
            Riwayat Aktivitas
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
            Audit log dan pencatatan aktivitas seluruh petugas dan admin di dalam sistem.
        </p>
    </div>
    <div class="inline-flex items-center gap-2 text-xs font-medium text-gray-700 bg-white px-3.5 py-2 rounded-xl border border-gray-200 shadow-2xs flex-shrink-0">
        <i class="bi bi-shield-check text-brand-green text-sm"></i> 
        <span>Total: {{ number_format($activities->total()) }} Catatan</span>
    </div>
</div>

@php
    $actionColors = [
        'login' => 'bg-blue-50 text-blue-700 border-blue-200',
        'logout' => 'bg-gray-100 text-gray-700 border-gray-200',
        'create' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'update' => 'bg-amber-50 text-amber-800 border-amber-200',
        'delete' => 'bg-red-50 text-red-700 border-red-200',
        'profile' => 'bg-purple-50 text-brand-purple border-purple-200',
        'password' => 'bg-orange-50 text-orange-800 border-orange-200',
    ];
@endphp

<!-- ========================================== -->
<!-- TAMPILAN MOBILE (< md): TIMELINE CARDS     -->
<!-- ========================================== -->
<div class="block md:hidden space-y-3">
    @forelse ($activities as $log)
        @php
            $colorClass = $actionColors[$log->action] ?? 'bg-gray-100 text-gray-800 border-gray-200';
        @endphp
        <div class="bg-white rounded-2xl border border-gray-200 shadow-xs p-4 space-y-2.5">
            <!-- Header Kartu: User & Action Badge -->
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-2.5 min-w-0">
                    @if ($log->user)
                        <img src="{{ $log->user->profile_photo_url }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover border border-gray-200 flex-shrink-0">
                        <div class="min-w-0">
                            <span class="font-semibold text-gray-900 text-xs sm:text-sm block truncate">{{ $log->user->name }}</span>
                            <span class="text-[10px] text-gray-400 block truncate">{{ $log->user->email }}</span>
                        </div>
                    @else
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 font-medium text-xs flex-shrink-0">
                            ?
                        </div>
                        <div class="min-w-0">
                            <span class="font-medium text-gray-500 text-xs block truncate">Sistem / Tamu</span>
                        </div>
                    @endif
                </div>

                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase border flex-shrink-0 {{ $colorClass }}">
                    {{ $log->action }}
                </span>
            </div>

            <!-- Isi Deskripsi Aktivitas -->
            <p class="text-xs sm:text-sm text-gray-800 leading-relaxed font-medium pt-1">
                {{ $log->description }}
            </p>

            <!-- Footer: Waktu & IP Address -->
            <div class="pt-2 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-400">
                <span class="flex items-center gap-1 font-mono">
                    <i class="bi bi-hdd-network text-gray-400"></i> {{ $log->ip_address ?? '-' }}
                </span>
                <span class="font-medium text-gray-500">
                    {{ $log->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-2xl border border-gray-200 p-8 text-center text-gray-500">
            <i class="bi bi-clock-history text-4xl mb-2 block text-gray-300"></i>
            <p class="font-medium text-gray-700 text-sm">Belum ada riwayat aktivitas.</p>
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
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pengguna</th>
                    <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-28">Tindakan</th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Deskripsi Aktivitas</th>
                    <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-36">Alamat IP</th>
                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider w-44">Waktu</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($activities as $log)
                    @php
                        $colorClass = $actionColors[$log->action] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                @if ($log->user)
                                    <img src="{{ $log->user->profile_photo_url }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                                    <div>
                                        <div class="font-semibold text-gray-900 text-sm">{{ $log->user->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $log->user->email }}</div>
                                    </div>
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 font-medium text-xs">
                                        ?
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-500 text-sm">Sistem / Tamu</div>
                                        <div class="text-xs text-gray-400">-</div>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold uppercase border {{ $colorClass }}">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800 font-medium">
                            {{ $log->description }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-xs font-mono text-gray-500">
                            {{ $log->ip_address ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs text-gray-500">
                            <div class="font-semibold text-gray-700">{{ $log->created_at->translatedFormat('d M Y, H:i') }}</div>
                            <div class="text-gray-400 mt-0.5">{{ $log->created_at->diffForHumans() }}</div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-gray-500">
                            <i class="bi bi-clock-history text-4xl mb-3 block text-gray-300"></i>
                            <p class="font-semibold text-gray-600">Belum ada riwayat aktivitas yang tercatat.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-5">
    {{ $activities->links() }}
</div>
@endsection
