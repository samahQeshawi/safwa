@extends('adminlte::page')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datetimepicker/css/bootstrap-glyphicons.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
@endsection
@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('trip.create') }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <a href="{{ route('trip.index') }}" class="btn btn-primary" title="{{ trans('trip.show_all') }}">
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

            <form method="POST" action="{{ route('trip.store') }}" accept-charset="UTF-8" id="create_trip_form" name="create_trip_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('trip.form', [
                                        'trip' => null,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('trip.add') }}">
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
<script type="text/javascript" >
    $(document).ready(function() {
        $('.date-picker').datetimepicker({  
           format:'DD-MM-YYYY HH:mm:ss',
         }); 
              
     });  
</script>
<script type="text/javascript" >
 
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
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpuXp5i5ud7H3YqQQVVnAoD8dbBJ24Pe8&callback=initialize&libraries=places&v=weekly"></script>
<script type="text/javascript" src="{{ asset('js/map-trip.js') }}" defer>

</script>
@endsection


