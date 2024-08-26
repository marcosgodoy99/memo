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

class PDFController extends Controller
{
     
    public function generatePDF()
    {

        $dataConsulta= $this->consulta();
        $totalOrder= $this->consultaTotal();
        
        $data = ['orders' => $dataConsulta,
                   'total'=> $totalOrder ];
        $pdf = PDF::loadView('clients/pdfDocument', $data);
        return $pdf->download('documento_de_prueba.pdf');

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
}