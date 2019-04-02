<?php

namespace App\Http\Middleware;

use App\Http\Controllers\SessionController;
use Closure;
use Session;

class SessionManager
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
        return SessionController::getInstance($request)
                        ->handleRequest() ?: $next($request);
    }
}
