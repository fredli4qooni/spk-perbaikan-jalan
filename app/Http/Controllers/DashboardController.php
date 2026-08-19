<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Criterion;
use App\Models\Road;
use App\Models\User;
use App\Services\MooraService;

class DashboardController extends Controller
{
    public function index(MooraService $mooraService)
    {
        $summary = $mooraService->calculate();
        $roads = Road::with('user')->latest()->get();

        return view('dashboard.index', [
            'roadCount' => $roads->count(),
            'criterionCount' => Criterion::count(),
            'activityCount' => ActivityLog::count(),
            'petugasCount' => User::where('role', 'petugas')->count(),
            'ranking' => $summary['results'][0] ?? null,
            'topThree' => array_slice($summary['results'], 0, 3),
            'latestRoads' => $roads->take(5),
            'latestActivities' => ActivityLog::with('user')->latest()->take(5)->get(),
        ]);
    }
}
