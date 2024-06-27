<?php

namespace App\Http\Controllers;

use App\Models\Client;
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
    public function show(Client $client) : View
    {
        return view('clients.show', [
            'client' => $client
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
        /*  
        $userId = Auth::id();
        $orders = DB::table('orders')->select('*')->where('users_id', $userId)->get();
        //$products = DB::table('products')->select('*')->where('id', $order[0]->products_id)->get();
        $cantidad = 0;
        $products = [];
        $i=0;
        //dd($orders[0]->products_id);
        foreach ($orders as $order){
         // $products[$i] = Product::where('id', $order->products_id)->get();
           // $i++;
           $products = Order::where('id', $order->products_id)->get()->unique('id');
           // foreach($products as $product){
             //   $cantidad = Order::where('products_id', $product->id)
               //  ->where('users_id', $userId)
                // ->count();
           // }
        };
       dd($products);
        return view('clients.order', [
                'products' => $products,
                'cantidad' => $cantidad, 
        ]);
        */
        $userId = Auth::id();
        $orders=DB::select('SELECT * FROM orders WHERE users_id = :userId',['userId'=>$userId]);
        select 
            orders.fecha
            products.name

        $Products= DB::select('SELECT id FROM products');
        $results=[];
        foreach ($orders as $order) {
            foreach ($Products as $Product) {
                
                if ($order->products_id == $Product->id) {
                    $results[]=$Product;
                }
            }
            }
        dd($results);


    }
}

