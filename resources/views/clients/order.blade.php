@extends('clients.layouts')
@section('content')

<x-app-layout>
<div class="row justify-content-center mt-3">
    <div class="col-md-12">

        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">Order List</div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Nombre del producto</th>
                        
                        <th scope="col">Cantidad elegida</th>
                        <th scope="col">Precio por unidad</th>
                        <th scope="col">Precio subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>

                            <td>{{ $order->name }}</td>                         
                                                                                     
                            <td>
                                <div class="d-flex justify-content-between align-items-center">
                                    
                                    <livewire:livewire-controller :idProducto="$order->products_id" class="mr-3"/>
                        
                                    <div>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-warning btn-sm mr-2">
                                            <i class="bi bi-info-square"></i>
                                        </a>
                            
                                        <form action="{{ route('orders.destroy', $order->products_id) }}" method="post" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>

                            <td class="text-primary">${{ number_format($order->price, 2, ',', '.') }}</td>
                            <td class="text-primary"> <livewire:livewire-subtotal :idProducto="$order->products_id" class="mr-3"/></td>
                        </tr>
                        @empty
                            <td colspan="6">
                                <span class="text-danger">
                                    <strong> No ha hecho ninguna orden !!</strong>
                                </span>
                            </td>
                        @endforelse
                     
                    </tbody>
                  </table>      
                   <div class="text-center text-primary">
                        <span>
                            <h1 class="h5">
                                Total de la orden
                                <br>
                                <b> <livewire:livewire-total class="mr-3"/> </b> 
                            </h1>
                        </span>
                    </div> 
                </div>
            </div>
            <form action="{{ route('clients.PDF')}}" method="GET" class="btn-custom btn-lg">

                <div class="text-center">
                    <button  type="submit" >Comprar Orden</button>
                </div>

            </form>
    </div>    
</div>
</x-app-layout>
@endsection
