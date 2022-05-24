@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ !empty($company->name) ? $company->name : 'Company' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        @can("view companies")
        <a href="{{ route('companies.company.index') }}" class="btn btn-primary" title="{{ trans('companies.show_all') }}">
            <i class="fas fa-list-alt"></i>
        </a>
        @endcan
        @can("add companies")
        <a href="{{ route('companies.company.create') }}" class="btn btn-success" title="{{ trans('companies.create') }}">
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

            <form method="POST" action="{{ route('companies.company.update', $company->id) }}" id="edit_company_form" name="edit_company_form" accept-charset="UTF-8" class="form-horizontal" enctype='multipart/form-data'>
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('companies.form', [
                                        'company' => $company,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('companies.update') }}">
                    </div>
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection


@section('js')
<script type="text/javascript">
    function initialize() {
let myLatlng = { lat: {{optional($company)->latitude ?: 24.774265 }}, lng: {{optional($company)->longitude ?: 46.738586}} };
    let map = new google.maps.Map(document.getElementById("map-canvas"), {
      zoom: 9,
      center: myLatlng,
    });
    let geocoder = new google.maps.Geocoder();//For geocoding address

    // Create the initial InfoWindow.
    let infoWindow = new google.maps.InfoWindow({
      content: "{{optional($company)->name}}<br><br> Note : Click the map to set a different location for the branch!",
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

        $('#address').val(mapsMouseEvent.latLng.toUrlValue(15));
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
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-q1JYVn8f510Ta_pZPI0iOHcFpBFshMY&libraries=places&callback=initialize"></script>

@endsection