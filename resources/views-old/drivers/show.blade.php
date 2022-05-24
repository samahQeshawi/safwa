@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Driver' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    <form method="POST" action="{!! route('drivers.driver.destroy', $driver->id) !!}" accept-charset="UTF-8">
        <input name="_method" value="DELETE" type="hidden">
        {{ csrf_field() }}
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('drivers.driver.index') }}" class="btn btn-primary"
                title="{{ trans('drivers.show_all') }}">
                <i class="fas fa-list-alt"></i>
            </a>

            <a href="{{ route('drivers.driver.create') }}" class="btn btn-success"
                title="{{ trans('drivers.create') }}">
                <i class="fas fa-plus-circle"></i>
            </a>

            <a href="{{ route('drivers.driver.edit', $driver->id ) }}" class="btn btn-primary"
                title="{{ trans('drivers.edit') }}">
                <i class="fas fa-edit"></i>
            </a>

            <button type="submit" class="btn btn-danger" title="{{ trans('drivers.delete') }}"
                onclick="return confirm(&quot;{{ trans('drivers.confirm_delete') }}?&quot;)">
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



                <div class="card bg-light mb-3">
                    <div class="card-header text-white bg-primary mb-3">Personal Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <dt>{{ trans('drivers.profile_image') }}</dt>
                                @if($driver->profile_image)
                                <dd><img src="{{ url('storage/app/'.$driver->profile_image) }}" width="100px" /></dd>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('users.name') }}</dt>
                                <dd>{{ optional($driver)->name }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('drivers.surname') }}</dt>
                                <dd>{{ optional($driver)->surname }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('drivers.email') }}</dt>
                                <dd>{{ optional($driver)->email }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('drivers.phone') }}</dt>
                                <dd>{{ optional($driver)->phone }}</dd>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('drivers.gender') }}</dt>
                                <dd>{{ optional($driver)->gender }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('drivers.dob') }}</dt>
                                <dd>{{ $driver->dob }}</dd>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('drivers.country') }}</dt>
                                <dd>{{ optional($driver->country)->name }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('drivers.city') }}</dt>
                                <dd>{{ optional($driver->city)->name }}</dd>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('drivers.nationality_id') }}</dt>
                                <dd>{{ optional($driver->driver->nationality)->name }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('drivers.national_id') }}</dt>
                                <dd>{{ $driver->driver->national_id }}</dd>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('drivers.is_safwa_driver') }}</dt>
                                <dd>{{ optional($driver->driver)->is_safwa_driver ? 'Yes' : 'No' }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('drivers.is_active') }}</dt>
                                <dd>{{ optional($driver->driver)->is_active }}</dd>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="card bg-light mb-3">
                    <div class="card-header text-white bg-primary mb-3">Attachments</div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('drivers.birth') }}</dt>
                                @if($driver->driver->birth_certificate_file)
                                <dd><img src="{{ url('storage/app/'.$driver->driver->birth_certificate_file) }}"
                                        width="100px" />
                                </dd>
                                @endif
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('drivers.passport_file') }}</dt>
                                @if($driver->driver->passport_file)
                                <dd><img src="{{ url('storage/app/'.$driver->driver->passport_file) }}" width="100px" />
                                </dd>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('drivers.national_file') }}</dt>
                                @if($driver->driver->national_file)
                                <dd><img src="{{ url('storage/app/'.$driver->driver->national_file) }}" width="100px" />
                                </dd>
                                @endif
                            </div>

                            <div class="col md-6">
                                <dt>{{ trans('drivers.license_file') }}</dt>
                                @if($driver->license_file)
                                <dd><img src="{{ url('storage/app/'.$driver->license_file) }}" width="100px" /></dd>
                                @endif
                            </div>

                        </div>


                    </div>
                </div>



                <div class="card bg-light mb-3">
                    <div class="card-header text-white bg-primary mb-3">Vehicle Information</div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('car.car_name') }}</dt>
                                <dd>{{ optional($car)->car_name  }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('car.category_id') }}</dt>
                                <dd>{{ optional(optional($car)->category)->category }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('car.car_type_id') }}</dt>
                                <dd>{{ optional(optional($car)->carType)->name }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('car.car_make_id') }}</dt>
                                <dd>{{ optional(optional($car)->carMake)->car_make }}</dd>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('car.fuel_type_id') }}</dt>
                                <dd>{{ optional(optional($car)->carFuel)->fuel_type }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('car.model_year') }}</dt>
                                <dd>{{ optional($car)->model_year }}</dd>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('car.seats') }}</dt>
                                <dd>{{ optional($car)->seats }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('car.transmission') }}</dt>
                                <dd>{{ optional($car)->transmission }}</dd>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('car.color') }}</dt>
                                <dd>{{ optional($car)->color }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('car.engine') }}</dt>
                                <dd>{{ optional($car)->engine }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('car.engine_no') }}</dt>
                                <dd>{{ optional($car)->engine_no }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('car.registration_no') }}</dt>
                                <dd>{{ optional($car)->registration_no }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('car.insurance_expiry_date') }}</dt>
                                <dd>{{ optional($car)->insurance_expiry_date }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('car.registration_no') }}</dt>
                                <dd>{{ optional($car)->registration_no }}</dd>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('car.insurance_file') }}</dt>
                                @if($car->insurance_file)
                                <dd><img src="{{ url('storage/app/'.$car->insurance_file) }}" width="100px" /></dd>
                                @else
                                <dd>Not available</dd>
                                @endif
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('car.registration_file') }}</dt>
                                @if($car->registration_file)
                                <dd><img src="{{ url('storage/app/'.$car->registration_file) }}" width="100px" />
                                </dd>
                                @else
                                <dd>Not available</dd>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('car.photos') }}</dt>
                            </div>
                        </div>
                        <div class="row">

                            @foreach ($car->carPhotos as $photos)
                            <div class="col md-6">
                                <dd>
                                    <img src="{{ url('storage/app/'.$photos->photo_file) }}" width="100px" />
                                </dd>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>




                <div class="card bg-light mb-3">
                    <div class="card-header text-white bg-primary mb-3">Other Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('drivers.created_at') }}</dt>
                                <dd>{{ $driver->created_at }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('drivers.created_at') }}</dt>
                                <dd>{{ $driver->created_at }}</dd>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
