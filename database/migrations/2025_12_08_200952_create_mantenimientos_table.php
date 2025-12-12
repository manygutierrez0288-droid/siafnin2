<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('mantenimientos')) {
            Schema::create('mantenimientos', function (Blueprint $table) {
                $table->increments('idMantenimiento');
                $table->integer('idActivoFijo')->nullable(false);
                $table->date('fecha')->nullable(false);
                $table->text('descripcion')->nullable(false);
                $table->decimal('costo',12,2)->nullable();
                $table->integer('idTecnico')->nullable();
                $table->integer('idProveedor')->nullable();
                $table->integer('idEstado')->nullable(false);
                $table->integer('idUsuario')->nullable(false);
                $table->dateTime('fechaCreacion');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('mantenimientos')) {
            Schema::dropIfExists('mantenimientos');
        }
    }
};
