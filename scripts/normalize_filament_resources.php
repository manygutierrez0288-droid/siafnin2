<?php
/**
 * Normaliza namespaces y navigationGroup en app/Filament/Resources
 * - Ajusta `namespace` según la carpeta relativa (Resources/<Name>[/{Pages,Tables,Schemas}])
 * - Asegura que `use App\Filament\Resources\<Name>\Pages` y RelationManagers estén apuntando correctamente
 * - Convierte `protected static $navigationGroup` a `protected static string|\UnitEnum|null $navigationGroup`
 * - Reemplaza duplicaciones accidentales de namespace en líneas como
 *   "\\Filament\\Forms\\Components\\Filament\\Forms\\Components\\" => "\\Filament\\Forms\\Components\\"
 */

$base = realpath(__DIR__ . '/../app/Filament/Resources');
if (!is_dir($base)) {
    echo "Resources folder not found: $base\n";
    exit(1);
}

$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base));
$changed = [];

foreach ($it as $file) {
    if (!$file->isFile()) continue;
    if ($file->getExtension() !== 'php') continue;

    $path = $file->getPathname();
    $relative = substr($path, strlen($base) + 1);
    $parts = explode(DIRECTORY_SEPARATOR, $relative);
    $dirs = $parts;
    array_pop($dirs); // remove filename

    // Build expected namespace
    $ns = 'App\\Filament\\Resources';
    if (!empty($dirs)) {
        $ns .= '\\' . implode('\\', array_map(function($p){ return preg_replace('/[^A-Za-z0-9_]/','', $p); }, $dirs));
    }

    $content = file_get_contents($path);
    $orig = $content;

    // 1) Replace namespace (first occurrence)
    $content = preg_replace('/^namespace\s+[^{;\r\n]+;/m', "namespace $ns;", $content, 1);

    // 2) If this is a Resource class file, normalize Pages/RelationManagers use statements
    if (str_ends_with($file->getFilename(), 'Resource.php')) {
        $resourceFolder = basename(dirname($path));
        $resourceNs = 'App\\Filament\\Resources\\' . preg_replace('/[^A-Za-z0-9_]/','', $resourceFolder);

        // Replace any use ...\Pages; with the correct resource namespace
        $content = preg_replace('/use\s+App\\\\Filament\\\\Resources\\\\[A-Za-z0-9_\\\\]+\\\\Pages\s*;/m', "use $resourceNs\\\\Pages;", $content);
        $content = preg_replace('/use\s+App\\\\Filament\\\\Resources\\\\[A-Za-z0-9_\\\\]+\\\\RelationManagers\s*;/m', "use $resourceNs\\\\RelationManagers;", $content);

        // Ensure navigationGroup uses union type string|\UnitEnum|null if property exists
            $content = preg_replace_callback('/protected\s+static\s+[^{;\$]*\$navigationGroup\s*=\s*([^;]+);/m', function($m){
                $value = trim($m[1]);
                return 'protected static string|\\UnitEnum|null $navigationGroup = ' . $value . ';';
        }, $content, 1);
    }

    // 3) Fix common duplicated namespace fragments introduced earlier
    $content = str_replace('\\Filament\\Forms\\Components\\Filament\\Forms\\Components\\', '\\Filament\\Forms\\Components\\', $content);
    $content = str_replace('\\Filament\\Tables\\Columns\\Filament\\Tables\\Columns\\', '\\Filament\\Tables\\Columns\\', $content);

    // Also remove repeated sequences if any
    $content = preg_replace('#(\\\\Filament\\\\Forms\\\\Components\\\\)+#', '\\\\Filament\\\\Forms\\\\Components\\\\', $content);
    $content = preg_replace('#(\\\\Filament\\\\Tables\\\\Columns\\\\)+#', '\\\\Filament\\\\Tables\\\\Columns\\\\', $content);

    if ($content !== $orig) {
        file_put_contents($path, $content);
        $changed[] = $path;
    }
}

if (!empty($changed)) {
    echo "Normalized files:\n";
    foreach ($changed as $c) echo " - $c\n";
} else {
    echo "No changes required.\n";
}

echo "Done.\n";
