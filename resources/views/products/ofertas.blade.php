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
  .main-container {
    display: flex;
  }

  .categories-container {
    width: 20%;
    padding: 20px;
    border-right: 1px solid #ccc;
    box-sizing: border-box;
  }

  .product-container {
    width: 80%;
    display: flex;
    flex-wrap: wrap;
    justify-content: left; 
    gap: 20px;
    padding: 20px;
    box-sizing: border-box;
  }

  .product-card {
    position: relative;
    flex: 1 1 200px;
    max-width: 200px;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
    box-sizing: border-box;
  }

  .product-image {
    width: 100%;
    height: 200px;
    object-fit: contain;
  }
  .product-image-container {
  position: relative;
}

  .product-details {
    padding: 10px;
  }

  .product-name {
    font-weight: bold;
    margin-bottom: 5px;
  }

  .product-price {
    color: #28a745;
    font-size: 18px;
  }

  .product-description {
    font-size: 14px;
    width: 100%;
    height: 80px;
    word-wrap: break-word;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;    
    text-overflow: ellipsis;
  }
  .product-price-discount {
    color: #888; /* Puedes ajustar el color según tu diseño */
    font-size: 1rem; /* Tamaño de fuente, ajustable según tu preferencia */
    text-decoration: line-through; /* Tacha el texto */
    margin-right: 10px; /* Espaciado a la derecha */
}

  .product-button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
  }
  .product-button:hover {
    background-color: #033972;
  }

  .sold-button {
    width: 100%;
    padding: 10px;
    background-color: #bd0606;
    color: #ffffff;
    border: none;
    cursor: pointer;
  }

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
  .btn-custom {
    display: block;
    background-color: #f1f1f1; /* Fondo claro */
    color: #333; /* Color del texto */
    padding: 8px 15px; /* Padding más pequeño (8px en la parte superior e inferior) */
    margin-bottom: 8px; /* Menos espacio entre los elementos */
    border-radius: 5px; /* Bordes ligeramente redondeados */
    border: 1px solid #ddd; /* Borde claro */
    font-size: 1rem; /* Tamaño de fuente un poco más pequeño */
    text-align: left; /* Alineación del texto */
    text-decoration: none; /* Sin subrayado */
    transition: background-color 0.3s ease, transform 0.3s ease; /* Transiciones suaves */
}

.btn-custom:hover {
    background-color: #e0e0e0; /* Fondo más oscuro al hacer hover */
    transform: scale(1.02); /* Efecto de agrandar ligeramente */
    cursor: pointer; /* Cambiar el cursor a pointer */
}

.btn-custom:active {
    background-color: #d4d4d4; /* Fondo más oscuro al hacer clic */
    transform: scale(1); /* Vuelve al tamaño original al hacer clic */
}
.header-categorias {
  font-size: 1.25em;
  text-decoration: underline;
}
.image-category-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 20px;
  }

  .image-category {
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 5px;
    cursor: pointer;
  }
  .no-offers-message-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start; /* Cambiado de center a flex-start */
    width: 100%;
    height: 100vh;
    text-align: center;
    padding-top: 20vh; /* Añadir padding para ajustar hacia arriba */
}

.no-offers-message {
    color: red;
    font-weight: bold;
    font-size: 24px;
    margin-bottom: 20px;
}

.back-button {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s ease, transform 0.2s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.back-button:hover {
    background-color: #0056b3;
    transform: scale(1.05);
    cursor: pointer;
}

.back-button:active {
    background-color: #004080;
    transform: scale(1);
}
.off-image {
    position: absolute;
    top: 5px; /* Ajusta la posición vertical */
    right: 5px; /* Ajusta la posición horizontal */
    width: 60px; /* Tamaño más grande */
    height: 60px; /* Tamaño más grande */
    object-fit: contain; /* Asegura que la imagen no se deforme */
    z-index: 1; /* Asegura que la imagen esté por encima de la imagen del producto */
}

</style>
</head>
<body>

  @if ($message = Session::get('success'))
      <div class="alert alert-success d-flex justify-content-between align-items-center" role="alert">
          {{ $message }}
      </div>
  @endif
  @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @endif

  <div class="search-container">
    <form action="{{route('clients.buscarProductos') }}" method="get" class="search-form">
      @csrf
      <input type="search" name="nombreProducto" id="nombreProducto" class="search-input" placeholder="Buscar producto...">
      <button type="submit" class="search-button"><i class="bi bi-search"></i></button>
    </form>

    @if (!empty($mensaje))
    <div class="search-result-message">
      El resultado de la búsqueda es: "{{ $mensaje }}"
    </div>
    <a href="{{route('dashboard')}}" class=""><i class="bi bi-x-circle-fill"></i></a>

    @endif
  </div>

    <!-- Productos -->
<div class="product-container">
  @forelse ($products as $product)

    <div class="product-card" id="product-{{$product->id}}">

      <div class="product-image-container">
        <img class="product-image" src="{{ asset($product->links) }}" alt="{{ $product->name }}">
        @if($product->precioReal > $product->price)
          <img class="off-image" src="{{ asset('images/off.png') }}" alt="Off">
        @endif
      </div>

      <div class="product-details">
        <div class="product-name">{{ $product->name }}</div>
        <div class="product-price-discount">${{ number_format($product->precioReal, 2, ',', '.') }}</div>
        <div class="product-price">${{ number_format($product->price, 2, ',', '.') }}</div>
        <div class="product-description">{{ $product->description }}</div>

        @if($product->stock > 0)
          <form action="{{ route('orders.buy') }}" method="get"> 
            @csrf
            <input type="hidden" name="products_id" value="{{ $product->id }}">
            <input type="hidden" name="users_id" value="{{ $users->id }}">
            <input type="hidden" name="name" value="{{$product->name}}">
            <button class="product-button" type="submit">Comprar</button>
          </form>
        @else
          <button class="sold-button" type="submit">Sold</button>
        @endif

      </div>
    </div>
    @empty
  <div class="no-offers-message-container">
    <div class="no-offers-message">
      No hay ofertas disponibles
    </div>
    <a href="{{ route('dashboard') }}" class="back-button">&larr; Volver</a>
  </div>
@endforelse



</body>
</html>
</x-app-layout>
@endsection
