<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Akses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $leveluser): Response
    {
        if (auth()->user()-> level == $leveluser) {
            return $next($request);
        }
        return response()->json('Anda tidak memiliki hak');
    }
}
