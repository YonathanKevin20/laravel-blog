<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Chief
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
        if(Auth::check() && Auth::user()->role == 'chief') {
            return $next($request);
        }
        return redirect()->route('home');
    }
}