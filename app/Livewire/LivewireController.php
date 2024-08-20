<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LivewireController extends Component
{
    public $userId;
    public $cantidadProducto;
    public $idProducto;

    public function mount($idProducto)
    {
        $this->userId = Auth::id();
        $this->idProducto = $idProducto;

        $this->actualizarCantidadProducto();
        
        $this->cantidadProducto = DB::table('orders')
            ->where('users_id', $this->userId)
            ->where('products_id', $this->idProducto)
            ->value('quantity');
    }

    public function actualizarCantidadProducto()
    {
        $this->cantidadProducto = DB::table('orders')
            ->where('users_id', $this->userId)
            ->where('products_id', $this->idProducto)
            ->value('quantity');
    }

    public function cambiarCantidad($operacion)
    {
        $cantidadActual = $this->cantidadProducto;

        if ($operacion == 'incrementar') {
            DB::table('orders')
                ->where('users_id', $this->userId)
                ->where('products_id', $this->idProducto)
                ->increment('quantity');
            $this->cantidadProducto++;
        } elseif ($operacion == 'decrementar') {
            if ($cantidadActual >= 1) {
                DB::table('orders')
                    ->where('users_id', $this->userId)
                    ->where('products_id', $this->idProducto)
                    ->decrement('quantity');
                $this->cantidadProducto--;
            } else {
                DB::table('orders')
                    ->where('products_id', $this->idProducto)
                    ->where('users_id', $this->userId)
                    ->limit(1)->delete();  
            }
        }

        // Actualizar cantidad
        $this->actualizarCantidadProducto();

        // Emitir evento para que otros componentes actualicen sus datos
        $this->dispatch('updateOrders');
    }

    public function render()
    {
        return view('livewire.livewire-controller');
    }
}
