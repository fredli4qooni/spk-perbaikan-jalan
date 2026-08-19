@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <i class="bi bi-clock-history text-brand-purple"></i> Riwayat Aktivitas Pengguna
        </h2>
        <p class="text-sm text-gray-500 mt-1">Audit log dan pencatatan aktivitas seluruh petugas dan admin di dalam sistem.</p>
    </div>
    <div class="text-sm text-gray-500 bg-white px-3.5 py-2 rounded-lg border border-gray-200 shadow-sm flex items-center gap-2">
        <i class="bi bi-shield-check text-brand-green"></i> Total Catatan: <span class="font-bold text-gray-900">{{ $activities->total() }}</span>
    </div>
</div>

<div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pengguna</th>
                    <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tindakan</th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Deskripsi Aktivitas</th>
                    <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Alamat IP</th>
                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($activities as $log)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                @if ($log->user)
                                    <img src="{{ $log->user->profile_photo_url }}" alt="Avatar" class="w-9 h-9 rounded-full object-cover border border-gray-200 shadow-xs">
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm">{{ $log->user->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $log->user->email }}</div>
                                    </div>
                                @else
                                    <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 font-bold text-xs">
                                        ?
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-500 text-sm">Sistem / Tamu</div>
                                        <div class="text-xs text-gray-400">-</div>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @php
                                $actionColors = [
                                    'login' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'logout' => 'bg-gray-100 text-gray-700 border-gray-200',
                                    'create' => 'bg-green-100 text-green-800 border-green-200',
                                    'update' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'delete' => 'bg-red-100 text-red-800 border-red-200',
                                    'profile' => 'bg-purple-100 text-purple-800 border-purple-200',
                                    'password' => 'bg-orange-100 text-orange-800 border-orange-200',
                                ];
                                $colorClass = $actionColors[$log->action] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase border {{ $colorClass }}">
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
                            <p class="text-xs text-gray-400 mt-1">Setiap tindakan seperti login, penambahan data jalan, dan pengubahan profil akan tercatat di sini.</p>
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
