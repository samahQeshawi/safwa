@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Booking' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    <form method="POST" action="{!! route('car_rentals.destroy', $car_rental->id) !!}" accept-charset="UTF-8">
        <input name="_method" value="DELETE" type="hidden">
        {{ csrf_field() }}
        <div class="btn-group btn-group-sm" role="group">
            @can("view booking")
            <a href="{{ route('car_rentals.index') }}" class="btn btn-primary"
                title="{{ trans('car_rental.show_all') }}">
                <i class="fas fa-list-alt"></i>
            </a>
            @endcan
            @can("add booking")
            <a href="{{ route('car_rentals.create') }}" class="btn btn-success"
                title="{{ trans('car_rental.create') }}">
                <i class="fas fa-plus-circle"></i>
            </a>
            @endcan
            @can("edit booking")
            <a href="{{ route('car_rentals.edit', $car_rental->id ) }}" class="btn btn-primary"
                title="{{ trans('car_rental.edit') }}">
                <i class="fas fa-edit"></i>
            </a>
            @endcan
            @can("delete booking")
            <button type="submit" class="btn btn-danger" title="{{ trans('car_rental.delete') }}"
                onclick="return confirm(&quot;{{ trans('car_rental.confirm_delete') }}?&quot;)">
                <i class="fas fa-trash-alt"></i>
            </button>
            @endcan
        </div>
    </form>
</div>
@stop

@section('content')

<div class="panel panel-default">
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="panel-body">
                 <div class="card bg-light mb-3">
                    <div class="card-header text-white bg-primary mb-3">Booking Information</div>
                    <div class="card-body">
                         <div class="row">
                            <div class="col md-6">                    
                                <dt>{{ trans('car_rental.booking_no') }}</dt>
                                <dd>{{ $car_rental->booking_no }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('car_rental.booking_status') }}</dt>
                                <dd>{{ $car_rental->booking_status }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                
                                <dt>{{ trans('car_rental.payment_status') }}</dt>
                                <dd>{{ $car_rental->payment_status ? 'Paid' : 'Not Paid' }}</dd>
                            </div>
                            <div class="col md-6">
                                 
                               <dt>{{ trans('car_rental.user_id') }}</dt>
                                <dd>{{ optional($car_rental->user)->name }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">                    
                                <dt>{{ trans('car_rental.car_id') }}</dt>
                                <dd>{{ optional($car_rental->car)->car_name }}</dd>
                            </div>
                            <div class="col md-6">
                                 <dt>{{ trans('car_rental.pickup_on') }}</dt>
                                <dd>{{ $car_rental->pickup_on }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                
                                <dt>{{ trans('car_rental.dropoff_on') }}</dt>
                                <dd>{{ $car_rental->dropoff_on }}</dd>
                            </div>
                            <div class="col md-6">
                                 
                               <dt>{{ trans('car_rental.duration_in_days') }}</dt>
                               <dd>{{ $car_rental->duration_in_days }}</dd>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col md-6">                    
                                <dt>{{ trans('car_rental.car_id') }}</dt>
                                <dd>{{ optional($car_rental->car)->car_name }}</dd>
                            </div>
                            <div class="col md-6">
                                 <dt>{{ trans('car_rental.pickup_on') }}</dt>
                                <dd>{{ $car_rental->pickup_on }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                
                                 <dt>{{ trans('car_rental.amount') }}</dt>
                                 <dd>{{ $car_rental->amount }}</dd>
                            </div>
                            <div class="col md-6">
                                 
                               <dt>{{ trans('car_rental.duration_in_days') }}</dt>
                               <dd>{{ $car_rental->duration_in_days }}</dd>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header text-white bg-primary mb-3">Car Information</div>
                    <div class="card-body">
                         <div class="row">
                            <div class="col md-6">                    
                                <dt>{{ trans('car_rental.registration_no') }}</dt>
                               
                                <dd>{{ optional($car_rental->car)->registration_no }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('car_rental.color') }}</dt>
                                <dd>{{ optional($car_rental->car)->color }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                
                                <dt>{{ trans('car_rental.engine') }}</dt>
                                <dd>{{ optional($car_rental->car)->engine }}</dd>
                            </div>
                            <div class="col md-6">
                                 
                               <dt>{{ trans('car_rental.model_year') }}</dt>
                                <dd>{{ optional($car_rental->car)->model_year }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">                    
                                <dt>{{ trans('car_rental.transmission') }}</dt>
                                <dd>{{ optional($car_rental->car)->transmission }}</dd>
                            </div>
                            <div class="col md-6">
                                 <dt>{{ trans('car_rental.car_type') }}</dt>
                                <dd>{{ optional(optional($car_rental->car)->carType)->name }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                
                                <dt>{{ trans('car_rental.car_make') }}</dt>
                                <dd>{{ optional(optional($car_rental->car)->carMake)->name }}</dd>
                            </div>
                            <div class="col md-6">
                                 
                               <dt>{{ trans('car_rental.car_fuel') }}</dt>
                              <dd>{{ optional(optional($car_rental->car)->carFuel)->fuel_type }}</dd>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col md-6">                    
                                <dt>{{ trans('car_rental.car_seats') }}</dt>
                                 <dd>{{ optional($car_rental->car)->seats }}</dd>
                            </div>
                            <div class="col md-6">
                               
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div class="card-header text-white bg-primary mb-3">Branch Information</div>
                    <div class="card-body">
                         <div class="row">
                            <div class="col md-6">                    
                                <dt>{{ trans('car_rental.branch_name') }}</dt>
                               
                                 <dd>{{ optional($car_rental->branch)->name }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('car_rental.branch_address') }}</dt>
                                <dd>{{ optional($car_rental->branch)->address }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                
                                <dt>{{ trans('car_rental.branch_zipcode') }}</dt>
                                <dd>{{ optional($car_rental->branch)->zipcode }}</dd>
                            </div>
                            <div class="col md-6">
                                 
                               <dt>{{ trans('car_rental.branch_phone') }}</dt>
                                <dd>{{ optional($car_rental->branch)->phone }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">                    
                                <dt>{{ trans('car_rental.branch_code') }}</dt>
                                <dd>{{ optional($car_rental->branch)->branch_code }}</dd>
                            </div>
                            <div class="col md-6">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header text-white bg-primary mb-3">Customer Information</div>
                    <div class="card-body">
                         <div class="row">
                            <div class="col md-6">                    
                                <dt>{{ trans('car_rental.customer_name') }}</dt>
                               
                                 <dd>{{ optional($car_rental->user)->name }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('car_rental.customer_address') }}</dt>
                                 <dd>{{ optional($car_rental->user)->address }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                
                                <dt>{{ trans('car_rental.customer_zipcode') }}</dt>
                                <dd>{{ optional($car_rental->user)->zipcode }}</dd>
                            </div>
                            <div class="col md-6">
                                 
                               <dt>{{ trans('car_rental.customer_phone') }}</dt>
                                <dd>{{ optional($car_rental->user)->phone }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">                    
                                <dt>{{ trans('car_rental.customer_email') }}</dt>
                                <dd>{{ optional($car_rental->user)->email }}</dd>
                            </div>
                            <div class="col md-6">   
                            </div>
                        </div>

                        <div class="row">
                            <div class="col md-6">                    
                                <dt>{{ trans('car_rental.customer_nationality') }}</dt>
                                <dd>{{ optional(optional(optional($car_rental->user)->customer)->nationality)->name }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('car_rental.customer_national_id') }}</dt>
                                <dd>{{ optional(optional($car_rental->user)->customer)->national_id }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">                    
                              <dt>{{ trans('car_rental.license_no') }}</dt>
                                <dd>{{ optional(optional($car_rental->user)->customer)->license_no }}</dd>
                            </div>
                            <div class="col md-6">
                               
                            </div>
                        </div>
                    </div>
                </div>
        </div>

@endsection
