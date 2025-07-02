<?php

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    // ...

    public function boot(): void
    {
        // === Permisos de Administrador ===
        // Un administrador puede hacer todo.
        Gate::before(function (User $user, $ability) {
            if ($user->rol === 'admin') {
                return true;
            }
        });

        // === Permisos de Empleado ===
        // Define aquí las acciones específicas que un empleado SÍ puede hacer.
        Gate::define('view-subscriptions', fn (Usuario $user) => $user->rol === 'empleado');
        Gate::define('view-sales', fn (Usuario $user) => $user->rol === 'empleado');
        Gate::define('view-products', fn (Usuario $user) => $user->rol === 'empleado');
        Gate::define('view-training', fn (Usuario $user) => $user->rol === 'empleado');
        Gate::define('view-client-tracking', fn (Usuario $user) => $user->rol === 'empleado');

        // CRUD: Permisos para crear y leer (pero no editar/borrar)
        Gate::define('create-sales', fn (Usuario $user) => $user->rol === 'empleado');
        Gate::define('create-subscriptions', fn (Usuario $user) => $user->rol === 'empleado');
        
        // ... el resto de permisos serán denegados para 'empleado' por el Gate::before() del admin.
    }
}