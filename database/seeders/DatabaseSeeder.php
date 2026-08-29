<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Criterion;
use App\Models\Road;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@pupr.test'],
            [
                'name' => 'Admin PUPR',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $petugas = User::updateOrCreate(
            ['email' => 'petugas@pupr.test'],
            [
                'name' => 'Petugas PUPR',
                'password' => Hash::make('password'),
                'role' => 'petugas',
            ]
        );

        // 5 Kriteria Resmi Sesuai Dokumen Skripsi (Semua Benefit, Total Bobot 1.00 / 100)
        $criteria = [
            [
                'code' => 'C1',
                'name' => 'Panjang Kerusakan Jalan',
                'weight' => 25,
                'type' => 'benefit',
                'unit' => 'cm',
                'description' => '> 1000 cm (5), 600–999 cm (4), 300–599 cm (3), 100–299 cm (2), < 100 cm (1)'
            ],
            [
                'code' => 'C2',
                'name' => 'Lebar Jalan',
                'weight' => 15,
                'type' => 'benefit',
                'unit' => 'cm',
                'description' => '≥ 600 cm (5), 400–599 cm (4), 300–399 cm (3), 100–299 cm (2), < 100 cm (1)'
            ],
            [
                'code' => 'C3',
                'name' => 'Kedalaman Lubang',
                'weight' => 20,
                'type' => 'benefit',
                'unit' => 'cm',
                'description' => '≥ 8 cm (5), 6–7.9 cm (4), 4–5.9 cm (3), 2–3.9 cm (2), < 2 cm (1)'
            ],
            [
                'code' => 'C4',
                'name' => 'Banyaknya Lubang',
                'weight' => 25,
                'type' => 'benefit',
                'unit' => 'lubang',
                'description' => '≥ tidak beraturan (5), 11–15 lubang (4), 6–10 lubang (3), 3–5 lubang (2), 1–2 lubang (1)'
            ],
            [
                'code' => 'C5',
                'name' => 'Tingkat Kepentingan Jalan',
                'weight' => 15,
                'type' => 'benefit',
                'unit' => 'kategori',
                'description' => 'Rumah Sakit (5), Sekolah/Pendidikan (4), Kantor (3), Pasar (2), Lainnya (1)'
            ],
        ];

        foreach ($criteria as $criterion) {
            Criterion::updateOrCreate(['code' => $criterion['code']], $criterion);
        }

        // 5 Sampel Data Jalan Resmi dari Tabel 2 Dokumen Word
        $roads = [
            [
                'location' => 'Jl. Letjen Alamsyah Ratu Prawiranegara, Way Halim',
                'survey_year' => 2026,
                'kecamatan' => 'Way Halim',
                'kelurahan' => 'Way Halim Permai',
                'latitude' => -5.385500,
                'longitude' => 105.275000,
                'c1_panjang' => 4,
                'c2_lebar' => 5,
                'c3_kedalaman' => 5,
                'c4_lubang' => 2,
                'c5_kepentingan' => 5,
                'user_id' => $petugas->id,
            ],
            [
                'location' => 'Jl. Urip Sumoharjo, Way Halim Permai',
                'survey_year' => 2026,
                'kecamatan' => 'Way Halim',
                'kelurahan' => 'Way Halim Permai',
                'latitude' => -5.391200,
                'longitude' => 105.281000,
                'c1_panjang' => 1,
                'c2_lebar' => 1,
                'c3_kedalaman' => 4,
                'c4_lubang' => 2,
                'c5_kepentingan' => 5,
                'user_id' => $petugas->id,
            ],
            [
                'location' => 'Jl. Endro Suratmin (Jalur 2 samping UIN) Sisi Timur',
                'survey_year' => 2026,
                'kecamatan' => 'Sukarame',
                'kelurahan' => 'Sukarame',
                'latitude' => -5.378900,
                'longitude' => 105.298500,
                'c1_panjang' => 3,
                'c2_lebar' => 5,
                'c3_kedalaman' => 4,
                'c4_lubang' => 5,
                'c5_kepentingan' => 3,
                'user_id' => $petugas->id,
            ],
            [
                'location' => 'Jl. Endro Suratmin (Jalur 2 samping UIN) Sisi Barat',
                'survey_year' => 2026,
                'kecamatan' => 'Sukarame',
                'kelurahan' => 'Sukarame',
                'latitude' => -5.379200,
                'longitude' => 105.297800,
                'c1_panjang' => 4,
                'c2_lebar' => 5,
                'c3_kedalaman' => 5,
                'c4_lubang' => 5,
                'c5_kepentingan' => 3,
                'user_id' => $petugas->id,
            ],
            [
                'location' => 'Jl. Endro Suratmin, Sukarame (depan UIN Raden Intan)',
                'survey_year' => 2026,
                'kecamatan' => 'Sukarame',
                'kelurahan' => 'Sukarame',
                'latitude' => -5.377500,
                'longitude' => 105.299000,
                'c1_panjang' => 5,
                'c2_lebar' => 5,
                'c3_kedalaman' => 5,
                'c4_lubang' => 5,
                'c5_kepentingan' => 3,
                'user_id' => $petugas->id,
            ],
        ];

        foreach ($roads as $roadData) {
            $roadData['name'] = $roadData['location'];
            Road::create($roadData);
        }

        ActivityLog::create([
            'user_id' => $admin->id,
            'action' => 'login',
            'description' => 'Inisialisasi sistem, akun pengguna, dan konfigurasi 5 kriteria MOORA resmi',
            'ip_address' => '127.0.0.1',
        ]);
    }
}
