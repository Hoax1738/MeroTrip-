<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class Customer
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
            abort(401, 'This action is unauthorized.');
        }
        elseif (\Auth::check() && \Auth::user()->hasrole('customer')) {
            return $next($request);
        }
        else {
            return redirect('/login');
        }
    }
}
