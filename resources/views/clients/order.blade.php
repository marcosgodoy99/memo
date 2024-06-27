@extends('products.layouts')

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
                        <th scope="col">id</th>
                        <th scope="col">nombre</th>
                        <th scope="col">precio</th>
                        <th scope="col">cantidad de productos</th>
                
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $order-> name }}</td>
                            <td>{{ $order->price }}</td>
                            <td>{{ $order->cantidad_productos }}</td>
                            
                            <td>
                            
                                <form action="{{ route('orders.destroy', $order->products_id) }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>

                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this order?');"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                                
                            </td>
                        </tr>
                        @empty
                            <td colspan="6">
                                <span class="text-danger">
                                    <strong>No Product Found!</strong>
                                </span>
                            </td>
                        @endforelse
                    </tbody>
                  </table>      

            </div>
        </div>
    </div>    
</div>
</x-app-layout>
@endsection
