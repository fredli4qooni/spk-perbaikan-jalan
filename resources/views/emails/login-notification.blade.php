<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Masuk Akun</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 580px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #582c7d;
            padding: 24px 32px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .content {
            padding: 32px;
        }
        .greeting {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 16px;
        }
        .message {
            font-size: 14px;
            line-height: 1.6;
            color: #475569;
            margin-bottom: 24px;
        }
        .alert-box {
            background-color: #f8fafc;
            border-left: 4px solid #582c7d;
            padding: 16px;
            border-radius: 6px;
            margin-bottom: 24px;
            border-top: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }
        .alert-item {
            font-size: 13px;
            margin-bottom: 8px;
            color: #334155;
        }
        .alert-item:last-child {
            margin-bottom: 0;
        }
        .alert-item strong {
            color: #0f172a;
        }
        .security-notice {
            font-size: 12px;
            color: #64748b;
            background-color: #f1f5f9;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 24px;
            line-height: 1.5;
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px 32px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SPK PERBAIKAN JALAN (PUPR)</h1>
        </div>
        <div class="content">
            <div class="greeting">Halo, {{ $user->name }}</div>
            <div class="message">
                Akun Anda baru saja berhasil masuk (login) ke dalam sistem <strong>SPK Perbaikan Jalan (Metode MOORA)</strong>.
            </div>

            <div class="alert-box">
                <div class="alert-item"><strong>Akun Email:</strong> {{ $user->email }}</div>
                <div class="alert-item"><strong>Waktu Masuk:</strong> {{ now()->translatedFormat('d F Y, H:i:s') }} WIB</div>
                @if ($ipAddress)
                    <div class="alert-item"><strong>Alamat IP:</strong> {{ $ipAddress }}</div>
                @endif
                <div class="alert-item"><strong>Peran / Role:</strong> {{ ucfirst($user->role) }}</div>
            </div>

            <div class="security-notice">
                <strong>Catatan Keamanan:</strong> Jika ini adalah aktivitas Anda, Anda dapat mengabaikan email ini. Apabila Anda tidak merasa melakukan aktivitas masuk ini, segera lakukan reset kata sandi melalui menu Lupa Password di halaman masuk atau hubungi Administrator.
            </div>

            <div class="message" style="margin-bottom: 0; font-size: 13px;">
                Selamat bekerja dan selamat memperbarui data infrastruktur jalan.
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Dinas PUPR - Sistem Pendukung Keputusan Prioritas Perbaikan Jalan.
        </div>
    </div>
</body>
</html>
