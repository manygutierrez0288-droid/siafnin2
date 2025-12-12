<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('tecnicos')) {
            Schema::create('tecnicos', function (Blueprint $table) {
                $table->increments('idTecnico');
                $table->string('nombre',150)->nullable(false);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('tecnicos')) {
            Schema::dropIfExists('tecnicos');
        }
    }
};
