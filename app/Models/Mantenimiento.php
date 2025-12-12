<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $table = 'mantenimientos';
    protected $primaryKey = 'idMantenimiento';
    public $timestamps = false; // si usas fechas personalizadas

    protected $fillable = [
        'idActivoFijo',
        'fecha',
        'descripcion',
        'costo',
        'idTecnico',
        'idProveedor',
        'idEstado', // ← estado del mantenimiento (ej. programado, completado, cancelado)
        'idUsuario',
        'fechaCreacion',
        // Solo estos campos deben estar aquí
        // Si tu tabla tiene más (ej. 'tipo', 'observaciones', 'activo'), añádelos con comas
    ];

    protected $casts = [
        'costo' => 'decimal:2',
        'fecha' => 'date',
        'fechaCreacion' => 'datetime',
    ];

    // Relaciones
    public function activo()
    {
        return $this->belongsTo(ActivoFijo::class, 'idActivoFijo', 'idActivoFijo');
    }

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class, 'idTecnico', 'idTecnico');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'idProveedor', 'idProveedor');
    }

    // ⚠️ IMPORTANTE: ¿Qué representa `idEstado`?
    // Si es el estado DEL MANTENIMIENTO (no del activo), crea un modelo `EstadoMantenimiento`
    // Por ahora, asumimos que es una tabla `estados_mantenimiento`
    public function estado()
    {
        return $this->belongsTo(EstadoMantenimiento::class, 'idEstado', 'idEstado');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario', 'idUsuario');
    }
}