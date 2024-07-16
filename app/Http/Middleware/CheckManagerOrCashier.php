<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckManagerOrCashier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && (auth()->user()->id_level == 2 || auth()->user()->id_level == 3)) {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('error', 'Unauthorized access');
    }
}
