<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Si el usuario no está logueado o su rol no coincide con el requerido
        if (!auth()->check() || auth()->user()->role !== $role) {
            // Lo mandamos al home con un mensaje de error
            return redirect('/home')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
