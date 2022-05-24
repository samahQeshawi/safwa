@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ !empty($title) ? $title : 'Fuel Type' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        @can("view setting")
        <a href="{{ route('fuel_types.fuel_type.index') }}" class="btn btn-primary" title="{{ trans('fuel_types.show_all') }}">
            <i class="fas fa-list-alt"></i>
        </a>
        @endcan
        @can("add setting")
        <a href="{{ route('fuel_types.fuel_type.create') }}" class="btn btn-success" title="{{ trans('fuel_types.create') }}">
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

            <form method="POST" action="{{ route('fuel_types.fuel_type.update', $fuelType->id) }}" id="edit_fuel_type_form" name="edit_fuel_type_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('fuel_types.form', [
                                        'fuelType' => $fuelType,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('fuel_types.update') }}">
                    </div>
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection
