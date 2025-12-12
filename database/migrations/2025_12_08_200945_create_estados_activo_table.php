<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('estados_activo')) {
            Schema::create('estados_activo', function (Blueprint $table) {
                $table->increments('idEstado');
                $table->string('nombre',50)->nullable(false)->unique();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('estados_activo')) {
            Schema::dropIfExists('estados_activo');
        }
    }
};
