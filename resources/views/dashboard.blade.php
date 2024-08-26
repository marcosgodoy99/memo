

@extends('products.layouts')

@section('content')
<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lista de Productos</title>
<style>
  /* Estilos CSS */
  .product-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin: 20px;
  }

  .product-card {
    width: 200px;
    
 
border: 1px solid #ccc;
    border-radius: 5px;
    margin-right: 20px; /* Margen a la derecha */
    margin-bottom: 20px; /* Margen inferior */
    
    over
overflow: hidden;
}

  .product-image {
    width: 100%;
    height: 200px;
    object-fit: contain;
  }

  .product-details {
    padding: 10px;
  }

  .product-name {
    font-weight: bold;
    margin-bottom: 5px;
  }

  .product-price {
    color: #007bff;
    font-size: 18px;
  }

  .product-description {
    font-size: 14px;
  }

  .product-button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;

    
  }

  .product-quantity {
    width: 50px; 
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 14px;
    text-align: center;
    margin-bottom: 10px;
    background-color: #f9f9f9; 
  }
 

</style>
</head>
<body>
    @if ($message = Session::get('success'))
              <div class="alert alert-success d-flex justify-content-between align-items-center" role="alert">
                  {{ $message }}
                  
                      <a href="{{ route('clients.order') }}" class="btn btn-outline-info">
                          <i class="bi bi-cart-check-fill "> Ir al carrito</i>
                      </a>
                      {{-- <button type="submit" class="btn btn-outline-info"> Ir al carrito</button> --}}

                  
              </div>
          @endif
  <div class="product-container" >
    <!-- Primer Producto -->
    @foreach ($products as $product)
    <div class="product-card">
      <img class="product-image" src="{{$product->links }}"  alt="{{ $product->name }}">
      <div class="product-details">
        <div class="product-name">{{ $product->name }}</div>
        <div class="product-price">${{ $product->price }}</div>
        <div class="product-description">{{ $product->description }}</div>
        <form action="{{ route('orders.order') }}" method="post"> 
         @csrf
          <input type="hidden" name="products_id" value="{{ $product->id }}">
          <input type="hidden" name="users_id" value="{{ $users->id }}">
          <input type="hidden" name="name" value="{{$product->name}}">
          <input type="number" class="product-quantity" name="quantity" min="1" value="1">
          <button class="product-button" type="submit">Comprar</button>
        </form>
    </div>
    </div>
    @endforeach
    <!-- Más productos aquí -->
  </div>
</body>
</html>
</x-app-layout>
@endsection
