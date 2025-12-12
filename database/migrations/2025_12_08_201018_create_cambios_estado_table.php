<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('cambios_estado')) {
            Schema::create('cambios_estado', function (Blueprint $table) {
                $table->increments('idCambio');
                $table->integer('idActivoFijo')->nullable(false);
                $table->integer('idEstadoAnterior')->nullable(false);
                $table->integer('idEstadoNuevo')->nullable(false);
                $table->dateTime('fecha');
                $table->integer('idUsuario')->nullable(false);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('cambios_estado')) {
            Schema::dropIfExists('cambios_estado');
        }
    }
};
