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
            ['code' => 'C1', 'name' => 'Panjang Kerusakan Jalan', 'weight' => 20, 'type' => 'benefit', 'unit' => 'm'],
            ['code' => 'C2', 'name' => 'Lebar Jalan', 'weight' => 15, 'type' => 'benefit', 'unit' => 'm'],
            ['code' => 'C3', 'name' => 'Kedalaman Lubang', 'weight' => 25, 'type' => 'benefit', 'unit' => 'cm'],
            ['code' => 'C4', 'name' => 'Banyaknya Lubang', 'weight' => 20, 'type' => 'benefit', 'unit' => 'buah'],
            ['code' => 'C5', 'name' => 'Kepentingan Jalan', 'weight' => 15, 'type' => 'benefit', 'unit' => 'kategori'],
            ['code' => 'C6', 'name' => 'Jarak jalan dari pusat', 'weight' => 5, 'type' => 'cost', 'unit' => 'km'],
        ];

        foreach ($criteria as $criterion) {
            Criterion::updateOrCreate(['code' => $criterion['code']], $criterion);
        }
    }
}
