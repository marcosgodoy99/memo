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
            $stock=DB::select('SELECT stock
            from products
            where id = :idProducto',['idProducto' => $this->idProducto]);
            if ($cantidadActual < $stock[0]->stock){
            DB::table('orders')
                ->where('users_id', $this->userId)
                ->where('products_id', $this->idProducto)
                ->increment('quantity');
            $this->cantidadProducto++;
             }else{
                return redirect()->route('clients.order')
            ->with('error', 'Alcanzo el limite de stock');
             }
            
        } elseif ($operacion == 'decrementar') {
            if ($cantidadActual >= 1) {
                DB::table('orders')
                    ->where('users_id', $this->userId)
                    ->where('products_id', $this->idProducto)
                    ->decrement('quantity');
                $this->cantidadProducto--;
            } if($cantidadActual <= 0) {
                DB::table('orders')
                ->where('products_id', $this->idProducto)
                ->where('users_id', $this->userId)
                ->limit(1)->delete();
                return redirect()->route('clients.order');  
            }
        }

        // Actualizar cantidad
        $this->actualizarCantidadProducto();

        // Emitir evento para que otros componentes actualicen sus datos
        $this->dispatch('updateOrders');
        $this->dispatch('updateTotal');
    }

    public function render()
    {
        return view('livewire.livewire-controller');
    }
}
