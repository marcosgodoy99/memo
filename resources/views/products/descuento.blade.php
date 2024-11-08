@extends('products.layouts')

@section('content')

<div class="row justify-content-center mt-3">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Agregar Nuevo descuento
                </div>
                <div class="float-end">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">&larr; Atras</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard') }}" method="post">
                    @csrf

                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">NOMBRE DESCUENTO</label>
                        <div class="col-md-6">
                          <input type="text"  class="form-control @error('name') is-invalid @enderror" pattern="[A-Za-z\s]+" id="name" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Crear">
                    </div>
                    


                    @extends('products.layouts')

@section('content')
<x-app-layout>

<style>
    .search-container {
    margin-top: 20px; /* Ajusta la distancia superior */
    display: flex;
    align-items: center;
    gap: 20px; /* Espacio entre el campo de búsqueda y el mensaje */
  }

  .search-input {
    padding: 10px;
    border-radius: 20px; /* Bordes redondeados */
    border: 1px solid #ccc;
    width: 250px;
    box-sizing: border-box;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Añade un sombreado suave */
    margin-left: 5px;
  }

  .search-button {
    padding: 8px;
    border-radius: 20px; /* Bordes redondeados para el botón también */
    background-color: #28a745;
    color: white;
    border: none;
    cursor: pointer;
  }

  .search-result-message {
    font-size: 16px;
    color: #555;
    font-weight: bold;
  }

  .search-button i {
    margin-right: 5px;
  }
</style>
<div class="row justify-content-center mt-3">
    <div class="col-md-12">

        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">Lista de productos</div>
                <div class="search-container">
                    <form action="{{route('product.buscarProductos') }}" method="get" class="search-form">
                    @csrf
                    <input type="search" name="nombreProducto" id="nombreProducto" class="search-input" placeholder="Buscar producto...">
                    <button type="submit" class="search-button"><i class="bi bi-search"></i></button>
                    </form>
                
                    @if (!empty($mensaje))
                    <div class="search-result-message">
                    El resultado de la búsqueda es: "{{ $mensaje }}"
                    </div>
                    <a href="{{route('products.index')}}" class=""><i class="bi bi-x-circle-fill"></i></a>
                
                    @endif
                </div>
            <div class="card-body">
                <a href="{{ route('products.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Agregar Nuevo Producto</a>
                <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">CODIGO</th>
                        <th scope="col">NOMBRE PRODUCTO</th>
                        <th scope="col">STOCK</th>
                        <th scope="col">PRECIO</th>
                        <th scope="col">ACCION</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->price }}</td>
                            <td>
                            
                            
                                <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Editar</a>

                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this product?');"><i class="bi bi-trash"></i> </button>
                                    
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i></a>
                        
                                    
                                    
                                </form>
                            </td>
                        </tr>
                        @empty
                            <td colspan="6">
                                <span class="text-danger">
                                    <strong>Producto no encontrado!</strong>
                                </span>
                            </td>
                        @endforelse
                    </tbody>
                  </table>

                  {{ $products->links() }}

            </div>
        </div>
    </div>    
</div>
</x-app-layout>
@endsection
