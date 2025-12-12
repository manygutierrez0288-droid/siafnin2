<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colore extends Model
{
    protected $table = 'colores';
    protected $primaryKey = 'idColor';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        // Solo este campo debe estar aquí
        // Si tu tabla tiene más (ej. 'codigo_hex', 'activo'), añádelos con comas:
        // 'codigo_hex',
        // 'activo',
    ];

    // Relación: un color puede tener muchos activos fijos
    public function activos()
    {
        return $this->hasMany(ActivoFijo::class, 'idColor', 'idColor');
    }
}