<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Mail;
use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Categoria;
use App\Models\Descuento;
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
    public function index() : View
    {
        
        return view('products.indexCategorias', [
            'categorias' => Categoria::orderBy('name', 'asc')->paginate(10)]);
    }
    public function create() : View
    {
        $categorias= DB::select('SELECT *
                            FROM categorias');
        return view('products.createCategorias',[
            'categorias'=> $categorias]);
    }
    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:25',
        ]);
        Categoria::create($request->all());
        return redirect()->route('products.indexCategorias')
                ->withSuccess('Se agrego una nueva categoria con exito.');
    }
    public function destroy($id)
    {
                $category = Categoria::findOrFail($id);

                $category->delete();
        
                return redirect()->route('products.indexCategorias')
                    ->withSuccess('Categoria eliminada con exito');
    }

    public function edit( $id) : View
    {
        
        $categorias = DB::select('
            SELECT *
            FROM categorias 
            WHERE id = :idCategoria', ['idCategoria' => $id]);
        

        return view('products.editCategorias', [
            'categorias' => $categorias
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:25',
        ]);
    
        DB::table('categorias')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
            ]);
         

        return redirect()->route('products.indexCategorias')
                        ->with('success', 'Categoria editada con exito');
    }
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
        $clientController = new ClientController();
        
        if ($products == null) {
            return redirect()->route('dashboard')
            ->with('error', 'No se encontro ningun producto con este filtro');
        }else{
            $images = $clientController->showCategoryImages();

            $product = Product::where('name', 'like', '%' . $products[0]->name . '%')
                  ->orderBy('name', 'asc')
                  ->paginate(10);
            $descuento = Descuento::whereIn('product_id', $product->pluck('id'))->get();
            
            $mensaje= $products[0]->nombre_categoria;
            return view('dashboard',[ 
                'products' => $products,
                'users' => $users,
                'categorias'=> $categorias,
                'descuento'=> $descuento,
                'mensaje' => $mensaje,
                'images' => $images,
            ]);
        }
    }
}
