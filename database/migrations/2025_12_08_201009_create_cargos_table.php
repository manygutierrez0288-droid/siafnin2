<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('cargos')) {
            Schema::create('cargos', function (Blueprint $table) {
                $table->increments('idCargo');
                $table->string('nombre',100)->nullable(false)->unique();
                $table->text('descripcion')->nullable();
                $table->boolean('activo');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('cargos')) {
            Schema::dropIfExists('cargos');
        }
    }
};
