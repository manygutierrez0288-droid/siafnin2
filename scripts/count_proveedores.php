<?php

// Boot Laravel application and count Proveedor records
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Proveedor;

try {
    $count = Proveedor::count();
    echo "PROVEEDOR_COUNT:" . $count . PHP_EOL;
} catch (Throwable $e) {
    echo "ERROR:" . $e->getMessage() . PHP_EOL;
}
