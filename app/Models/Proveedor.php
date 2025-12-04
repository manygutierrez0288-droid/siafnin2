<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Proveedor extends Model
{
  protected $fillable = [
    'id',
    'nombre',
    'numero_ruc',
    'telefono',
    'email',
    'direccion',
  ];
}
