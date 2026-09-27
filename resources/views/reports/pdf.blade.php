<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Prioritas Perbaikan Jalan Metode MOORA - Dinas PUPR Kota Bandar Lampung</title>
    <style>
        @page {
            margin: 1.0cm 1.2cm 1.2cm 1.2cm;
            size: A4 landscape;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            line-height: 1.35;
            font-size: 10.5px;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat Halaman 1 */
        .kop-table {
            width: 100%;
            border-bottom: 3px double #0f172a;
            padding-bottom: 6px;
            margin-bottom: 12px;
            border-collapse: collapse;
        }

        .kop-table td {
            vertical-align: middle;
        }

        .kop-logo {
            width: 70px;
            text-align: center;
        }

        .kop-logo img {
            max-width: 62px;
            max-height: 62px;
        }

        .kop-text {
            text-align: center;
            padding-right: 70px;
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
            font-size: 9.5px;
            color: #475569;
        }

        /* Judul Laporan */
        .report-title-box {
            text-align: center;
            margin-bottom: 10px;
        }

        .report-title-box h1 {
            margin: 0;
            font-size: 13.5px;
            font-weight: 800;
            color: #1e1b4b;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .report-title-box p {
            margin: 2px 0 0 0;
            font-size: 9.5px;
            color: #64748b;
        }

        /* Box Informasi Ringkas */
        .info-strip {
            width: 100%;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            padding: 5px 8px;
            margin-bottom: 10px;
            font-size: 9.5px;
            border-collapse: collapse;
        }

        .info-strip td {
            vertical-align: middle;
            padding: 2px 4px;
        }

        /* Tabel Data MOORA */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 9.5px;
        }

        table.data-table th {
            background-color: #312e81;
            color: #ffffff;
            font-weight: 700;
            text-align: center;
            padding: 6px 4px;
            border: 1px solid #1e1b4b;
            font-size: 9px;
            text-transform: uppercase;
        }

        table.data-table td {
            padding: 5px 6px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
        }

        table.data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .badge-rank {
            display: inline-block;
            width: 20px;
            height: 20px;
            line-height: 20px;
            text-align: center;
            border-radius: 50%;
            font-weight: 800;
            font-size: 9.5px;
        }

        .rank-1 { background-color: #fbbf24; color: #78350f; font-size: 10.5px; }
        .rank-2 { background-color: #e2e8f0; color: #1e293b; }
        .rank-3 { background-color: #fde68a; color: #92400e; }
        .rank-other { background-color: #f1f5f9; color: #475569; }

        .badge-priority {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 8.5px;
            text-align: center;
        }

        .prio-tinggi { background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .prio-sedang { background-color: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
        .prio-rendah { background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; }

        /* Tanda Tangan */
        .signature-table {
            width: 100%;
            margin-top: 14px;
            border-collapse: collapse;
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 9.5px;
        }

        .signature-space {
            height: 48px;
        }

        .signature-name {
            font-weight: 700;
            text-decoration: underline;
            color: #0f172a;
        }

        /* Lampiran Dokumentasi Foto */
        .page-break {
            page-break-before: always;
        }

        .photo-card {
            width: 100%;
            border: 1px solid #cbd5e1;
            background-color: #ffffff;
            border-radius: 5px;
            margin-bottom: 12px;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }

        .photo-card-header {
            background-color: #f1f5f9;
            padding: 5px 8px;
            border-bottom: 1px solid #cbd5e1;
        }

        .badge-rank-pill {
            background-color: #312e81;
            color: #ffffff;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8.5px;
            font-weight: bold;
            text-align: center;
            display: block;
            letter-spacing: 0.3px;
        }

        .photo-card-body {
            padding: 8px 10px;
        }

        .photo-frame {
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 2px;
            background-color: #f8fafc;
            display: inline-block;
            text-align: center;
        }

        .gallery-img {
            width: 180px;
            height: 115px;
            display: block;
            border-radius: 3px;
        }

        .photo-caption {
            font-size: 8px;
            color: #64748b;
            text-align: center;
            margin-top: 3px;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <!-- ============================================================== -->
    <!-- HALAMAN 1: KOP SURAT, REKAPITULASI MOORA, PENGESAHAN           -->
    <!-- ============================================================== -->

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
        <p>Sistem Pendukung Keputusan Penentuan Prioritas Perbaikan Jalan Menggunakan Metode MOORA</p>
    </div>

    <!-- STRIP INFORMASI LAPORAN -->
    <table class="info-strip">
        <tr>
            <td style="width: 28%;"><strong>Waktu Cetak:</strong> {{ $generatedAt }} WIB</td>
            <td style="width: 25%;"><strong>Jumlah Ruas:</strong> {{ $totalRoads }} Ruas Terdata</td>
            <td style="width: 47%; text-align: right;"><strong>Metode:</strong> MOORA Resmi (Normalisasi Vektor)</td>
        </tr>
    </table>

    <!-- TABEL HASIL PERANGKINGAN PRIORITAS JALAN -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 28%; text-align: left;">Lokasi Ruas Jalan</th>
                <th style="width: 17%;">Wilayah</th>
                <th style="width: 7%;">C1 (Pjg)</th>
                <th style="width: 7%;">C2 (Lbr)</th>
                <th style="width: 7%;">C3 (Kdlm)</th>
                <th style="width: 7%;">C4 (Lbg)</th>
                <th style="width: 7%;">C5 (Kptg)</th>
                <th style="width: 7.5%;">Nilai Yi</th>
                <th style="width: 7.5%;">Prioritas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $row)
                @php
                    $road = $row['road'];
                    $rank = $row['rank'];
                    $yi = $row['result'];

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
                        <div style="font-size: 8px; color: #64748b; margin-top: 1px;">
                            Survei Tahun {{ $road->survey_year }}
                            @if ($road->latitude && $road->longitude)
                                &bull; ({{ number_format($road->latitude, 4) }}, {{ number_format($road->longitude, 4) }})
                            @endif
                        </div>
                    </td>
                    <td>
                        <div>Kec. {{ str_replace('Kecamatan ', '', $road->kecamatan) }}</div>
                        <div style="font-size: 8px; color: #64748b;">Kel. {{ str_replace('Kelurahan ', '', $road->kelurahan) }}</div>
                    </td>
                    <td style="text-align: center;">{{ $road->c1_label }}</td>
                    <td style="text-align: center;">{{ $road->c2_label }}</td>
                    <td style="text-align: center;">{{ $road->c3_label }}</td>
                    <td style="text-align: center;">{{ $road->c4_label }}</td>
                    <td style="text-align: center;">{{ $road->c5_label }}</td>
                    <td style="text-align: center; font-family: monospace; font-weight: bold; color: #1e1b4b; font-size: 10px;">
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
    <div style="font-size: 8.5px; color: #475569; background: #f8fafc; padding: 4px 8px; border-radius: 4px; border: 1px solid #e2e8f0;">
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


    <!-- ============================================================== -->
    <!-- HALAMAN 2: LAMPIRAN DOKUMENTASI FOTO KERUSAKAN JALAN           -->
    <!-- ============================================================== -->
    <div class="page-break"></div>

    <!-- HEADER LAMPIRAN RESMI RINGKAS (HEMAT RUANG) -->
    <table style="width: 100%; border-bottom: 2px solid #1e1b4b; padding-bottom: 6px; margin-bottom: 12px; border-collapse: collapse;">
        <tr>
            <td style="width: 44px; vertical-align: middle; padding: 0;">
                @if (!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" style="max-width: 38px; max-height: 38px;" alt="Logo PUPR">
                @endif
            </td>
            <td style="vertical-align: middle; padding-left: 8px;">
                <div style="font-size: 11.5px; font-weight: 800; color: #1e1b4b; text-transform: uppercase; letter-spacing: 0.3px;">
                    LAMPIRAN DOKUMENTASI FOTO KERUSAKAN JALAN HASIL SURVEI LAPANGAN
                </div>
                <div style="font-size: 9px; color: #475569; margin-top: 1px;">
                    Dinas Pekerjaan Umum dan Penataan Ruang Kota Bandar Lampung &bull; Bukti Fisik Prioritas Penanganan MOORA
                </div>
            </td>
            <td style="width: 170px; text-align: right; vertical-align: middle; font-size: 8.5px; color: #64748b; padding: 0;">
                <strong>Lampiran Dokumen Resmi</strong><br>
                Waktu Cetak: {{ $generatedAt }}
            </td>
        </tr>
    </table>

    @foreach ($results as $row)
        @php
            $road = $row['road'];
            $rank = $row['rank'];
            $photos = $row['photos_base64'] ?? [];
        @endphp
        <div class="photo-card">
            <!-- Header Kartu: Tabel Rapi, Tidak Pernah Bertumpuk -->
            <div class="photo-card-header">
                <table style="width: 100%; border-collapse: collapse; border: none;">
                    <tr>
                        <td style="width: 95px; vertical-align: middle; padding: 0;">
                            <div class="badge-rank-pill">
                                PERINGKAT #{{ $rank }}
                            </div>
                        </td>
                        <td style="vertical-align: middle; padding-left: 8px;">
                            <strong style="font-size: 10.5px; color: #0f172a;">{{ $road->location }}</strong>
                            <span style="font-weight: normal; color: #64748b; font-size: 9px;">
                                (Kec. {{ str_replace('Kecamatan ', '', $road->kecamatan) }}, Kel. {{ str_replace('Kelurahan ', '', $road->kelurahan) }})
                            </span>
                        </td>
                        <td style="width: 200px; text-align: right; vertical-align: middle; font-size: 9px; color: #312e81; padding: 0;">
                            <strong>Nilai MOORA: {{ number_format($row['result'], 4) }}</strong> &bull; Total Foto: {{ count($photos) }}
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Body Kartu: Grid Foto Berdampingan & Spesifikasi -->
            <div class="photo-card-body">
                @if (!empty($photos) && count($photos) > 0)
                    <table style="border: none; border-collapse: collapse; margin-bottom: 6px;">
                        <tr>
                            @foreach ($photos as $idx => $p)
                                <td style="padding: 0 10px 0 0; vertical-align: top; border: none;">
                                    <div class="photo-frame">
                                        <img src="{{ $p }}" class="gallery-img" alt="Foto {{ $idx + 1 }}">
                                    </div>
                                    <div class="photo-caption">
                                        Dokumentasi #{{ $idx + 1 }}
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    </table>
                @else
                    <div style="padding: 10px; color: #94a3b8; font-style: italic; font-size: 9px;">
                        Tidak ada foto dokumentasi terlampir.
                    </div>
                @endif

                <!-- Strip Matriks Spesifikasi Kerusakan 5 Kriteria (Kotak-Kotak Rapi) -->
                <table style="width: 100%; border-collapse: collapse; border: none; font-size: 8px; margin-top: 2px;">
                    <tr>
                        <td style="width: 20%; padding: 3px 5px; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 3px;">
                            <span style="color: #64748b; font-size: 7.5px; display: block;">C1 - Panjang:</span>
                            <strong style="color: #0f172a;">{{ $road->c1_label }}</strong>
                        </td>
                        <td style="width: 1%; border: none;"></td>
                        <td style="width: 20%; padding: 3px 5px; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 3px;">
                            <span style="color: #64748b; font-size: 7.5px; display: block;">C2 - Lebar Jalan:</span>
                            <strong style="color: #0f172a;">{{ $road->c2_label }}</strong>
                        </td>
                        <td style="width: 1%; border: none;"></td>
                        <td style="width: 20%; padding: 3px 5px; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 3px;">
                            <span style="color: #64748b; font-size: 7.5px; display: block;">C3 - Kedalaman:</span>
                            <strong style="color: #0f172a;">{{ $road->c3_label }}</strong>
                        </td>
                        <td style="width: 1%; border: none;"></td>
                        <td style="width: 18%; padding: 3px 5px; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 3px;">
                            <span style="color: #64748b; font-size: 7.5px; display: block;">C4 - Jml Lubang:</span>
                            <strong style="color: #0f172a;">{{ $road->c4_label }}</strong>
                        </td>
                        <td style="width: 1%; border: none;"></td>
                        <td style="width: 18%; padding: 3px 5px; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 3px;">
                            <span style="color: #64748b; font-size: 7.5px; display: block;">C5 - Kepentingan:</span>
                            <strong style="color: #0f172a;">{{ $road->c5_label }}</strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    @endforeach

    <!-- FOOTER RESMI DENGAN NOMOR HALAMAN DINAMIS DOMPDF -->
    <script type="text/php">
        if (isset($pdf)) {
            $font = $fontMetrics->get_font("Helvetica", "normal");
            $size = 8;
            $color = array(0.45, 0.45, 0.45);
            // Garis footer bawah
            $pdf->line(34, 572, 808, 572, array(0.85, 0.85, 0.85), 1);
            // Teks kiri
            $pdf->text(34, 577, "Dokumen Resmi Sistem Pendukung Keputusan MOORA | Dinas PUPR Kota Bandar Lampung", $font, $size, $color);
            // Teks kanan (Nomor halaman)
            $pdf->page_text(725, 577, "Halaman {PAGE_NUM} dari {PAGE_COUNT}", $font, $size, $color);
        }
    </script>

</body>
</html>
