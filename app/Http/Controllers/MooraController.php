<?php

namespace App\Http\Controllers;

use App\Services\MooraService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class MooraController extends Controller
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

        return view('moora.index', $summary);
    }
}
