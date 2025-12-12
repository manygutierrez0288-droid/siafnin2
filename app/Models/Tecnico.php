<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tecnico extends Model
{
    protected $table = 'tecnicos';
    protected $primaryKey = 'idTecnico';
    public $timestamps = false; // si no usas created_at/updated_at

    protected $fillable = [
        'nombre',
        // Solo estos campos deben estar aquí
        // Si tu tabla tiene más (ej. 'telefono', 'especialidad', 'activo'), añádelos:
        // 'telefono',
        // 'especialidad',
        // 'activo',
    ];

    // Relación: un técnico puede tener muchos mantenimientos
    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'idTecnico', 'idTecnico');
    }
}