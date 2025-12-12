<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaActivo extends Model
{
    protected $table = 'auditoria_activos';
    protected $primaryKey = 'idAuditoria';
    public $timestamps = false;

    protected $fillable = [
        'idActivoFijo',
        'idUsuario',
        'tipo',
        'detalle',
        'fecha',
        // Solo estos campos deben estar aquí
            'fecha',
        // 'resultado',
        // 'documento',
    ];

    protected $casts = [
        'fecha' => 'datetime',
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