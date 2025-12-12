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
    // TABLA PERSONAL RESPONSABLE
    public function up(): void
    {
        Schema::create('personal_responsable', function (Blueprint $table) {
            $table->id();
             $table->string('nombre', 150);
            $table->foreignId('idCargo')->constrained('cargos'); // FK a cargos.id
            $table->string('numero_cedula', 20)->unique();
            $table->string('telefono', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_responsable');
    }
};
