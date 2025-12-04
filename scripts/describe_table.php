<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

if ($argc < 2) {
    echo "Usage: php describe_table.php table_name\n";
    exit(1);
}

$table = $argv[1];
try {
    $cols = Illuminate\Support\Facades\DB::select("SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ?", [$table]);
    foreach ($cols as $c) {
        echo $c->COLUMN_NAME . " (" . $c->DATA_TYPE . ")" . PHP_EOL;
    }
} catch (Throwable $e) {
    echo 'ERROR: '. $e->getMessage() . PHP_EOL;
}
