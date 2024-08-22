<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LivewireSubtotal extends Component
{
    public $idProducto;
    public $userId;
    public $orders;
    

    protected $listeners = ['updateOrders' => 'updateOrders'];

    public function mount($idProducto)
    {
        $this->userId = Auth::id();
        $this->idProducto = $idProducto;

        // Inicializar los datos
        $this->updateOrders();
    }

    public function updateOrders()
    {
        $this->orders = DB::table('orders')
            ->join('products', 'orders.products_id', '=', 'products.id')
            ->where('orders.users_id', $this->userId)
            ->where('orders.products_id', $this->idProducto)
            ->select(DB::raw('orders.quantity * products.price AS precio_orden'))
            ->value('precio_orden');

    }

    public function render()
    {
        return view('livewire.livewire-subtotal');
    }
}
