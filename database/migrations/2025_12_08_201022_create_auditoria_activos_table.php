<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('auditoria_activos')) {
            Schema::create('auditoria_activos', function (Blueprint $table) {
                $table->increments('idAuditoria');
                $table->integer('idActivoFijo')->nullable(false);
                $table->integer('idUsuario')->nullable(false);
                $table->string('tipo',30)->nullable(false);
                $table->text('detalle')->nullable();
                $table->dateTime('fecha');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('auditoria_activos')) {
            Schema::dropIfExists('auditoria_activos');
        }
    }
};
