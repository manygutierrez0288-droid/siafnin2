<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimientos';
    protected $primaryKey = 'idMovimiento';
    public $timestamps = false;

    protected $fillable = [
        'idActivoFijo',
        'idUbicacionOrigen',
        'idUbicacionDestino',
        'idResponsableOrigen',
        'idResponsableDestino',
        'fecha',
        'motivo',
        'idUsuario',
        // Solo estos campos deben estar aquí
        // Si tu tabla tiene más (ej. 'aprobado', 'observaciones'), añádelos con comas
    ];

    // Relaciones
    public function activo()
    {
        return $this->belongsTo(ActivoFijo::class, 'idActivoFijo', 'idActivoFijo');
    }

    public function ubicacionOrigen()
    {
        return $this->belongsTo(Ubicacion::class, 'idUbicacionOrigen', 'idUbicacion');
    }

    public function ubicacionDestino()
    {
        return $this->belongsTo(Ubicacion::class, 'idUbicacionDestino', 'idUbicacion');
    }

    public function responsableOrigen()
    {
        return $this->belongsTo(PersonalResponsable::class, 'idResponsableOrigen', 'idResponsable');
    }

    public function responsableDestino()
    {
        return $this->belongsTo(PersonalResponsable::class, 'idResponsableDestino', 'idResponsable');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario', 'idUsuario');
    }
}