<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use App\Models\Road;
use App\Services\MooraService;
use Illuminate\Http\Request;

class PublicDashboardController extends Controller
{
    /**
     * Tampilkan Dashboard Publik Transparansi Prioritas Perbaikan Jalan
     */
    public function index(Request $request, MooraService $mooraService)
    {
        $summary = $mooraService->calculate();
        $results = $summary['results'] ?? [];

        $totalRoads = count($results);
        $topThree = array_slice($results, 0, 3);

        // Hitung kategori prioritas tinggi / mendesak
        $highPriorityCount = 0;
        foreach ($results as $row) {
            if ($row['rank'] <= 5 || ($row['road']->damage_score ?? 0) >= 3.8) {
                $highPriorityCount++;
            }
        }

        // Daftar 20 Kecamatan resmi Kota Bandar Lampung
        $kecamatanList = [
            'Bumi Waras', 'Enggal', 'Kedamaian', 'Kedaton', 'Kemiling',
            'Labuhan Ratu', 'Langkapura', 'Panjang', 'Rajabasa', 'Sukabumi',
            'Sukarame', 'Tanjung Karang Barat', 'Tanjung Karang Pusat',
            'Tanjung Karang Timur', 'Tanjung Senang', 'Teluk Betung Barat',
            'Teluk Betung Selatan', 'Teluk Betung Timur', 'Teluk Betung Utara',
            'Way Halim'
        ];
        sort($kecamatanList);

        // Kriteria MOORA untuk seksi edukasi transparansi
        $criteria = Criterion::orderBy('code')->get();

        // Siapkan data koordinat dan detail untuk marker Leaflet.js
        $mapMarkers = [];
        foreach ($results as $row) {
            $road = $row['road'];
            if (!empty($road->latitude) && !empty($road->longitude) && is_numeric($road->latitude) && is_numeric($road->longitude)) {
                $damageStatus = $road->damage_status;
                $mapMarkers[] = [
                    'id' => $road->id,
                    'rank' => $row['rank'],
                    'name' => $road->name,
                    'location' => $road->location,
                    'kecamatan' => $road->kecamatan,
                    'kelurahan' => $road->kelurahan,
                    'lat' => (float) $road->latitude,
                    'lng' => (float) $road->longitude,
                    'score' => round($row['result'], 4),
                    'damage_label' => $damageStatus['label'],
                    'damage_score' => $damageStatus['score'],
                    'c1' => $road->c1_label,
                    'c2' => $road->c2_label,
                    'c3' => $road->c3_label,
                    'c4' => $road->c4_label,
                    'c5' => $road->c5_label,
                    'photo' => !empty($road->photo) ? asset('storage/' . $road->photo) : null,
                ];
            }
        }

        return view('public.index', [
            'results' => $results,
            'topThree' => $topThree,
            'totalRoads' => $totalRoads,
            'highPriorityCount' => $highPriorityCount,
            'kecamatanCount' => count($kecamatanList),
            'kecamatanList' => $kecamatanList,
            'criteria' => $criteria,
            'mapMarkers' => $mapMarkers,
            'latestSurveyYear' => Road::max('survey_year') ?? date('Y'),
        ]);
    }
}
