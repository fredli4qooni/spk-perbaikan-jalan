<?php

namespace App\Http\Controllers;

use App\Models\Road;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoadController extends Controller
{
    public function index()
    {
        $roads = Road::withCount('scores')->latest()->paginate(10);
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
            'survey_year' => ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'photo' => ['nullable', 'image', 'max:2048'],
            'video' => ['nullable', 'file', 'mimetypes:video/mp4,video/quicktime,video/x-msvideo', 'max:51200'],
            'notes' => ['nullable', 'string'],
            'length' => ['required', 'numeric', 'min:0'],
            'width' => ['required', 'numeric', 'min:0'],
            'holes_count' => ['required', 'integer', 'min:0'],
            'hole_depth' => ['required', 'numeric', 'min:0'],
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

        $data['is_verified'] = false;
        $data['verified_by'] = null;
        $data['verified_at'] = null;

        Road::create($data);

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
            'survey_year' => ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'photo' => ['nullable', 'image', 'max:2048'],
            'video' => ['nullable', 'file', 'mimetypes:video/mp4,video/quicktime,video/x-msvideo', 'max:51200'],
            'notes' => ['nullable', 'string'],
            'length' => ['required', 'numeric', 'min:0'],
            'width' => ['required', 'numeric', 'min:0'],
            'holes_count' => ['required', 'integer', 'min:0'],
            'hole_depth' => ['required', 'numeric', 'min:0'],
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

        return redirect()->route('roads.index')->with('success', 'Ruas jalan berhasil diperbarui.');
    }

    public function destroy(Road $road)
    {
        abort_unless(Auth::user()?->role === 'petugas', 403);

        if ($road->photo) {
            Storage::disk('public')->delete($road->photo);
        }

        if ($road->video) {
            Storage::disk('public')->delete($road->video);
        }

        $road->delete();

        return back()->with('success', 'Ruas jalan berhasil dihapus.');
    }

    public function verify(Road $road)
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        $road->update([
            'is_verified' => true,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Ruas jalan berhasil diverifikasi.');
    }
}
