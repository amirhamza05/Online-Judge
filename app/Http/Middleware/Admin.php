<?php

namespace App\Http\Middleware;

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
        if (!auth()->check()) {
            abort(401,"You need to login your account");
        }
        $user = auth()->user();
        $role = $user ? $user->type : abort(401);
        if($role > 20)
        {
            abort(401);
        }
        return $next($request);
    }
}
