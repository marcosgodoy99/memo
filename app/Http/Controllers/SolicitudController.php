<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ClientController;

class SolicitudController extends Controller
{
    
    public function solicitud()   
    {
        $id=Auth::id();
        return view('clients.solicitudCliente',[
            'id'=> $id]);
    }
    public function solicitudAdmin()   
    {
        $solicitudes = Solicitud::select('solicituds.*', 'users.email')
            ->join('users', 'users.id', '=', 'solicituds.users_id')
            ->paginate(10);
    
        return view('clients.solicitudAdmin',[
            'solicitudes'=> $solicitudes]);
        }

    public function store(Request $request)   
    {
        
        Solicitud::create($request->all());
        return redirect()->route('dashboard')
                ->withSuccess('Su solicitud fue creada con exito');
    }
   
    public function solicitudAceptada($id)   
    {   
        $request=DB::SELECT('SELECT *
        FROM solicituds
        WHERE id = :idSolicitud',['idSolicitud'=>$id]);
     
     $attributes = (array) $request[0];
     Client::create($attributes);

     DB::delete('DELETE FROM solicituds 
     WHERE id = :idSolicitud', ['idSolicitud' => $id]);

        
        return redirect()->route('clients.solicitudAdmin')
                ->withSuccess('Solicitud Aceptada .');
    
    }
        
    public function solicitudDenegada($id)   
    {   
        
        DB::delete('DELETE FROM solicituds 
        WHERE id = :idSolicitud', ['idSolicitud' => $id]);
   
           
           return redirect()->route('clients.solicitudAdmin')
                   ->withError('Solicitud denegada.');
       
       }
}
