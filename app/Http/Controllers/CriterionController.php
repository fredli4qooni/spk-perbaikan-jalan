<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Criterion;
use Illuminate\Http\Request;

class CriterionController extends Controller
{
    public function index()
    {
        $criteria = Criterion::orderBy('code')->paginate(10);
        return view('criteria.index', compact('criteria'));
    }

    public function create()
    {
        return view('criteria.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:criteria,code'],
            'name' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'numeric', 'min:0'],
            'type' => ['required', 'in:benefit,cost'],
            'unit' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
        ]);

        $criterion = Criterion::create($data);

        ActivityLogger::log('create', "Menambahkan kriteria penilaian: {$criterion->code} - {$criterion->name}");

        return redirect()->route('criteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function edit(Criterion $criterion)
    {
        return view('criteria.edit', compact('criterion'));
    }

    public function update(Request $request, Criterion $criterion)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:criteria,code,' . $criterion->id],
            'name' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'numeric', 'min:0'],
            'type' => ['required', 'in:benefit,cost'],
            'unit' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
        ]);

        $criterion->update($data);

        ActivityLogger::log('update', "Memperbarui kriteria penilaian: {$criterion->code} - {$criterion->name}");

        return redirect()->route('criteria.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Criterion $criterion)
    {
        $code = $criterion->code;
        $name = $criterion->name;

        $criterion->delete();

        ActivityLogger::log('delete', "Menghapus kriteria penilaian: {$code} - {$name}");

        return back()->with('success', 'Kriteria berhasil dihapus.');
    }
}
