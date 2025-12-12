<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculos';
    protected $primaryKey = 'idVehiculo';
    public $timestamps = false; // tus fechas son personalizadas

    protected $fillable = [
        'placa',
        'numeroMotor',
        'chasis',
        'anio',
        'idActivoFijo',
        'fechaCreacion',
        'fechaActualizacion',
        // Solo campos que existan EN LA TABLA `vehiculos`
        // Si tu tabla tiene más campos reales (ej. idMarca), añádelos aquí con comas
    ];

    // Relación: un vehículo PERTENECE a un activo fijo
    public function activoFijo() // ← singular, coherente
    {
        return $this->belongsTo(ActivoFijo::class, 'idActivoFijo', 'idActivoFijo');
    }
}
