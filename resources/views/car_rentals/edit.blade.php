@extends('adminlte::page')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datetimepicker/css/bootstrap-glyphicons.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
@endsection
@section('content_header')
<h1 class="m-0 text-dark">{{ !empty($title) ? $title : 'Car Rental' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    @can("view booking")
    <a href="{{ route('car_rentals.index') }}" class="btn btn-primary" title="{{ trans('car_rental.show_all') }}">
        <i class="fas fa-list-alt"></i>
    </a>
    @endcan
    @can("add booking")
    <a href="{{ route('car_rentals.create') }}" class="btn btn-success" title="{{ trans('car_rental.create') }}">
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

                <form method="POST" action="{{ route('car_rentals.update', $car_rental->id) }}"
                    id="edit_car_rental_form" name="edit_car_rental_form" accept-charset="UTF-8"
                    class="form-horizontal">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PUT">
                    @include ('car_rentals.form', [
                    'car_rental' => $car_rental,
                    ])

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <input class="btn btn-primary" type="submit" value="{{ trans('car_rental.update') }}">
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
        $('#pickup_on').datetimepicker({
           format:'YYYY-MM-DD HH:mm:ss',
         });
        $('#dropoff_on').datetimepicker({
           format:'YYYY-MM-DD HH:mm:ss',
         });
     });


     function rentCalculate() {
    var pickup_on = $('#pickup_on').val();
    var dropoff_on = $('#dropoff_on').val();
    var car_id = $('#car_id').val();
    if (!pickup_on || !dropoff_on  || !car_id) return;
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "POST",
        url: "{{ route("CarRentals.calculateCarRent") }}",
        data: {'car_id':car_id, 'pickup_on': pickup_on, 'dropoff_on': dropoff_on},
        dataType:"json",
        success: function(data){
            //Empty the DropDown
            $("#amount").val(data.amount);
            $("#duration_in_days").val(data.days);
        }
    });
}

$('#pickup_on').on('blur', rentCalculate);
$('#dropoff_on').on('blur', rentCalculate);
$('#car_id').on('change', rentCalculate);



</script>
@endsection
