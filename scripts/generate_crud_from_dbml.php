<?php
// Simple DBML -> Laravel scaffolder (models, migrations, filament resources)
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Str;

$path = __DIR__.'/../public/basedatos.dbml';
if (!file_exists($path)) {
    echo "DBML file not found: $path\n";
    exit(1);
}
$txt = file_get_contents($path);

// Extract Table blocks
preg_match_all('/Table\s+(\w+)\s*\{([^}]*)\}/m', $txt, $matches, PREG_SET_ORDER);
if (empty($matches)) {
    echo "No tables found in DBML.\n";
    exit(0);
}

foreach ($matches as $m) {
    $table = trim($m[1]);
    $body = trim($m[2]);
    $lines = preg_split('/\r?\n/', $body);
    $cols = [];
    $primary = null;
    foreach ($lines as $ln) {
        $ln = trim($ln);
        if ($ln === '' || strpos($ln, '//') === 0) continue;
        // parse: name type [attrs] or name type
        if (!preg_match('/^(\w+)\s+(\w+(?:\([^)]*\))?)(?:\s*\[(.*)\])?/', $ln, $c)) continue;
        $col = $c[1];
        $type = $c[2];
        $attrs = isset($c[3]) ? $c[3] : '';
        $cols[] = ['name'=>$col,'type'=>$type,'attrs'=>$attrs];
        if (strpos($attrs, 'pk') !== false) {
            $primary = $col;
        }
    }

    // Generate model
    $class = Str::studly(Str::singular($table));
    $modelPath = __DIR__.'/../app/Models/'.$class.'.php';
    $fillable = [];
    foreach ($cols as $col) {
        if ($col['name'] === $primary) continue;
        $fillable[] = "'".$col['name']."'";
    }
    $primaryKeyLine = ($primary && $primary !== 'id') ? "\n    protected \$primaryKey = '$primary';\n" : '';
    $tableLine = ($table !== Str::plural(Str::snake($class))) ? "\n    protected \$table = '$table';\n" : '';
    $modelTemplate = "<?php\n\nnamespace App\\Models;\n\nuse Illuminate\\Database\\Eloquent\\Factories\\HasFactory;\nuse Illuminate\\Database\\Eloquent\\Model;\n\nclass $class extends Model\n{\n    use HasFactory;\n";
    if ($tableLine) $modelTemplate .= "    protected \$table = '$table';\n";
    if ($primaryKeyLine) $modelTemplate .= "    protected \$primaryKey = '$primary';\n";
    $modelTemplate .= "\n    protected \$fillable = [\n        ".implode(', ', $fillable)."\n    ];\n}\n";

    // write model
    if (!file_exists($modelPath)) {
        file_put_contents($modelPath, $modelTemplate);
        echo "Model created: $modelPath\n";
    } else {
        echo "Model exists, skipping: $modelPath\n";
    }

    // Generate migration (safe: only create if not exists) - timestamped
    $timestamp = date('Y_m_d_His', time());
    $migrationName = $timestamp.'_create_'.Str::snake($table).'_table.php';
    $migrationPath = __DIR__.'/../database/migrations/'.$migrationName;
    if (!file_exists($migrationPath)) {
        $mig = "<?php\n\nuse Illuminate\\Database\\Migrations\\Migration;\nuse Illuminate\\Database\\Schema\\Blueprint;\nuse Illuminate\\Support\\Facades\\Schema;\n\nreturn new class extends Migration\n{\n    public function up(): void\n    {\n        if (! Schema::hasTable('$table')) {\n            Schema::create('$table', function (Blueprint $table) {\n";
        foreach ($cols as $col) {
            $cname = $col['name'];
            $ctype = $col['type'];
            $attrs = $col['attrs'];
            // simple type mapping
            if (strpos($attrs, 'pk') !== false && strpos($attrs, 'increment') !== false) {
                $mig .= "                \$table->increments('$cname');\n";
                continue;
            }
            if (stripos($ctype, 'varchar') !== false) {
                if (preg_match('/varchar\((\d+)\)/i',$ctype,$g)) $len = $g[1]; else $len = 255;
                $mig .= "                \$table->string('$cname',$len)";
            } elseif (stripos($ctype,'integer')!==false) {
                $mig .= "                \$table->integer('$cname')";
            } elseif (stripos($ctype,'decimal')!==false) {
                $mig .= "                \$table->decimal('$cname',12,2)";
            } elseif (stripos($ctype,'text')!==false) {
                $mig .= "                \$table->text('$cname')";
            } elseif (stripos($ctype,'boolean')!==false) {
                $mig .= "                \$table->boolean('$cname')";
            } elseif (stripos($ctype,'datetime')!==false) {
                $mig .= "                \$table->dateTime('$cname')";
            } elseif (stripos($ctype,'date')!==false) {
                $mig .= "                \$table->date('$cname')";
            } else {
                $mig .= "                \$table->string('$cname')";
            }
            if (strpos($attrs,'not null') !== false) {
                $mig .= "->nullable(false)";
            } else {
                if (strpos($attrs,'null') !== false) $mig .= "->nullable()";
            }
            if (strpos($attrs,'unique') !== false) $mig .= "->unique()";
            $mig .= ";\n";
        }
        $mig .= "            });\n        }\n    }\n\n    public function down(): void\n    {\n        if (Schema::hasTable('$table')) {\n            Schema::dropIfExists('$table');\n        }\n    }\n};\n";
        file_put_contents($migrationPath, $mig);
        echo "Migration created: $migrationPath\n";
        // sleep 1 to get different timestamps
        sleep(1);
    } else {
        echo "Migration exists, skipping: $migrationPath\n";
    }

    // Generate Filament Resource (basic)
    $resourceDir = __DIR__.'/../app/Filament/Resources/'.Str::studly($table);
    if (!is_dir($resourceDir)) mkdir($resourceDir, 0755, true);
    $resourceClass = Str::studly(Str::singular($table))."Resource";
    $resourcePath = $resourceDir.'/'.$resourceClass.'.php';
    if (!file_exists($resourcePath)) {
        $fields = [];
        $columns = [];
        foreach ($cols as $col) {
            $cname = $col['name'];
            if ($cname === $primary) continue;
            $fields[] = "                \Filament\\Forms\\Components\\TextInput::make('$cname')->label('".Str::title(str_replace('_',' ',$cname))."')";
            $columns[] = "                \Filament\\Tables\\Columns\\TextColumn::make('$cname')->label('".Str::title(str_replace('_',' ',$cname))."')";
        }
        // Escape $model variable in the template so PHP doesn't try to interpolate it when building the string
        $modelClass = Str::studly(Str::singular($table));
        $resourceTpl = "<?php\n\nnamespace App\\Filament\\Resources\\".Str::studly($table).";\n\nuse App\\Filament\\Resources\\".Str::studly($table)."\\Pages\\List".Str::studly($table)."s;\nuse App\\Filament\\Resources\\".Str::studly($table)."\\Pages\\Create".Str::studly($table).";\nuse App\\Filament\\Resources\\".Str::studly($table)."\\Pages\\Edit".Str::studly($table).";\nuse App\\Models\\$modelClass;\nuse Filament\\Resources\\Resource;\nuse Filament\\Schemas\\Schema;\nuse Filament\\Tables\\Table;\n\nclass $resourceClass extends Resource\n{\n    protected static ?string \$model = $modelClass::class;\n\n    public static function form(Schema \$schema): Schema\n    {\n        return \$schema->components([\n".implode(",\n", $fields)."\n        ]);\n    }\n\n    public static function table(Table \$table): Table\n    {\n        return \$table->columns([\n".implode(",\n", $columns)."\n        ]);\n    }\n\n    public static function getPages(): array\n    {\n        return [\n            'index' => List".Str::studly($table)."s::route('/'),\n            'create' => Create".Str::studly($table)."::route('/create'),\n            'edit' => Edit".Str::studly($table)."::route('/{record}/edit'),\n        ];\n    }\n}\n";
        file_put_contents($resourcePath, $resourceTpl);
        echo "Resource created: $resourcePath\n";

        // Create Pages folder and simple pages
        $pagesDir = $resourceDir.'/Pages';
        if (!is_dir($pagesDir)) mkdir($pagesDir,0755,true);
        $listPage = "<?php\n\nnamespace App\\Filament\\Resources\\".Str::studly($table)."\\Pages;\n\nuse App\\Filament\\Resources\\".Str::studly($table)."\\".Str::studly(Str::singular($table))."Resource;\nuse Filament\\Resources\\Pages\\ListRecords;\n\nclass List".Str::studly($table)."s extends ListRecords\n{\n    protected static string \$resource = ".Str::studly(Str::singular($table))."Resource::class;\n}\n";
        file_put_contents($pagesDir.'/List'.Str::studly($table).'s.php',$listPage);
        $createPage = "<?php\n\nnamespace App\\Filament\\Resources\\".Str::studly($table)."\\Pages;\n\nuse App\\Filament\\Resources\\".Str::studly($table)."\\".Str::studly(Str::singular($table))."Resource;\nuse Filament\\Resources\\Pages\\CreateRecord;\n\nclass Create".Str::studly($table)." extends CreateRecord\n{\n    protected static string \$resource = ".Str::studly(Str::singular($table))."Resource::class;\n}\n";
        file_put_contents($pagesDir.'/Create'.Str::studly($table).'.php',$createPage);
        $editPage = "<?php\n\nnamespace App\\Filament\\Resources\\".Str::studly($table)."\\Pages;\n\nuse App\\Filament\\Resources\\".Str::studly($table)."\\".Str::studly(Str::singular($table))."Resource;\nuse Filament\\Resources\\Pages\\EditRecord;\n\nclass Edit".Str::studly($table)." extends EditRecord\n{\n    protected static string \$resource = ".Str::studly(Str::singular($table))."Resource::class;\n}\n";
        file_put_contents($pagesDir.'/Edit'.Str::studly($table).'.php',$editPage);
    } else {
        echo "Resource exists, skipping: $resourcePath\n";
    }
}

echo "Done.\n";
