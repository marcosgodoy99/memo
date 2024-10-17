<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RemitoController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\PDFController;
use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {

    $users = Auth::user();
    $categorias= Categoria::latest()->get();
    

    $products = Product::latest()->get();
    return view('dashboard',[
        'products' => $products,
        'users' => $users,
        'categorias'=> $categorias
    ]); 
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//Route::resource('/clients', ClientController::class);

Route::post('/orders', [OrderController::class, 'order'])->name('orders.order');
Route::get('/orders/product', [OrderController::class, 'orderCart'])->name('orders.orderCart');
Route::delete('/orders/delete/{products_id}',[OrderController::class, 'delete'])->name('orders.destroy');
Route::get('/orders/show/{id}',[OrderController::class, 'show'])->name('orders.show');
Route::get('/orders/buy',[OrderController::class, 'buy'])->name('orders.buy');

Route::get('/generate-pdf', [PDFController::class, 'generatePDF'])->name('clients.PDF');

Route::get('/orders/user', [ClientController::class, 'orderUser'])->name('clients.order');
//Route::resource('products', ProductController::class);
//Route::resource('clients', ClientController::class);
//Route::get('login', [ClientController::class, 'login'])->name('login');
Route::view('/products/home', 'products.home')->name('products.home');
Route::middleware(['auth', 'role:admin'])->group(function () {
    
    Route::middleware(['auditoriaProductos'])->group(function (){
        Route::resource('/products', ProductController::class); 
    });
    Route::get('/clients/buscarClientes',[ClientController::class, 'search'])->name('clients.buscarClientes');
    Route::get('/clients/buscarProductos',[ClientController::class, 'searchProducts'])->name('clients.buscarProductos');
    Route::resource('/clients', ClientController::class)->names([
        'index' => 'clients.index',
        'create' => 'clients.create',
        'store' => 'clients.store',
        'show' => 'clients.show',
        'edit' => 'clients.edit',
        'update' => 'clients.update',
        'destroy' => 'clients.destroy',
    ]);

});


Route::get('/solicitud', function () {
    return view('clients.solicitudCliente');
});



Route::get('/solicitudCliente',[ClientController::class, 'solicitud'])->name('clients.solicitud');
Route::get('/listaRemitos', [RemitoController::class, 'listaRemito'])->name('clients.listaRemitos');

Route::get('/categorias/edit/{id}',[CategoriaController::class, 'edit'])->name('categorias.edit');
Route::post('/categorias/update/{id}',[CategoriaController::class, 'update'])->name('categorias.update');
Route::get('/categorias/create',[CategoriaController::class, 'create'])->name('categorias.create');
Route::delete('/categorias/delete/{id}',[CategoriaController::class, 'destroy'])->name('categorias.destroy');
Route::post('/categorias/store',[CategoriaController::class, 'store'])->name('categoria.store');
Route::get('/categorias',[CategoriaController::class, 'index'])->name('products.indexCategorias');
Route::get('/filtrarPorCategoria/{id}',[CategoriaController::class, 'filtrar'])->name('clients.filtrarPorCategoria');

Route::get('/generate-pdf/{id}', [RemitoController::class, 'generatePDF'])->name('clients.RemitosPDF');
Route::get('/generate-pdfDowload/{id}', [RemitoController::class, 'generatePDFDescarga'])->name('clients.RemitosPDFDescarga');


    