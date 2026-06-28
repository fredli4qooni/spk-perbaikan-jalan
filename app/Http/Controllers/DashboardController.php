<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use App\Models\Road;
use App\Services\MooraService;

class DashboardController extends Controller
{
    public function index(MooraService $mooraService)
    {
        $summary = $mooraService->calculate();
        $roads = Road::latest()->get();

        return view('dashboard.index', [
            'roadCount' => $roads->count(),
            'criterionCount' => Criterion::count(),
            'verifiedCount' => $roads->where('is_verified', true)->count(),
            'pendingCount' => $roads->where('is_verified', false)->count(),
            'ranking' => $summary['results'][0] ?? null,
            'topThree' => array_slice($summary['results'], 0, 3),
            'latestRoads' => $roads->take(5),
        ]);
    }
}
