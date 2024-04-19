<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Verificar si el usuario autenticado es el administrador
            if (Auth::user()->isAdmin()) {
                return $next($request);
            }
        }

        // Si el usuario no es el administrador, redirigir o devolver un error 403
        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
