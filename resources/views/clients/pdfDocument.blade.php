
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remito de Distribuidora MEMO </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
        }
        
        .invoice-container {
            max-width: 1000px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
        }

        .header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .company-details,
        .invoice-details {
            display: inline-block;
            vertical-align: top;
        }

        .company-details {
            width: 50%;
        }

        .invoice-details {
            width: 48%;
            text-align: right;
        }

        .R{
            width: 100px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .invoice-details .big-text {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .invoice-details .small-text {
            font-size: 0.875rem;
        }

        .customer-info {
            margin: 20px 0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .items-table th {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>

    <div class="invoice-container">
        <div class="header">ORIGINAL - NO REGISTRADO EN AFIP</div>

        <div class="company-details">
            <div class="text-2xl font-bold">Distribuidora MEMO</div>
            <div>Domicilio: Santa Fe 194 </div>
        </div>

        <div class="invoice-details">
            <div class="small-text">REMITO</div>
            <div class="big-text">Nro de remito:  {{ $remito['nro'] }}</div>
            <div class="small-text">Fecha de Emision: {{ $remito['fechaEmision'] }}</div>
            <div class="small-text">Cuit: {{$remito['cuit']}}</div>
            <div class="small-text">Inicio de actividades:  {{ $remito['inicioActividades'] }}</div>
            <div class="small-text">Condicion IVA:   {{ $remito['condicionIva'] }}</div>
        </div>

        <div class="customer-info">
            <div>Cliente: {{ $remito['cliente'] }}</div>
            <div>Direccion: {{ $remito['direccion'] }}</div>
            <div>Cuit Cliente: {{ $remito['cuitCliente'] }} </div>
            <div> Condición frente al IVA: {{ $remito['condicionIvaCliente'] }}</div> 
            <div>Condición de venta: {{ $remito['condicionDeVenta'] }} </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Unidades</th>
                    <th>Precio unidad</th>
                    <th>precio subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->name }}</td>                         
                        <td>{{ $order->quantity }}</td>
                        <td class="text-primary">${{ number_format($order->price, 2, ',', '.') }}</td>
                        <td class="text-primary">${{ number_format($order->precio_orden, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <td colspan="6">
                        <span class="text-danger">
                            <strong>No ha hecho ninguna orden !!</strong>
                        </span>
                    </td>
                @endforelse
            </tbody>
        </table>
        <h4>Total de la Orden: 
                        <b>${{ number_format($total[0]->precio_orden, 2, ',', '.') }}</b>
        </h4>
    </div>

</body>


