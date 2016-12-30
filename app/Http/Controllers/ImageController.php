<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ImageController extends Controller
{

    public static function saveImage($data, $route, $name){
      list($type, $data) = explode(';', $data);
      list(, $data)      = explode(',', $data);
      list(,$ext)       = explode('/', $type);
      $data = base64_decode($data);
      $filePath = $route . $name . "." .$ext;
      file_put_contents($filePath, $data);
      return $filePath;
    }


    public static function eliminarImagen($url){
        $spl = explode("/", $url);
        if(count($spl) > 3) {
            $path = $spl[count($spl) - 3] . "/" . $spl[count($spl) - 2] . "/" . $spl[count($spl) - 1];
            if (file_exists($path))
                unlink($path);
        }
    }
}
