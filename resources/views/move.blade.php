<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Real-time Messaging with socket - Demo</title>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBBs3uqoz2A_XWSx2b-QghXIH_3KBYksV4&sensor=true"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="https://cdn.socket.io/3.1.1/socket.io.min.js" integrity="sha384-gDaozqUvc4HTgo8iZjwth73C6dDDeOJsAgpxBcMpZYztUfjHXpzrpdrHRdVp8ySO" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

</head>
<body>
 Message: <input type="text" id="msg" size="100"/><br>
 To User ID: <input type="text" id="to" /> |
 Trip ID: <input type="text" id="trip_id" />
<input type="button" id="btn" value="chat"/>
<script>
    token = {!! json_encode($token) !!};

    $(document).ready(function () {
        var socket = io('http://127.0.0.1:2775');
        //var socket=io('{{Config("constants.CHAT_SOCKET_CLIENT")}}:{{Config("constants.CHAT_SOCKET_PORT")}}');
        socket.on("connect", () => {
            socket.emit('join', token);
        });
        socket.on('join',function (response){
            alert(response.text);
        });
        socket.on('chat',function (response){
            alert(response.msg+ " from user_id:"+response.from);
        });
        $(document).on('click','#btn',function () {
            var msg=$('#msg').val();
            var to=$('#to').val();
            var trip_id=$('#trip_id').val();
            // socket.on('chat',function (response){
            //     alert(response.msg+ " from user_id:"+response.from);
            // });
            socket.emit('chat', {to:to,trip_id:trip_id,msg:msg});

        });

    });

</script>
</body>
</html>
