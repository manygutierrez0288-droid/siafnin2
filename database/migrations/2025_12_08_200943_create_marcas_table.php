<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('marcas')) {
            Schema::create('marcas', function (Blueprint $table) {
                $table->increments('idMarca');
                $table->string('nombre',100)->nullable(false)->unique();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('marcas')) {
            Schema::dropIfExists('marcas');
        }
    }
};
