<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $tables = Illuminate\Support\Facades\DB::select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE'");
    foreach ($tables as $t) {
        echo $t->TABLE_NAME . PHP_EOL;
    }
} catch (Throwable $e) {
    echo 'ERROR: '. $e->getMessage() . PHP_EOL;
}
