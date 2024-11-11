
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

        @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @endif

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
                                    @if (!$descuento->contains('product_id', $product->id))
                                        <!-- Si no tiene descuento, mostrar el botón de descuento del 10% -->
                                        <a href="{{ route('product.descuento', $product->id) }}" class="btn btn-success btn-sm">-10%</a>
                                    @else
                                        <!-- Si ya tiene descuento, mostrar un mensaje o nada -->
                                        <span>Descuento aplicado</span>
                                    @endif
                                    
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

