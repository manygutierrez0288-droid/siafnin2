<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = 'ubicaciones';
    protected $primaryKey = 'idUbicacion';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo', // ← ✅ ahora sí tiene coma
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function activos()
    {
        return $this->hasMany(ActivoFijo::class, 'idUbicacion', 'idUbicacion');
    }

    public function movimientosOrigen()
    {
        return $this->hasMany(Movimiento::class, 'idUbicacionOrigen', 'idUbicacion');
    }

    public function movimientosDestino()
    {
        return $this->hasMany(Movimiento::class, 'idUbicacionDestino', 'idUbicacion');
    }
}