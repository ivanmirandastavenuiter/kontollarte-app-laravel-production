<?php

namespace App\Http\Middleware;

use Closure;

class AlwaysRedirect
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
        if ($request->path() == 'about') {
            return redirect('/');
        }
        return $next($request);
    }
}
