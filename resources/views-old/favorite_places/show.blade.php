@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Favorite Place' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    <form method="POST" action="{!! route('favorite_places.destroy', $favorite_place->id) !!}" accept-charset="UTF-8">
        <input name="_method" value="DELETE" type="hidden">
        {{ csrf_field() }}
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('favorite_places.index') }}" class="btn btn-primary" title="{{ trans('favorite_places.show_all') }}">
                <i class="fas fa-list-alt"></i>
            </a>

            <a href="{{ route('favorite_places.create') }}" class="btn btn-success" title="{{ trans('favorite_places.create') }}">
                <i class="fas fa-plus-circle"></i>
            </a>

            <a href="{{ route('favorite_places.edit', $favorite_place->id ) }}" class="btn btn-primary"
                title="{{ trans('favorite_places.edit') }}">
                <i class="fas fa-edit"></i>
            </a>

            <button type="submit" class="btn btn-danger" title="{{ trans('favorite_places.delete') }}"
                onclick="return confirm(&quot;{{ trans('favorite_places.confirm_delete') }}?&quot;)">
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
                    <dt>{{ trans('favorite_places.user_id') }}</dt>
                    <dd>{{ optional($favorite_place)->user->name }}</dd>
                    <dt>{{ trans('favorite_places.title') }}</dt>
                    <dd>{{ optional($favorite_place)->title }}</dd>
                    <dt>{{ trans('favorite_places.address') }}</dt>
                    <dd>{{ optional($favorite_place)->address }}</dd>
                    <dt>{{ trans('favorite_places.latitude') }}</dt>
                    <dd>{{ optional(optional($favorite_place)->location)->getLat() }}</dd>
                    <dt>{{ trans('favorite_places.longitude') }}</dt>
                    <dd>{{ optional(optional($favorite_place)->location)->getLng() }}</dd>
                    <dt>{{ trans('favorite_places.created_at') }}</dt>
                    <dd>{{ $favorite_place->created_at }}</dd>
                    <dt>{{ trans('favorite_places.updated_at') }}</dt>
                    <dd>{{ $favorite_place->updated_at }}</dd>

                </dl>
            </div>
        </div>
    </div>
</div>

@endsection
