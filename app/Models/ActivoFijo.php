<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivoFijo extends Model
{
    use HasFactory;

    protected $table = 'activos_fijos';
    protected $primaryKey = 'idActivoFijo';
    public $timestamps = false; // ← IMPORTANTE: tus campos de fecha son personalizados

    protected $fillable = [
        'nombre',
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
        'fechaAdquisicion',
        'valorAdquisicion',
        'vidaUtilAnios',
        'valorResidual',
        'depreciacionAcumulada',
        'idUsuarioCreacion',
        'fechaCreacion',
        'idUsuarioUltimaModificacion',
        'fechaUltimaModificacion',
    ];

    // Relaciones (con nombres claros y coherentes)
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'idMarca');
    }

    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'idModelo');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'idColor'); // ← mejor nombre: Color (no Colore)
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'idDepartamento');
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'idUbicacion'); // ← Ubicacion (no Ubicacione)
    }

    public function fuente()
    {
        return $this->belongsTo(Fuente::class, 'idFuente');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'idProveedor'); // ← Proveedor (no Proveedore)
    }

    public function responsable()
    {
        return $this->belongsTo(PersonalResponsable::class, 'idResponsable');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoActivo::class, 'idEstado'); // ← EstadoActivo (no EstadosActivo)
    }

    // ✅ Después
public function creadoPor()
{
    return $this->belongsTo(Usuario::class, 'idUsuarioCreacion', 'idUsuario');
}

public function actualizadoPor()
{
    return $this->belongsTo(Usuario::class, 'idUsuarioUltimaModificacion', 'idUsuario');
}

    // Relaciones inversas (hasMany)
    public function bajas()
    {
        return $this->hasMany(BajaActivo::class, 'idActivoFijo'); // ← BajaActivo (singular)
    }

    public function cambiosEstado()
    {
        return $this->hasMany(CambioEstado::class, 'idActivoFijo'); // ← CambioEstado
    }

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class, 'idActivoFijo');
    }

    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'idActivoFijo');
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class, 'idActivoFijo');
    }

    public function auditorias()
    {
        return $this->hasMany(AuditoriaActivo::class, 'idActivoFijo');
    }
}