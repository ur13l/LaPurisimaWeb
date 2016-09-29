<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Si el usuario es diferente del usuario común
        if(Auth::user()->tipo_usuario_id == 1) {
            return $next($request);
        }
        return redirect()->action('HomeController@index');
    }
}
