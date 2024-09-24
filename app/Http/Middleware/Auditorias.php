<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class Auditorias
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $ip = $request->ip();
        $navegador = $request->header('User-Agent');
        $userId = Auth::id();
        $accion = $this->getAction($request);

        DB::table('auditorias')->insert([
            'users_id' => $userId,
            'accion' => $accion,
            'ip' => $ip,
            'navegador' => $navegador,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $next($request);
    }
        private function getAction(Request $request)
    {
        $method = $request->method();

        switch ($method) {
            case 'POST':
                return 'crear Producto';
            case 'PUT':
                return 'editar Producto';
            case 'DELETE':
                return 'borrar Producto';
            default:
                return 'recarga de Producto';
        }
    }

}
