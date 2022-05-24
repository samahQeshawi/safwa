@extends('adminlte::page')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datetimepicker/css/bootstrap-glyphicons.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('content_header')
<h1 class="m-0 text-dark">{{ !empty($title) ? $title : 'Trip' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    @can("view trips")
    <a href="{{ route('trip.index') }}" class="btn btn-primary" title="{{ trans('trip.show_all') }}">
        <i class="fas fa-list-alt"></i>
    </a>
    @endcan
    @can("add trips")
   <!--  <a href="{{ route('trip.create') }}" class="btn btn-success" title="{{ trans('trip.create') }}">
        <i class="fas fa-plus-circle"></i>
    </a> -->
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

                <form method="POST" action="{{ route('trip.update', $trip->id) }}" id="edit_trip_form"
                    name="edit_trip_form" accept-charset="UTF-8" class="form-horizontal">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PUT">
                    @include ('trip.form', [
                    'trip' => $trip,
                    ])

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <input class="btn btn-primary" type="submit" value="{{ trans('trip.update') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.date-picker').datetimepicker({
           format:'DD-MM-YYYY HH:mm:ss',
         });

     });
</script>
<script type="text/javascript">
    $('#service_id').change(function(){
        $.ajax({
            url: "{{ route('car.getcategories')}}",
            data: { "id": $("#service_id").val() },
            dataType:"json",
            type: "get",
            success: function(data){
               //$('#artist').append(data);
               $("#category_id").find("option:gt(0)").remove();
                $.each(data, function(key, modelName){
                    $("#category_id").append('<option value=' + modelName.id + '>' + modelName.category + '</option>');
                });
            }
        });
    });
</script>
{{-- <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAe1XfwUagaTE5d49oJHNEUWoi5kffzVok&libraries=places&callback=initialize">
</script>
<script type="text/javascript" src="{{ asset('js/map-trip-edit.js') }}" defer></script> --}}

@endsection
