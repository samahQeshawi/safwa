@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Service' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('services.service.destroy', $service->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('services.service.index') }}" class="btn btn-primary" title="{{ trans('services.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>

                    <a href="{{ route('services.service.create') }}" class="btn btn-success" title="{{ trans('services.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>

                    <a href="{{ route('services.service.edit', $service->id ) }}" class="btn btn-primary" title="{{ trans('services.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('services.delete') }}" onclick="return confirm(&quot;{{ trans('services.confirm_delete') }}?&quot;)">
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
            <dt>{{ trans('services.service') }}</dt>
            <dd>{{ $service->service }}</dd>
            <dt>{{ trans('services.service_image') }}</dt>
            @if($service->service_image)
                <dd><img src="{{ url('storage/app/'.$service->service_image) }}" width="100px"/></dd>
            @endif            
            <dt>{{ trans('services.is_active') }}</dt>
            <dd>{{ ($service->is_active) ? 'Yes' : 'No' }}</dd>
            <dt>{{ trans('services.created_at') }}</dt>
            <dd>{{ $service->created_at }}</dd>
            <dt>{{ trans('services.updated_at') }}</dt>
            <dd>{{ $service->updated_at }}</dd>

        </dl>
    </div>
    </div>
</div>
</div>

@endsection
