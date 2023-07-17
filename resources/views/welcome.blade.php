<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat | test</title>
    <style>
        body {
            display: flex;
            margin: 0;
            padding: 0;
            height: 100vh;
            width: 100%;
            font-family: Arial, Helvetica, sans-serif;
        }

        .cont {
            display: flex;
            flex-direction: column;
            margin: auto;
            padding: 20px;
            height: 80%;
            width: 60%;
            min-width: 500px;
            border-radius: 20px;
            border: 2px solid black;
            gap: 10px
        }

        .chat-box {
            height: 500px;
            width: 100%;
            border: 2px solid black;
            /* border-radius: 20px; */
            overflow: hidden;
        }

        .chat-input,
        .room-input {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 35px;
            border-radius: 20px;
            border: 2px solid black;
            overflow: hidden;
        }

        .chat-input *,
        .room-input * {
            height: 100%;
            border: none;
        }

        span,
        .btn-send {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 15%;
        }

        .user-input {
            width: 70%;
            padding: 0;
            border-left: 2px solid black;
            border-right: 2px solid black;
            padding-left: 5px;
            overflow: hidden;
        }

        #msg-input {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .btn-send {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 15%;
            min-width: fit-content;
            background-color: black;
            color: white;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-send:hover {
            letter-spacing: 2px;
        }

        .btn-send:active {
            background-color: white;
            color: black;
        }

        .user-name {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 30px;
            border: 2px solid black;
            border-radius: 20px;
            overflow: hidden;
        }

        #input-name {
            height: 100%;
            width: 85%;
            border: none;
            padding-left: 5px;
            border-left: 2px solid black;
        }

        ul {
            margin: 0;
            height: 100%;
            list-style: none;
            padding: 10px;
            overflow-y: scroll;
        }

        ul li {
            width: auto;
            padding: 5px;
        }

        ul li:hover {
            background-color: lightgray;
        }
    </style>
</head>

<body>
    <div class="cont">
        <div class="user-name">
            <span>Name:</span>
            <input id="input-name" type="text" placeholder="Name...">
        </div>
        <div class="chat-box">
            <ul id="chat-list">
            </ul>
        </div>
        <div class="chat-input">
            <span>Message:</span>
            <div id="msg-input" class="user-input" name="user-msg" contenteditable="true"></div>
            <button id="btn-msg" class="btn-send">Send</button>
        </div>
        <div class="room-input">
            <span>Room:</span>
            <input id="room-input" class="user-input" type="text" name="user-msg">
            <button id="btn-room" class="btn-send">Join</button>
        </div>
    </div>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <!-- Socket.io -->
    <script src="https://cdn.socket.io/4.6.0/socket.io.min.js"
        integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+" crossorigin="anonymous">
    </script>

    <!-- Script -->
    <script>
        // import {io} from 'socket.io-client';
const socket = io('https://socket-io-server-7rlr.onrender.com');
var room = ""
$( document ).ready(function(){
    //Mensaje de conexión
    socket.on('connect', ()=>{
        msgNew(`<strong>Connected with id:</strong> ${socket.id}`)
    });
    //Recibir mensajes
    socket.on('share-msg', (msg) =>{
        msgNew(msg);
    });

    //Enviar mensaje
    $('#btn-msg').on('click', function(e){
        send();
    });
    $('#msg-input').on('keypress', function(e){
        if (e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            send();
        }
    });

    //Unirse a una sala
    $('#btn-room').on('click', function(e){
        joinRoom();
    });
    $('#room-input').on('keypress', function(e){
        if (e.keyCode === 13) {
            e.preventDefault();
            joinRoom();
        }
    });

    function joinRoom(){
        let name = $('#input-name').val();
        let input_room = $('#room-input').val(); //Get user input room

        if(input_room==""){
            room = "";
            return msgNew('<strong>You are in the public chat</strong>')
        };
        room = input_room;

        if(name === "") return alert("Write your name");

        
        // let msgRoom = `<strong style="color:blue">Just join to room:</strong> ${room}`; //Comeback to the user informing his connection to the room

        socket.emit('join-room', room, callback =>{
            msgNew(callback);
        });
        socket.emit('send-msg', `<strong style="color:blue">${name} just join</strong>`, room)
        // msgNew(msgRoom);
    }
    //Enviar un mensaje
    function send(){
        let msg = $('#msg-input').html();
        let name = $('#input-name').val();
        let chat_msg = ""
        if (name=="") return alert("Write your name")
        if (msg=="") return alert("Write your message")
        
        let input_room = $('#room-input').val(); //Get user input room

        if(room === ""){
            chat_msg = input_room === "" ? `<strong>${name}:</strong> ${msg}` : `<strong style="color:red">(Privado) ${name}: </strong> ${msg}`;
        }
        else{
            chat_msg = `<strong style="color:blue">(${room}) ${name}: </strong> ${msg}`
        }

        msgNew(chat_msg);
        socket.emit('send-msg', chat_msg, input_room);
        
        $('#msg-input').html('');
    };

    //Añadir un mensaje a la lista
    function msgNew(msg){
        let lista = document.getElementById('chat-list')
        $('#chat-list').append(`<li>${msg}</li>`);
        $('#chat-list').scrollTop(lista.scrollHeight);
    }
});
    </script>
</body>

</html>