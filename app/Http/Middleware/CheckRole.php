<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
//use App\Http\Controllers\Request;
class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        foreach ($roles as $role) {
          
            if ($user->hasRole($role)) {
               return $next($request);
            }
        }
       
        abort(403, 'Permisos denegados.');
    }
}
