<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use Livewire\Component;

class OrderController extends Controller
{
    
public function order(Request $request){
    
        if ($request->quantity != 0) {
            
            $order=DB::Select(' SELECT *
            FROM orders
            WHERE users_id = :user_id  AND products_id = :products_id ' 
            ,['user_id'=> $request->users_id, 'products_id' => $request->products_id]);
            
            if ($order) {
                DB::table('orders')
                ->where('users_id', $request->users_id)
                ->where('products_id', $request->products_id)
                ->update(['quantity' => DB::raw('quantity + ' . $request->quantity)]);
            } else {
                
                Order::create([
                    'users_id' => $request->users_id,
                    'products_id' => $request->products_id,
                    'quantity' => $request->quantity
                ]);
            }
            return redirect()->route('dashboard')
            ->with('success','Se agrego un producto ('.$request->name.') a la orden')
            ->withFragment('product-' . $request->products_id);
        } else {
            $orderBuy=DB::select('SELECT *
                                FROM products
                                where products.id = :idProducts '
                                ,['idProducts'=>$request->products_id ]);

            $idUser=$request->users_id;
            $mensaje="Error, no ingreso una cantidad";

            return view('clients.buyOrder', [
                'product' => $orderBuy,
                'idUser'=>$idUser,
                'mensaje'=>$mensaje ]);
        }
    }
    public function orderCart(){
        
        $products = Product::latest()->get();
        return view('products.order',[
            'products'=>$products
        ]);
    }
    public function delete(Order $orders, $products_id)
    {
        
        $userId = Auth::id();        
        DB::table('orders')->where('products_id', $products_id)->where('users_id',$userId)->limit(1)->delete();
        
        return redirect()->route('clients.order')
        ->withSuccess('Order is deleted successfully.');    
    }
    public function show($id) : View
    {   
        
        $orders=DB::select('SELECT 
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
                        where orders.id = :id 
                        ORDER BY orders.products_id',['id'=>$id]);

        return view('clients.showOrder', [
                'orders' => $orders, 
        ]);
    }
    public function buy(Request $request) : View{


        $orderBuy=DB::select('SELECT *
                        FROM products
                        where products.id = :idProducts '
                        ,['idProducts'=>$request->products_id ]);

        
        $idUser=$request->users_id;

        return view('clients.buyOrder', [
            'product' => $orderBuy,
            'idUser'=>$idUser 
        ]);
    }

}
