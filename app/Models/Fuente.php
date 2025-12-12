<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fuente extends Model
{
    protected $table = 'fuentes';
    protected $primaryKey = 'idFuente';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        // Solo este campo debe estar aquí (o añade más si tu tabla los tiene, ej. 'descripcion', 'activo')
        // 'descripcion',
        // 'activo',
    ];

    // Relación: una fuente puede tener muchos activos fijos
    public function activos()
    {
        return $this->hasMany(ActivoFijo::class, 'idFuente', 'idFuente');
    }
}