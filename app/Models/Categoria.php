<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'idCategoria';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'activo',
        // Solo estos campos deben estar aquí
        // Si tu tabla tiene más (ej. 'descripcion', 'codigo'), añádelos con comas:
        // 'descripcion',
        // 'codigo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Relación: una categoría puede tener muchos activos fijos
    public function activos()
    {
        return $this->hasMany(ActivoFijo::class, 'idCategoria', 'idCategoria');
    }
}