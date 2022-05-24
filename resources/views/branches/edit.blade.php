@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ !empty($title) ? $title : 'Branch' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    @can("view branch")
    <a href="{{ route('branches.index') }}" class="btn btn-primary" title="{{ trans('branch.show_all') }}">
        <i class="fas fa-list-alt"></i>
    </a>
    @endcan
    @can("add branch")
    <a href="{{ route('branches.create') }}" class="btn btn-success" title="{{ trans('branch.create') }}">
        <i class="fas fa-plus-circle"></i>
    </a>
    @endcan
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

                <form method="POST" action="{{ route('branches.update', $branch->id) }}" id="edit_branch_form"
                    name="edit_branch_form" accept-charset="UTF-8" class="form-horizontal">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PUT">
                    @include ('branches.form', [
                    'branch' => $branch,
                    ])

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <input class="btn btn-primary" type="submit" value="{{ trans('branch.update') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-q1JYVn8f510Ta_pZPI0iOHcFpBFshMY&callback=initMap&libraries=&v=weekly"
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
function initMap() {

    let myLatlng = { lat: {{optional($branch)->latitude ?: 24.774265 }}, lng: {{optional($branch)->longitude ?: 46.738586}} };
    let map = new google.maps.Map(document.getElementById("map_location"), {
      zoom: 9,
      center: myLatlng,
    });
    let geocoder = new google.maps.Geocoder();//For geocoding address

    // Create the initial InfoWindow.
    let infoWindow = new google.maps.InfoWindow({
      content: "{{optional($branch)->name}}<br><br> Note : Click the map to set a different location for the branch!",
      position: myLatlng,
    });
    infoWindow.open(map);

    // Configure the click listener.
    map.addListener("click", (mapsMouseEvent) => {
        // Close the current InfoWindow.
        infoWindow.close();
        // Create a new InfoWindow.
        infoWindow = new google.maps.InfoWindow({
            position: mapsMouseEvent.latLng,
        });
        infoWindow.setContent(
            JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
        );
        infoWindow.open(map);

        $('#location').val(mapsMouseEvent.latLng.toUrlValue(15));
        $('#latitude').val(mapsMouseEvent.latLng.toUrlValue(15).split(',')[0]);
        $('#longitude').val(mapsMouseEvent.latLng.toUrlValue(15).split(',')[1]);

        myLatlng = mapsMouseEvent.latLng;

        // The marker, positioned at branch location
        const marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
        });

        //Geocode lat lng to address
        geocoder.geocode({ location: myLatlng }, (results, status) => {
            if (status === "OK") {
            if (results[0]) {
                $('#address').val(results[0].formatted_address);
            } else {
                window.alert("No results found");
            }
            } else {
                window.alert("Geocoder failed due to: " + status);
            }
        });

    });
  }

  $('#country_code').on('change', function() {
    $("#country").val($(this).val());
  });
   $('#country').on('change', function() {
    $("#country_code").val($(this).val());
  });


  /* function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 8,
    center: { lat: 40.731, lng: -73.997 },
  });
  const geocoder = new google.maps.Geocoder();
  const infowindow = new google.maps.InfoWindow();
  document.getElementById("submit").addEventListener("click", () => {
    geocodeLatLng(geocoder, map, infowindow);
  });
}

function geocodeLatLng(geocoder, map, infowindow) {
  const input = document.getElementById("latlng").value;
  const latlngStr = input.split(",", 2);
  const latlng = {
    lat: parseFloat(latlngStr[0]),
    lng: parseFloat(latlngStr[1]),
  };
  geocoder.geocode({ location: latlng }, (results, status) => {
    if (status === "OK") {
      if (results[0]) {
        map.setZoom(11);
        const marker = new google.maps.Marker({
          position: latlng,
          map: map,
        });
        infowindow.setContent(results[0].formatted_address);
        infowindow.open(map, marker);
      } else {
        window.alert("No results found");
      }
    } else {
      window.alert("Geocoder failed due to: " + status);
    }
  });
}
*/
</script>
@endsection
