<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Keamanan Akun</title>
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
            background-color: #f1f5f9;
            border-left: 4px solid #582c7d;
            padding: 16px;
            border-radius: 6px;
            margin-bottom: 24px;
        }
        .alert-item {
            font-size: 13px;
            margin-bottom: 6px;
            color: #334155;
        }
        .alert-item strong {
            color: #0f172a;
        }
        .warning-text {
            font-size: 13px;
            color: #b91c1c;
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 24px;
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
                Kami memberitahukan bahwa kata sandi untuk akun Anda pada sistem <strong>SPK Perbaikan Jalan (Metode MOORA)</strong> telah berhasil diperbarui.
            </div>

            <div class="alert-box">
                <div class="alert-item"><strong>Akun Email:</strong> {{ $user->email }}</div>
                <div class="alert-item"><strong>Waktu Perubahan:</strong> {{ now()->translatedFormat('d F Y, H:i:s') }} WIB</div>
                <div class="alert-item"><strong>Metode:</strong> {{ $changeType }}</div>
                @if ($ipAddress)
                    <div class="alert-item"><strong>Alamat IP:</strong> {{ $ipAddress }}</div>
                @endif
            </div>

            <div class="warning-text">
                <strong>Penting:</strong> Jika Anda tidak merasa melakukan perubahan kata sandi ini, segera hubungi Administrator sistem untuk mengamankan akun Anda.
            </div>

            <div class="message" style="margin-bottom: 0;">
                Terima kasih atas dedikasi dan kerja sama Anda dalam pemutakhiran data infrastruktur jalan.
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Dinas PUPR - Sistem Pendukung Keputusan Prioritas Perbaikan Jalan.
        </div>
    </div>
</body>
</html>
