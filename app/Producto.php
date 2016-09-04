<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id',
        'nombre',
        'stock',
        'contenido',
        'precio',
        'imagen'
    ];

    protected $dates = ['deleted_at'];

}
