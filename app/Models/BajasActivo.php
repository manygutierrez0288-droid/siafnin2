<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BajasActivo extends Model
{
    protected $table = 'bajas_activos';
    protected $primaryKey = 'idBaja';
    public $timestamps = false;

    protected $fillable = [
        'idActivoFijo',
        'fecha',
        'motivo',
        'idUsuario',
        'fechaCreacion',
        // Solo estos campos deben estar aquí
        // Si tu tabla tiene más (ej. 'documento_autorizacion', 'valor_residual_final'), añádelos con comas:
        // 'documento_autorizacion',
        // 'valor_residual_final',
    ];

    protected $casts = [
        'fecha' => 'date',
        'fechaCreacion' => 'datetime',
    ];

    // Relaciones
    public function activo()
    {
        return $this->belongsTo(ActivoFijo::class, 'idActivoFijo', 'idActivoFijo');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario', 'idUsuario');
    }
}