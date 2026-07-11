<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'PUPR MOORA' }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen">
    
    <div class="flex min-h-screen">
        <!-- Left Side: Hero / Intro (Hidden on small screens) -->
        <div class="hidden lg:flex lg:w-5/12 bg-brand-purple text-white flex-col justify-center px-12 py-16 relative overflow-hidden">
            <!-- Decorative background elements -->
            <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 rounded-full bg-white opacity-5"></div>
            <div class="absolute bottom-0 left-0 -mb-16 -ml-16 w-80 h-80 rounded-full bg-brand-yellow opacity-10"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-10">
                    <span class="w-10 h-10 rounded-md bg-brand-yellow text-brand-purple flex items-center justify-center font-black text-xl">P</span>
                    <span class="font-bold text-2xl tracking-widest uppercase">PUPR MOORA</span>
                </div>
                
                <h1 class="text-4xl font-extrabold leading-tight mb-6">
                    @yield('guest-title', 'Prioritas perbaikan jalan yang lebih cepat, rapi, dan terukur.')
                </h1>
                
                <p class="text-brand-purple-300 text-lg mb-12 opacity-80 max-w-md">
                    @yield('guest-description', 'Kelola data ruas jalan, verifikasi perbaikan, dan susun prioritas menggunakan perhitungan MOORA dengan alur kerja yang jelas untuk admin dan petugas.')
                </p>
                
                <div class="grid grid-cols-2 gap-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-brand-yellow">
                            <i class="bi bi-shield-check text-xl"></i>
                        </div>
                        <div>
                            <div class="text-xs text-brand-purple-200 uppercase tracking-wider font-semibold opacity-70">Role terpisah</div>
                            <div class="font-medium text-sm mt-0.5">Admin & Petugas</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-brand-yellow">
                            <i class="bi bi-lightning-charge text-xl"></i>
                        </div>
                        <div>
                            <div class="text-xs text-brand-purple-200 uppercase tracking-wider font-semibold opacity-70">Alur cepat</div>
                            <div class="font-medium text-sm mt-0.5">Input, verifikasi, ranking</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-brand-yellow">
                            <i class="bi bi-graph-up-arrow text-xl"></i>
                        </div>
                        <div>
                            <div class="text-xs text-brand-purple-200 uppercase tracking-wider font-semibold opacity-70">Pemantauan</div>
                            <div class="font-medium text-sm mt-0.5">Status verifikasi realtime</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-brand-yellow">
                            <i class="bi bi-person-badge text-xl"></i>
                        </div>
                        <div>
                            <div class="text-xs text-brand-purple-200 uppercase tracking-wider font-semibold opacity-70">Akses akun</div>
                            <div class="font-medium text-sm mt-0.5">Reset & permohonan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side: Form Panel -->
        <div class="w-full lg:w-7/12 flex flex-col justify-center items-center p-6 sm:p-12">
            <div class="w-full max-w-md">
                <!-- Mobile Logo (hidden on desktop) -->
                <div class="lg:hidden flex items-center justify-center gap-2 mb-10">
                    <span class="w-10 h-10 rounded-md bg-brand-yellow text-brand-purple flex items-center justify-center font-black text-xl">P</span>
                    <span class="font-bold text-2xl tracking-widest text-brand-purple uppercase">PUPR MOORA</span>
                </div>
                
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 sm:p-10">
                    @yield('guest-content')
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>