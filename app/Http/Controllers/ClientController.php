<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

class ClientController extends Controller
{
    public function login(): View
    {
        return view('clients.login');
    }
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        
        return view('clients.index', [
            'clients' => Client::orderBy('username', 'asc')->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $user= DB::select('SELECT *
                            FROM users');
        return view('clients.create',[
            'users'=> $user]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request) : RedirectResponse
    {
        Client::create($request->all());
        return redirect()->route('clients.index')
                ->withSuccess('New client is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client) : View
    {
    
        $idClient=$client->id;

        $clients=DB::select('
        SELECT *
        FROM clients 
        WHERE id = :ClientId',
        ['ClientId'=>$idClient]);
        
        return view('clients.show', [
            'client' => $clients
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client) : View
{
    // Obtén el ID del cliente
    $idClient = $client->id;

    // Realiza una consulta para obtener los detalles del cliente
    $clients = DB::select('
        SELECT *
        FROM Clients 
        WHERE id = :clientId', ['clientId' => $idClient]);

    // Retornar la vista 'clients.edit' con los datos del cliente
    return view('clients.edit', [
        'client' => $client,  // Pasar también el modelo User si es necesario
        'clients' => $clients
    ]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'username' => 'required|string|max:25',
        'address' => 'required|string|min:3|max:100',
        'cuit' => 'required|integer|digits_between:8,11',
        'phone' => 'required|integer|digits_between:10,13'
    ]);

    
    DB::table('clients')
        ->where('id', $id)
        ->update([
            'username' => $request->username,
            'address' => $request->address,
            'cuit' => $request->cuit,
            'phone' => $request->phone
        ]);
    $clients= Client::latest()->paginate(10);

    return redirect()->route('clients.index', $clients)
                     ->with('success', 'Client updated successfully');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client) 
    {
        $idClient=$client->id;
        
        $client->delete();

        // $deleted = DB::delete('
        //     DELETE clients
        //     FROM clients
        //     INNER JOIN users ON clients.users_id = users.id
        //     WHERE users_id = :userId
        // ', ['userId' => $idClient]);
        
        return redirect()->route('clients.index')
                ->withSuccess('Client is deleted successfully.');
    }
    
    public function orderUser(){
       
        $userId = Auth::id();
        $orders=DB::select('SELECT 
                orders.quantity * products.price AS precio_orden,
                orders.id,
                orders.products_id,
                orders.quantity,
                products.name,
                products.price
            FROM orders
            INNER JOIN products ON products.id = orders.products_id
            WHERE users_id = :userId
            ORDER BY orders.products_id', ["userId" => $userId]);

        $totalOrden=DB::select('SELECT 
                                    sum(orders.quantity * products.price) AS precio_orden
                                FROM orders
                                INNER JOIN products ON products.id = orders.products_id
                                WHERE 
                                    users_id = :userId',["userId" => $userId]); 
         $userId=Auth::id();
         $clients= DB::select('SELECT *
                             From clients
                             where clients.users_id = :id',[
                                 'id'=>$userId ]);
        
        return view('clients.order', [
                'orders' => $orders,
                'totalOrder' => $totalOrden,
                'clients'=>$clients
        ]);
        
    }
    public function search(Request $request){
        
        if ($request->nombreCliente == null) {
            return redirect()->route('clients.index')
            ->with('error', 'Ingrese nombre del cliente para buscarlo');
        }
        $clientes = DB::select('SELECT *   
                        FROM clients
                        WHERE clients.username LIKE :nombreCliente
                        order by username ASC', 
                        ["nombreCliente" => '%' . $request->nombreCliente . '%']);

        if ($clientes != null) {
            return view('clients.index', [
                        'clients' => $clientes
            ]);
        }


        if ($clientes == null) {
            return redirect()->route('clients.index')
            ->with('error', 'Cliente no encontrado');
        }
    }
    public function searchProducts(Request $request){

        if ($request->nombreProducto == null) {
            return redirect()->route('dashboard')
                    ->with('error', 'No se encontro resultados del producto');
                }

        $users = Auth::user();
        $products=DB::select('SELECT *
                                FROM products
                                WHERE products.name like :nombreProducto
                                order by products.name ASC',
                                ['nombreProducto'=>'%'.$request->nombreProducto.'%']);
       
        if ($products == null) {
            return redirect()->route('dashboard')
                    ->with('error', 'No se encontro resultados del producto');
                }
        $mensaje= $request->nombreProducto;

        return view('dashboard',[
                'products' => $products,
                'users' => $users,
                'mensaje' => $mensaje
                            ]); 
    }

    public function solicitud(){
        
        

        Mail::raw('Correo de prueba desde Laravel', function ($message) {
        $message->to('agustinhloa@gmail.com')
            ->subject('Correo de Prueba');
        });
        
    }
    
}

