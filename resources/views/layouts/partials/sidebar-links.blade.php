@php
$navClass = 'group flex items-center px-4 py-2.5 text-sm rounded-xl mb-1.5 transition-all duration-150';
$navActive = 'bg-brand-purple text-white font-semibold shadow-xs';
$navInactive = 'text-gray-600 font-medium hover:bg-gray-100 hover:text-brand-purple';
$iconClass = 'flex-shrink-0 -ml-1 mr-4 text-xl transition-colors duration-150';
$iconActive = 'text-brand-yellow drop-shadow-xs';
$iconInactive = 'text-gray-400 group-hover:text-brand-purple';
@endphp

<a href="{{ route('dashboard') }}" class="{{ $navClass }} {{ request()->routeIs('dashboard') ? $navActive : $navInactive }}">
    <i class="bi bi-grid-1x2-fill {{ $iconClass }} {{ request()->routeIs('dashboard') ? $iconActive : $iconInactive }}"></i>
    <span class="truncate tracking-wide">Dashboard</span>
</a>

@if (auth()->user()->role === 'petugas')
    <a href="{{ route('roads.index') }}" class="{{ $navClass }} {{ request()->routeIs('roads.*') ? $navActive : $navInactive }}">
        <i class="bi bi-signpost-split-fill {{ $iconClass }} {{ request()->routeIs('roads.*') ? $iconActive : $iconInactive }}"></i>
        <span class="truncate tracking-wide">Input Ruas Jalan</span>
    </a>
@else
    <a href="{{ route('roads.index') }}" class="{{ $navClass }} {{ request()->routeIs('roads.*') ? $navActive : $navInactive }}">
        <i class="bi bi-signpost-split-fill {{ $iconClass }} {{ request()->routeIs('roads.*') ? $iconActive : $iconInactive }}"></i>
        <span class="truncate tracking-wide">Data Ruas Jalan</span>
    </a>
    <a href="{{ route('users.index') }}" class="{{ $navClass }} {{ request()->routeIs('users.*') ? $navActive : $navInactive }}">
        <i class="bi bi-people-fill {{ $iconClass }} {{ request()->routeIs('users.*') ? $iconActive : $iconInactive }}"></i>
        <span class="truncate tracking-wide">Daftar User</span>
    </a>
    <a href="{{ route('activity-logs.index') }}" class="{{ $navClass }} {{ request()->routeIs('activity-logs.*') ? $navActive : $navInactive }}">
        <i class="bi bi-clock-history {{ $iconClass }} {{ request()->routeIs('activity-logs.*') ? $iconActive : $iconInactive }}"></i>
        <span class="truncate tracking-wide">Riwayat Aktivitas</span>
    </a>
@endif

<a href="{{ route('criteria.index') }}" class="{{ $navClass }} {{ request()->routeIs('criteria.*') ? $navActive : $navInactive }}">
    <i class="bi bi-ui-checks-grid {{ $iconClass }} {{ request()->routeIs('criteria.*') ? $iconActive : $iconInactive }}"></i>
    <span class="truncate tracking-wide">Data Kriteria</span>
</a>
<a href="{{ route('moora.index') }}" class="{{ $navClass }} {{ request()->routeIs('moora.*') ? $navActive : $navInactive }}">
    <i class="bi bi-bar-chart-line-fill {{ $iconClass }} {{ request()->routeIs('moora.*') ? $iconActive : $iconInactive }}"></i>
    <span class="truncate tracking-wide">Hasil MOORA</span>
</a>
<a href="{{ route('reports.index') }}" class="{{ $navClass }} {{ request()->routeIs('reports.*') ? $navActive : $navInactive }}">
    <i class="bi bi-file-earmark-bar-graph-fill {{ $iconClass }} {{ request()->routeIs('reports.*') ? $iconActive : $iconInactive }}"></i>
    <span class="truncate tracking-wide">Laporan Prioritas</span>
</a>

<div class="mt-8 mb-4">
    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-3 border-t border-gray-100 pt-6">Pengaturan</div>
    <a href="{{ route('profile.edit') }}" class="{{ $navClass }} {{ request()->routeIs('profile.*') ? $navActive : $navInactive }}">
        <i class="bi bi-person-gear {{ $iconClass }} {{ request()->routeIs('profile.*') ? $iconActive : $iconInactive }}"></i>
        <span class="truncate tracking-wide">Kelola Profil</span>
    </a>

    <button type="button" onclick="window.installPWA()" class="w-full text-left group flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-xl mb-1.5 transition-all duration-150 text-brand-purple bg-purple-50/60 hover:bg-purple-100/80 hover:shadow-2xs cursor-pointer border border-purple-100">
        <div class="flex items-center">
            <i class="bi bi-download flex-shrink-0 -ml-1 mr-4 text-xl text-brand-purple transition-transform group-hover:scale-110"></i>
            <span class="truncate tracking-wide font-semibold text-gray-800">Install Aplikasi</span>
        </div>
        <span class="text-[10px] px-1.5 py-0.5 rounded font-bold bg-brand-purple text-white">PWA</span>
    </button>

    <form method="POST" action="{{ route('logout') }}" class="w-full mt-2">
        @csrf
        <button type="submit" class="w-full text-left group flex items-center px-4 py-2.5 text-sm font-medium rounded-xl mb-1.5 transition-all duration-150 text-red-600 hover:bg-red-50 hover:text-red-700 hover:shadow-xs cursor-pointer">
            <i class="bi bi-box-arrow-right flex-shrink-0 -ml-1 mr-4 text-xl transition-colors duration-150 text-red-500 group-hover:text-red-700"></i>
            <span class="truncate tracking-wide">Logout</span>
        </button>
    </form>
</div>
