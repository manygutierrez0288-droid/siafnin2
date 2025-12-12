<?php
$models = [];
foreach (glob(__DIR__.'/../app/Models/*.php') as $f) {
    $models[] = basename($f, '.php');
}
// collect resource files
$resources = [];
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__.'/../app/Filament/Resources'));
foreach ($it as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        if (preg_match('/class\s+(\w+)Resource\s+extends\s+Resource/', $content, $m)) {
            $resources[] = $m[1];
        }
    }
}
$resources = array_unique($resources);
$missing = [];
foreach ($models as $m) {
    if (!in_array($m, $resources)) $missing[] = $m;
}
foreach ($missing as $mm) echo $mm.PHP_EOL;
if (empty($missing)) echo "NO_MISSING\n";
