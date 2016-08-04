<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  protected $fillable = [
    'nombre',
    'email',
    'password',
    'calle',
    'colonia',
    'referencia',
    'codigo_postal',
    'imagen_usuario',
    'tipo_usuario_id',
    'remember_token'
  ];
  protected $hidden = [
      'password',
      'remember_token'
  ];

  public function setPasswordAttribute($value) {
    $this->attributes['password'] = bcrypt($value);
  }
}
