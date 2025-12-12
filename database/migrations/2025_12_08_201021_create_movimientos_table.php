<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('movimientos')) {
            Schema::create('movimientos', function (Blueprint $table) {
                $table->increments('idMovimiento');
                $table->integer('idActivoFijo')->nullable(false);
                $table->integer('idUbicacionOrigen')->nullable(false);
                $table->integer('idUbicacionDestino')->nullable(false);
                $table->integer('idResponsableOrigen')->nullable(false);
                $table->integer('idResponsableDestino')->nullable(false);
                $table->dateTime('fecha');
                $table->text('motivo')->nullable(false);
                $table->integer('idUsuario')->nullable(false);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('movimientos')) {
            Schema::dropIfExists('movimientos');
        }
    }
};
