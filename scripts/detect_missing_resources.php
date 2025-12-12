<?php
$models = glob(__DIR__ . '/../app/Models/*.php');
$resources = glob(__DIR__ . '/../app/Filament/Resources/*/*Resource.php');
$resourceModels = [];
foreach ($resources as $r) {
    $c = basename($r, 'Resource.php');
    $resourceModels[] = $c;
}
$missing = [];
foreach ($models as $m) {
    $name = basename($m, '.php');
    // check if any resource uses model: search resource files for "= $name::class"
    $found = false;
    foreach (glob(__DIR__ . '/../app/Filament/Resources/**/*.php') as $file) {
        $content = @file_get_contents($file);
        if ($content && strpos($content, "= $name::class") !== false) { $found = true; break; }
    }
    if (!$found) $missing[] = $name;
}
echo "Models detected:\n";
foreach ($models as $m) echo " - ".basename($m)."\n";
echo "\nMissing Resources for models:\n";
foreach ($missing as $mm) echo " - $mm\n";
?>