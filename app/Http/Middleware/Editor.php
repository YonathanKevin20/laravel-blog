<?php

namespace App\Http\Middleware;

use Closure;

class Editor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $condition)
    {
        if($request->user()->role != 'editor' && $condition == 'not') {
            return $next($request);
        }
        return redirect()->route('home');
    }
}
