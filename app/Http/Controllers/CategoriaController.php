<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Mail;
use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Categoria;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;


class CategoriaController extends Controller
{
    public function filtrar($id)
    {
        

        $products=DB::select('SELECT products.id, 
                                    products.name,
                                    products.code,
                                    products.stock,
                                    products.price,
                                    products.links,
                                    products.description,
                                    categorias.name as nombre_categoria

                                FROM products
                                INNER JOIN categorias ON products.categorias_id = categorias.id
                                WHERE products.categorias_id = :idCategoria
                                order by products.name ASC',
                                ['idCategoria'=>$id]);
        // dd($products);
        
        $users = Auth::user();
        $categorias= Categoria::latest()->get();
        $mensaje= $products[0]->nombre_categoria;

        return view('dashboard',[ 
                'products' => $products,
                'users' => $users,
                'categorias'=> $categorias,
                'mensaje' => $mensaje,
                        ]);
    }
}
