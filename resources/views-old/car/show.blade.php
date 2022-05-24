@extends('adminlte::page')


@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Car Rental'}}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('car.destroy', $car->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('car.index') }}" class="btn btn-primary" title="{{ trans('car.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>

                    <a href="{{ route('car.create') }}" class="btn btn-success" title="{{ trans('car.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>

                    <a href="{{ route('car.edit', $car->id ) }}" class="btn btn-primary" title="{{ trans('car.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('car.delete') }}" onclick="return confirm(&quot;{{ trans('car.confirm_delete') }}?&quot;)">
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
            <dt>{{ trans('car.service_id') }}</dt>
            <dd>{{ optional($car->service)->service }}</dd>
            <dt>{{ trans('car.branch_id') }}</dt>
            <dd>{{ optional($car->location)->name }}</dd>
            <dt>{{ trans('car.car_name') }}</dt>
            <dd>{{ $car->car_name }}</dd>
            <dt>{{ trans('car.category_id') }}</dt>
            <dd>{{ optional($car->category)->category }}</dd>
            <dt>{{ trans('car.car_make_id') }}</dt>
            <dd>{{ optional($car->carMake)->car_make }}</dd>
            <dt>{{ trans('car.car_type_id') }}</dt>
            <dd>{{ optional($car->carType)->name }}</dd>
            <dt>{{ trans('car.model_year') }}</dt>
            <dd>{{ $car->model_year }}</dd>
            <dt>{{ trans('car.seats') }}</dt>
            <dd>{{ $car->seats }}</dd>
            <dt>{{ trans('car.fuel_type_id') }}</dt>
            <dd>{{ optional($car->carFuel)->fuel_type }}</dd>
            <dt>{{ trans('car.transmission') }}</dt>
            <dd>{{ $car->transmission }}</dd>
            <dt>{{ trans('car.color') }}</dt>
            <dd>{{ $car->color }}</dd>
            <dt>{{ trans('car.engine') }}</dt>
            <dd>{{ $car->engine }}</dd>
            <dt>{{ trans('car.engine_no') }}</dt>
            <dd>{{ $car->engine_no }}</dd>
			<dt>{{ trans('car.short_description') }}</dt>
            <dd>{!! $car->short_description !!}</dd>
            <dt>{{ trans('car.description') }}</dt>
            <dd>{!! $car->description !!}</dd>

            <dt>{{ trans('car.registration_no') }}</dt>
            <dd>{{ $car->registration_no }}</dd>
            <dt>{{ trans('car.insurance_expiry_date') }}</dt>
            <dd>{{ $car->insurance_expiry_date }}</dd>
            <dt>{{ trans('car.registration_file') }}</dt>
            @if($car->registration_file)
                <dd><img src="{{ url('storage/app/'.$car->registration_file) }}" width="100px"/></dd>
            @endif
            <dt>{{ trans('car.insurance_file') }}</dt>
            @if($car->insurance_file)
                <dd><img src="{{ url('storage/app/'.$car->insurance_file) }}" width="100px"/></dd>
            @endif
            <dt>{{ trans('car.photo_upload') }}</dt>
             @if($car->carPhotos())
                <dd><ul class="list-photos">
                @foreach($car->carPhotos as $photo)
                    <li><img src="{{ url('storage/app/'.$photo->photo_file) }}" width="100px"/></li>
                @endforeach
            </ul></dd>
             @endif
            <!--<dt>{{ trans('car.star') }}</dt>
            <dd><div class="stars" style="--rating:{{  $car->star }};"></dd>
            <dt>{{ trans('car.meta_keyword') }}</dt>
            <dd>{{ $car->meta_keyword }}</dt>
            <dt>{{ trans('car.meta_description') }}</dt>
            <dd>{{ $car->meta_description }}</dt>-->


        </dl>
    </div>
    </div>
</div>
</div>

@endsection
