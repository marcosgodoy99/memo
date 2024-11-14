<?php

namespace App\Http\Controllers;

use App\Models\lineasRemito;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Remito;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PDFController extends Controller
{
     
    public function generatePDF(Request $request)
    {
        if ($request->clients_id == null) {
            return redirect()->route('clients.order')
            ->with('error', 'Seleccione un cliente por favor');
        }
            $dataConsulta= $this->consulta();
            $totalOrder= $this->consultaTotal();
            $remito= $this->datosRemito($request->clients_id);

            if ($dataConsulta == null) {
                return redirect()->route('clients.order')
                ->with('error', 'No ha seleccionado ningun producto');
            }
       
        $data = ['orders' => $dataConsulta,
                'total'=> $totalOrder,
                'remito' => $remito];
        $pdf = PDF::loadView('clients/pdfDocument', $data);
        $this->save($request->clients_id);
        return $pdf->download('documento_de_prueba.pdf');
    }
    public function consulta(){

        $userId = Auth::id();
        $orders = DB::select('
                SELECT DISTINCT
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
                INNER JOIN products ON products.id = orders.products_id 
                WHERE orders.users_id = :userId
                ORDER BY orders.products_id
            ', ['userId' => $userId]);

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
    
    public function datosRemito($id){
            
            // $userId = Auth::id();
            $fechaHoy = Carbon::now(); 
            $clients= DB::select('SELECT *
                                FROM clients
                                WHERE 
                                clients.id = :clientId',["clientId" => $id]);
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

    public function save($id) {
        $dataConsulta = $this->consulta();
        $userId = Auth::id();
        
        // Obtener datos del cliente
        $remito = DB::select('
            SELECT *
            FROM clients
            INNER JOIN users ON clients.users_id = users.id
            WHERE users_id = :userId and clients.id = :clientId
        ', ['userId' => $userId,
            'clientId'=>$id]);
    
        // Crear remito
        $requestClient = [
            'numberRemito' => '2',
            'nameClient' => $remito[0]->username,
            'address' => $remito[0]->address,
            'estado' => 'PENDIENTE',
            'cuit' => $remito[0]->cuit,
            'users_id' => $remito[0]->users_id,
        ];
    
        Remito::create($requestClient);
    
        // Obtener el ID del remito recién creado
        $idRemito = DB::table('remitos')
            ->where('users_id', $userId)
            ->max('id');
    
            $request = []; // Inicializar el array fuera del bucle

            foreach ($dataConsulta as $order) {
                $request[] = [
                    'quantity' => $order->quantity,
                    'product' => $order->name,
                    'idProduct' => $order->products_id,
                    'remito_id' => $idRemito,
                    'price' => $order->price,
                    'subtotal' => $order->precio_orden,
                ];
            
                $product = DB::SELECT('SELECT stock FROM products WHERE id = :idProduct', ['idProduct' => $order->products_id]);
            
                if ($product) {
                    $currentStock = $product[0]->stock;
                    $newStock = $currentStock - $order->quantity;
            
                    if ($newStock < 0) {
                        return response()->json(['error' => 'No hay suficiente stock para el producto: ' . $order->name], 400);
                    }
            
                    DB::update('UPDATE products SET stock = :newStock WHERE id = :idProduct', [
                        'newStock' => $newStock,
                        'idProduct' => $order->products_id,
                    ]);
                }
            }
            
            // Inserta las líneas del remito fuera del bucle
            if (!empty($request)) {
                lineasRemito::insert($request);
            }
            
            // Eliminar órdenes del usuario
            DB::delete('DELETE FROM orders WHERE users_id = :userId', ['userId' => $userId]);
            
    }
}