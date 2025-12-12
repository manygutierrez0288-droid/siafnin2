<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos';
    protected $primaryKey = 'idDepartamento';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'activo',
        // Solo estos campos deben estar aquí
        // Si tu tabla tiene más (ej. 'direccion', 'telefono', 'encargado'), añádelos con comas:
        // 'direccion',
        // 'telefono',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Relación: un departamento puede tener muchos activos fijos
    public function activos()
    {
        return $this->hasMany(ActivoFijo::class, 'idDepartamento', 'idDepartamento');
    }
}