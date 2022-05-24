{{-- Extends layout --}}
@extends('web._default')

@section('content')

    @include('web.layout.partials._index_form')

    <div class="site-block-02-wrapper">

      <div class="col-lg-12 text-center">

        <h4 id="welcome" class="yellow-title pt-5">Welcome</h4>

        <h1 class="black-title">Our Services</h1>

      </div>

      <div class="block-02-inner-wrapper main">

         <!-- Slider -->

      <div class="page_container">
        <div id="immersive_slider">
          <div class="slide">
            <div class="content">
              <h2><a class="yellow-title" href="">Airport Service</a></h2>
              <p>Nam ac ligula congue, interdum enim sit amet, fermentum nisi,Nam ac ligula congue, interdum enim sit amet, fermentum nisi.Nam ac ligula congue.interdum enim sit amet, fermentum nisi,Nam ac ligula congue, interdum enim sit amet, fermentum nisi.Nam ac ligula congue.</p>
            </div>
            <div class="image">
              <a href="http://www.bucketlistly.com" target="_blank">
                <img src="{{ asset('images/slide1.jpg') }}" alt="Slider 1">
              </a>
            </div>
          </div>
          <div class="slide">
            <div class="content">
              <h2><a class="yellow-title" href="">Taxi Services</a></h2>
              <p>Nam ac ligula congue, interdum enim sit amet, fermentum nisi,Nam ac ligula congue, interdum enim sit amet, fermentum nisi.Nam ac ligula congue.interdum enim sit amet, fermentum nisi,Nam ac ligula congue, interdum enim sit amet, fermentum nisi.Nam ac ligula congue.</p>
            </div>
            <div class="image">
             <a href="http://www.bucketlistly.com/apps" target="_blank"> <img src="{{ asset('images/slide2.jpg') }}" alt="Slider 1"></a>
            </div>
          </div>
          <div class="slide">
            <div class="content">
              <h2><a class="yellow-title" href="">Rent Car Services</a></h2>
              <p>Nam ac ligula congue, interdum enim sit amet, fermentum nisi,Nam ac ligula congue, interdum enim sit amet, fermentum nisi.Nam ac ligula congue.interdum enim sit amet, fermentum nisi,Nam ac ligula congue, interdum enim sit amet, fermentum nisi.Nam ac ligula congue.</p>
            </div>
            <div class="image">
              <a href="http://www.thepetedesign.com" target="_blank"><img src="{{ asset('images/slide3.jpg') }}" alt="Slider 1"></a>
            </div>
          </div>

          <a href="#" class="is-prev">

              <i class="fas fa-chevron-left"></i>

          </a>
          <a href="#" class="is-next">

            <i class="fas fa-chevron-right"></i>

          </a>
        </div>
      </div>


        <!-- Slider ends -->


      </div>
    </div> <!-- Site Block-02-Wrapper DIV Closed -->

    <div class="site-block-06-wrapper">

      <div class="col-lg-12 text-center">

        <h4 id="welcome" class="yellow-title pt-5">App feature</h4>

        <h1 class="black-title">Download the app</h1>

      </div>

      <div class="block-06-inner-wrapper">

        <div class="container">

          <div class="row">

            <div class="col">

              <h4 class="black-title">Book an <span class="yellow-title bg-dark pl-1 pr-1">safwa</span> from the App</h4>

              <h6 class="pt-3">Download the app for exclusive deals and ease of booking </h6>

              <div class="store-blk">

                <a href="">

                  <img class="img-fluid pt-4 pr-4" src="{{ asset('images/appstore.png') }}">

                </a>

                <a href="">

                  <img class="img-fluid pt-4 pr-4" src="{{ asset('images/playstore.png') }}">

                </a>

              </div>

            </div>

            <div class="col-4">

              <img class="img-fluid app-feature-phone d-sm-none d-md-block d-none d-sm-block" src="{{ asset('images/ios-mob-img.png') }}" width="200">

            </div>

          </div>

        </div>

      </div>

    </div><!-- Site Block-06-Wrapper DIV Closed -->


    <div class="site-block-04-wrapper">

      <div class="col-12 text-center">

        <h4 id="app-feature" class="black-title pt-3">About Us</h4>

        <h1 class="yellow-title">Why Choose us</h1>

      </div>

      <div class="block-04-inner-wrapper">

        <div class="container">

          <div class="row">

            <div class="col-lg-7">

              <ul class="about-us-ul">

                <li><h5><i class="fab fa-bandcamp"> </i> Gas & insurance included</h5></li>

                <li><h5><i class="fab fa-bandcamp"> </i> Any Locations Rent</h5></li>

                <li><h5><i class="fab fa-bandcamp"> </i> Cleaning Included</h5></li>

                <li><h5><i class="fab fa-bandcamp"> </i> Online 24 / 7 Support</h5></li>

              </ul>

              <button class="btn banner-btn mt-3">search car</button>

            </div>

            <div class="col-lg-5 text-center">

              <img class="img-fluid about-us-img" src="{{ asset('images/about-us-img.jpg') }}">

              <h5 class="custom-position">Take only memories,<br/>leave only footprints</h5>

            </div>

          </div>

        </div>

      </div>

    </div> <!-- Site Block-04-Wrapper DIV Closed -->


    <div class="site-block-05-wrapper">

      <div class="block-05-inner-wrapper">

        <div class="container">

          <div class="row">

            <div class="col-12">

              <h4 class="yellow-title">For Drivers</h4>

              <h2 class="black-title">Do You Want To Earn With Us?</h2>

            </div>

            <div class="col-lg-5">

              <p class="mt-4">Nam ac ligula congue, interdum enim sit amet, fermentum nisi,Nam ac ligula congue, interdum enim sit amet, fermentum nisi.Nam ac ligula congue.interdum enim sit amet, fermentum nisi,Nam ac ligula congue, interdum enim sit amet, fermentum nisi.Nam ac ligula congue.</p>

              <button class="btn yellow-btn">become a driver</button>

            </div>

            <div class="col-lg-7 text-center">

              <img class="img-fluid" src="{{ asset('images/yellow-car-side-img.png') }}">

            </div>

          </div>

        </div>

      </div>

    </div> <!-- Site Block-05-Wrapper DIV Closed -->


@endsection

@section('scripts')
<script src="{{ asset('js/bootstrap-autocomplete.js') }}"></script>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyBBs3uqoz2A_XWSx2b-QghXIH_3KBYksV4&sensor=false"></script>

<script>
    let map, marker;
    let markers = [];
    let map_shown = false;
    var map_element = "pick_location";

    function showPosition() {
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showMap, showError);
        } else {
            alert("Sorry, your browser does not support HTML5 geolocation.");
        }
    }

    // Define callback function for successful attempt
    function showMap(position) {
        // Get location data
        lat = position.coords.latitude;
        long = position.coords.longitude;
        var latlong = $('#' + map_element).val();
        if( latlong != "") {
            var pos = latlong.split(',');
            lat = pos[0];
            long = pos[1];
        }
        latlong = new google.maps.LatLng(lat, long);
        var myOptions = {
            center: latlong,
            zoom: 16,
            mapTypeControl: true,
            navigationControlOptions: {
                style:google.maps.NavigationControlStyle.SMALL
            }
        }

        map = new google.maps.Map(document.getElementById(map_element + "_embedMap"), myOptions);
        //var marker = new google.maps.Marker({ position:latlong, map:map, title:"You are here!" });
        addMarker(latlong);
        // markers.push(marker);

        map.addListener("click", (event) => {
            var pos = event.latLng;
            deleteMarkers();
            addMarker(pos);
            map.setCenter(pos);
            //if( confirm('Do you confirm selected location?')) {
            $('#' + map_element).val(pos.lat() + ',' + pos.lng());
            $('#' + map_element + "_embedMap").hide();
            map_shown = false;
            //}
        });

        // Adds a marker to the map and push to the array.
        function addMarker(location) {
            const mark = new google.maps.Marker({
                position: location,
                map: map,
            });
            markers.push(mark);
        }

        // Sets the map on all markers in the array.
        function setMapOnAll(map) {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }

        // Removes the markers from the map, but keeps them in the array.
        function clearMarkers() {
            setMapOnAll(null);
        }

        // Shows any markers currently in the array.
        function showMarkers() {
            setMapOnAll(map);
        }

        // Deletes all markers in the array by removing references to them.
        function deleteMarkers() {
            clearMarkers();
            markers = [];
        }

    }

    // Define callback function for failed attempt
    function showError(error) {
        if(error.code == 1) {
            result.innerHTML = "You've decided not to share your position, but it's OK. We won't ask you again.";
        } else if(error.code == 2) {
            result.innerHTML = "The network is down or the positioning service can't be reached.";
        } else if(error.code == 3) {
            result.innerHTML = "The attempt timed out before it could get the location data.";
        } else {
            result.innerHTML = "Geolocation failed due to unknown error.";
        }
    }

    // ===================

    $(document).ready(function(){

        $('.get_location').click(function(){
            map_element = $(this).attr("id");
            if(map_shown === true) {
                $('#' + map_element + '_embedMap').hide();
                map_shown = false;
            } else {
                $('#' + map_element + '_embedMap').show();
                showPosition();
                map_shown = true;
            }
        });

        $('#book_round_trip').click(function(){
            if ($(this).is(':checked')) {
                $('#book_round_trip_input').show();
            } else {
                $('#book_round_trip_input').hide();
            }
        });


      $('#airport').autocomplete();
      $('#hotel').autocomplete();

      $('#flip_click').on('click',function(e){
        e.preventDefault();
         let input1_val = $('.input1_val').val();
         let input2_val = $('.input2_val').val();
         $('.input1_val').val(input2_val);
         $('.input2_val').val(input1_val);
         if($('.input1_icon').hasClass('fa-map-marker-alt')) {
            $('.input1_icon').removeClass('fa-map-marker-alt');
            $('.input2_icon').removeClass('fa-building');
            $('.input1_icon').addClass('fa-building');
            $('.input2_icon').addClass('fa-map-marker-alt');
         } else {
            $('.input1_icon').removeClass('fa-building');
            $('.input2_icon').removeClass('fa-map-marker-alt');
            $('.input1_icon').addClass('fa-map-marker-alt');
            $('.input2_icon').addClass('fa-building');
         }
          
      });
    });
    </script>
@endsection
