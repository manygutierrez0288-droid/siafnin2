<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->increments('idUsuario');
                $table->string('nombre',100)->nullable(false);
                $table->string('email',100)->nullable(false)->unique();
                $table->string('password_hash',255)->nullable(false);
                $table->integer('idUsuarioCreacion')->nullable(false);
                $table->dateTime('fechaCreacion');
                $table->integer('idUsuarioUltimaModificacion')->nullable();
                $table->dateTime('fechaUltimaModificacion')->nullable();
                $table->boolean('activo');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('usuarios')) {
            Schema::dropIfExists('usuarios');
        }
    }
};
