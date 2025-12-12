<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'cargos';
    protected $primaryKey = 'idCargo';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
        // Solo estos campos deben estar aquí
        // Si tu tabla tiene más (ej. 'nivel', 'departamento_id'), añádelos con comas:
        // 'nivel',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Relación: un cargo puede tener varios personal responsable
    public function personal()
    {
        return $this->hasMany(PersonalResponsable::class, 'idCargo', 'idCargo');
    }
}