@extends('adminlte::page')



@section('content_header')
<h1 class="m-0 text-dark">{{optional($page)->name  }}</h1>

@stop

@section('content')

<div class="panel panel-default">

    <div class="card card-primary card-outline">
        <div class="card-body">

            <div class="panel-body">

                <div class="form-group">
                    <div class="col-md-10">
                        {{optional($page)->value }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
