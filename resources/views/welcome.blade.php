<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Larachat | socket.io</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('./css/style.css ') }}">
</head>

<body>
    <div class="container">
        <div class="cont-user-name">
            <input id="user-name" type="text" placeholder="Nombre...">
        </div>
        <div class="row chat-row">
            <div class="chat-content">
                <ul>
                    <li id="chat-tittle"><stron>Chat:</stron></li>
                </ul>
            </div>

            <div class="chat-section">
                <div class="chat-box">
                    <div id="chatInput" class="chat-input bg-white" contenteditable=""></div>
                </div>
                <button id="btn-enviar">Enviar</button>

            </div>
        </div>
    </div>


    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <!-- Socket.io -->
    <script src="https://cdn.socket.io/4.6.0/socket.io.min.js"
        integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+" crossorigin="anonymous">
    </script>

    <!-- Script -->
    <script src="{{ asset('./js/script.js ') }}"></script>
</body>

</html>