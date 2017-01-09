<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Descuento extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id',
        'user_id',
        'producto_id',
        'descuento',
        'descuento_porcentaje',
        'fecha_vencimiento',
        'usos_restantes'
    ];

    protected $dates = ['deleted_at'];
}
