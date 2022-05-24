@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ !empty($title) ? $title : 'Favorite Place' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">

    <a href="{{ route('favorite_places.index') }}" class="btn btn-primary" title="{{ trans('favorite_places.show_all') }}">
        <i class="fas fa-list-alt"></i>
    </a>

    <a href="{{ route('favorite_places.create') }}" class="btn btn-success" title="{{ trans('favorite_places.create') }}">
        <i class="fas fa-plus-circle"></i>
    </a>

</div>
@stop

@section('content')

<div class="panel panel-default">
    <div class="card card-primary card-outline">
        <div class="card-body">




            <div class="panel-body">

                @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif

                <form method="POST" action="{{ route('favorite_places.update', $favorite_places->id) }}" id="edit_favorite_place_form"
                    name="edit_favorite_place_form" accept-charset="UTF-8" class="form-horizontal">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PUT">
                    @include ('favorite_places.form', [
                    'favorite_places' => $favorite_places,
                    ])

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <input class="btn btn-primary" type="submit" value="{{ trans('favorite_places.update') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDncW_1D3YQhJgk0rZj-kwGN_AiY8RmFtc&callback=initialize&libraries=places"
    defer></script>
<style type="text/css">
    #map_location {
        height: 0;
        overflow: hidden;
        margin-left: 8px;
        margin-bottom: 4px;
        padding-bottom: 35.25%;
        padding-top: 30px;
        position: relative;
    }
</style>
<script>
function initialize() {

  var mapOptions, map, marker, searchBox,
    infoWindow = '',
    addressEl = document.querySelector( '#address' ),
    latEl = document.querySelector( '#latitude' ),
    longEl = document.querySelector( '#longitude' ),
    location = document.querySelector( '#location' ),
    element = document.getElementById( 'map_location' );

  mapOptions = {
    // How far the maps zooms in.
    zoom: 8,
    // Current Lat and Long position of the pin/
    center: new google.maps.LatLng( {{ optional($favorite_places)->latitude ?: 24.774265 }}, {{optional($favorite_places)->longitude ?: 46.738586}}),
    // center : {
    //  lat: -34.397,
    //  lng: 150.644
    // },
    disableDefaultUI: false, // Disables the controls like zoom control on the map if set to true
    scrollWheel: true, // If set to false disables the scrolling on the map.
    draggable: true, // If set to false , you cannot move the map around.
    // mapTypeId: google.maps.MapTypeId.HYBRID, // If set to HYBRID its between sat and ROADMAP, Can be set to SATELLITE as well.
    // maxZoom: 11, // Wont allow you to zoom more than this
    // minZoom: 9  // Wont allow you to go more up.

  };

  /**
   * Creates the map using google function google.maps.Map() by passing the id of canvas and
   * mapOptions object that we just created above as its parameters.
   *
   */
  // Create an object map with the constructor function Map()
  map = new google.maps.Map( element, mapOptions ); // Till this like of code it loads up the map.

  /**
   * Creates the marker on the map
   *
   */
  marker = new google.maps.Marker({
    position: mapOptions.center,
    map: map,
    // icon: 'http://pngimages.net/sites/default/files/google-maps-png-image-70164.png',
    draggable: true
  });

  /**
   * Creates a search box
   */
  searchBox = new google.maps.places.SearchBox( addressEl );

  /**
   * When the place is changed on search box, it takes the marker to the searched location.
   */
  google.maps.event.addListener( searchBox, 'places_changed', function () {
    var places = searchBox.getPlaces(),
      bounds = new google.maps.LatLngBounds(),
      i, place, lat, long, resultArray,
      addresss = places[0].formatted_address;

    for( i = 0; place = places[i]; i++ ) {
      bounds.extend( place.geometry.location );
      marker.setPosition( place.geometry.location );  // Set marker position new.
    }

    map.fitBounds( bounds );  // Fit to the bound
    map.setZoom( 15 ); // This function sets the zoom to 15, meaning zooms to level 15.
    // console.log( map.getZoom() );

    lat = marker.getPosition().lat();
    long = marker.getPosition().lng();
    latEl.value = lat;
    longEl.value = long;
    location.value = lat + ',' + long;
    resultArray =  places[0].address_components;


    // Closes the previous info window if it already exists
    if ( infoWindow ) {
      infoWindow.close();
    }
    /**
     * Creates the info Window at the top of the marker
     */
    infoWindow = new google.maps.InfoWindow({
      content: addresss
    });

    infoWindow.open( map, marker );
  } );


  /**
   * Finds the new position of the marker when the marker is dragged.
   */
  google.maps.event.addListener( marker, "dragend", function ( event ) {
    var lat, long, address, resultArray, citi;

    console.log( 'i am dragged' );
    lat = marker.getPosition().lat();
    long = marker.getPosition().lng();

    var geocoder = new google.maps.Geocoder();
    geocoder.geocode( { latLng: marker.getPosition() }, function ( result, status ) {
      if ( 'OK' === status ) {  // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
        address = result[0].formatted_address;
        resultArray =  result[0].address_components;

        addressEl.value = address;
        latEl.value = lat;
        longEl.value = long;
        location.value = lat + ',' + long;

      } else {
        console.log( 'Geocode was not successful for the following reason: ' + status );
      }

      // Closes the previous info window if it already exists
      if ( infoWindow ) {
        infoWindow.close();
      }

      /**
       * Creates the info Window at the top of the marker
       */
      infoWindow = new google.maps.InfoWindow({
        content: address
      });

      infoWindow.open( map, marker );
    } );
  });


}
</script>
<script>
      $('#user_id').select2({
        placeholder: 'Select sender',
        ajax: {
            url: '{{ route("favorite_places.search.user") }}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
    <?php if(isset($favorite_places->user->name)) { ?>
        var newCustomer = new Option('{{$favorite_places->user->name}}', '{{$favorite_places->user_id}}', true, true);
        $('#user_id').append(newCustomer).trigger('change');
    <?php } ?>       
</script>
@endsection
