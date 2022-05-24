@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Booking' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    <form method="POST" action="{!! route('car_rentals.destroy', $car_rental->id) !!}" accept-charset="UTF-8">
        <input name="_method" value="DELETE" type="hidden">
        {{ csrf_field() }}
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('car_rentals.index') }}" class="btn btn-primary"
                title="{{ trans('car_rental.show_all') }}">
                <i class="fas fa-list-alt"></i>
            </a>

            <a href="{{ route('car_rentals.create') }}" class="btn btn-success"
                title="{{ trans('car_rental.create') }}">
                <i class="fas fa-plus-circle"></i>
            </a>

            <a href="{{ route('car_rentals.edit', $car_rental->id ) }}" class="btn btn-primary"
                title="{{ trans('car_rental.edit') }}">
                <i class="fas fa-edit"></i>
            </a>

            <button type="submit" class="btn btn-danger" title="{{ trans('car_rental.delete') }}"
                onclick="return confirm(&quot;{{ trans('car_rental.confirm_delete') }}?&quot;)">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    </form>
</div>
@stop

@section('content')

<div class="panel panel-default">
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="panel-body">
                <dl class="dl-horizontal">

                    <dt>{{ trans('car_rental.booking_no') }}</dt>
                    <dd>{{ $car_rental->booking_no }}</dd>
                    <dt>{{ trans('car_rental.booking_status') }}</dt>
                    <dd>{{ $car_rental->booking_status }}</dd>
                    <dt>{{ trans('car_rental.payment_status') }}</dt>
                    <dd>{{ $car_rental->payment_status ? 'Paid' : 'Not Paid' }}</dd>
                    <dt>{{ trans('car_rental.user_id') }}</dt>
                    <dd>{{ optional($car_rental->user)->name }}</dd>
                    <dt>{{ trans('car_rental.car_id') }}</dt>
                    <dd>{{ optional($car_rental->car)->car_name }}</dd>
                    <dt>{{ trans('car_rental.pickup_on') }}</dt>
                    <dd>{{ $car_rental->pickup_on }}</dd>
                    <dt>{{ trans('car_rental.dropoff_on') }}</dt>
                    <dd>{{ $car_rental->dropoff_on }}</dd>
                    <dt>{{ trans('car_rental.duration_in_days') }}</dt>
                    <dd>{{ $car_rental->duration_in_days }}</dd>
                    <dt>{{ trans('car_rental.amount') }}</dt>
                    <dd>{{ $car_rental->amount }}</dd>
                    <hr>
                    <dt>{{ trans('car_rental.car_details') }}</dt>
                    <dd>{{ optional($car_rental->car)->registration_no }}</dd>
                    <dd>{{ optional($car_rental->car)->color }}</dd>
                    <dd>{{ optional($car_rental->car)->engine }}</dd>
                    <dd>{{ optional($car_rental->car)->model_year }}</dd>
                    <dd>{{ optional($car_rental->car)->transmission }}</dd>
                    <dd>{{ optional(optional($car_rental->car)->carType)->name }}</dd>
                    <dd>{{ optional(optional($car_rental->car)->carMake)->name }}</dd>
                    <dd>{{ optional(optional($car_rental->car)->carFuel)->fuel_type }}</dd>
                    <dd>{{ optional($car_rental->car)->seats }}</dd>
                    <hr>
                    <dt>{{ trans('car_rental.branch_details') }}</dt>
                    <dd>{{ optional($car_rental->branch)->name }}</dd>
                    <dd>{{ optional($car_rental->branch)->address }}</dd>
                    <dd>{{ optional($car_rental->branch)->zipcode }}</dd>
                    <dd>{{ optional($car_rental->branch)->phone }}</dd>
                    <dd>{{ optional($car_rental->branch)->branch_code }}</dd>

                    <hr>
                    <dt>{{ trans('car_rental.customer_details') }}</dt>
                    <dd>{{ optional($car_rental->user)->name }}</dd>
                    <dd>{{ optional($car_rental->user)->address }}</dd>
                    <dd>{{ optional($car_rental->user)->zipcode }}</dd>
                    <dd>{{ optional($car_rental->user)->phone }}</dd>
                    <dd>{{ optional($car_rental->user)->email }}</dd>
                    <dd>{{ optional($car_rental->user)->gender }}</dd>
                    <dd>{{ optional(optional(optional($car_rental->user)->customer)->nationality)->name }}</dd>
                    <dd>{{ optional(optional($car_rental->user)->customer)->national_id }}</dd>
                    <dd>{{ optional(optional($car_rental->user)->customer)->license_no }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

@endsection
