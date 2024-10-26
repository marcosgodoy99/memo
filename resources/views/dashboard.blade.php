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
    padding: 10px;
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
</style>
</head>
<body>

  @if ($message = Session::get('success'))
      <div class="alert alert-success d-flex justify-content-between align-items-center" role="alert">
          {{ $message }}
          <a href="{{ route('clients.order') }}" class="btn btn-outline-info">
              <i class="bi bi-cart-check-fill"> Ir al carrito</i>
          </a>
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

  <div class="main-container">
    <!-- Listado de categorías -->
    <div class="categories-container">
      <div class="header-categorias">Categorías</div>
      <ul>
          @forelse ($categorias as $category)
              <li><a href="{{ route('clients.filtrarPorCategoria', [$category->id]) }}" class="btn-custom">{{ $category->name }}</a></li>
          @empty
              <li>No hay categorías disponibles.</li> <!-- Aquí puedes personalizar tu mensaje -->
          @endforelse
      </ul>
  </div>

    <!-- Productos -->
    <div class="product-container">
      @foreach ($products as $product)

      <div class="product-card" id="product-{{$product->id}}">
        <img class="product-image" src="{{$product->links }}" alt="{{ $product->name }}">
        <div class="product-details">
          <div class="product-name">{{ $product->name }}</div>
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
      @endforeach
    </div>
  </div>

</body>
</html>
</x-app-layout>
@endsection
