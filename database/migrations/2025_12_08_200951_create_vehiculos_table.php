<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('vehiculos')) {
            Schema::create('vehiculos', function (Blueprint $table) {
                $table->increments('idVehiculo');
                $table->string('placa',20)->nullable(false)->unique();
                $table->string('numeroMotor',50)->nullable();
                $table->string('chasis',50)->nullable()->unique();
                $table->integer('anio')->nullable();
                $table->integer('idActivoFijo')->nullable(false)->unique();
                $table->dateTime('fechaCreacion');
                $table->dateTime('fechaActualizacion')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('vehiculos')) {
            Schema::dropIfExists('vehiculos');
        }
    }
};
