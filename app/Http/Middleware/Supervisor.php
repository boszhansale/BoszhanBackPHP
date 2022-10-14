<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Supervisor
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (\Auth::user()->role->name == 'supervisor') {
            return $next($request);
        }
        return to_route('login')->with('нет доступа');
    }
}
