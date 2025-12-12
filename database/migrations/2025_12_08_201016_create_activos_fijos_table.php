<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('activos_fijos')) {
            Schema::create('activos_fijos', function (Blueprint $table) {
                $table->increments('idActivoFijo');
                $table->string('nombre',255)->nullable(false);
                $table->integer('idMarca')->nullable();
                $table->integer('idModelo')->nullable();
                $table->integer('idColor')->nullable();
                $table->integer('idCategoria')->nullable(false);
                $table->integer('idDepartamento')->nullable(false);
                $table->integer('idUbicacion')->nullable(false);
                $table->integer('idFuente')->nullable(false);
                $table->integer('idProveedor')->nullable();
                $table->integer('idResponsable')->nullable(false);
                $table->integer('idEstado')->nullable(false);
                $table->date('fechaAdquisicion')->nullable(false);
                $table->decimal('valorAdquisicion',12,2)->nullable(false);
                $table->integer('vidaUtilAnios')->nullable();
                $table->decimal('valorResidual',12,2)->nullable();
                $table->decimal('depreciacionAcumulada',12,2);
                $table->integer('idUsuarioCreacion')->nullable(false);
                $table->dateTime('fechaCreacion');
                $table->integer('idUsuarioUltimaModificacion')->nullable();
                $table->dateTime('fechaUltimaModificacion')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('activos_fijos')) {
            Schema::dropIfExists('activos_fijos');
        }
    }
};
