<?php

namespace App\Http\Middleware;

use Closure;

class Cors2
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
      /*

      header('Access-Control-Allow-Origin : *');
        header('Access-Control-Allow-Headers : Content-type, X-Auth-Token, Authorization, Origin');
        return $next($request);
*/

       return $next($request) 
      ->header('Access-Control-Allow-Origin','http://192.168.1.96:81/,http://localhost/,http://localhost:4200/,http://localhost:4201/,*')
      ->header('Access-Control-Allow-Methods','*')
      ->header('Access-Control-Allow-Headers','Content-type, X-Auth-Token,Authorization, Origin');
      // De esta forma funciona
    }
}
