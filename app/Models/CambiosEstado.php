<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CambiosEstado extends Model
{
    protected $table = 'cambios_estado';
    protected $primaryKey = 'idCambio';
    public $timestamps = false;

    protected $fillable = [
        'idActivoFijo',
        'idEstadoAnterior',
        'idEstadoNuevo',
        'fecha',
        'idUsuario',
        // Solo estos campos deben estar aquí
        // Si tu tabla tiene más (ej. 'motivo', 'observaciones'), añádelos con comas:
        // 'motivo',
        // 'observaciones',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    // Relaciones
    public function activo()
    {
        return $this->belongsTo(ActivoFijo::class, 'idActivoFijo', 'idActivoFijo');
    }

    public function estadoAnterior()
    {
        return $this->belongsTo(EstadoActivo::class, 'idEstadoAnterior', 'idEstado');
    }

    public function estadoNuevo()
    {
        return $this->belongsTo(EstadoActivo::class, 'idEstadoNuevo', 'idEstado');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario', 'idUsuario');
    }
}