<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioRol extends Model
{
    protected $table = 'usuario_rol';
    public $timestamps = false; // si no usas created_at/updated_at

    protected $fillable = [
        'idUsuario',
        'idRol',
        'primary', // ← solo si este campo EXISTE en tu tabla
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario', 'idUsuario');
    }

    public function rol() // ← nombre en español, coherente
    {
        return $this->belongsTo(Rol::class, 'idRol', 'idRol');
    }
}