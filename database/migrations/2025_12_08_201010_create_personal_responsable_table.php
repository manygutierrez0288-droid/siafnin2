<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('personal_responsable')) {
            Schema::create('personal_responsable', function (Blueprint $table) {
                $table->increments('idResponsable');
                $table->string('nombre',150)->nullable(false);
                $table->integer('idCargo')->nullable(false);
                $table->string('numero_cedula',20)->nullable(false)->unique();
                $table->string('telefono',30)->nullable();
                $table->string('email',100)->nullable();
                $table->boolean('activo');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('personal_responsable')) {
            Schema::dropIfExists('personal_responsable');
        }
    }
};
