<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class Admin
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
        if (\Auth::check() && \Auth::user()->hasrole('admin')) {
            return $next($request);
        }
        elseif (\Auth::check() && \Auth::user()->hasrole('customer')) {
            abort(401, 'This action is unauthorized.');
        }
        else {
            return redirect('/login');
        }
    }
}
