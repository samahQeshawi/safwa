@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Booking' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('booking.destroy', $booking->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('booking.index') }}" class="btn btn-primary" title="{{ trans('booking.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>

                    <a href="{{ route('booking.create') }}" class="btn btn-success" title="{{ trans('booking.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>

                    <a href="{{ route('booking.edit', $booking->id ) }}" class="btn btn-primary" title="{{ trans('booking.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('booking.delete') }}" onclick="return confirm(&quot;{{ trans('booking.confirm_delete') }}?&quot;)">
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
            <dt>{{ trans('booking.booking_no') }}</dt>
            <dd>{{ $booking->booking_no }}</dd>
            <dt>{{ trans('booking.customer_id') }}</dt>
            <dd>{{ $booking->customer->name }}</dd>
			<dt>{{ trans('booking.start_destination') }}</dt>
            <dd>{{ $booking->start_destination }}</dd>
            <dt>{{ trans('booking.end_destination') }}</dt>
            <dd>{{ $booking->end_destination }}</dd>
            <dt>{{ trans('booking.distance') }}</dt>
            <dd>{{ $booking->distance }}</dd>
            <dt>{{ trans('booking.amount') }}</dt>
            <dd>{{ $booking->amount }}</dd>
            <dt>{{ trans('booking.start_date') }}</dt>
            <dd>{{ $booking->start_date }}</dd>
            <dt>{{ trans('booking.start_time') }}</dt>
            <dd>{{ $booking->start_time }}</dd>
            <dt>{{ trans('booking.landmark') }}</dt>
            <dd>{{ $booking->landmark }}</dd>
            <dt>{{ trans('booking.start_address') }}</dt>
            <dd>{{ $booking->start_address }}</dd>
            <dt>{{ trans('booking.car_type_id') }}</dt>
            <dd>{{ $booking->cartype->name }}</dd>
            <dt>{{ trans('booking.driver_id') }}</dt>
            <dd>{{ $booking->driver->name }}</dd>
        </dl>
    </div>
    </div>
</div>
</div>

@endsection
