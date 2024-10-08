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
    object-fit: cover;
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
</style>
</head>
<body>
  <div class="product-container">
    <!-- Primer Producto -->
    @foreach ($products as $product)
    <div class="product-card">
      <img class="product-image" src="{{$product->links }}" alt="Producto 1">
      <div class="product-details">
        <div class="product-name">{{ $product->name }}</div>
        <div class="product-price">{{ $product->price }}</div>
        <div class="product-description">{{ $product->description }}</div>
        <button class="product-button">Comprar</button>
      </div>
    </div>
    @endforeach
    <!-- Más productos aquí -->
  </div>
</body>
</html>
</x-app-layout>
@endsection