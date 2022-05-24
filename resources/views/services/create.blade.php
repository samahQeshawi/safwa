@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('services.create') }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <a href="{{ route('services.service.index') }}" class="btn btn-primary" title="{{ trans('services.show_all') }}">
            <i class="fas fa-list-alt"></i>
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

            <form method="POST" action="{{ route('services.service.store') }}" accept-charset="UTF-8" id="create_service_form" name="create_service_form" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            @include ('services.form', [
                                        'service' => null,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('services.add') }}">
                    </div>
                </div>

            </form>

        </div>
    </div>
    </div>
    </div>

@endsection


