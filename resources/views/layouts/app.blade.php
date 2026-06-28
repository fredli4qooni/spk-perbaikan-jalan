<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'PUPR MOORA' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body class="app-shell">
<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid d-flex align-items-center">
        @auth
            <div class="d-flex align-items-center me-3 nav-profile">
                <div class="avatar rounded-circle bg-white d-flex align-items-center justify-content-center overflow-hidden" style="width:40px;height:40px;border:2px solid rgba(255,255,255,0.15)">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="Foto profil" class="w-100 h-100 object-fit-cover">
                </div>
                <div class="ms-2 d-none d-md-block">
                    <div class="fw-bold small mb-0 text-white">{{ auth()->user()->name }}</div>
                    <div class="text-white-50 small">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
            </div>

            @if (request()->routeIs('dashboard'))
                <div class="me-2 d-md-none">
                    <button class="btn menu-btn text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#appMenu" aria-controls="appMenu" aria-label="Buka menu">
                        <i class="bi bi-three-dots-vertical" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
        @endauth

        @auth
            <a class="navbar-brand ms-auto ms-md-0" href="{{ route('dashboard') }}">PUPR MOORA</a>
        @else
            <a class="navbar-brand ms-auto" href="{{ route('dashboard') }}">PUPR MOORA</a>
        @endauth
    </div>
</nav>

@auth
    @if (request()->routeIs('dashboard'))
        <aside class="app-sidebar bg-light border-end d-none d-md-flex">
            <div class="app-sidebar-scroll">
                <nav class="app-sidebar-nav nav flex-column">
                    <div class="nav-item d-flex align-items-center">
                        <a class="nav-link flex-grow-1" href="{{ route('profile.edit') }}"><i class="bi bi-person-gear"></i> <span>Kelola Profil</span></a>
                    </div>
                    @if (auth()->user()->role === 'petugas')
                        <div class="nav-item d-flex align-items-center">
                            <a class="nav-link flex-grow-1" href="{{ route('roads.index') }}"><i class="bi bi-geo-alt"></i> <span>Input Ruas Jalan</span></a>
                        </div>
                        <div class="nav-item d-flex align-items-center">
                            <a class="nav-link flex-grow-1" href="{{ route('scores.index') }}"><i class="bi bi-card-checklist"></i> <span>Nilai Alternatif</span></a>
                        </div>
                    @else
                        <div class="nav-item d-flex align-items-center">
                            <a class="nav-link flex-grow-1" href="{{ route('roads.index') }}"><i class="bi bi-clipboard-check"></i> <span>Verifikasi Ruas Jalan</span></a>
                        </div>
                        <div class="nav-item d-flex align-items-center">
                            <a class="nav-link flex-grow-1" href="{{ route('users.index') }}"><i class="bi bi-people"></i> <span>Daftar User</span></a>
                        </div>
                        <div class="nav-item d-flex align-items-center">
                            <a class="nav-link flex-grow-1" href="{{ route('account-requests.index') }}"><i class="bi bi-shield-check"></i> <span>Verifikasi Petugas</span></a>
                        </div>
                    @endif
                    <div class="nav-item d-flex align-items-center">
                        <a class="nav-link flex-grow-1" href="{{ route('criteria.index') }}"><i class="bi bi-list-check"></i> <span>Data Kriteria</span></a>
                    </div>
                    <div class="nav-item d-flex align-items-center">
                        <a class="nav-link flex-grow-1" href="{{ route('moora.index') }}"><i class="bi bi-graph-up"></i> <span>Hasil MOORA</span></a>
                    </div>
                    <div class="nav-item d-flex align-items-center">
                        <a class="nav-link flex-grow-1" href="{{ route('reports.index') }}"><i class="bi bi-file-earmark-text"></i> <span>Laporan</span></a>
                    </div>
                </nav>
            </div>
            <div class="app-sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="nav-link nav-link-muted w-100 text-start border-0 bg-transparent">
                        <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>
        <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="appMenu" aria-labelledby="appMenuLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="appMenuLabel">Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Tutup"></button>
            </div>
            <div class="offcanvas-body p-0 d-flex flex-column">
                <nav class="nav flex-column flex-grow-1 overflow-auto">
                    <div class="nav-item d-flex align-items-center">
                        <a class="nav-link flex-grow-1" href="{{ route('profile.edit') }}"><i class="bi bi-person-gear"></i> Kelola Profil</a>
                        <a href="{{ route('dashboard') }}" class="back-link ms-2" title="Kembali ke Dashboard"><i class="bi bi-arrow-left-short"></i></a>
                    </div>
                    @if (auth()->user()->role === 'petugas')
                        <div class="nav-item d-flex align-items-center">
                            <a class="nav-link flex-grow-1" href="{{ route('roads.index') }}"><i class="bi bi-geo-alt"></i> Input Ruas Jalan</a>
                            <a href="{{ route('dashboard') }}" class="back-link ms-2" title="Kembali ke Dashboard"><i class="bi bi-arrow-left-short"></i></a>
                        </div>
                        <div class="nav-item d-flex align-items-center">
                            <a class="nav-link flex-grow-1" href="{{ route('scores.index') }}"><i class="bi bi-card-checklist"></i> Nilai Alternatif</a>
                            <a href="{{ route('dashboard') }}" class="back-link ms-2" title="Kembali ke Dashboard"><i class="bi bi-arrow-left-short"></i></a>
                        </div>
                    @else
                        <div class="nav-item d-flex align-items-center">
                            <a class="nav-link flex-grow-1" href="{{ route('roads.index') }}"><i class="bi bi-clipboard-check"></i> Verifikasi Ruas Jalan</a>
                            <a href="{{ route('dashboard') }}" class="back-link ms-2" title="Kembali ke Dashboard"><i class="bi bi-arrow-left-short"></i></a>
                        </div>
                        <div class="nav-item d-flex align-items-center">
                            <a class="nav-link flex-grow-1" href="{{ route('users.index') }}"><i class="bi bi-people"></i> Daftar User</a>
                            <a href="{{ route('dashboard') }}" class="back-link ms-2" title="Kembali ke Dashboard"><i class="bi bi-arrow-left-short"></i></a>
                        </div>
                        <div class="nav-item d-flex align-items-center">
                            <a class="nav-link flex-grow-1" href="{{ route('account-requests.index') }}"><i class="bi bi-shield-check"></i> Verifikasi Petugas</a>
                            <a href="{{ route('dashboard') }}" class="back-link ms-2" title="Kembali ke Dashboard"><i class="bi bi-arrow-left-short"></i></a>
                        </div>
                    @endif
                    <div class="nav-item d-flex align-items-center">
                        <a class="nav-link flex-grow-1" href="{{ route('criteria.index') }}"><i class="bi bi-list-check"></i> Data Kriteria</a>
                        <a href="{{ route('dashboard') }}" class="back-link ms-2" title="Kembali ke Dashboard"><i class="bi bi-arrow-left-short"></i></a>
                    </div>
                    <div class="nav-item d-flex align-items-center">
                        <a class="nav-link flex-grow-1" href="{{ route('moora.index') }}"><i class="bi bi-graph-up"></i> Hasil MOORA</a>
                        <a href="{{ route('dashboard') }}" class="back-link ms-2" title="Kembali ke Dashboard"><i class="bi bi-arrow-left-short"></i></a>
                    </div>
                    <div class="nav-item d-flex align-items-center">
                        <a class="nav-link flex-grow-1" href="{{ route('reports.index') }}"><i class="bi bi-file-earmark-text"></i> Laporan</a>
                        <a href="{{ route('dashboard') }}" class="back-link ms-2" title="Kembali ke Dashboard"><i class="bi bi-arrow-left-short"></i></a>
                    </div>
                </nav>
                <div class="user-block mt-auto">
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="nav-link nav-link-muted w-100 text-start border-0 bg-transparent">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endauth

@auth
    <main class="app-main container py-4">
@else
    <main class="container py-4">
@endauth
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali input.</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @unless (request()->routeIs('dashboard'))
        <div class="page-back mb-3">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    @endunless

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
