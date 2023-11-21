<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class IncrementCounter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Incrementa el contador en la caché
        $counter = Cache::increment('request_counter');

        // Puedes hacer algo con el contador, como guardarlo en una base de datos, si lo deseas
        // Tu lógica adicional aquí

        return $next($request);
    }
}
