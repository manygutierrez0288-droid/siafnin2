<?php
$dir = __DIR__ . '/../database/migrations';
$files = scandir($dir);
foreach ($files as $f) {
    if (!preg_match('/\.php$/', $f)) continue;
    $path = $dir . '/' . $f;
    $content = file_get_contents($path);
    $new = preg_replace('/function \(Blueprint\s+[A-Za-z_][A-Za-z0-9_]*\)/', 'function (Blueprint $table)', $content);
    if ($new !== $content) {
        file_put_contents($path, $new);
        echo "Fixed: $f\n";
    }
}
echo "Done.\n";
