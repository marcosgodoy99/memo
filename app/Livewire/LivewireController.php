<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class LivewireController extends Component
{
    public $userId;
    public $cantidadProducto;
    public $idProducto;

    public function mount(){

        $this->userId = Auth::id();

        $this->idProducto=DB::select(
            'SELECT orders.products_id
            FROM orders
            WHERE orders.users_id = :userId',
            ['userId'=> $this->userId]);



        $this->cantidadProducto = DB::select(
            'SELECT quantity
            FROM orders 
            WHERE orders.users_id = :users_id',
        ['users_id'=> $this->userId ]);
    }

    public function cambiarCantidad(){

        $idProducto=$this->idProducto[0]->products_id;
        
        DB::table('orders')
        ->where('users_id', $this->userId)
        ->where('products_id', $idProducto )
        ->update(['quantity' => DB::raw('quantity - 1')]);
    
    
    }

    public function render()
    {
        return view('livewire.livewire-controller');
    }
}
