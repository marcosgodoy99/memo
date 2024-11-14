@extends('clients.layouts')

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
                <div class="card-header">Editar Remito #{{ $remito->numberRemito }}</div>
                <div class="card-body">
                    <form action="{{ route('remito.update', $remito->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5>Productos del Remito</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lineasRemito as $linea)
                                <tr>
                                    <td>{{ $linea->producto_name }}</td>
                                    <td>
                                        <input type="number" name="productos[{{ $linea->idProduct}}]" 
                                               value="{{ $linea->quantity }}" min="0" class="form-control">
                                    </td>
                                    <td>{{ $linea->price }}</td>
                                    <td>{{ $linea->price * $linea->quantity }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger" 
                                                onclick="removeProduct({{ $linea->idProduct }})">Eliminar</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary">Actualizar Remito</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    function removeProduct(productId) {
        // Aquí podemos hacer una solicitud Ajax para eliminar un producto de las líneas del remito
        if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
            // Si estás utilizando un formulario tradicional, también puedes hacer esto con el formulario
            // para eliminar el producto, si lo prefieres hacer por formulario en lugar de Ajax
            document.querySelector('input[name="productos[' + productId + ']"]').value = 0;
        }
    }
</script>

@endsection
