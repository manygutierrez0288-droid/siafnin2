<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('usuario_rol')) {
            Schema::create('usuario_rol', function (Blueprint $table) {
                $table->integer('idUsuario');
                $table->integer('idRol');
                $table->string('primary');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('usuario_rol')) {
            Schema::dropIfExists('usuario_rol');
        }
    }
};
