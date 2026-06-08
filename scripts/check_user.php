<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$u = User::where('email', 'monir112761@gmail.com')->first();
if ($u) {
    echo "FOUND: " . $u->email . " (name: " . $u->name . ")\n";
} else {
    echo "NOT FOUND\n";
}
