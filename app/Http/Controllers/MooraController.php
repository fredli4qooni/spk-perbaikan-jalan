<?php

namespace App\Http\Controllers;

use App\Services\MooraService;

class MooraController extends Controller
{
    public function index(MooraService $mooraService)
    {
        $summary = $mooraService->calculate();

        return view('moora.index', $summary);
    }
}
