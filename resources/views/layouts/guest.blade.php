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
</head>
<body class="guest-page">
    <main class="guest-layout">
        <section class="guest-hero">
            <div class="guest-brand">PUPR MOORA</div>
            <h1 class="guest-title">@yield('guest-title', 'Prioritas perbaikan jalan yang lebih cepat, rapi, dan terukur.') </h1>
            <p class="guest-description">@yield('guest-description', 'Kelola data ruas jalan, verifikasi perbaikan, dan susun prioritas menggunakan perhitungan MOORA dengan alur kerja yang jelas untuk admin dan petugas.') </p>

            <div class="guest-features">
                <div class="guest-feature">
                    <i class="bi bi-shield-check"></i>
                    <div>
                        <span>Role terpisah</span>
                        <strong>Admin & Petugas</strong>
                    </div>
                </div>
                <div class="guest-feature">
                    <i class="bi bi-lightning-charge"></i>
                    <div>
                        <span>Alur cepat</span>
                        <strong>Input, verifikasi, ranking</strong>
                    </div>
                </div>
                <div class="guest-feature">
                    <i class="bi bi-graph-up-arrow"></i>
                    <div>
                        <span>Pemantauan</span>
                        <strong>Status verifikasi realtime</strong>
                    </div>
                </div>
                <div class="guest-feature">
                    <i class="bi bi-person-badge"></i>
                    <div>
                        <span>Akses akun</span>
                        <strong>Reset & permohonan akun</strong>
                    </div>
                </div>
            </div>
        </section>

        <section class="guest-panel">
            <div class="guest-panel-card">
                @yield('guest-content')
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>