<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'PUPR MOORA' }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Memperbesar ukuran icon library Bootstrap Icons agar lebih menonjol -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased overflow-hidden">

<div class="flex h-screen bg-gray-50" x-data="{ mobileMenuOpen: false }">
    
    <!-- Mobile sidebar -->
    <div x-show="mobileMenuOpen" class="md:hidden fixed inset-0 z-40 flex" style="display: none;">
        <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900 bg-opacity-75"></div>
        
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative flex-1 flex flex-col max-w-xs w-full bg-white shadow-xl">
            <div class="absolute top-0 right-0 -mr-12 pt-4">
                <button @click="mobileMenuOpen = false" type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="sr-only">Close sidebar</span>
                    <i class="bi bi-x-lg text-white text-xl"></i>
                </button>
            </div>
            
            <div class="h-16 flex items-center px-6 bg-brand-purple text-white shadow-sm">
                <a href="{{ route('dashboard') }}" class="font-bold text-xl tracking-wider flex items-center gap-2">
                    <span class="w-8 h-8 rounded bg-brand-yellow text-brand-purple flex items-center justify-center font-black">P</span>
                    PUPR MOORA
                </a>
            </div>
            
            <div class="mt-5 flex-1 h-0 overflow-y-auto">
                <nav class="px-4 space-y-1.5">
                    @include('layouts.partials.sidebar-links')
                </nav>
            </div>
        </div>
        <div class="flex-shrink-0 w-14" aria-hidden="true"></div>
    </div>

    <!-- Desktop sidebar -->
    <div class="hidden md:flex md:flex-shrink-0 bg-white border-r border-gray-200 shadow-sm z-20 transition-all duration-300 w-64">
        <div class="flex flex-col w-full">
            <div class="h-16 flex items-center px-6 bg-brand-purple text-white flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="font-bold text-xl tracking-wider flex items-center gap-3">
                    <span class="w-8 h-8 rounded bg-brand-yellow text-brand-purple flex items-center justify-center font-black shadow-inner">P</span>
                    <span>PUPR MOORA</span>
                </a>
            </div>
            <div class="flex flex-col flex-grow pt-6 pb-4 overflow-y-auto">
                <nav class="flex-1 px-4 space-y-1.5 bg-white">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-3">Menu Utama</div>
                    @include('layouts.partials.sidebar-links')
                </nav>
            </div>
            
            <!-- User Info in Sidebar Footer (Optional enhancement) -->
            <div class="p-4 border-t border-gray-100 mt-auto">
                <div class="flex items-center gap-3 px-3 py-2 rounded-lg bg-gray-50 border border-gray-100">
                    <img class="h-9 w-9 rounded-full object-cover border border-gray-200" src="{{ auth()->user()->profile_photo_url }}" alt="">
                    <div class="overflow-hidden">
                        <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-brand-purple font-medium truncate">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        
        <!-- Top Navbar -->
        <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow-sm border-b border-gray-200">
            <!-- Mobile menu button -->
            <button @click="mobileMenuOpen = true" type="button" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-purple md:hidden hover:bg-gray-50">
                <span class="sr-only">Open sidebar</span>
                <i class="bi bi-list text-2xl"></i>
            </button>
            
            <div class="flex-1 px-4 flex justify-between sm:px-6 lg:px-8 items-center">
                <div class="flex-1 flex">
                    <!-- Optional: Search bar or Page Breadcrumbs can go here -->
                    <div class="hidden sm:flex items-center text-sm font-medium text-gray-500">
                        <span class="text-gray-400 mr-2">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                
                <div class="ml-4 flex items-center md:ml-6 gap-4">
                    <!-- Profile dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <div>
                            <button @click="open = !open" type="button" class="flex items-center gap-2 max-w-xs text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-brand-purple focus:ring-offset-2 transition-all hover:ring-2 hover:ring-brand-purple/50 p-1 pr-3 bg-gray-50 border border-gray-100" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ auth()->user()->profile_photo_url }}" alt="">
                                <span class="hidden md:block font-medium text-gray-700">{{ explode(' ', auth()->user()->name)[0] }}</span>
                                <i class="bi bi-chevron-down text-gray-400 text-xs ml-1"></i>
                            </button>
                        </div>
                        
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-48 rounded-xl shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 divide-y divide-gray-100" style="display: none;">
                            <div class="px-4 py-3">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-brand-purple">
                                    <i class="bi bi-person-gear mr-3 text-gray-400 group-hover:text-brand-purple text-lg"></i> Profil
                                </a>
                            </div>
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="group flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="bi bi-box-arrow-right mr-3 text-red-400 group-hover:text-red-600 text-lg"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 relative z-0 overflow-y-auto focus:outline-none bg-gray-50/50">
            <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 bg-green-50 border border-green-200 border-l-4 border-l-brand-green p-4 rounded-lg shadow-sm flex justify-between items-start">
                        <div class="flex">
                            <i class="bi bi-check-circle-fill text-brand-green mt-0.5 mr-3 text-lg"></i>
                            <p class="text-sm text-green-800 font-semibold">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-green-600 hover:text-brand-green transition-colors"><i class="bi bi-x-lg"></i></button>
                    </div>
                @endif
                
                @if ($errors->any())
                    <div x-data="{ show: true }" x-show="show" class="mb-6 bg-red-50 border border-red-200 border-l-4 border-l-brand-red p-4 rounded-lg shadow-sm">
                        <div class="flex justify-between">
                            <div class="flex">
                                <i class="bi bi-exclamation-triangle-fill text-brand-red mt-0.5 mr-3 text-lg"></i>
                                <div>
                                    <h3 class="text-sm font-bold text-red-800">Periksa kembali input Anda</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <button @click="show = false" class="text-red-600 hover:text-brand-red items-start transition-colors"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </div>
                @endif

                @unless (request()->routeIs('dashboard'))
                    <div class="mb-6">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-brand-purple hover:text-brand-purple-hover bg-white border border-gray-200 rounded-lg px-4 py-2 shadow-sm hover:bg-gray-50 hover:border-gray-300 transition-all focus:ring-2 focus:ring-brand-purple focus:outline-none">
                            <i class="bi bi-arrow-left mr-2"></i> Kembali ke Dashboard
                        </a>
                    </div>
                @endunless

                <div class="animate-fade-in-up">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</div>

@stack('modals')
@stack('scripts')
</body>
</html>
