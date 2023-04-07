<?php

namespace App\Http\Middleware;
use Closure;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class Refer
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
        $id=$request->get('ref');
        // $user=User::find($id);
        if($id){
            Cookie::queue(Cookie::forever('ref', $id));
        }      
        return $next($request);
    }
}
