@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ isset($group->title) ? $group->title : 'Group' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    <form method="POST" action="{!! route('groups.group.destroy', $group->id) !!}" accept-charset="UTF-8">
        <input name="_method" value="DELETE" type="hidden">
        {{ csrf_field() }}
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('groups.group.index') }}" class="btn btn-primary" title="{{ trans('groups.show_all') }}">
                <i class="fas fa-list-alt"></i>
            </a>

            <a href="{{ route('groups.group.create') }}" class="btn btn-success" title="{{ trans('groups.create') }}">
                <i class="fas fa-plus-circle"></i>
            </a>

            <a href="{{ route('groups.group.edit', $group->id ) }}" class="btn btn-primary"
                title="{{ trans('groups.edit') }}">
                <i class="fas fa-edit"></i>
            </a>

            <button type="submit" class="btn btn-danger" title="{{ trans('groups.delete') }}"
                onclick="return confirm(&quot;{{ trans('groups.confirm_delete') }}?&quot;)">
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
                    <dt>{{ trans('groups.title') }}</dt>
                    <dd>{{ $group->title }}</dd>
                    <dt>{{ trans('groups.description') }}</dt>
                    <dd>{{ $group->description }}</dd>
                    <dt>Members</dt>
                    <dd>
                        <ul>@foreach($group->users()->pluck('name')->toArray() as $key=>$name)
                            <li>{{ $name }}</li>
                            @endforeach
                        </ul>
                    </dd>
                    <dt>{{ trans('groups.is_active') }}</dt>
                    <dd>{{ ($group->is_active) ? trans('groups.is_active_1') : trans('groups.is_active_0') }}</dd>
                    <dt>{{ trans('groups.created_at') }}</dt>
                    <dd>{{ $group->created_at }}</dd>
                    <dt>{{ trans('groups.updated_at') }}</dt>
                    <dd>{{ $group->updated_at }}</dd>

                </dl>
            </div>
        </div>
    </div>
</div>

@endsection
