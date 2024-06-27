<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;

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
            'clients' => Client::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        return view('clients.create');
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
    public function show(User $client) : View
    {
        $idClient=$client->id;

        $clients=DB::select('
        SELECT *
        FROM users
        inner join clients on clients.users_id = users.id 
        WHERE 
        users_id = :userId',['userId'=>$idClient]);
        
        return view('clients.show', [
            'client' => $clients
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client) : View
    {
        return view('clients.edit', [
            'client' => $client
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client) : RedirectResponse
    {
        $client->update($request->all());
        return redirect()->back()
                ->withSuccess('Client is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client) : RedirectResponse
    {
        $client->delete();
        return redirect()->route('clients.index')
                ->withSuccess('Client is deleted successfully.');
    }
    
    public function orderUser(){
       
        $userId = Auth::id();
        $orders=DB::select('
            SELECT 
                orders.products_id,
	            products.*,	
                COUNT(*) AS cantidad_productos
            FROM orders
            inner join products on products.id = orders.products_id 
	        WHERE 
                users_id = :userId
            GROUP BY orders.products_id',['userId'=>$userId]);


        return view('clients.order', [
                'orders' => $orders, 
        ]);
        
    }
}

