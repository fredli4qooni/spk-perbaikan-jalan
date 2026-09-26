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
            'photos' => ['required', 'array', 'min:1'],
            'photos.*' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'video' => ['nullable', 'file', 'mimes:mp4,mov,avi,mkv', 'max:51200'],
            'notes' => ['nullable', 'string'],
        ], [
            'photos.required' => 'Foto dokumentasi kerusakan jalan wajib diunggah minimal 1 foto.',
            'photos.min' => 'Foto dokumentasi kerusakan jalan wajib diunggah minimal 1 foto.',
            'photos.*.image' => 'File yang diunggah harus berupa gambar (foto).',
            'photos.*.max' => 'Ukuran file foto maksimal 5 MB per foto.',
        ]);

        $uploadedPhotos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                if ($photoFile && $photoFile->isValid()) {
                    $uploadedPhotos[] = $photoFile->store('roads', 'public');
                }
            }
        }

        $data['photos'] = $uploadedPhotos;
        $data['photo'] = !empty($uploadedPhotos) ? $uploadedPhotos[0] : null;

        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('roads/videos', 'public');
        }

        $data['name'] = $data['location'];
        $data['user_id'] = Auth::id();

        $road = Road::create($data);

        ActivityLogger::log('create', "Menambahkan data ruas jalan: {$road->location}");

        return redirect()->route('roads.index')->with('success', 'Data ruas jalan beserta ' . count($uploadedPhotos) . ' foto dokumentasi berhasil ditambahkan.');
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
            'photos' => ['nullable', 'array'],
            'photos.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'keep_photos' => ['nullable', 'array'],
            'video' => ['nullable', 'file', 'mimes:mp4,mov,avi,mkv', 'max:51200'],
            'notes' => ['nullable', 'string'],
        ], [
            'photos.*.image' => 'File yang diunggah harus berupa gambar (foto).',
            'photos.*.max' => 'Ukuran file foto maksimal 5 MB per foto.',
        ]);

        // Foto yang dipertahankan
        $existingPhotos = $road->photos_list;
        $keptPhotos = $request->input('keep_photos', $existingPhotos);
        if (!is_array($keptPhotos)) {
            $keptPhotos = [];
        }

        // Hapus foto lama yang di-uncheck atau dibuang
        $removedPhotos = array_diff($existingPhotos, $keptPhotos);
        foreach ($removedPhotos as $removed) {
            Storage::disk('public')->delete($removed);
        }

        // Upload foto baru jika ada
        $newPhotos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                if ($photoFile && $photoFile->isValid()) {
                    $newPhotos[] = $photoFile->store('roads', 'public');
                }
            }
        }

        $allPhotos = array_values(array_merge($keptPhotos, $newPhotos));

        // Validasi: Wajib minimal 1 foto
        if (empty($allPhotos)) {
            return back()->withInput()->withErrors([
                'photos' => 'Foto dokumentasi kerusakan jalan wajib diunggah minimal 1 foto.'
            ]);
        }

        $data['photos'] = $allPhotos;
        $data['photo'] = $allPhotos[0] ?? null;

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

        foreach ($road->photos_list as $photoPath) {
            Storage::disk('public')->delete($photoPath);
        }

        if ($road->video) {
            Storage::disk('public')->delete($road->video);
        }

        $road->delete();

        ActivityLogger::log('delete', "Menghapus data ruas jalan: {$roadLoc}");

        return back()->with('success', 'Data ruas jalan berhasil dihapus.');
    }
}
