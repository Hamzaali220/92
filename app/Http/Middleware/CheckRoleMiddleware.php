<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\Store;
use App;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->agents_users_role_id ==1) {
            return $next($request);
        }
        return redirect('/agentadmin');
    }

    /**
     * Obtiene los roles requeridos por la ruta.
     *
     * @param string/array $route arreglo de cadenas o cadena con el nombre del rol necesario
     *
     * @return bool
     */
    private function getRequiredRoleForRoute($route)
    {
        $actions = $route->getAction();

        return isset($actions['roles']) ? $actions['roles'] : null;
    }
}
