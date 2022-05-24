@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1 class="m-0 text-dark">{{__('dashboard.title')}}</h1>
@stop

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{$total_cities}}</h3>

                <p>{{__('dashboard.total_title',['items'=>'cities'])}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('cities.city.index') }}" class="small-box-footer">{{__('dashboard.more_info')}} <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{$total_drivers}}</h3>

                <p>{{__('dashboard.total_title',['items'=>'drivers'])}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('drivers.driver.index') }}" class="small-box-footer">{{__('dashboard.more_info')}} <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$total_bookings}}</h3>

                <p>{{__('dashboard.total_title',['items'=>'bookings'])}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('booking.index') }}" class="small-box-footer">{{__('dashboard.more_info')}} <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{$total_trip}}</h3>

                <p>{{__('dashboard.total_title',['items'=>'trips'])}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('trip.index') }}" class="small-box-footer">{{__('dashboard.more_info')}} <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{$total_customers}}</h3>

                <p>{{__('dashboard.total_title',['items'=>'customers'])}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('customer.index') }}" class="small-box-footer">{{__('dashboard.more_info')}} <i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <!-- ./col -->
    <!-- ./col -->
</div>
<div class="row">
    <div class="col">
        {{-- <drivers :user="{{ auth()->user() }}"></drivers> --}}




    </div>
</div>
<div class="panel panel-default">
          <div style="width:100%; height:620px;">
              <div id="map_canvas" style="width: 100%; height: 100%"></div>
          </div>
</div>
 <div class="chatbox-holder">

      </div>
<!-- /.row -->
@stop
@section('js')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBBs3uqoz2A_XWSx2b-QghXIH_3KBYksV4&sensor=true"></script>
<script>
    // insialization map view
var lat1=26.726046;
var lng1=44.639191;
let markers = [];
var rotation = 0;



const Latlng = { lat: lat1, lng: lng1 };

    function initialize(callback) {
        const myLatlng = { lat: lat1, lng: lng1 };
        var myOptions = {
            center: myLatlng,
            zoom: 10,
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        callback(map);
    }
    initialize(function (map) {

        function addVehicle(vehicle) {

            var icon = {
                path: "M -53.582954,-415.35856 C -67.309015,-415.84417 -79.137232,-411.40275 -86.431515,-395.45159 L -112.76807,-329.50717 C -131.95714,-324.21675 -140.31066,-310.27864 -140.75323,-298.84302 L -140.75323,-212.49705 L -115.44706,-212.49705 L -115.44706,-183.44029 C -116.67339,-155.74786 -71.290042,-154.67757 -70.275134,-183.7288 L -69.739335,-212.24976 L 94.421043,-212.24976 L 94.956841,-183.7288 C 95.971739,-154.67759 141.39631,-155.74786 140.16998,-183.44029 L 140.16998,-212.49705 L 165.43493,-212.49705 L 165.43493,-298.84302 C 164.99236,-310.27864 156.63886,-324.21677 137.44977,-329.50717 L 111.11322,-395.45159 C 103.81894,-411.40272 91.990714,-415.84414 78.264661,-415.35856 L -53.582954,-415.35856 z M -50.57424,-392.48409 C -49.426163,-392.49037 -48.215854,-392.45144 -46.988512,-392.40166 L 72.082372,-392.03072 C 82.980293,-392.28497 87.602258,-392.03039 92.236634,-381.7269 L 111.19565,-330.61998 L -86.30787,-330.86727 L -67.554927,-380.61409 C -64.630656,-390.57231 -58.610776,-392.44013 -50.57424,-392.48409 z M -92.036791,-305.02531 C -80.233147,-305.02529 -70.646071,-295.47944 -70.646071,-283.6758 C -70.646071,-271.87217 -80.233147,-262.28508 -92.036791,-262.28508 C -103.84043,-262.28508 -113.42751,-271.87216 -113.42751,-283.6758 C -113.42751,-295.47946 -103.84043,-305.02531 -92.036791,-305.02531 z M 117.91374,-305.02531 C 129.71738,-305.02533 139.26324,-295.47944 139.26324,-283.6758 C 139.26324,-271.87216 129.71738,-262.28508 117.91374,-262.28508 C 106.1101,-262.28507 96.523021,-271.87216 96.523021,-283.6758 C 96.523021,-295.47944 106.1101,-305.02531 117.91374,-305.02531 z M 103.2216,-333.14394 L 103.2216,-333.14394 z M 103.2216,-333.14394 C 103.11577,-333.93673 102.96963,-334.55679 102.80176,-335.21316 C 101.69663,-339.53416 100.2179,-342.16153 97.043938,-345.3793 C 93.958208,-348.50762 90.488134,-350.42644 86.42796,-351.28706 C 82.4419,-352.13197 45.472822,-352.13422 41.474993,-351.28706 C 33.885682,-349.67886 27.380491,-343.34759 25.371094,-335.633 C 25.286417,-335.3079 25.200722,-334.40363 25.131185,-333.2339 L 103.2216,-333.14394 z M 64.176391,-389.01277 C 58.091423,-389.00227 52.013792,-385.83757 48.882186,-379.47638 C 47.628229,-376.92924 47.532697,-376.52293 47.532697,-372.24912 C 47.532697,-368.02543 47.619523,-367.53023 48.822209,-364.99187 C 50.995125,-360.40581 54.081354,-357.67937 59.048334,-355.90531 C 60.598733,-355.35157 62.040853,-355.17797 64.86613,-355.27555 C 68.233081,-355.39187 68.925861,-355.58211 71.703539,-356.95492 C 75.281118,-358.72306 77.90719,-361.35074 79.680517,-364.96188 C 80.736152,-367.11156 80.820083,-367.68829 80.820085,-372.0392 C 80.820081,-376.56329 80.765213,-376.87662 79.470596,-379.50637 C 76.3443,-385.85678 70.261355,-389.02327 64.176391,-389.01277 z",
                //path:"M204.2,564.3c-56.9,0-103.2,46.3-103.2,103.2s46.3,103.2,103.2,103.2s103.2-46.3,103.2-103.2S261.1,564.3,204.2,564.3z M204.2,714.2c-25.8,0-46.7-21-46.7-46.8c0-25.801,21-46.801,46.7-46.801c25.8,0,46.8,21,46.8,46.801 C251,693.2,230,714.2,204.2,714.2z M733.1,564.3c-56.899,0-103.2,46.3-103.2,103.2S676.2,770.7,733.1,770.7c56.9,0,103.2-46.3,103.2-103.2 S790,564.3,733.1,564.3z M779.899,667.5c0,25.8-21,46.8-46.8,46.8s-46.8-21-46.8-46.8s21-46.8,46.8-46.8 S779.899,641.7,779.899,667.5z",
                //path:"M29.395,0H17.636c-3.117,0-5.643,3.467-5.643,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759   c3.116,0,5.644-2.527,5.644-5.644V6.584C35.037,3.467,32.511,0,29.395,0z M34.05,14.188v11.665l-2.729,0.351v-4.806L34.05,14.188z    M32.618,10.773c-1.016,3.9-2.219,8.51-2.219,8.51H16.631l-2.222-8.51C14.41,10.773,23.293,7.755,32.618,10.773z M15.741,21.713   v4.492l-2.73-0.349V14.502L15.741,21.713z M13.011,37.938V27.579l2.73,0.343v8.196L13.011,37.938z M14.568,40.882l2.218-3.336   h13.771l2.219,3.336H14.568z M31.321,35.805v-7.872l2.729-0.355v10.048L31.321,35.805",
                fillColor: vehicle.color,
                strokeColor: "#2d2d2d",
                fillOpacity: 1,
                //anchor: new google.maps.Point(12,-290),
                strokeWeight: 1,
                scale: 0.06,
                rotation: 0
            }

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(vehicle.lat, vehicle.lng),
                rotation: 0,
                map: map,
                icon:icon,
                title: vehicle.name,
                mapTypeId: "terrain",
                id:vehicle.id,
                driver_name:vehicle.name,
                trip_no:vehicle.trip_no,
                user_id:vehicle.user_id,
                profile_image:vehicle.profile_image,
                status:vehicle.status,
                phone:vehicle.phone,
                email:vehicle.email
            });

            marker.addListener("click", (e) => {
                toggleBounce(marker);
            });
            markers.push(marker);
        }

        @foreach($trips as $trip)
            addVehicle(<?php echo json_encode($trip) ?>);
        @endforeach

        function toggleBounce(marker) {
            map.setZoom(15);
            //alert(marker.getPosition());
            map.setCenter(marker.getPosition());
            var status='';
            switch (parseInt(marker.status)){
                case 1: status='New';break;
                case 2: status='Pending';break;
                case 3: status='No driver available';break;
                case 4: status='Driver accepted';break;
                case 5: status='Driver reached pickup location';break;
                case 6: status='Trip started';break;
                case 7: status='Reached destination';break;
                case 8: status='Completed trip';break;
                case 9: status='Money collected';break;
                case 10: status='Trip cancelled by driver';break;
                case 11: status='Trip cancelled by customer';break;
            }

            const contentString =
                '<div id="Car'+marker.id+'" class="table-responsive">'+
                '<table class="table">'+
                    '<tbody>'+
                        '<tr>'+
                        '<th scope="row">Trip No : </th>'+
                        '<td>'+marker.trip_no+'</td>'+
                        '</tr>'+
                        '<tr>'+
                        '<th scope="row">Trip Status : </th>'+
                        '<td>'+status+'</td>'+
                        '</tr>'+
                        '<tr>'+
                        '<th scope="row">Driver Name : </th>'+
                        '<td>'+marker.driver_name+'</td>'+
                        '</tr>'+
                        '<tr>'+
                        '<th scope="row">Driver Image : </th>'+
                        '<td><img src="" style="max-height: 80px; max-width: 80px;" class="driver_image"/></td>'+
                        '</tr>'+
                        '<tr>'+
                        '<th scope="row">Driver Email : </th>'+
                        '<td>'+marker.email+'</td>'+
                        '</tr>'+
                        '<tr>'+
                        '<th scope="row">Driver Phone : </th>'+
                        '<td>'+marker.phone+'</td>'+
                        '</tr>'+
                        '<tr>'+
                        '<td colspan="2" style="text-align: center"><button type="button" class="btn btn-info chat_driver" user_id="'+marker.user_id+'" user_name="'+marker.driver_name+'" user_image="'+marker.profile_image+'" trip_id="'+marker.id+'" ><i class="fa fa-comments-o"></i> Chat With Driver</button></td>'+
                        '</tr>'+
                    '</tbody>'
                '</table>';
            const infowindow = new google.maps.InfoWindow({
                content: contentString,
            });

            infowindow.open(map, marker);
            $.ajax({
                type: 'get',
                data:{file:marker.profile_image},
                url: '{{route('preview.image')}}',
                success: function (data) {
                    $('#Car'+marker.id).find('.driver_image').attr('src', data)
                }
            });
        }



        $(document).ready(function () {
         //   $('img[src="{{ url('/') }}/images/car_map.png#markerOne"]').css({
        //         'transform': 'rotate(150deg)'
         //    });


            $(document).on('click','.fa-minus',function () {
                $(this).closest('.chatbox').toggleClass('chatbox-min');
            });
            $(document).on('click','.fa-close',function () {
                $(this).closest('.chatbox').remove();
            });

            function create_chatbox(object) {

                var chat_html = '<div class="chatbox" user_id="'+object.id+'" id="Chat'+object.id+'">' +
                    '<div class="chatbox-top">' +
                    '<div class="chatbox-avatar">' +
                    '<a href="#"><img src="" class="driver_image"/></a>' +
                    '</div>' +
                    '<div class="chat-partner-name">' +
                    '<span class="status online"></span>' +
                    '<a href="#" class="driver_name">'+object.name+'</a>' +
                    '</div>' +
                    '<div class="chatbox-icons">' +
                    '<a href="javascript:void(0);"><i class="fa fa-minus"></i></a>' +
                    '<a href="javascript:void(0);"><i class="fa fa-close fa-times"></i></a>' +
                    '</div>' +
                    '</div>' +

                    '<div class="chat-messages" user_id="'+object.id+'">' +
                    '<div class="load_msgs" style="display:none;text-align: center">'+
                    '<i class="fa fa-refresh loader">'+
                    '</i>'+
                    '</div>'+
                    '</div>' +

                    '<div class="chat-input-holder">' +
                    '<textarea class="chat-input"></textarea>' +
                    '<input type="submit" value="Send" class="message-send" user_id="'+object.id+'" trip_id="'+object.trip_id+'" />' +
                    '</div>' +
                    '</div>';
                return chat_html;
            }

            function add_msg(object,type) {
                if (type==1) {
                    msg_tick=''

                    switch (object.status){
                        case 1:
                            msg_tick="<img class='msg-tick' src='{{asset("images/tick/tick-send.svg")}}' alt=''>";
                            break;
                        case 2:
                            msg_tick="<img class='msg-tick' src='{{asset("images/tick/tick-delivered.svg")}}' alt=''>";
                            break;
                        case 3:
                            msg_tick="<img class='msg-tick' src='{{asset("images/tick/tick-read.svg")}}' alt=''>";
                            break;
                    }
                    var msg = '<div class="message-box-holder" msg_id="'+object.id+'" created_at="'+object.date+'">' +
                        '<div class="message-box">' + object.msg +
                        '<div class="time"><time>' + object.date + '</time> '+msg_tick+'</div>'+
                        '</div>' +
                        '</div>';

                }else if (type==0) {
                    var sender=$('#Chat'+object.user_id).find('.driver_name').html();

                    var msg = '<div class="message-box-holder" msg_id="'+object.id+'" created_at="'+object.date+'">'+
                        '<div class="message-sender">'+ sender + '</div>'+
                        '<div class="message-box message-partner">'+object.msg+' ' +
                        '<div class="time"><time>' + object.date + '</time></div>'+
                        '</div>'+
                        '</div>';
                }
                return msg;
            }

            function scrollToBottomFunc(chatt_id) {
                $('#Chat'+chatt_id).find('.chat-messages').animate({
                    scrollTop: $('.chat-messages').get(0).scrollHeight
                }, 10);
            }

            function scrollfunc() {
                if ($(this).scrollTop() == 0) {
                    var user_id=$(this).attr("user_id");
                    var created_at=$('#Chat'+user_id).find('.message-box-holder').first().attr('created_at');
                    var msg_id=$('#Chat'+user_id).find('.message-box-holder').first().attr('msg_id');

                    fetch_oldest_msgs(user_id,created_at,msg_id);
                }
            }


            function fetch_oldest_msgs(user_id,created_at,msg_id){
                //alert(user_id+"-"+created_at+"-"+msg_id);
                $('.load_msgs').show();
                $.ajax({
                    type: 'post',
                    data:{user_id:user_id,created_at:created_at,msg_id:msg_id,_token:'{{csrf_token()}}'},
                    url: '{{route('old.messages')}}',
                    success:function (data) {
                        if(data.code==0) {
                            data.messages.forEach(response => {
                               // console.log(response);
                                $('#Chat'+user_id).find('.chat-messages').prepend(add_msg({user_id:response.sender_id,msg:response.message,date:response.created_at,status:response.status},1));
                                $('#Chat'+user_id).find('.chat-messages').animate({scrollTop:400});
                            });
                            //console.log("-------------------------");

                        }
                        else{
                            console.log(data.messages);

                        }
                    },
                    complete:function (){
                        $('.load_msgs').hide();
                    },
                    error:function (jqXHR, exception) {
                        $('.loader').hide();
                    },
                });
            }

            // alert("{{ $socket_token }}");

            var socket=io('{{Config("constants.CHAT_SOCKET_CLIENT")}}:{{Config("constants.CHAT_SOCKET_PORT")}}');
            socket.on("connect", () => {



                socket.emit('join','{{ $socket_token }}' );
                socket.on('join',function (response){
                    //alert(response.status);
                    console.log('admin join');
                });
                socket.on('receive_trip_track',function (object){
                    for(var i = 0; i < markers.length; ++i){
                        if(markers[i].id==object.trip_id){
                            //alert(markers[i].id);
                            var latlng = new google.maps.LatLng(object.lat, object.lng);
                            markers[i].setPosition(latlng);
                            //this.map.setCenter({lat:this.lat, lng:this.long, alt:0});
                            //marker.setMap(null);
                        }
                    }

                });

                // socket.on('trip_track',function (object){
                //     for(var i = 0; i < markers.length; ++i){
                //         if(markers[i].id==object.trip_id){
                //             //alert(markers[i].id);
                //             var latlng = new google.maps.LatLng(object.lat, object.lng);
                //             markers[i].setPosition(latlng);
                //             //this.map.setCenter({lat:this.lat, lng:this.long, alt:0});
                //             //marker.setMap(null);
                //         }
                //     }

                // });




            ////////////////////



            $(document).on('click','.chat_driver',function () {
                var user_id=$(this).attr("user_id");
                var user_name=$(this).attr("user_name");
                var user_image=$(this).attr("user_image");
                var trip_id=$(this).attr("trip_id");
                if (!$('#Chat'+user_id).length) {
                    $('.chatbox-holder').append(create_chatbox({id:user_id,name:user_name,profile_image:user_image,trip_id:trip_id}));
                    scrollToBottomFunc(user_id);
                   // var create_chatbox = $('#Chat'+user_id).find(".create_chatbox");
                    //$('#Chat'+user_id).find(".chat-messages").onscroll = scrollfunc;
                    var all = document.querySelectorAll(".chat-messages");
                    for (i = 0; i < all.length; i++) {
                        all[i].onscroll = scrollfunc;
                    }

                    $.ajax({
                        type: 'get',
                        data:{file:user_image},
                        url: '{{route('preview.image')}}',
                        success: function (data) {
                            $('#Chat'+user_id).find('.driver_image').attr('src', data)
                        }
                    });

                } else {
                    $('#Chat'+user_id).removeClass('chatbox-min');
                }

            });

            $(document).on('click','.message-send',function () {
                var user_id=$(this).attr("user_id");
                var msg=$('#Chat'+user_id).find('.chat-input').val();
                var trip_id=$(this).attr("trip_id");

                var created_at=new Date().toISOString().slice(0, 19).replace('T', ' ');
                socket.emit('chat',{to:user_id,msg:msg,trip_id:trip_id,});
                $('#Chat'+user_id).find('.chat-input').val('');

            });
            socket.on('chat_response',function (response){
                if (response.status){
                    //alert(response.status)
                    $('#Chat'+response.object.to).find('.chat-messages').append(add_msg({id:response.object.id,user_id:response.object.to,msg:response.object.msg,date:response.object.date,status:response.object.status},1));
                    scrollToBottomFunc(response.object.to);
                }
            });
            socket.on('chat',function (object){
                    $('#Chat'+object.from).find('.chat-messages').append(add_msg({id:response.id,user_id:object.from,msg:object.msg,date:object.date,status:object.status},0));
                     scrollToBottomFunc(object.from);
            });
            ///////////////////

            });

        });
    });
</script>
@stop
