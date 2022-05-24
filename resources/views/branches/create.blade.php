@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ trans('branch.create') }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    <a href="{{ route('branches.index') }}" class="btn btn-primary" title="{{ trans('branch.show_all') }}">
        <i class="fas fa-list-alt"></i>
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

                <form method="POST" action="{{ route('branches.store') }}" accept-charset="UTF-8"
                    id="create_branch_form" name="create_branch_form" class="form-horizontal">
                    {{ csrf_field() }}
                    @include ('branches.form', [
                    'branch' => null,
                    ])

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <input class="btn btn-primary" type="submit" value="{{ trans('branch.add') }}">
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
    let myLatlng = { lat: 24.774265, lng: 46.738586 };
    const map = new google.maps.Map(document.getElementById("map_location"), {
      zoom: 9,
      center: myLatlng,
    });

    let geocoder = new google.maps.Geocoder();//For geocoding address
    // Create the initial InfoWindow.
    let infoWindow = new google.maps.InfoWindow({
      content: "Click the map to set location of the branch!",
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
</script>
@endsection
