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