<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
  protected $fillable = [
    'nombre',
    'correo',
    'contrasena',
    'calle',
    'colonia',
    'referencia',
    'codigo_postal',
    'imagen_usuario',
    'tipo_usuario_id'
  ];
  protected $hidden = [
      'contrasena'
  ];

  public function setContrasenaAttribute($value) {
    $this->attributes['contrasena'] = bcrypt($value);
  }

}
