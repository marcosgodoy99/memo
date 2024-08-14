<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class LivewireController extends Component
{
    public function render()
    {
        return view('livewire.livewire-controller',["userAll"=>$userId = Auth::id()]);
    }
}
