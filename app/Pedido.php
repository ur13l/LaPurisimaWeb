<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    /*
     * Definición de los estados de un pedido, campo "status" en la base de datos.
     */
    const SOLICITADO = 1;
    const ASIGNADO = 2;
    const EN_CAMINO = 3;
    const ENTREGADO = 4;
    const CANCELADO = 5;
    const FAILED = 6;

    protected $fillable = [
        'id',
        'cliente_id',
        'conductor_id',
        'total',
        'latitud',
        'longitud',
        'direccion',
        'status',
        'fecha'
    ];

    public function detalles(){
        return $this->hasMany('App\Detalle');
    }

    public function cliente(){
        return $this->belongsTo('App\User', 'cliente_id')->select(array(
            'id', 'nombre', 'email', 'imagen_usuario', 'telefono'
        ));
    }

    public function repartidor(){
        return $this->belongsTo('App\User', 'conductor_id')->select(array(
            'id','nombre', 'email', 'imagen_usuario', 'telefono'
        ));
    }

    protected $dates = ['fecha','deleted_at'];
}
