@extends('adminlte::page')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datetimepicker/css/bootstrap-glyphicons.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('content_header')
<h1 class="m-0 text-dark">{{ trans('car_rental.create') }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    <a href="{{ route('car_rentals.index') }}" class="btn btn-primary" title="{{ trans('car_rental.show_all') }}">
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

                <form method="POST" action="{{ route('car_rentals.store') }}" accept-charset="UTF-8"
                    id="create_car_rental_form" name="create_car_rental_form" class="form-horizontal">
                    {{ csrf_field() }}
                    @include ('car_rentals.form', [
                    'car_rental' => null,
                    ])

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <input class="btn btn-primary" type="submit" value="{{ trans('car_rental.add') }}">
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
