@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Trip' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    <form method="POST" action="{!! route('trip.destroy', $trip->id) !!}" accept-charset="UTF-8">
        <input name="_method" value="DELETE" type="hidden">
        {{ csrf_field() }}
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('trip.index') }}" class="btn btn-primary" title="{{ trans('trip.show_all') }}">
                <i class="fas fa-list-alt"></i>
            </a>

            <a href="{{ route('trip.create') }}" class="btn btn-success" title="{{ trans('trip.create') }}">
                <i class="fas fa-plus-circle"></i>
            </a>

            <a href="{{ route('trip.edit', $trip->id ) }}" class="btn btn-primary" title="{{ trans('trip.edit') }}">
                <i class="fas fa-edit"></i>
            </a>

            <button type="submit" class="btn btn-danger" title="{{ trans('trip.delete') }}"
                onclick="return confirm(&quot;{{ trans('trip.confirm_delete') }}?&quot;)">
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
            <div class="row">
                <div class="col-md-6">
                    <div class="panel-body">
                        <dl class="dl-horizontal">
                            <dt>{{ trans('trip.trip_no') }}</dt>
                            <dd>{{ optional($trip)->trip_no }}</dd>
                            <dt>{{ trans('trip.is_now_trip') }}</dt>
                            <dd>{{ optional($trip)->is_now_trip ? 'Now' : 'Later' }}</dd>
                            <dt>{{ trans('trip.pickup_on') }}</dt>
                            <dd>{{ optional($trip)->pickup_on }}</dd>
                            <dt>{{ trans('trip.dropoff_on') }}</dt>
                            <dd>{{ optional($trip)->dropoff_on }}</dd>
                            <dt>{{ trans('trip.from_address') }}</dt>
                            <dd>{{ optional($trip)->from_address }}</dd>
                            <dt>{{ trans('trip.from_location') }}</dt>
                            <dd>{{ optional($trip)->from_location }}</dd>
                            <dt>{{ trans('trip.distance') }}</dt>
                            <dd>{{ optional($trip)->distance }}</dd>
                            <dt>{{ trans('trip.km_charge') }}</dt>
                            <dd>{{ optional($trip)->km_charge }}</dd>
                            <dt>{{ trans('trip.cancellation_charge') }}</dt>
                            <dd>{{ optional($trip)->cancellation_charge }}</dd>
                            <dt>{{ trans('trip.amount') }}</dt>
                            <dd>{{ optional($trip)->amount }}</dd>
                            <dt>{{ trans('trip.discount') }}</dt>
                            <dd>{{ optional($trip)->discount }}</dd>
                            <dt>{{ trans('trip.tax') }}</dt>
                            <dd>{{ optional($trip)->tax }}</dd>
                            <dt>{{ trans('trip.final_amount') }}</dt>
                            <dd>{{ optional($trip)->final_amount }}</dd>
                            <dt>{{ trans('trip.customer_id') }}</dt>
                            <dd>{{ optional(optional($trip)->customer)->name }}</dd>
                            <dt>{{ trans('trip.driver_id') }}</dt>
                            <dd>{{ optional(optional($trip)->driver)->name }}</dd>
                            <dt>{{ trans('trip.car_id') }}</dt>
                            <dd>{{ optional(optional($trip)->car)->car_name }}</dd>
                            <dt>{{ trans('trip.service_id') }}</dt>
                            <dd>{{ optional(optional($trip)->service)->service }}</dd>
                            <dt>{{ trans('trip.category_id') }}</dt>
                            <dd>{{ optional(optional($trip)->category)->category }}</dd>
                            <dt>{{ trans('trip.payment_method') }}</dt>
                            <?php if(isset(optional($trip)->paymentMethod)) { ?>
                            <dd>{{ optional(optional($trip)->paymentMethod)->name}}</dd>
                            <?php } else { ?>
                            <dd></dd>
                            <?php } ?>
                            <dt>{{ trans('trip.payment_status') }}</dt>
                            <dd>{{ optional($trip)->payment_status ? 'Paid' : 'Due'}}</dd>
                            <dt>{{ trans('trip.created_at') }}</dt>
                            <dd>{{ $trip->created_at }}</dd>
                            <dt>{{ trans('trip.updated_at') }}</dt>
                            <dd>{{ $trip->updated_at }}</dd>

                        </dl>
                    </div>
                </div>
                <div class="col-md-6"><trips :trip="{{ $trip->id }}"></trips></div>
            </div>
        </div>
    </div>
</div>

@endsection
