<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Road;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RoadController extends Controller
{
    public function index()
    {
        $roads = Road::with(['user', 'scores'])->latest()->paginate(10);
        return view('roads.index', compact('roads'));
    }

    public function create()
    {
        abort_unless(Auth::user()?->role === 'petugas', 403);

        return view('roads.create');
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()?->role === 'petugas', 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'survey_year' => ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'photo' => ['nullable', 'image', 'max:2048'],
            'video' => ['nullable', 'file', 'mimes:mp4,mov,avi,mkv', 'max:51200'],
            'notes' => ['nullable', 'string'],
            'length' => ['required', 'numeric', 'min:0'],
            'width' => ['required', 'numeric', 'min:0'],
            'distance' => ['required', 'numeric', 'min:0'],
            'holes_count' => ['required', 'integer', 'min:0'],
            'potholes_data' => ['nullable', 'array'],
            'potholes_data.*.length' => ['required', 'numeric', 'min:0'],
            'potholes_data.*.width' => ['required', 'numeric', 'min:0'],
            'potholes_data.*.depth' => ['required', 'numeric', 'min:0'],
            'importance' => ['required', 'string', 'max:50'],
            'kelurahan' => ['required', 'string', 'max:150'],
            'kecamatan' => ['required', 'string', 'max:150'],
            'rt' => ['required', 'string', 'max:10'],
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('roads', 'public');
        }

        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('roads/videos', 'public');
        }

        $data['user_id'] = Auth::id();

        $road = Road::create($data);

        ActivityLogger::log('create', "Menambahkan data ruas jalan: {$road->name} ({$road->location})");

        return redirect()->route('roads.index')->with('success', 'Ruas jalan berhasil ditambahkan.');
    }

    public function edit(Road $road)
    {
        abort_unless(Auth::user()?->role === 'petugas', 403);

        return view('roads.edit', compact('road'));
    }

    public function update(Request $request, Road $road)
    {
        abort_unless(Auth::user()?->role === 'petugas', 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'survey_year' => ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'photo' => ['nullable', 'image', 'max:2048'],
            'video' => ['nullable', 'file', 'mimes:mp4,mov,avi,mkv', 'max:51200'],
            'notes' => ['nullable', 'string'],
            'length' => ['required', 'numeric', 'min:0'],
            'width' => ['required', 'numeric', 'min:0'],
            'distance' => ['required', 'numeric', 'min:0'],
            'holes_count' => ['required', 'integer', 'min:0'],
            'potholes_data' => ['nullable', 'array'],
            'potholes_data.*.length' => ['required', 'numeric', 'min:0'],
            'potholes_data.*.width' => ['required', 'numeric', 'min:0'],
            'potholes_data.*.depth' => ['required', 'numeric', 'min:0'],
            'importance' => ['required', 'string', 'max:50'],
            'kelurahan' => ['required', 'string', 'max:150'],
            'kecamatan' => ['required', 'string', 'max:150'],
            'rt' => ['required', 'string', 'max:10'],
        ]);

        if ($request->hasFile('photo')) {
            if ($road->photo) {
                Storage::disk('public')->delete($road->photo);
            }
            $data['photo'] = $request->file('photo')->store('roads', 'public');
        }

        if ($request->hasFile('video')) {
            if ($road->video) {
                Storage::disk('public')->delete($road->video);
            }
            $data['video'] = $request->file('video')->store('roads/videos', 'public');
        }

        $road->update($data);

        ActivityLogger::log('update', "Memperbarui data ruas jalan: {$road->name}");

        return redirect()->route('roads.index')->with('success', 'Ruas jalan berhasil diperbarui.');
    }

    public function destroy(Road $road)
    {
        abort_unless(Auth::user()?->role === 'petugas', 403);

        $roadName = $road->name;

        if ($road->photo) {
            Storage::disk('public')->delete($road->photo);
        }

        if ($road->video) {
            Storage::disk('public')->delete($road->video);
        }

        $road->delete();

        ActivityLogger::log('delete', "Menghapus data ruas jalan: {$roadName}");

        return back()->with('success', 'Ruas jalan berhasil dihapus.');
    }
}
