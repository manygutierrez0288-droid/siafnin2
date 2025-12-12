<?php
$base = __DIR__ . '/../app/Filament/Resources';
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base));
$changed = [];
foreach ($it as $file) {
    if (!$file->isFile()) continue;
    if ($file->getExtension() !== 'php') continue;
    $path = $file->getPathname();
    $content = file_get_contents($path);
    $orig = $content;
    // replace double backslash before Filament with single backslash
    $content = str_replace('\\\\Filament', '\\Filament', $content);
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
