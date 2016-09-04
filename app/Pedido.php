<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'id',
        'cliente_id',
        'conductor_id',
        'total',
        'latitud',
        'longitud',
        'direccion'
    ];

    public function detalles(){
        return $this->hasMany('App\Detalle');
    }
}
