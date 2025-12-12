<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //CATALOGO BASICO
    // TABLA FUENTES//
    public function up(): void
    {
        Schema::create('fuentes', function (Blueprint $table) {
            $table->id();
             $table->string('nombre', 100)->unique();
            $table->timestamps(); // created_at, updated_at
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuentes');
    }
};
