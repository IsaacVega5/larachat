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

    {{--
    <link rel="stylesheet" href="./resourses/css/style.css"> --}}

    <style>
        .container {
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 80%;
        }

        #chat-tittle {
            background-color: black;
            color: white;
        }

        .chat-row {
            margin: 50px;
            width: 100%;
        }

        ul {
            margin: 0;
            padding: 0;
            list-style: none;
            border: 2px solid black;
            border-radius: 10px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        ul li {
            padding: 8px;
        }

        ul li:hover {
            background-color: lightgray;
        }

        .chat-input {
            border: 2px solid black;
            border-radius: 10px;
            padding: 8px 10px;
            width: 100%;
        }

        .chat-section {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            width: 100%;
        }

        .chat-box {
            width: 100%;
        }

        #user-name {
            border: 2px solid black;
            border-radius: 10px;
            padding: 8px 10px;
        }

        #btn-enviar {
            width: 80px;
            height: 33px;
            margin-top: 5px;
            background: black;
            color: white;
            border: 2px solid black;
            border-radius: 10px;
        }

        #btn-enviar:active {
            background-color: white;
            color: black;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="cont-user-name">
            <input id="user-name" type="text" placeholder="Nombre...">
        </div>
        <div class="row chat-row">
            <div class="chat-content">
                <ul>
                    <li id="chat-tittle">
                        <stron>Chat:</stron>
                    </li>
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
    {{-- <script src="{{ asset('../js/script.js ') }}"></script> --}}
    <script>
        $(function () {
    let ip_adress = '127.0.0.1'; //Esta es la ip de la página
    let socket_port = '3000'; //El mismo que pusimos en el 'server.listen()'
    let socket = io(ip_adress + ':' + socket_port); //Le pasamos la ip y el puerto a socket.io



    let chatInput = $('#chatInput');
    chatInput.keypress(function (e) {
        // console.log(message);
        if (e.which === 13 && !e.shiftKey) {
            send();
            return false;
        }
    });

    $("#btn-enviar").on('click', function (e) {
        send();
        return false;
    })

    function send() {
        let chatInput = $('#chatInput');
        let chat = $(chatInput).html();
        let name = $('#user-name').val();
        let message = `<strong>${name}: </strong>${chat}`;

        if (name == "") {
            alert("El nombre no puede estar vacio");
            return false;
        }

        socket.emit('sendChatToServer', message);
        chatInput.html('');

    }

    socket.on('sendChatToClient', (message) => {
        // console.log(message);
        $('.chat-content ul').append(`<li> ${message} </li>`);
    });
    //Ahora para crear la conexión
    // socket.on('connection')
});
    </script>
</body>

</html>