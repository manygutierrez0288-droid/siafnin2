<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('categorias')) {
            Schema::create('categorias', function (Blueprint $table) {
                $table->increments('idCategoria');
                $table->string('nombre',100)->nullable(false)->unique();
                $table->boolean('activo');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('categorias')) {
            Schema::dropIfExists('categorias');
        }
    }
};
