@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ !empty($city->name) ? $city->name : 'City' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">

        <a href="{{ route('cities.city.index') }}" class="btn btn-primary" title="{{ trans('cities.show_all') }}">
            <i class="fas fa-list-alt"></i>
        </a>

        <a href="{{ route('cities.city.create') }}" class="btn btn-success" title="{{ trans('cities.create') }}">
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

            <form method="POST" action="{{ route('cities.city.update', $city->id) }}" id="edit_city_form" name="edit_city_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('cities.form', [
                                        'city' => $city,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('cities.update') }}">
                    </div>
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection
