@extends('clients.layouts')

@section('content')
<style>
        .product-image {
    width: 200px;
    
 
border: 1px solid #ccc;
    border-radius: 5px;
    margin-right: 20px; /* Margen a la derecha */
    margin-bottom: 20px; /* Margen inferior */
    
    over
overflow: hidden;
}
</style>
<div class="row justify-content-center mt-3">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Orders Information
                </div>
                <div class="float-end">
                    <a href="{{ route('clients.order') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">

                    <div class="row">
                        <label for="code" class="col-md-4 col-form-label text-md-end text-start"><strong>Code:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $orders[0]->code }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $orders[0]->name }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="stock" class="col-md-4 col-form-label text-md-end text-start"><strong>Stock:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $orders[0]->stock}}
                        </div>
                    </div>

                    <div class="row">
                        <label for="price" class="col-md-4 col-form-label text-md-end text-start"><strong>Price:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $orders[0]->price }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="description" class="col-md-4 col-form-label text-md-end text-start"><strong>Description:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $orders[0]->description }}
                        </div>
                    </div>
                    <div class="row">
                        <label for="cantidad_productos" class="col-md-4 col-form-label text-md-end text-start"><strong>Cantidad de productos seleccionados:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            <input type="number" value='{{ $orders[0]->quantity }}'>
                        </div>
                    </div>
                    <div class="row">
                        <label for="links" class="col-md-4 col-form-label text-md-end text-start"><strong>Foto del articulo:</strong></label>
                        <img class="product-image" src="{{$orders[0]->links }}"  alt="{{ $orders[0]->name }}">
                    </div>
                    
            </div>
        </div>
    </div>    
</div>
    
@endsection