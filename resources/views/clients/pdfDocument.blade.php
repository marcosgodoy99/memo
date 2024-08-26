<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remito de Orden</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #f8f9fa;
            font-size: 1.5rem;
            font-weight: bold;
            border-bottom: 2px solid #dee2e6;
        }
        .card-body {
            padding: 20px;
        }
        .table thead th {
            background-color: #f1f1f1;
            font-weight: bold;
            text-align: center;
        }
        .table tbody td {
            vertical-align: middle;
        }
        .text-primary {
            color: #007bff;
        }
        .total-section {
            border-top: 2px solid #dee2e6;
            padding-top: 15px;
            margin-top: 20px;
            text-align: right;
        }
        .total-section h2 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: bold;
        }
        .empty-message {
            text-align: center;
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Remito de Orden
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h2 class="text-center">Lista de Productos</h2>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Nombre del Producto</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio por Unidad</th>
                            <th scope="col">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->name }}</td>                         
                            <td class="text-center">{{ $order->quantity }}</td>
                            <td class="text-right text-primary">${{ number_format($order->price, 2, ',', '.') }}</td>
                            <td class="text-right text-primary">${{ number_format($order->precio_orden, 2, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="empty-message">
                                <strong>La orden está vacía</strong>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="total-section">
                    <h2>Total de la Orden: 
                        <b>${{ number_format($total[0]->precio_orden, 2, ',', '.') }}</b>
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Include Bootstrap JS and dependencies if necessary -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
