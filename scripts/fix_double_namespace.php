<?php
$dir = __DIR__ . '/../app/Filament/Resources';
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach ($it as $file) {
    if ($file->isDir()) continue;
    if ($file->getExtension() !== 'php') continue;
    $path = $file->getPathname();
    $content = file_get_contents($path);
    $new = str_replace('\\Filament\\Forms\\Components\\\\Filament\\Forms\\Components\\', '\\Filament\\Forms\\Components\\', $content);
    $new = str_replace('\\Filament\\Tables\\Columns\\\\Filament\\Tables\\Columns\\', '\\Filament\\Tables\\Columns\\', $new);
    if ($new !== $content) {
        file_put_contents($path, $new);
        echo "Fixed double namespace in: $path\n";
    }
}
echo "Done\n";
