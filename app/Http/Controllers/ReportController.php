<?php

namespace App\Http\Controllers;

use App\Services\MooraService;
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
                    $row['result']
                ]);
            }

            fclose($handle);
        }, 'laporan-prioritas-jalan-moora-pupr.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
