<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PDFController extends Controller
{
     
    public function generatePDF()
    {

        $dataConsulta= $this->consulta();
        $totalOrder= $this->consultaTotal();
        $remito= $this->datosRemito();
       
        $data = ['orders' => $dataConsulta,
                'total'=> $totalOrder,
                'remito' => $remito];
        $pdf = PDF::loadView('clients/pdfDocument', $data);
        return $pdf->stream('documento_de_prueba.pdf');

    }
    public function consulta(){

        $userId = Auth::id();
        $orders=DB::select('SELECT 
                            orders.quantity * products.price AS precio_orden,
                            orders.id,
                            orders.products_id,
                            orders.quantity,
                            products.name,
                            products.links,
                            products.price,
                            products.code,
                            products.description,
                            products.stock
                        FROM orders
                        inner join products on products.id = orders.products_id 
                        inner join clients on :userId = orders.users_id
                        
                        ORDER BY orders.products_id',['userId'=>$userId]);

        return $orders;
    }
    public function consultaTotal(){

        $userId=Auth::id();
        $totalOrder=DB::select('SELECT 
                    sum(orders.quantity * products.price) AS precio_orden
                    FROM orders
                    INNER JOIN products ON products.id = orders.products_id
                    WHERE 
                    users_id = :userId',["userId" => $userId]);
        return $totalOrder;
    }

    public function datosRemito(){

        $userId = Auth::id();
        $fechaHoy = Carbon::now(); 
        $clients= DB::select('SELECT *
                                FROM clients
                                INNER JOIN users ON clients.users_id = users.id
                                WHERE 
                                users_id = :userId',["userId" => $userId]);
        $remito = [
            'nro' => '00001-000000232',
            'fechaEmision' => $fechaHoy,
            'cuit' => '20-23222333-4',
            'ingresosBrutos' => '50',
            'inicioActividades' => '29-10-1999',
            'condicionIva' => 'responsable inscripto',
        
            'cliente' => $clients[0]->username,
            'direccion' => $clients[0]->address,
            'cuitCliente' => $clients[0]->cuit,
            'condicionIvaCliente' => 'consumidor final',
            'condicionDeVenta' => 'contado',
            'vtoPago' => '15-02-2019'
        ];
        return $remito;
    }
}