<?php

namespace App\Http\Controllers;

use App\Services\MooraService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request, MooraService $mooraService)
    {
        $summary = $mooraService->calculate();

        $perPage = $request->integer('per_page', 5);
        $currentPage = LengthAwarePaginator::resolveCurrentPage() ?: 1;
        $currentItems = array_slice($summary['results'], ($currentPage - 1) * $perPage, $perPage);

        $summary['results'] = new LengthAwarePaginator(
            $currentItems,
            count($summary['results']),
            $perPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]
        );

        return view('reports.index', $summary);
    }

    public function exportCsv(MooraService $mooraService): StreamedResponse
    {
        $summary = $mooraService->calculate();

        return response()->streamDownload(function () use ($summary) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Peringkat', 'Lokasi Ruas Jalan', 'Kecamatan', 'Kelurahan', 'Nilai MOORA']);

            foreach ($summary['results'] as $row) {
                fputcsv($handle, [
                    $row['rank'],
                    $row['road']->location,
                    $row['road']->kecamatan,
                    $row['road']->kelurahan,
                    number_format($row['result'], 4)
                ]);
            }

            fclose($handle);
        }, 'laporan-prioritas-jalan-moora-pu.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportPdf(MooraService $mooraService, Request $request)
    {
        $summary = $mooraService->calculate();

        // Siapkan Logo PU base64
        $logoBase64 = null;
        $logoPath = public_path('images/Logo-PU.png');
        if (file_exists($logoPath)) {
            $logoData = base64_encode(file_get_contents($logoPath));
            $logoBase64 = 'data:image/png;base64,' . $logoData;
        }

        // Siapkan foto dokumentasi base64 untuk setiap ruas jalan
        $resultsWithPhotos = [];
        foreach ($summary['results'] as $row) {
            $road = $row['road'];
            $photosBase64 = [];
            foreach ($road->photos_list as $p) {
                $fullPath = storage_path('app/public/' . $p);
                if (file_exists($fullPath)) {
                    $mime = mime_content_type($fullPath) ?: 'image/jpeg';
                    $data = base64_encode(file_get_contents($fullPath));
                    $photosBase64[] = "data:{$mime};base64,{$data}";
                }
            }
            $row['photos_base64'] = $photosBase64;
            $resultsWithPhotos[] = $row;
        }

        $pdf = Pdf::loadView('reports.pdf', [
            'results' => $resultsWithPhotos,
            'criteria' => $summary['criteria'],
            'weights' => $summary['weights'],
            'denominators' => $summary['denominators'],
            'logoBase64' => $logoBase64,
            'generatedAt' => now()->translatedFormat('d F Y, H:i'),
            'totalRoads' => count($resultsWithPhotos),
        ]);

        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'defaultFont' => 'sans-serif',
        ]);

        $filename = 'Laporan-Prioritas-Jalan-MOORA-PU-' . date('Ymd-His') . '.pdf';

        if ($request->boolean('stream')) {
            return $pdf->stream($filename);
        }

        return $pdf->download($filename);
    }
}
