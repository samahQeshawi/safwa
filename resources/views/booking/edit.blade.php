@extends('adminlte::page')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datetimepicker/css/bootstrap-glyphicons.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" 
	href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker-standalone.css">
@endsection
@section('content_header')
    <h1 class="m-0 text-dark">{{ !empty($title) ? $title : 'Booking' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">

        <a href="{{ route('booking.index') }}" class="btn btn-primary" title="{{ trans('booking.show_all') }}">
            <i class="fas fa-list-alt"></i>
        </a>

        <a href="{{ route('booking.create') }}" class="btn btn-success" title="{{ trans('booking.create') }}">
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

            <form method="POST" action="{{ route('booking.update', $booking->id) }}" id="edit_booking_form" name="edit_booking_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('booking.form', [
                                        'booking' => $booking,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('booking.update') }}">
                    </div>
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" >
	$(document).ready(function() {
		$('.date-picker').datetimepicker({  
		   format: 'DD-MM-YYYY' 
		 });  
		$('.time-picker').datetimepicker({
			format: 'LT'
		});		 
     });  
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAe1XfwUagaTE5d49oJHNEUWoi5kffzVok&libraries=places&callback=initialize"></script>
<script type="text/javascript" src="{{ asset('js/map-edit.js') }}" defer></script>
<script type="text/javascript" defer>
	$(document).ready(function() {
	});
</script>
@endsection
