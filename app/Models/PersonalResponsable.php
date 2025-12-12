<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalResponsable extends Model
{
    protected $table = 'personal_responsable';
    protected $primaryKey = 'idResponsable';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'idCargo',
        'numero_cedula',
        'telefono',
        'email',
        'activo',
        // Solo estos campos deben estar aquí
        // Si tu tabla tiene más (ej. 'direccion', 'fecha_ingreso'), añádelos con comas
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Relaciones
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'idCargo', 'idCargo');
    }

    public function activos()
    {
        return $this->hasMany(ActivoFijo::class, 'idResponsable', 'idResponsable');
    }

    public function movimientosOrigen()
    {
        return $this->hasMany(Movimiento::class, 'idResponsableOrigen', 'idResponsable');
    }

    public function movimientosDestino()
    {
        return $this->hasMany(Movimiento::class, 'idResponsableDestino', 'idResponsable');
    }
}