<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles Los roles permitidos para la ruta ('admin', 'empleado').
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Si el usuario no está autenticado, el middleware 'auth' ya lo habrá redirigido al login.
        // Esta es solo una capa extra de seguridad.
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Comprueba si el rol del usuario está en la lista de roles permitidos para esta ruta.
        if (!in_array($user->rol, $roles)) {
            // Si no tiene permiso, redirige a la ruta por defecto según su rol.
            // Esto es el equivalente a tu función getDefaultRoute().
            $redirectPath = match($user->rol) {
                'admin' => '/admin/dashboard', // Ruta por defecto para el admin
                'empleado' => '/dashboard',      // Ruta por defecto para el empleado
                default => '/login',
            };
            
            return redirect($redirectPath);
        }

        // Si el usuario tiene el rol permitido, permite que la petición continúe.
        return $next($request);
    }
}