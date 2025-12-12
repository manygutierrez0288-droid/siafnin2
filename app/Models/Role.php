<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';

protected $primaryKey = 'idRol';

    protected $fillable = ['nombre',
        'idMarca',
        'idModelo',
        'idColor',
        'idCategoria',
        'idDepartamento',
        'idUbicacion',
        'idFuente',
        'idProveedor',
        'idResponsable',
        'idEstado',
        'idUsuarioCreacion',
        'idUsuarioUltimaModificacion',
        'idActivoFijo',
        'idEstadoAnterior',
        'idEstadoNuevo',
        'idUsuario',
        'idUbicacionOrigen',
        'idUbicacionDestino',
        'idResponsableOrigen',
        'idResponsableDestino',
    ];
    
    public function usuarioRol()
    {
        return $this->hasMany(\App\Models\UsuarioRol::class, 'idRol', 'idRol');
    }
}
