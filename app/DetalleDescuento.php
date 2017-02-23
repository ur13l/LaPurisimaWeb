<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleDescuento extends Model
{
    protected $fillable = [
            'pedido_id',
            'descuento_id',
            'descuento',
            'cantidad'
        ];


    public function pedido(){
        return $this->belongsTo('App\Pedido', 'pedido_id');
    }

    public function descuento(){
        return $this->belongsTo('App\Descuento', 'descuento_id');
    }
}
