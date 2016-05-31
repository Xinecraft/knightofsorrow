<?php

namespace App\Http\Middleware;

use Closure;
use Entrust;

class EntrustRoles
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
        if(\Auth::guest())
            return \Redirect::home();

        if (Entrust::hasRole('admin') || Entrust::hasRole('superadmin') || Entrust::hasRole('leader')) {
            return $next($request);
        }

        return \Redirect::home();
    }
}
