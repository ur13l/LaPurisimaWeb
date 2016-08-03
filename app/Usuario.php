<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
  protected $fillable = ['nombre', 'calle','colonia','referencia','codigo_postal', 'tipo_usuario_id'];

}
