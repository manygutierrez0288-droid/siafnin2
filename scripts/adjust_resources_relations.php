<?php
$base = __DIR__ . '/../app/Filament/Resources';
$modelsDir = __DIR__ . '/../app/Models';

$modifiedFiles = [];
$addedFillables = [];

$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base));
foreach ($it as $file) {
    if (!$file->isFile()) continue;
    if ($file->getExtension() !== 'php') continue;
    $path = $file->getPathname();
    $content = file_get_contents($path);
    $orig = $content;
    // Replace TextInput FK fields: patterns like TextInput::make('idUsuario') or TextInput::make('id_usuario')
    $content = preg_replace_callback(
        "/TextInput::make\(\s*'(?P<field>id[_A-Za-z0-9]+)'\s*\)(->label\(\'(?P<label>[^']*)\'\))?/",
        function($m){
            $field = $m['field'];
            $label = isset($m['label']) && $m['label'] !== '' ? $m['label'] : ucfirst(str_replace(['id','_'], ['',' '], $field));
            // derive relation name
            if (strpos($field, 'id_') === 0) {
                $rel = substr($field, 3);
                $rel = preg_replace_callback('/_([a-z])/', function($mm){ return strtoupper($mm[1]); }, $rel);
            } elseif (strpos($field, 'id') === 0) {
                $rel = substr($field, 2);
                $rel = lcfirst($rel);
            } else {
                $rel = $field;
            }
            $rel = lcfirst($rel);
            $replacement = "\Filament\Forms\Components\BelongsToSelect::make('$field')->relationship('$rel','nombre')->label('$label')";
            return $replacement;
        },
        $content
    );
    // Replace TextColumn for id fields -> relation.nombre
    $content = preg_replace_callback(
        "/TextColumn::make\(\s*'(?P<field>id[_A-Za-z0-9]+)'\s*\)(->label\(\'(?P<label>[^']*)\'\))?/",
        function($m){
            $field = $m['field'];
            $label = isset($m['label']) && $m['label'] !== '' ? $m['label'] : ucfirst(str_replace(['id','_'], ['',' '], $field));
            if (strpos($field, 'id_') === 0) {
                $rel = substr($field, 3);
                $rel = preg_replace_callback('/_([a-z])/', function($mm){ return strtoupper($mm[1]); }, $rel);
            } elseif (strpos($field, 'id') === 0) {
                $rel = substr($field, 2);
                $rel = lcfirst($rel);
            } else {
                $rel = $field;
            }
            $rel = lcfirst($rel);
            return "\\Filament\\Tables\\Columns\\TextColumn::make('$rel.nombre')->label('$label')";
        },
        $content
    );

    if ($content !== $orig) {
        file_put_contents($path, $content);
        $modifiedFiles[] = $path;
        // collect fk names to ensure fillable
        preg_match_all("/BelongsToSelect::make\('(?P<field>id[_A-Za-z0-9]+)'/", $content, $mm);
        if (!empty($mm['field'])) {
            foreach ($mm['field'] as $f) $addedFillables[$f] = true;
        }
    }
}

// Update models' $fillable
$models = glob($modelsDir . '/*.php');
foreach ($models as $mfile) {
    $content = file_get_contents($mfile);
    $orig = $content;
    if (preg_match('/protected\s+\$fillable\s*=\s*\[([^\]]*)\]/s', $content, $fmatch)) {
        $inside = $fmatch[1];
        $hasChange = false;
        foreach ($addedFillables as $field => $_) {
            if (strpos($inside, "'{$field}'") === false) {
                $inside = trim($inside);
                if ($inside === '') {
                    $inside = "\n        '$field',\n    ";
                } else {
                    // insert before closing
                    $inside = rtrim($inside) . "\n        '$field',\n    ";
                }
                $hasChange = true;
            }
        }
        if ($hasChange) {
            $new = preg_replace('/protected\s+\$fillable\s*=\s*\[[^\]]*\]/s', "protected \$fillable = [{$inside}]", $content, 1);
            file_put_contents($mfile, $new);
        }
    } else {
        // no fillable defined, add one with fields
        if (!empty($addedFillables)) {
            $fields = "\n    protected \$fillable = [\n";
            foreach (array_keys($addedFillables) as $f) {
                $fields .= "        '$f',\n";
            }
            $fields .= "    ];\n\n";
            // insert after class opening
            $new = preg_replace('/class\s+\w+\s+extends\s+Model\s*\{/', "$0\n" . $fields, $content, 1);
            if ($new !== $content) file_put_contents($mfile, $new);
        }
    }
}

echo "Modified resource files:\n";
foreach ($modifiedFiles as $p) echo " - $p\n";
echo "\nUpdated models with added fillables for FK fields.\n";
