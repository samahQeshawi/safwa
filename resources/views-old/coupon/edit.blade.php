@extends('adminlte::page')
@section('css')

<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datetimepicker/css/bootstrap-glyphicons.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('content_header')
    <h1 class="m-0 text-dark">{{ !empty($coupon->coupon_name) ? $coupon->coupon_name : 'Coupon' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">

        <a href="{{ route('coupon.index') }}" class="btn btn-primary" title="{{ trans('coupon.show_all') }}">
            <i class="fas fa-list-alt"></i>
        </a>

        <a href="{{ route('coupon.create') }}" class="btn btn-success" title="{{ trans('coupon.create') }}">
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

            <form method="POST" action="{{ route('coupon.update', $coupon->id) }}" id="edit_coupon_form" name="edit_coupon_form" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('coupon.form', [
                                        'coupon' => $coupon,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('coupon.update') }}">
                    </div>
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>

<script type="text/javascript" >
    $(document).ready(function() {
         $('.date-picker').datetimepicker({
            format: 'YYYY-MM-DD hh:mm:ss',
         });         
       $('#use_percentage').on('change', function() {
            if ($(this).is(':checked')){
                $('.discount_data').show();
                $('.discount_amt').hide();
            } else {
                $('.discount_data').hide();  
                $('.discount_amt').show();           
            }
       });   
       $('#coupon_type').on('change', function() { 
             if ($(this).val() == '2'){
                $('.limit_coupon').show();   
            } else {
                $('.limit_coupon').hide();
            }
       });
       $('#use_percentage').trigger("change");
       $('#coupon_type').trigger("change");
     });  
</script>
@endsection

