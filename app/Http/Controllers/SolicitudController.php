<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SolicitudController extends Controller
{
    public function store(Request $request)   
    {
        
        Solicitud::create($request->all());
        return redirect()->route('dashboard')
                ->withSuccess('Su solicitud fue creada con exito');
    }
    public function solicitud()   
    {
        $id=Auth::id();
        return view('clients.solicitudCliente',[
            'id'=> $id]);
    }
}
