<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$emails = ['admin@pupr.test', 'petugas@pupr.test'];

try {
    $db = Illuminate\Support\Facades\DB::connection()->getDatabaseName();
    echo "DB: $db\n";
    foreach ($emails as $email) {
        $u = App\Models\User::where('email', $email)->first();
        echo $email . ': ' . ($u ? json_encode($u->toArray()) : 'NOT FOUND') . "\n";
    }
} catch (Throwable $e) {
    echo "DB ERROR: " . $e->getMessage() . "\n";
}
