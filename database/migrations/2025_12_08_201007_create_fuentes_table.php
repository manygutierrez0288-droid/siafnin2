<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('fuentes')) {
            Schema::create('fuentes', function (Blueprint $table) {
                $table->increments('idFuente');
                $table->string('nombre',100)->nullable(false)->unique();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('fuentes')) {
            Schema::dropIfExists('fuentes');
        }
    }
};
