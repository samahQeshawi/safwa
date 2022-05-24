@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ !empty($group->title) ? $group->title : 'Group' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">

        <a href="{{ route('groups.group.index') }}" class="btn btn-primary" title="{{ trans('groups.show_all') }}">
            <i class="fas fa-list-alt"></i>
        </a>

        <a href="{{ route('groups.group.create') }}" class="btn btn-success" title="{{ trans('groups.create') }}">
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

            <form method="POST" action="{{ route('groups.group.update', $group->id) }}" id="edit_group_form" name="edit_group_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('groups.form', [
                                        'group' => $group,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('groups.update') }}">
                    </div>
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection
