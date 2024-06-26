<?php

namespace App\Http\Middleware;

use Closure;
use App;

class WebLang
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
        App::setlocale($request->lang);

        session()->put('langCode', $request->lang);

        return $next($request);

    }
}
