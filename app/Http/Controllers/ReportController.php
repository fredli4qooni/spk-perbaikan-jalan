<?php

namespace App\Http\Controllers;

use App\Services\MooraService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(MooraService $mooraService)
    {
        $summary = $mooraService->calculate();

        return view('reports.index', $summary);
    }

    public function exportCsv(MooraService $mooraService): StreamedResponse
    {
        $summary = $mooraService->calculate();

        return response()->streamDownload(function () use ($summary) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Rank', 'Ruas Jalan', 'Nilai MOORA']);

            foreach ($summary['results'] as $row) {
                fputcsv($handle, [$row['rank'], $row['road']->name, $row['result']]);
            }

            fclose($handle);
        }, 'laporan-moora-pupr.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
