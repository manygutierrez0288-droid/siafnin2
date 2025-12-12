<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoActivo extends Model
{
    protected $table = 'estados_activoS'; // ← si tu tabla es 'estados_activo', cámbialo aquí
    protected $primaryKey = 'idEstado';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        // Solo este campo debe estar aquí
        // Si tu tabla tiene más (ej. 'codigo', 'descripcion', 'color'), añádelos con comas:
        // 'codigo',
        // 'descripcion',
    ];

    // Relaciones
    public function activos()
    {
        return $this->hasMany(ActivoFijo::class, 'idEstado', 'idEstado');
    }

    public function cambiosOrigen()
    {
        return $this->hasMany(CambioEstado::class, 'idEstadoAnterior', 'idEstado');
    }

    public function cambiosDestino()
    {
        return $this->hasMany(CambioEstado::class, 'idEstadoNuevo', 'idEstado');
    }

    // ⚠️ ¿Relación con `Mantenimiento`?
    // Si `mantenimientos.idEstado` se refiere al estado DEL MANTENIMIENTO (no del activo),
    // entonces NO debe relacionarse con `EstadoActivo`.
    // En su lugar, usa `
}