<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Criterion;
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

        $criteria = [
            ['code' => 'C1', 'name' => 'Panjang Kerusakan Jalan', 'weight' => 20, 'type' => 'benefit', 'unit' => 'm', 'description' => 'Panjang bagian jalan yang mengalami kerusakan'],
            ['code' => 'C2', 'name' => 'Lebar Jalan', 'weight' => 15, 'type' => 'benefit', 'unit' => 'm', 'description' => 'Dimensi jalan yang memengaruhi kapasitas dan biaya perbaikan'],
            ['code' => 'C3', 'name' => 'Kedalaman Lubang', 'weight' => 25, 'type' => 'benefit', 'unit' => 'cm', 'description' => 'Tingkat kedalaman lubang jalan; semakin dalam semakin mendesak untuk diperbaiki'],
            ['code' => 'C4', 'name' => 'Banyaknya Lubang', 'weight' => 20, 'type' => 'benefit', 'unit' => 'buah', 'description' => 'Jumlah lubang pada ruas jalan yang membahayakan pengendara'],
            ['code' => 'C5', 'name' => 'Kepentingan Jalan', 'weight' => 15, 'type' => 'benefit', 'unit' => 'kategori', 'description' => 'Peran strategis jalan dalam jaringan transportasi (sekolah, pasar, kantor dinas)'],
            ['code' => 'C6', 'name' => 'Jarak jalan dari pusat', 'weight' => 5, 'type' => 'cost', 'unit' => 'km', 'description' => 'Jarak tempuh dari kantor Dinas pusat ke lokasi ruas jalan'],
        ];

        foreach ($criteria as $criterion) {
            Criterion::updateOrCreate(['code' => $criterion['code']], $criterion);
        }

        ActivityLog::create([
            'user_id' => $admin->id,
            'action' => 'login',
            'description' => 'Inisialisasi sistem, akun pengguna, dan konfigurasi 6 kriteria MOORA',
            'ip_address' => '127.0.0.1',
        ]);
    }
}
