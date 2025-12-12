<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('proveedores')) {
            Schema::create('proveedores', function (Blueprint $table) {
                $table->increments('idProveedor');
                $table->string('nombre',100)->nullable(false);
                $table->string('numero_ruc',20)->unique();
                $table->string('telefono',20)->nullable();
                $table->string('email',100)->nullable();
                $table->text('direccion')->nullable();
                $table->boolean('activo');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('proveedores')) {
            Schema::dropIfExists('proveedores');
        }
    }
};
