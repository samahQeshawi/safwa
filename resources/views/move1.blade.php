<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- <title>Laravel</title> --}}
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBBs3uqoz2A_XWSx2b-QghXIH_3KBYksV4&sensor=true"></script>
        <title>Real-time Tracking with socket - Demo</title>
        {{-- <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBBs3uqoz2A_XWSx2b-QghXIH_3KBYksV4&sensor=true"></script> --}}
        <script type="text/javascript" src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
        <script src="https://cdn.socket.io/3.1.1/socket.io.min.js" integrity="sha384-gDaozqUvc4HTgo8iZjwth73C6dDDeOJsAgpxBcMpZYztUfjHXpzrpdrHRdVp8ySO" crossorigin="anonymous"></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    </head>
    <body>
    <script>
    $(document).ready(function () {
        var token = {!! json_encode($token) !!};
        var trip_id = {!! json_encode($trip_id) !!};

        // var token = "PrDktavJMYbqYP7O1iFLudguMmMIDX7sM9ys66EFW3KGK3JbzR";
        // var trip_id=3;
        var socket=io('{{Config("constants.CHAT_SOCKET_CLIENT")}}:{{Config("constants.CHAT_SOCKET_PORT")}}');

        //var socket = io('http://{{env('CHAT_SOCKET_HOST')}}:{{env('CHAT_SOCKET_PORT')}}');
        socket.on("connect", () => {
            socket.emit('join', token);

            socket.on('join',function (response){
                socket.emit('join_trip', {trip_id: trip_id, socket_token: token});
            });

            // 26.6852013
            // 42.6896617
            var lat=26.6852013;
            var lng=42.6896617;

            var intervalId = window.setInterval(function(){
            /// call your function here
                lat += 0.01;
                lng += 0.01;
                console.log("Lat: " + lat + ", Lng: " + lng);
                socket.emit('send_trip_track', {trip_id,lat,lng});
                // if(lat == 27 || lng == 43)
                //     clearInterval(intervalId)
            }, 5000);




        });
    });

    </script>
    </body>
</html>

