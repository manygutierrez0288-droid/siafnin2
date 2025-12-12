<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'idUsuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'email',
        'password_hash', // ⚠️ ¿seguro que no es 'password'? Verifica tu tabla
        'idUsuarioCreacion',
        'fechaCreacion',
        'idUsuarioUltimaModificacion',
        'fechaUltimaModificacion',
        'activo',
    ];

    // Para que Laravel use 'password_hash' como campo de contraseña
    protected $hidden = ['password_hash'];
    protected $casts = [
        'activo' => 'boolean',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash; // Laravel busca 'password' por defecto
    }

    // ✅ Relación muchos a muchos con roles (recomendado)
    public function roles()
    {
        return $this->belongsToMany(
            Rol::class,
            'usuario_rol',
            'idUsuario',
            'idRol'
        )->withPivot('primary');
    }

    // ✅ Rol principal (útil para el dashboard)
    public function rolPrincipal()
    {
        return $this->belongsToMany(Rol::class, 'usuario_rol', 'idUsuario', 'idRol')
                    ->wherePivot('primary', 1)
                    ->first();
    }

    // Relaciones con activos (solo si el usuario los crea)
    public function activosCreados()
    {
        return $this->hasMany(ActivoFijo::class, 'idUsuarioCreacion', 'idUsuario');
    }

    // ✅ Nombre más claro: no 'activosFijos', sino 'activosCreados'
}