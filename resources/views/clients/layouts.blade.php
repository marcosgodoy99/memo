<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <style> .product-quantity {
        width: 60px; 
       
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 14px;
        text-align: center;
        margin-bottom: 10px;
        background-color: #f9f9f9; 
      }
      .btn-custom {
            background-color: #5d9ff5; /* Cambia esto al color que desees */
            color: white;
            padding: 8px 30px; 
            font-size: 1.25rem;
        }
        .btn-custom:hover {
            background-color: #095dac; /* Color al pasar el cursor, opcional */
        }
      </style>
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Proyecto Memo distribuciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    
    @livewireScripts
    <div class="container">
            @yield('content')
        <div class="row justify-content-center text-center mt-3">
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
