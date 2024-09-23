<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuditoriaProductos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $ip=$request->ip();
        $navegador= $request->header('User-Agent');
        $userId=Auth::id();
        $accion= $this->getAction($request);
        if ($accion!== null) {
            
            DB::table('auditoria_productos')->insert([
                'users_id'=> $userId,
                'accion'=> $accion,
                'ip'=> $ip,
                'navegador'=> $navegador,
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
        }
        return $next($request);
    }

    private function getAction(Request $request){

        $method=$request->method();

        switch ($method) {
            case 'POST':
                return 'Crear Producto';
            case 'PUT':
                return 'Editar Producto';
            case 'DELETE':
                return 'Borrar Producto';
        }
    }
}
