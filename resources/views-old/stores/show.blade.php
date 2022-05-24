@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($store->name) ? $store->name : 'Store' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('stores.store.destroy', $store->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('stores.store.index') }}" class="btn btn-primary" title="{{ trans('stores.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>

                    <a href="{{ route('stores.store.create') }}" class="btn btn-success" title="{{ trans('stores.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>

                    <a href="{{ route('stores.store.edit', $store->id ) }}" class="btn btn-primary" title="{{ trans('stores.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('stores.delete') }}" onclick="return confirm(&quot;{{ trans('stores.confirm_delete') }}?&quot;)">
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
            <dt>{{ trans('stores.name') }}</dt>
            <dd>{{ $store->name }}</dd>
            <dt>{{ trans('stores.phone') }}</dt>
            <dd>{{ $store->phone }}</dd>
            <dt>{{ trans('stores.address') }}</dt>
            <dd>{{ $store->address }}</dd>
            <dt>{{ trans('stores.company_id') }}</dt>
            <dd>{{ optional($store->company)->name }}</dd>
            <dt>{{ trans('stores.is_active') }}</dt>
            <dd>{{ ($store->is_active) ? 'Yes' : 'No' }}</dd>
            <dt>{{ trans('stores.created_at') }}</dt>
            <dd>{{ $store->created_at }}</dd>
            <dt>{{ trans('stores.updated_at') }}</dt>
            <dd>{{ $store->updated_at }}</dd>

        </dl>
    </div>
    </div>
</div>
</div>

@endsection
