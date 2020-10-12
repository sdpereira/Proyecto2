<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ @csrf_token() }}">
    <link rel="stylesheet" href="css/plantilla.css">
    <link rel="shortcut icon" href="img/alien.png">
    <title>Practica SenaSoft 2020</title>

</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <div id="app">
        <header class="app-header navbar">
            <h3>Practica SenaSoft 2020</h3>
        </header>
        <div class="app-body">
            @include('plantilla.sidebar')
            @yield('contenido')
        </div>
    </div>
    <footer class="app-footer">
        <span> <a href="#">ADSI</a> &COPY; 2020 </span>
        <span class="ml-auto">Desarrollado por <a href="#">ADSI</a> <i class="fa fa-group"></i></span>

    </footer>
    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>
</body>

</html>
