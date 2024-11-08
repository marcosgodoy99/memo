<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Descuento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;

class ProductController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {

        $products = Product::latest()->paginate(10);
        $descuento = Descuento::whereIn('product_id', $products->pluck('id'))->get();

        return view('products.index', [
            'products' => $products,
            'descuento'=>$descuento
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $categorias= DB::select('SELECT *
                            FROM categorias');

        return view('products.create', 
    ['categorias'=> $categorias]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request) : RedirectResponse
    {
        Product::create($request->all());
        
        return redirect()->route('products.index')
                ->withSuccess('New product is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product) : View
    {
        return view('products.show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product) : View
    {
        return view('products.edit', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product) : RedirectResponse
    {
        $product->update($request->all());
        return redirect()->route('products.index')
                ->withSuccess('Product is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product) : RedirectResponse
    {
        $product->delete();
        return redirect()->route('products.index')
                ->withSuccess('Product is deleted successfully.');
    }


    public function search(Request $request){
        
        if ($request->nombreProducto == null) {
            return redirect()->route('products.index')
                    ->with('error', 'No se encontro resultados del producto');
                }

        $users = Auth::user();
        
        $products = Product::where('name', 'like', '%' . $request->nombreProducto . '%')
                  ->orderBy('name', 'asc')
                  ->paginate(10);
       
        if ($products == null) {
            return redirect()->route('products.index')
                    ->with('error', 'No se encontro resultados del producto');
                }
        $mensaje= $request->nombreProducto;

        return view('products.index',[
                'products' => $products,
                'users' => $users,
                'mensaje' => $mensaje,
                            ]); 
    }

    public function descuento($id)
{
 
    $descuento = new Descuento();
    $descuento->descuento = 10; 
    $descuento->product_id = $id;

    
    $product = DB::select('SELECT price, id FROM products WHERE id = :id', ['id' => $id]);

 
    if (empty($product)) {
        return redirect()->back()->with('error', 'Producto no encontrado');
    }

  
    $precioDescuento = $product[0]->price - ($product[0]->price * ($descuento->descuento / 100));


    $boolean = DB::select('SELECT coalesce("product_id", 0) as precio FROM descuentos WHERE descuentos.product_id = :id', ['id' => $id]);

 
    if (empty($boolean) || $boolean[0]->precio == null) {

        $descuento->save();
        DB::update('UPDATE products SET price = :precioD WHERE id = :idProduct', ['idProduct' => $id, 'precioD' => $precioDescuento]);
    }

    $products = Product::latest()->paginate(10);
    $descuento = Descuento::whereIn('product_id', $products->pluck('id'))->get();

    return view('products.index', [
        'products' => $products,
        'descuento' => $descuento
    ]);
}


}