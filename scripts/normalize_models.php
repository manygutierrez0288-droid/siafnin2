<?php
require __DIR__.'/../vendor/autoload.php';

$dbml = __DIR__.'/../public/basedatos.dbml';
if (!file_exists($dbml)) { echo "basedatos.dbml not found\n"; exit(1); }
$txt = file_get_contents($dbml);

// parse tables and primary keys
preg_match_all('/Table\s+(\w+)\s*\{([^}]*)\}/m', $txt, $tmatches, PREG_SET_ORDER);
$map = []; // table => primary
foreach ($tmatches as $m) {
    $table = $m[1];
    $body = $m[2];
    $lines = preg_split('/\r?\n/', $body);
    $primary = null;
    foreach ($lines as $ln) {
        $ln = trim($ln);
        if ($ln === '' || strpos($ln, '//') === 0) continue;
        if (!preg_match('/^(\w+)\s+(\w+(?:\([^)]*\))?)(?:\s*\[(.*)\])?/', $ln, $c)) continue;
        $col = $c[1]; $attrs = isset($c[3])?$c[3]:'';
        if (strpos($attrs,'pk') !== false) {
            $primary = $col; break;
        }
    }
    if (!$primary) $primary = 'id';
    $map[$table] = $primary;
}

function studly($s){ return str_replace(' ','',ucwords(str_replace(['_','-'], ' ', $s))); }
function singular($s){ if (substr($s,-3)==='ces') return substr($s,0,-3).'z'; if (substr($s,-1)==='s') return substr($s,0,-1); return $s; }
function modelNameFromTable($table){ return studly(singular($table)); }

$modelsDir = __DIR__.'/../app/Models';
$files = glob($modelsDir.'/*.php');
$changes = [];
foreach ($files as $file) {
    $content = file_get_contents($file);
    // detect class name
    if (!preg_match('/class\s+(\w+)\s+extends\s+Model/', $content, $m)) continue;
    $class = $m[1];
    // Determine expected table name by finding matching DBML entry: try plural snake of class, or find table with singular equal
    $expectedTable = null; $expectedPrimary = null;
    // Try to find table by matching modelNameFromTable
    foreach ($map as $table => $primary) {
        if (modelNameFromTable($table) === $class) { $expectedTable = $table; $expectedPrimary = $primary; break; }
    }
    // fallback: try snake plural of class
    if (!$expectedTable) {
        $guess = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $class)); // snake
        $guessPlural = $guess . 's';
        if (isset($map[$guessPlural])) { $expectedTable = $guessPlural; $expectedPrimary = $map[$guessPlural]; }
    }
    if (!$expectedTable) continue; // cannot map

    $updated = $content;
    // ensure protected $table
    if (!preg_match('/protected\s+\\$table\s*=\s*\'/', $updated) && !preg_match('/protected\s+\\$table\s*=/', $updated)) {
        // insert after use HasFactory; or after class opening
        if (preg_match('/use\s+HasFactory;\s*/', $updated)) {
            $updated = preg_replace('/use\s+HasFactory;\s*/', "use HasFactory;\n    protected \$table = '$expectedTable';\n\n", $updated, 1);
        } else {
            $updated = preg_replace('/\{\n/', "{\n    protected \$table = '$expectedTable';\n\n", $updated, 1);
        }
        $changes[] = "Added table for $class => $expectedTable";
    } else {
            // replace if different
            $updated = preg_replace('/protected\s+\$table\s*=\s*\'[^\']+\';/', "protected \$table = '$expectedTable';", $updated);
    }
    // ensure protected $primaryKey if not 'id'
    if ($expectedPrimary && $expectedPrimary !== 'id') {
        if (!preg_match('/protected\s+\\$primaryKey\s*=\s*\'/', $updated) && !preg_match('/protected\s+\\$primaryKey\s*=/', $updated)) {
            // insert after $table line if present
                if (strpos($updated, "protected \$table") !== false) {
                $updated = preg_replace('/protected\s+\$table\s*=\s*\'[^\']+\';\s*/', "protected \$table = '$expectedTable';\n    protected \$primaryKey = '$expectedPrimary';\n\n", $updated, 1);
            } else {
                $updated = preg_replace('/use\s+HasFactory;\s*/', "use HasFactory;\n    protected \\$primaryKey = '$expectedPrimary';\n\n", $updated, 1);
            }
            $changes[] = "Added primaryKey for $class => $expectedPrimary";
        } else {
                // replace existing
                $updated = preg_replace('/protected\s+\$primaryKey\s*=\s*\'[^\']+\';/', "protected \$primaryKey = '$expectedPrimary';", $updated);
        }
    }

    if ($updated !== $content) {
        file_put_contents($file, $updated);
        echo "Updated model: $file\n";
    }
}

echo "Done.\n";
