@extends('products.layouts')

@section('content')

<style>
     .product-image {
        width: 200px;
     }
</style>
<div class="row justify-content-center mt-3">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Informacion Del Producto
                </div>
                <div class="float-end">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">&larr; Atras</a>
                </div>
            </div>
            <div class="card-body">

                    <div class="row">
                        <label for="code" class="col-md-4 col-form-label text-md-end text-start"><strong>CODIGO</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $product->code }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>NOMBRE</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $product->name }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="stock" class="col-md-4 col-form-label text-md-end text-start"><strong>STOCK</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $product->stock }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="price" class="col-md-4 col-form-label text-md-end text-start"><strong>PRECIO</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $product->price }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="description" class="col-md-4 col-form-label text-md-end text-start"><strong>DESCRIPCION</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $product->description }}
                        </div>
                    </div>
                    
                    <div class="row">
                        <label for="links" class="col-md-4 col-form-label text-md-end text-start"><strong>FOTO DEL ARTICULO</strong></label>
                        <img class="product-image" src="{{$product->links }}"  alt="{{ $product->name }}">
                    </div>

            </div>
        </div>
    </div>    
</div>
    
@endsection