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
                ->withSuccess('Se agrego un nuevo producto correctamente.');
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
                ->withSuccess('El producto se actualizo correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product) : RedirectResponse
    {
        $product->delete();
        return redirect()->route('products.index')
                ->withSuccess('El producto se elimino correctamente.');
    }


    public function searchP(Request $request){

        if ($request->nombreProducto == null) {
            return redirect()->route('products.index')
                    ->with('error', 'Ingrese nombre del producto para buscarlo');
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
        $descuento = Descuento::whereIn('product_id', $products->pluck('id'))->get();

        return view('products.index',[
                'products' => $products,
                'users' => $users,
                'mensaje' => $mensaje,
                'descuento'=>$descuento
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

    return redirect()->back()->with([
        'success' => 'Descuento aplicado',
        'descuento' => $descuento
    ]);
}
public function aumento($id)
{
    // Verificar si el producto existe
    $product = DB::select('SELECT price, id FROM products WHERE id = :id', ['id' => $id]);

    if (empty($product)) {
        return redirect()->back()->with('error', 'Producto no encontrado');
    }

    // Verificar si existe un descuento registrado para este producto
    $descuento = DB::select('SELECT descuento, product_id FROM descuentos WHERE product_id = :id', ['id' => $id]);

    if (empty($descuento)) {
        return redirect()->back()->with('error', 'No hay descuento registrado para este producto');
    }

    // Calcular el precio original (quitando el descuento)
    $descuentoValor = $descuento[0]->descuento; // En este caso, será 10
    $precioActual = $product[0]->price;
    $precioReal = $precioActual / (1 - ($descuentoValor / 100));

    // Actualizar el precio del producto en la tabla 'products'
    DB::update('UPDATE products SET price = :precioReal WHERE id = :idProduct', [
        'idProduct' => $id,
        'precioReal' => $precioReal
    ]);

    // Eliminar el registro de descuento del producto
    DB::delete('DELETE FROM descuentos WHERE product_id = :id', ['id' => $id]);

    // Redireccionar con mensaje de éxito
    return redirect()->back()->with('success', 'Se ha revertido el descuento y actualizado el precio del producto');
}



}