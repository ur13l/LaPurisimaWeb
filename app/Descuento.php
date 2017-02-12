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

    public function producto(){
        return $this->belongsTo("App\Producto", "producto_id");
    }

    public function user(){
        return $this->belongsTo("App\User")->select(array(
            'id','nombre', 'email', 'imagen_usuario'
        ));
    }
}
