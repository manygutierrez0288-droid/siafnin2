<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'marcas';
    protected $primaryKey = 'idMarca';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        // Solo estos campos deben estar aquí
        // Si tu tabla tiene más (ej. 'activo', 'descripcion'), añádelos:
        // 'activo',
        // 'descripcion',
    ];

    // Relaciones
    public function modelos()
    {
        return $this->hasMany(Modelo::class, 'idMarca', 'idMarca');
    }

    public function activos()
    {
        return $this->hasMany(ActivoFijo::class, 'idMarca', 'idMarca');
    }
}