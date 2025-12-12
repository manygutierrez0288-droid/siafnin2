<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('modelos')) {
            Schema::create('modelos', function (Blueprint $table) {
                $table->increments('idModelo');
                $table->string('nombre',100)->nullable(false);
                $table->integer('idMarca')->nullable(false);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('modelos')) {
            Schema::dropIfExists('modelos');
        }
    }
};
