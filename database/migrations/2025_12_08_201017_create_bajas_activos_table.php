<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('bajas_activos')) {
            Schema::create('bajas_activos', function (Blueprint $table) {
                $table->increments('idBaja');
                $table->integer('idActivoFijo')->nullable(false);
                $table->date('fecha')->nullable(false);
                $table->text('motivo')->nullable(false);
                $table->integer('idUsuario')->nullable(false);
                $table->dateTime('fechaCreacion');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('bajas_activos')) {
            Schema::dropIfExists('bajas_activos');
        }
    }
};
