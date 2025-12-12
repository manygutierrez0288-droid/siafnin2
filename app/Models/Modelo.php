<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    protected $table = 'modelos';
    protected $primaryKey = 'idModelo';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'idMarca',
        // Solo estos campos deben estar aquí
        // Si tu tabla tiene más (ej. 'anio', 'descripcion'), añádelos con comas:
        // 'anio',
        // 'descripcion',
    ];

    // Relación: un modelo pertenece a una marca
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'idMarca', 'idMarca');
    }

    // Relación: un modelo puede tener muchos activos fijos
    public function activos()
    {
        return $this->hasMany(ActivoFijo::class, 'idModelo', 'idModelo');
    }
}