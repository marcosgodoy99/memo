@extends('clients.layouts')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:"poppins",sans-serif;
}

body{
    display: flex;
    justify-content:top;
    align-items: center;
    text-align: center;
    min-height: 100vh;
    background-image: url('https://cdn.dribbble.com/users/1365713/screenshots/7150856/media/db6c50fe37d3374e2ad1674aace52204.png?resize=768x576&vertical=center');
    background-repeat:no-repeat;
    background-size: 78%;
    background-position:top center;
    background-attachment: fixed;
    background-color:black;
}

.fondito {
    width: 420px;
    background: transparent;
    border: 2px solid rgba(255, 255, 255, .2);
    backdrop-filter: blur(20px);
    color: #ffff;
    border-radius: 10px;
    padding: 30px 40px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.fondito h1 {
    font-size:32px;
    text-align:center;
    color:black;
}

.fondito .input-box{
    width:100%;
    height:auto;
    margin:30px 0;
}
.register p {
    font-size:17px;
   
  }

.register a {
    font-size:17px;
    color: #16C6FA;
    text-decoration: none;
  }

.input-box input{
    width:100%;
    height:100%;
    background:transparent;
    border:none;
    outline:none;
    border:2px solid rgba(255, 255, 255, .2);
    border-radius:40px;
    font-size:16px;
    color:#FFFFFF;
    padding: 15px;
    margin-bottom: 10px;

}

.input-box input::placeholder{
    color:#FFFF;
}
    </style>
</head>
<body>
    <div class="fondito h1">
        <form action="login.blade.php" method="POST">
            <h1>Iniciar Sesión</h1>
            <div class="input-box">
                <input type="text" name="nombre" placeholder="Nombre...">
            </div>
            <div class="input-box">
                <input type="text" name="apellido" placeholder="Apellido...">
            </div>
            <button type="submit" class="btn btn-primary" name="iniciar">Iniciar Sesión</button>
            <div class="register">
                <p>¿No tienes una cuenta?<a href="{{ route('clients.create') }}"></i> Crear un nuevo usuario </a></p>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
@endsection