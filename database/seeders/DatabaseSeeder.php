<?php

namespace Database\Seeders;

use App\Models\Criterion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@pupr.test'],
            [
                'name' => 'Admin PUPR',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'petugas@pupr.test'],
            [
                'name' => 'Petugas PUPR',
                'password' => Hash::make('password'),
                'role' => 'petugas',
            ]
        );

        $criteria = [
            ['code' => 'C1', 'name' => 'Panjang Jalan', 'weight' => 15, 'type' => 'benefit', 'unit' => 'm'],
            ['code' => 'C2', 'name' => 'Lebar Jalan', 'weight' => 10, 'type' => 'benefit', 'unit' => 'm'],
            ['code' => 'C3', 'name' => 'Banyaknya Lubang', 'weight' => 20, 'type' => 'benefit', 'unit' => 'buah'],
            ['code' => 'C4', 'name' => 'Kedalaman Lubang', 'weight' => 15, 'type' => 'benefit', 'unit' => 'cm'],
            ['code' => 'C5', 'name' => 'Tingkat Kerusakan', 'weight' => 20, 'type' => 'benefit', 'unit' => 'skor'],
            ['code' => 'C6', 'name' => 'Kepentingan Jalan', 'weight' => 15, 'type' => 'benefit', 'unit' => 'skor'],
            ['code' => 'C7', 'name' => 'Biaya Perbaikan', 'weight' => 5, 'type' => 'cost', 'unit' => 'rupiah'],
        ];

        foreach ($criteria as $criterion) {
            Criterion::updateOrCreate(['code' => $criterion['code']], $criterion);
        }
    }
}
