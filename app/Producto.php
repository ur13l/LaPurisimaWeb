<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
  protected $fillable = [
    'id',
    'nombre',
    'stock',
    'contenido',
    'precio',
    'imagen'
  ];

}
