@php
$navClass = 'group flex items-center px-4 py-3 text-sm font-bold rounded-xl mb-2 transition-all duration-200';
$navActive = 'bg-brand-purple text-white shadow-md shadow-brand-purple/20';
$navInactive = 'text-gray-600 hover:bg-gray-100 hover:text-brand-purple hover:shadow-sm';
$iconClass = 'flex-shrink-0 -ml-1 mr-4 text-xl transition-colors duration-200';
$iconActive = 'text-brand-yellow drop-shadow-sm';
$iconInactive = 'text-gray-400 group-hover:text-brand-purple';
@endphp

@if (auth()->user()->role === 'petugas')
    <a href="{{ route('roads.index') }}" class="{{ $navClass }} {{ request()->routeIs('roads.*') ? $navActive : $navInactive }}">
        <i class="bi bi-signpost-split-fill {{ $iconClass }} {{ request()->routeIs('roads.*') ? $iconActive : $iconInactive }}"></i>
        <span class="truncate tracking-wide">Input Ruas Jalan</span>
    </a>
    <a href="{{ route('scores.index') }}" class="{{ $navClass }} {{ request()->routeIs('scores.*') ? $navActive : $navInactive }}">
        <i class="bi bi-card-checklist {{ $iconClass }} {{ request()->routeIs('scores.*') ? $iconActive : $iconInactive }}"></i>
        <span class="truncate tracking-wide">Nilai Alternatif</span>
    </a>
@else
    <a href="{{ route('roads.index') }}" class="{{ $navClass }} {{ request()->routeIs('roads.*') ? $navActive : $navInactive }}">
        <i class="bi bi-clipboard-check-fill {{ $iconClass }} {{ request()->routeIs('roads.*') ? $iconActive : $iconInactive }}"></i>
        <span class="truncate tracking-wide">Verifikasi Ruas Jalan</span>
    </a>
    <a href="{{ route('users.index') }}" class="{{ $navClass }} {{ request()->routeIs('users.*') ? $navActive : $navInactive }}">
        <i class="bi bi-people-fill {{ $iconClass }} {{ request()->routeIs('users.*') ? $iconActive : $iconInactive }}"></i>
        <span class="truncate tracking-wide">Daftar User</span>
    </a>
    <a href="{{ route('account-requests.index') }}" class="{{ $navClass }} {{ request()->routeIs('account-requests.*') ? $navActive : $navInactive }}">
        <i class="bi bi-shield-lock-fill {{ $iconClass }} {{ request()->routeIs('account-requests.*') ? $iconActive : $iconInactive }}"></i>
        <span class="truncate tracking-wide">Verifikasi Petugas</span>
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

    <form method="POST" action="{{ route('logout') }}" class="w-full mt-2">
        @csrf
        <button type="submit" class="w-full text-left group flex items-center px-4 py-3 text-sm font-bold rounded-xl mb-2 transition-all duration-200 text-red-600 hover:bg-red-50 hover:text-red-700 hover:shadow-sm">
            <i class="bi bi-box-arrow-right flex-shrink-0 -ml-1 mr-4 text-xl transition-colors duration-200 text-red-500 group-hover:text-red-700"></i>
            <span class="truncate tracking-wide">Logout</span>
        </button>
    </form>
</div>
