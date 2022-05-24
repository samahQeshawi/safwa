@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ !empty($country->name) ? $country->name : 'Country' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        @can("view setting")
        <a href="{{ route('countries.country.index') }}" class="btn btn-primary" title="{{ trans('countries.show_all') }}">
            <i class="fas fa-list-alt"></i>
        </a>
        @endcan
        @can("add setting")
        <a href="{{ route('countries.country.create') }}" class="btn btn-success" title="{{ trans('countries.create') }}">
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

            <form method="POST" action="{{ route('countries.country.update', $country->id) }}" id="edit_country_form" name="edit_country_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('countries.form', [
                                        'country' => $country,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('countries.update') }}">
                    </div>
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection
