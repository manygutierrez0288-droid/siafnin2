<?php
$base = __DIR__ . '/../app/Filament/Resources';
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base));
$patterns = [
    "\\\\Filament\\\\Forms\\\\Components\\\\Filament\\\\Forms\\\\Components\\\\" => "\\\\Filament\\\\Forms\\\\Components\\\\",
    "\\\\Filament\\\\Tables\\\\Columns\\\\Filament\\\\Tables\\\\Columns\\\\" => "\\\\Filament\\\\Tables\\\\Columns\\\\",
];
$changed = [];
foreach ($it as $file) {
    if (!$file->isFile()) continue;
    if ($file->getExtension() !== 'php') continue;
    $path = $file->getPathname();
    $content = file_get_contents($path);
    $orig = $content;
    foreach ($patterns as $from => $to) {
        $content = str_replace($from, $to, $content);
    }
    if ($content !== $orig) {
        file_put_contents($path, $content);
        $changed[] = $path;
    }
}
if (!empty($changed)) {
    echo "Fixed files:\n";
    foreach ($changed as $c) echo " - $c\n";
} else {
    echo "No replacements needed.\n";
}
