<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LivewireTotal extends Component
{
    public $userId;
    public $totalOrder;

    protected $listeners = ['updateTotal' => 'updateTotal'];
    
    public function mount()
    {
        $this->userId = Auth::id();
        $this->updateTotal();

    }
    public function updateTotal(){

        $this->totalOrder=DB::select('SELECT 
                    sum(orders.quantity * products.price) AS precio_orden
                    FROM orders
                    INNER JOIN products ON products.id = orders.products_id
                    WHERE 
                    users_id = :userId',["userId" => $this->userId]);
    }

    public function render()
    {
        return view('livewire.livewire-total');
    }
}
