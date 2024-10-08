<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lineasRemito;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Remito;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RemitoController extends Controller
{
    public function listaRemito(): View 
    { 
        $id=Auth::id();
        return view('clients.listaRemitos', [
            'remitos' => Remito::where('users_id', $id)->latest()->paginate(10)
        ]);
    }
    public function generatePDF($id)
    {
        $lineasRemitos = DB::select(' SELECT *
        FROM lineas_remitos as LR
        WHERE LR.remito_id = :id
        ', ['id' => $id]);

        $totalOrder=DB::select(' 
        SELECT sum(subtotal) as precio_orden
        FROM lineas_remitos as LR
        WHERE LR.remito_id = :id
        ', ['id' => $id]);


        $orders = DB::select('
        SELECT 
        LR.*,
        R.*,
        LR.product as name,
        LR.subtotal as precio_orden
        FROM lineas_remitos as LR
        INNER JOIN remitos as R ON LR.remito_id = R.id
        WHERE R.id = :id',['id' => $id]);

        $clients=[];
        $clients=DB::select('SELECT *
                                FROM remitos
                                WHERE id = :id                          
                                ORDER BY created_at',['id'=>$id]);

        $remito = [
            'nro' => '00001-000000232',
            'fechaEmision' => $clients[0]->created_at,
            'cuit' => '20-23222333-4',
            'ingresosBrutos' => '50',
            'inicioActividades' => '29-10-1999',
            'condicionIva' => 'responsable inscripto',
        
            'cliente' => $clients[0]->nameClient,
            'direccion' => $clients[0]->address,
            'cuitCliente' => $clients[0]->cuit,
            'condicionIvaCliente' => 'consumidor final',
            'condicionDeVenta' => 'contado',
            'vtoPago' => '15-02-2019'
        ];

        $data = ['orders' => $orders,
                'total'=> $totalOrder,
                'remito' => $remito];
        $pdf = PDF::loadView('clients/pdfDocument', $data);
        return $pdf->stream('documento_de_prueba.pdf');

    }
    public function generatePDFDescarga($id){
        $lineasRemitos = DB::select(' SELECT *
        FROM lineas_remitos as LR
        WHERE LR.remito_id = :id
        ', ['id' => $id]);

        $totalOrder=DB::select(' 
        SELECT sum(subtotal) as precio_orden
        FROM lineas_remitos as LR
        WHERE LR.remito_id = :id
        ', ['id' => $id]);


        $orders = DB::select('
        SELECT 
        LR.*,
        R.*,
        LR.product as name,
        LR.subtotal as precio_orden
        FROM lineas_remitos as LR
        INNER JOIN remitos as R ON LR.remito_id = R.id
        WHERE R.id = :id',['id' => $id]);

        $clients=[];
        $clients=DB::select('SELECT *
                                FROM remitos
                                WHERE id = :id                          
                                ORDER BY created_at',['id'=>$id]);

        $remito = [
            'nro' => '00001-000000232',
            'fechaEmision' => $clients[0]->created_at,
            'cuit' => '20-23222333-4',
            'ingresosBrutos' => '50',
            'inicioActividades' => '29-10-1999',
            'condicionIva' => 'responsable inscripto',
        
            'cliente' => $clients[0]->nameClient,
            'direccion' => $clients[0]->address,
            'cuitCliente' => $clients[0]->cuit,
            'condicionIvaCliente' => 'consumidor final',
            'condicionDeVenta' => 'contado',
            'vtoPago' => '15-02-2019'
        ];

        $data = ['orders' => $orders,
                'total'=> $totalOrder,
                'remito' => $remito];
        $pdf = PDF::loadView('clients/pdfDocument', $data);
        return $pdf->download('documento_de_prueba.pdf');
    }
}
