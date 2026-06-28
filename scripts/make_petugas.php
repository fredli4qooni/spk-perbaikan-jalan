<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Hash;

try {
    $user = App\Models\User::updateOrCreate([
        'email' => 'petugas@pupr.test',
    ], [
        'name' => 'Petugas PUPR',
        'password' => Hash::make('password'),
        'role' => 'petugas',
    ]);
    echo "Created/Updated user: " . $user->email . "\n";
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
