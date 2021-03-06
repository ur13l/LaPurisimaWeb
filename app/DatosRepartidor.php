<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DatosRepartidor extends Model
{
    use SoftDeletes;
    const ACTIVO = 1;
    const INACTIVO = 2;

    protected $table = "datos_repartidores";
    protected  $fillable =  [
        'id',
        'user_id',
        'latitud',
        'longitud',
        'status'
    ];
    protected $dates = ['deleted_at'];


    public function productos(){
        return $this->belongsToMany("App\Producto", "stock_repartidor")->withPivot('cantidad');
    }

    public function user(){
        return $this->belongsTo("App\User")->select(array(
            'id','nombre', 'email', 'imagen_usuario','telefono'
        ));
    }
}
