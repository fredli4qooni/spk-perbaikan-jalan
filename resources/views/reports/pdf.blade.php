<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Prioritas Perbaikan Jalan Metode MOORA</title>
    <style>
        @page {
            margin: 1.2cm 1.2cm 1.5cm 1.2cm;
            size: A4 landscape;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            line-height: 1.35;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat */
        .kop-table {
            width: 100%;
            border-bottom: 3px double #0f172a;
            padding-bottom: 8px;
            margin-bottom: 14px;
        }

        .kop-table td {
            vertical-align: middle;
        }

        .kop-logo {
            width: 75px;
            text-align: center;
        }

        .kop-logo img {
            max-width: 68px;
            max-height: 68px;
        }

        .kop-text {
            text-align: center;
            padding-right: 75px;
        }

        .kop-text h3 {
            margin: 0;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: #334155;
            text-transform: uppercase;
        }

        .kop-text h2 {
            margin: 2px 0;
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .kop-text p {
            margin: 1px 0;
            font-size: 10px;
            color: #475569;
        }

        /* Judul Laporan */
        .report-title-box {
            text-align: center;
            margin-bottom: 14px;
        }

        .report-title-box h1 {
            margin: 0;
            font-size: 14px;
            font-weight: 800;
            color: #1e1b4b;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .report-title-box p {
            margin: 3px 0 0 0;
            font-size: 10px;
            color: #64748b;
        }

        /* Box Informasi Ringkas */
        .info-strip {
            width: 100%;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 6px 10px;
            margin-bottom: 12px;
            font-size: 10px;
        }

        .info-strip td {
            vertical-align: middle;
        }

        /* Tabel Data MOORA */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 10px;
        }

        table.data-table th {
            background-color: #312e81;
            color: #ffffff;
            font-weight: 700;
            text-align: center;
            padding: 7px 5px;
            border: 1px solid #1e1b4b;
            font-size: 9.5px;
            text-transform: uppercase;
        }

        table.data-table td {
            padding: 6px 6px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
        }

        table.data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .badge-rank {
            display: inline-block;
            width: 22px;
            height: 22px;
            line-height: 22px;
            text-align: center;
            border-radius: 50%;
            font-weight: 800;
            font-size: 10px;
        }

        .rank-1 { background-color: #fbbf24; color: #78350f; font-size: 11px; }
        .rank-2 { background-color: #e2e8f0; color: #1e293b; }
        .rank-3 { background-color: #fde68a; color: #92400e; }
        .rank-other { background-color: #f1f5f9; color: #475569; }

        .badge-priority {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 9px;
            text-align: center;
        }

        .prio-tinggi { background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .prio-sedang { background-color: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
        .prio-rendah { background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; }

        /* Thumbnails di tabel */
        .photo-thumb-cell {
            text-align: center;
            white-space: nowrap;
        }

        .photo-thumb {
            width: 48px;
            height: 38px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #cbd5e1;
            margin: 0 1px;
            display: inline-block;
        }

        /* Lampiran Dokumentasi Foto */
        .page-break {
            page-break-before: always;
        }

        .section-header {
            font-size: 12px;
            font-weight: 800;
            color: #1e1b4b;
            border-bottom: 2px solid #312e81;
            padding-bottom: 4px;
            margin-bottom: 10px;
            margin-top: 6px;
            text-transform: uppercase;
        }

        .photo-card {
            width: 100%;
            border: 1px solid #cbd5e1;
            background-color: #ffffff;
            border-radius: 6px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .photo-card-header {
            background-color: #f1f5f9;
            padding: 5px 10px;
            border-bottom: 1px solid #cbd5e1;
            font-size: 10.5px;
            font-weight: 700;
            color: #0f172a;
        }

        .photo-card-body {
            padding: 8px 10px;
        }

        .gallery-img {
            width: 180px;
            height: 120px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #94a3b8;
            margin-right: 8px;
            display: inline-block;
        }

        /* Tanda Tangan */
        .signature-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 10px;
        }

        .signature-space {
            height: 55px;
        }

        .signature-name {
            font-weight: 700;
            text-decoration: underline;
            color: #0f172a;
        }

        .footer-note {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            font-size: 8.5px;
            color: #94a3b8;
            text-align: right;
            border-top: 1px solid #e2e8f0;
            padding-top: 3px;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT RESMI DINAS PUPR KOTA BANDAR LAMPUNG -->
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                @if (!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" alt="Logo PUPR">
                @endif
            </td>
            <td class="kop-text">
                <h3>PEMERINTAH KOTA BANDAR LAMPUNG</h3>
                <h2>DINAS PEKERJAAN UMUM DAN PENATAAN RUANG</h2>
                <p>Jl. Pulau Sebesi No. 67, Sukarame, Kota Bandar Lampung, Lampung 35131</p>
                <p>Telepon: (0721) 703445 | Laman: pupr.bandarlampungkota.go.id | Email: pupr@bandarlampungkota.go.id</p>
            </td>
        </tr>
    </table>

    <!-- JUDUL LAPORAN -->
    <div class="report-title-box">
        <h1>Laporan Rekapitulasi Hasil Prioritas Penanganan Jalan</h1>
        <p>Sistem Pendukung Keputusan Penentuan Prioritas Perbaikan Jalan Menggunakan Metode MOORA (Multi-Objective Optimization on the Basis of Ratio Analysis)</p>
    </div>

    <!-- STRIP INFORMASI LAPORAN -->
    <table class="info-strip">
        <tr>
            <td style="width: 25%;"><strong>Waktu Cetak:</strong> {{ $generatedAt }} WIB</td>
            <td style="width: 25%;"><strong>Jumlah Ruas:</strong> {{ $totalRoads }} Ruas Jalan Terdata</td>
            <td style="width: 50%; text-align: right;"><strong>Status Metode:</strong> MOORA Resmi (Vektor Pembagi Sesuai Skripsi)</td>
        </tr>
    </table>

    <!-- TABEL HASIL PERANGKINGAN PRIORITAS JALAN -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 26%; text-align: left;">Lokasi Ruas Jalan</th>
                <th style="width: 16%;">Wilayah</th>
                <th style="width: 7.5%;">C1 (Pjg)</th>
                <th style="width: 7.5%;">C2 (Lbr)</th>
                <th style="width: 7.5%;">C3 (Kdlm)</th>
                <th style="width: 7.5%;">C4 (Lbg)</th>
                <th style="width: 8%;">C5 (Kptg)</th>
                <th style="width: 8%;">Nilai Yi</th>
                <th style="width: 8%;">Prioritas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $row)
                @php
                    $road = $row['road'];
                    $rank = $row['rank'];
                    $yi = $row['result'];

                    // Prioritas label
                    if ($rank === 1) {
                        $prioClass = 'prio-tinggi';
                        $prioLabel = 'Tertinggi';
                    } elseif ($rank <= 3) {
                        $prioClass = 'prio-tinggi';
                        $prioLabel = 'Tinggi';
                    } elseif ($rank <= 4) {
                        $prioClass = 'prio-sedang';
                        $prioLabel = 'Sedang';
                    } else {
                        $prioClass = 'prio-rendah';
                        $prioLabel = 'Rendah';
                    }

                    $rankClass = $rank === 1 ? 'rank-1' : ($rank === 2 ? 'rank-2' : ($rank === 3 ? 'rank-3' : 'rank-other'));
                @endphp
                <tr>
                    <td style="text-align: center;">
                        <span class="badge-rank {{ $rankClass }}">{{ $rank }}</span>
                    </td>
                    <td>
                        <strong>{{ $road->location }}</strong>
                        <div style="font-size: 8.5px; color: #64748b; margin-top: 1px;">
                            Survei Tahun {{ $road->survey_year }}
                            @if ($road->latitude && $road->longitude)
                                &bull; ({{ number_format($road->latitude, 4) }}, {{ number_format($road->longitude, 4) }})
                            @endif
                        </div>
                    </td>
                    <td>
                        <div>Kec. {{ str_replace('Kecamatan ', '', $road->kecamatan) }}</div>
                        <div style="font-size: 8.5px; color: #64748b;">Kel. {{ str_replace('Kelurahan ', '', $road->kelurahan) }}</div>
                    </td>
                    <td style="text-align: center;">{{ $road->c1_label }}</td>
                    <td style="text-align: center;">{{ $road->c2_label }}</td>
                    <td style="text-align: center;">{{ $road->c3_label }}</td>
                    <td style="text-align: center;">{{ $road->c4_label }}</td>
                    <td style="text-align: center;">{{ $road->c5_label }}</td>
                    <td style="text-align: center; font-family: monospace; font-weight: bold; color: #1e1b4b; font-size: 10.5px;">
                        {{ number_format($yi, 4) }}
                    </td>
                    <td style="text-align: center;">
                        <span class="badge-priority {{ $prioClass }}">
                            {{ $prioLabel }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- BOBOT KRITERIA SUMMARY -->
    <div style="margin-top: 4px; font-size: 9px; color: #475569; background: #f8fafc; padding: 5px 8px; border-radius: 4px; border: 1px solid #e2e8f0;">
        <strong>Keterangan Bobot Kriteria MOORA:</strong>
        @foreach ($criteria as $c)
            {{ $c->code }} ({{ $c->name }}): <strong>{{ ($weights[$c->id] ?? 0) * 100 }}% [{{ strtoupper($c->type) }}]</strong>
            @if (!$loop->last) &bull; @endif
        @endforeach
    </div>

    <!-- TANDA TANGAN / PENGESAHAN LAPORAN -->
    <table class="signature-table">
        <tr>
            <td>
                Mengetahui,<br>
                <strong>Kepala Dinas Pekerjaan Umum dan Penataan Ruang</strong><br>
                Kota Bandar Lampung
                <div class="signature-space"></div>
                <div class="signature-name">Ir. H. IWAN GUNAWAN, M.T.</div>
                <div>NIP. 19680512 199403 1 005</div>
            </td>
            <td>
                Bandar Lampung, {{ now()->translatedFormat('d F Y') }}<br>
                <strong>Petugas Survei / Analis Sistem SPK</strong><br>
                Dinas PUPR Kota Bandar Lampung
                <div class="signature-space"></div>
                <div class="signature-name">TIM SURVEI INFRASTRUKTUR JALAN</div>
                <div>Bidang Bina Marga</div>
            </td>
        </tr>
    </table>

    <!-- HALAMAN 2: LAMPIRAN DOKUMENTASI FOTO KERUSAKAN JALAN -->
    <div class="page-break"></div>

    <table class="kop-table" style="margin-bottom: 8px;">
        <tr>
            <td class="kop-logo">
                @if (!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" alt="Logo PUPR">
                @endif
            </td>
            <td class="kop-text">
                <h3>LAMPIRAN DOKUMENTASI FOTO HASIL SURVEI LAPANGAN</h3>
                <h2>DINAS PEKERJAAN UMUM DAN PENATAAN RUANG KOTA BANDAR LAMPUNG</h2>
                <p>Dokumentasi Visual Kerusakan Ruas Jalan sebagai Bukti Fisik Prioritas Penanganan</p>
            </td>
        </tr>
    </table>

    <div class="section-header">
        Dokumentasi Visual Kerusakan Tiap Ruas Jalan (Wajib Ada Foto)
    </div>

    @foreach ($results as $row)
        @php
            $road = $row['road'];
            $rank = $row['rank'];
            $photos = $row['photos_base64'] ?? [];
        @endphp
        <div class="photo-card">
            <div class="photo-card-header">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td style="width: 70%;">
                            <span style="background: #312e81; color: #ffffff; padding: 2px 6px; border-radius: 4px; font-size: 9px; margin-right: 6px;">
                                PERINGKAT #{{ $rank }}
                            </span>
                            <strong>{{ $road->location }}</strong>
                            <span style="font-weight: normal; color: #475569; font-size: 9.5px;">
                                (Kec. {{ str_replace('Kecamatan ', '', $road->kecamatan) }}, Kel. {{ str_replace('Kelurahan ', '', $road->kelurahan) }})
                            </span>
                        </td>
                        <td style="width: 30%; text-align: right; font-size: 9.5px; color: #312e81;">
                            <strong>Nilai MOORA: {{ number_format($row['result'], 4) }}</strong> &bull; Total Foto: {{ count($photos) }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="photo-card-body">
                @if (!empty($photos) && count($photos) > 0)
                    <div style="margin-bottom: 4px;">
                        @foreach ($photos as $idx => $p)
                            <img src="{{ $p }}" class="gallery-img" alt="Foto {{ $idx + 1 }}">
                        @endforeach
                    </div>
                @else
                    <div style="padding: 10px; color: #94a3b8; font-style: italic;">
                        Tidak ada foto dokumentasi terlampir.
                    </div>
                @endif
                <div style="font-size: 9px; color: #475569; margin-top: 4px;">
                    <strong>Spesifikasi Kerusakan:</strong>
                    Panjang: {{ $road->c1_label }} &bull;
                    Lebar: {{ $road->c2_label }} &bull;
                    Kedalaman: {{ $road->c3_label }} &bull;
                    Jumlah Lubang: {{ $road->c4_label }} &bull;
                    Kepentingan: {{ $road->c5_label }}
                </div>
            </div>
        </div>
    @endforeach

    <div class="footer-note">
        Dokumen ini dibuat otomatis oleh Sistem Pendukung Keputusan MOORA Dinas PUPR Kota Bandar Lampung | Halaman dicetak pada {{ $generatedAt }}
    </div>

</body>
</html>
