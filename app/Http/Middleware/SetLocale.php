<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\App;

use Closure;

class SetLocale
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
        if(request('change_language')){
            session()->put('language',request('change_language'));
            $langauge=request('change_language');
            return redirect(url()->current());

        }elseif(session('language')){
            $langauge=session('language');
        }elseif(config('app.locale')){
            $langauge=config('app.locale');
        }

        if(isset($langauge)&& config('app.languages.' . $langauge)){
            App::setLocale($langauge);
        }

        return $next($request);
    }

}
