<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProfileController;

class OrderController extends Controller
{
    
public function order(Request $request)
    { Order::create([
        'products_id' => $request->products_id,
        'users_id' => $request->users_id
        ]);
        return redirect()->route('dashboard')
                ->with('success','Se agrego un producto ('.$request->name.') a la orden');
    }
    public function orderCart(){
        
        $products = Product::latest()->get();
        return view('products.order',[
            'products'=>$products
        ]);
    }
    public function delete(Order $orders){
        


        //$userId = Auth::id();        
        //DB::table('orders')->where('products_id', $orders->products_id)->where('users_id',$userId)->delete();
        return redirect()->route('clients.order')
        ->withSuccess('Order is deleted successfully.');    
    }
    public function show(){
        dd("en mantenimiento");
    }

}
