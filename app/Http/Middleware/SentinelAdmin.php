<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelAdmin
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
        if (! Sentinel::check() || Sentinel::getUser()->hasAccess(['admin'])) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('users/login');
            }
        }
        return $next($request);
    }
}
