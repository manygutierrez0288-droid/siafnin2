<?php
require __DIR__.'/../vendor/autoload.php';

$path = __DIR__.'/../public/basedatos.dbml';
if (!file_exists($path)) { echo "DBML not found\n"; exit(1); }
$txt = file_get_contents($path);

// parse tables and columns
preg_match_all('/Table\s+(\w+)\s*\{([^}]*)\}/m', $txt, $tmatches, PREG_SET_ORDER);
$tables = [];
foreach ($tmatches as $m) {
    $tname = $m[1];
    $body = $m[2];
    $lines = preg_split('/\r?\n/', $body);
    $cols = [];
    $primary = null;
    foreach ($lines as $ln) {
        $ln = trim($ln);
        if ($ln === '' || strpos($ln, '//') === 0) continue;
        if (!preg_match('/^(\w+)\s+(\w+(?:\([^)]*\))?)(?:\s*\[(.*)\])?/', $ln, $c)) continue;
        $col = $c[1]; $type = $c[2]; $attrs = isset($c[3])?$c[3]:'';
        $cols[$col] = ['type'=>$type,'attrs'=>$attrs];
        if (strpos($attrs,'pk')!==false) $primary = $col;
    }
    $tables[$tname] = ['cols'=>$cols,'primary'=>$primary];
}

// parse refs
preg_match_all('/Ref:\s*(\w+)\.(\w+)\s*<\s*(\w+)\.(\w+)/m', $txt, $rmatches, PREG_SET_ORDER);
$refs = [];
foreach ($rmatches as $r) {
    $parentTable = $r[1]; $parentCol = $r[2];
    $childTable = $r[3]; $childCol = $r[4];
    $refs[] = ['parentTable'=>$parentTable,'parentCol'=>$parentCol,'childTable'=>$childTable,'childCol'=>$childCol];
}

if (empty($refs)) { echo "No refs found\n"; exit(0); }

function studly($s){ return str_replace(' ','',ucwords(str_replace(['_','-'], ' ', $s))); }
function singular($s){ // naive
    if (substr($s,-3)==='ces') return substr($s,0,-3).'z';
    if (substr($s,-1)==='s') return substr($s,0,-1);
    return $s;
}
function camel($s){ $st = studly($s); return lcfirst($st); }

$changes = [];
foreach ($refs as $r) {
    $parent = $r['parentTable']; $parentCol = $r['parentCol'];
    $child = $r['childTable']; $childCol = $r['childCol'];
    // compute model class names
    $parentModel = studly(singular($parent));
    $childModel = studly(singular($child));
    // relation method names
    $belongsToName = camel(singular($parent));
    $hasManyName = camel($child);
    // display column for parent
    $display = ''.$parentCol;
    if (isset($tables[$parent])){
        if (isset($tables[$parent]['cols']['nombre'])) $display = 'nombre';
        else {
            foreach ($tables[$parent]['cols'] as $cname=>$meta){ if (stripos($meta['type'],'varchar')!==false){ $display=$cname; break;} }
        }
        if (!$display) $display = $parentCol;
    }

    // Update child model: add belongsTo method if not exists
    $childModelPath = __DIR__.'/../app/Models/'.$childModel.'.php';
    if (file_exists($childModelPath)){
        $content = file_get_contents($childModelPath);
        $method = "\n    public function $belongsToName()\n    {\n        return \$this->belongsTo(\\App\\Models\\$parentModel::class, '$childCol', '$parentCol');\n    }\n";
        if (strpos($content, "function $belongsToName(") === false && strpos($content, "function $belongsToName ()")===false){
            // insert before last closing bracket
            $content = preg_replace('/}\s*$/','    '.$method."}\n", $content);
            file_put_contents($childModelPath, $content);
            echo "Added belongsTo $belongsToName to $childModel\n";
        }
    }

    // Update parent model: add hasMany
    $parentModelPath = __DIR__.'/../app/Models/'.$parentModel.'.php';
    if (file_exists($parentModelPath)){
        $pcontent = file_get_contents($parentModelPath);
        $pmethod = "\n    public function $hasManyName()\n    {\n        return \$this->hasMany(\\App\\Models\\$childModel::class, '$childCol', '$parentCol');\n    }\n";
        if (strpos($pcontent, "function $hasManyName(") === false){
            $pcontent = preg_replace('/}\s*$/','    '.$pmethod."}\n", $pcontent);
            file_put_contents($parentModelPath, $pcontent);
            echo "Added hasMany $hasManyName to $parentModel\n";
        }
    }

    // Update Filament Resource for child: replace TextInput FK with BelongsToSelect and add table column for relation
    $resourceDir = __DIR__.'/../app/Filament/Resources/'.studly($child);
    $resourcePath = $resourceDir.'/'.$childModel.'Resource.php';
    if (file_exists($resourcePath)){
        $rcontent = file_get_contents($resourcePath);
        // replace TextInput::make('childCol') line
        $pattern = "/TextInput::make\('".$childCol."'\)[^,\n]*(?:->label\([^\)]*\))?[^,\n]*,/";
        $replacement = "\\Filament\\Forms\\Components\\BelongsToSelect::make('$childCol')->relationship('$belongsToName','$display')->label('".ucwords(str_replace('_',' ',$belongsToName))."'),";
        $new = preg_replace($pattern, $replacement, $rcontent);
        if ($new !== $rcontent){
            file_put_contents($resourcePath, $new);
            echo "Updated Resource form for $child: replaced $childCol with BelongsToSelect\n";
        }
        // update table: replace TextColumn for childCol with relation column
        $pattern2 = "/TextColumn::make\('".$childCol."'\)[^,\n]*(?:->label\([^\)]*\))?[^,\n]*,/";
        $replacement2 = "\\Filament\\Tables\\Columns\\TextColumn::make('$belongsToName.$display')->label('".ucwords(str_replace('_',' ',$belongsToName))."'),";
        $new2 = preg_replace($pattern2, $replacement2, $new);
        if ($new2 !== $new){
            file_put_contents($resourcePath, $new2);
            echo "Updated Resource table for $child: show $belongsToName.$display\n";
        }
    }
}

echo "Relations applied.\n";
