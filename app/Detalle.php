<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detalle extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'producto_id',
        'pedido_id',
        'cantidad'
    ];

    public function producto(){
        return $this->belongsTo('App\Producto')->select(array(
            'id', 'nombre', 'contenido', 'precio', 'imagen'
        ));
    }

    public function pedido(){
        return $this->belongsTo('App\Pedido');
    }
}
