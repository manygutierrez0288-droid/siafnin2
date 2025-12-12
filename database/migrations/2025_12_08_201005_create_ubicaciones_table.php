<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('ubicaciones')) {
            Schema::create('ubicaciones', function (Blueprint $table) {
                $table->increments('idUbicacion');
                $table->string('nombre',100)->nullable(false);
                $table->text('descripcion')->nullable();
                $table->boolean('activo');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('ubicaciones')) {
            Schema::dropIfExists('ubicaciones');
        }
    }
};
