<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use App\Models\Road;
use App\Models\RoadScore;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function index()
    {
        $roads = Road::with('scores')->orderBy('name')->get();
        $criteria = Criterion::orderBy('code')->get();

        return view('scores.index', compact('roads', 'criteria'));
    }

    public function store(Request $request)
    {
        $roads = Road::all();
        $criteria = Criterion::all();

        $rules = [];
        foreach ($roads as $road) {
            foreach ($criteria as $criterion) {
                $rules["scores.{$road->id}.{$criterion->id}"] = ['nullable', 'numeric', 'min:0'];
            }
        }

        $validated = $request->validate($rules);

        foreach ($roads as $road) {
            foreach ($criteria as $criterion) {
                $value = data_get($validated, "scores.{$road->id}.{$criterion->id}");

                if ($value === null || $value === '') {
                    continue;
                }

                RoadScore::updateOrCreate(
                    [
                        'road_id' => $road->id,
                        'criterion_id' => $criterion->id,
                    ],
                    [
                        'value' => $value,
                    ]
                );
            }
        }

        return redirect()->route('scores.index')->with('success', 'Nilai alternatif berhasil disimpan.');
    }
}
