<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Road;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RoadController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 5);
        $roads = Road::with(['user', 'scores'])
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

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
            'location' => ['required', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'survey_year' => ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'kecamatan' => ['required', 'string', 'max:150'],
            'kelurahan' => ['required', 'string', 'max:150'],
            'c1_panjang' => ['required', 'integer', 'in:1,2,3,4,5'],
            'c2_lebar' => ['required', 'integer', 'in:1,2,3,4,5'],
            'c3_kedalaman' => ['required', 'integer', 'in:1,2,3,4,5'],
            'c4_lubang' => ['required', 'integer', 'in:1,2,3,4,5'],
            'c5_kepentingan' => ['required', 'integer', 'in:1,2,3,4,5'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'video' => ['nullable', 'file', 'mimes:mp4,mov,avi,mkv', 'max:51200'],
            'notes' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('roads', 'public');
        }

        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('roads/videos', 'public');
        }

        $data['name'] = $data['location'];
        $data['user_id'] = Auth::id();

        $road = Road::create($data);

        ActivityLogger::log('create', "Menambahkan data ruas jalan: {$road->location}");

        return redirect()->route('roads.index')->with('success', 'Data ruas jalan berhasil ditambahkan.');
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
            'location' => ['required', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'survey_year' => ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'kecamatan' => ['required', 'string', 'max:150'],
            'kelurahan' => ['required', 'string', 'max:150'],
            'c1_panjang' => ['required', 'integer', 'in:1,2,3,4,5'],
            'c2_lebar' => ['required', 'integer', 'in:1,2,3,4,5'],
            'c3_kedalaman' => ['required', 'integer', 'in:1,2,3,4,5'],
            'c4_lubang' => ['required', 'integer', 'in:1,2,3,4,5'],
            'c5_kepentingan' => ['required', 'integer', 'in:1,2,3,4,5'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'video' => ['nullable', 'file', 'mimes:mp4,mov,avi,mkv', 'max:51200'],
            'notes' => ['nullable', 'string'],
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

        $data['name'] = $data['location'];

        $road->update($data);

        ActivityLogger::log('update', "Memperbarui data ruas jalan: {$road->location}");

        return redirect()->route('roads.index')->with('success', 'Data ruas jalan berhasil diperbarui.');
    }

    public function destroy(Road $road)
    {
        abort_unless(Auth::user()?->role === 'petugas', 403);

        $roadLoc = $road->location;

        if ($road->photo) {
            Storage::disk('public')->delete($road->photo);
        }

        if ($road->video) {
            Storage::disk('public')->delete($road->video);
        }

        $road->delete();

        ActivityLogger::log('delete', "Menghapus data ruas jalan: {$roadLoc}");

        return back()->with('success', 'Data ruas jalan berhasil dihapus.');
    }
}
