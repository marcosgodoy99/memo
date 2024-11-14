<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lineasRemito;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Remito;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
//use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DB;


class RemitoController extends Controller
{
    public function listaRemito(): View 
{ 
    $id = Auth::id();

    // Verifica si el usuario tiene el rol de 'admin'
    if (Auth::user()->hasRole('admin')) {
        // Si el usuario es admin, obtiene todos los remitos
        $remitos = Remito::latest()->paginate(10);
    } else {
        // Si no es admin, solo obtiene los remitos asociados al usuario
        $remitos = Remito::where('users_id', $id)->latest()->paginate(10);
    }

    return view('clients.listaRemitos', [
        'remitos' => $remitos
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

    public function estado($id)
{
    if (Auth::user()->hasRole('admin')) {
       
        DB::update('UPDATE remitos SET estado = :newEstado WHERE id = :idRemito', [
            'newEstado' => 'ENVIADO',
            'idRemito' => $id,
        ]);
       
        $remito = DB::table('remitos')->where('id', $id)->first();
        
        $lineasRemito = DB::table('lineas_remitos')
        ->join('products', 'lineas_remitos.idProduct', '=', 'products.id')  
        ->where('lineas_remitos.remito_id', $id)  
        ->select('lineas_remitos.*', 'products.name as producto_name', 'products.price')  
        ->get();
    

        return view('clients.RemitoEdit', compact('remito', 'lineasRemito'));
    }

    
    return redirect()->back()->with('error', 'No tienes permiso para realizar esta acción');
}

    

public function update(Request $request, $id)
{
    $remito = Remito::findOrFail($id);
    
   
    $lineasRemito = DB::table('lineas_remitos')->where('remito_id', $id)->get();

 
    foreach ($request->productos as $productoId => $cantidad) {
      
        $producto = Product::findOrFail($productoId); 

        $lineaRemito = $lineasRemito->where('idProduct', $productoId)->first(); 

        if ($lineaRemito) {
           
            if ($cantidad == 0) {
              
                $producto->stock += $lineaRemito->quantity; 
                DB::table('lineas_remitos')->where('id', $lineaRemito->id)->delete(); 
            } else {
                
                $producto->stock += $lineaRemito->quantity - $cantidad;
                DB::table('lineas_remitos')->where('id', $lineaRemito->id)
                    ->update(['quantity' => $cantidad]);
            }
        } else {
        
            if ($cantidad > 0) {
                
                DB::table('lineas_remitos')->insert([
                    'remito_id' => $id,
                    'idProduct' => $productoId, 
                    'quantity' => $cantidad      
                ]);
                
                $producto->stock -= $cantidad;
            }
        }

       
        $producto->save();
    }

    $remito->save();

    return redirect()->route('clients.listaRemitos')->with('success', 'Remito actualizado exitosamente');
}




}




