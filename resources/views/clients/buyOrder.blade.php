@extends('clients.layouts')

@section('content')

<style>
    .product-card {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        text-align: center;
        position: relative; /* Para que el botón de atrás pueda estar en la esquina */
    }

    .product-image {
        width: 200px; /* Ajuste del ancho de la imagen */
        height: auto;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .product-info {
        font-size: 18px;
        margin-bottom: 15px;
        text-align: center;
    }

    .product-info strong {
        font-weight: bold;
        color: #333;
    }

    .product-header {
        margin-bottom: 20px;
    }

    .product-header h2 {
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .btn-back {
        position: absolute;
        top: 20px;
        right: 20px; /* Alinea el botón a la derecha */
        background-color: #007bff;
        color: #fff;
        padding: 5px 10px;
        font-size: 14px;
        border-radius: 5px;
        text-decoration: none;
    }

    .btn-back:hover {
        background-color: #0056b3;
        color: #fff;
    }

    .price {
        font-size: 24px;
        font-weight: bold;
        color: #28a745;
        margin-bottom: 20px;
    }

    .description {
        font-size: 16px;
        color: #666;
        line-height: 1.5;
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px; /* Espacio entre el campo de cantidad y el botón */
        margin-bottom: 20px;
    }

    .product-quantity {
        width: 60px;
        padding: 5px;
        font-size: 16px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .btn-buy {
        background-color: #28a745;
        color: #fff;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-buy:hover {
        background-color: #218838;
        color: #fff;
    }
</style>

<div class="row justify-content-center mt-3">
    <div class="col-md-8">
        <div class="product-card">
            <div class="product-header">
                <h2>{{ $product[0]->name }}</h2>
            </div>

            <a href="{{ route('dashboard') }}" class="btn-back">&larr; Atras</a>

            <img class="product-image" src="{{ $product[0]->links }}" alt="{{ $product[0]->name }}">

            <div class="price">${{ number_format($product[0]->price, 2) }}</div>

            <div class="product-info">
                <strong>Description:</strong>
                <p class="description">{{ $product[0]->description }}</p>
            </div>

            <form action="{{ route('orders.order') }}" method="post">
                @csrf
                <input type="hidden" name="products_id" value="{{ $product[0]->id }}" >
                <input type="hidden" name="users_id" value="{{ $idUser }}">
                <input type="hidden" name="name" value="{{$product[0]->name}}">
                
                <input type="number" class="product-quantity" name="quantity" min="1" value="1"> 
                <div class="form-group">
                    <button type="submit" class="btn-buy">Comprar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
