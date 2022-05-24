@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Car Type' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('cartype.destroy', $cartype->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('cartype.index') }}" class="btn btn-primary" title="{{ trans('cartype.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>

                    <a href="{{ route('cartype.create') }}" class="btn btn-success" title="{{ trans('cartype.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>

                    <a href="{{ route('cartype.edit', $cartype->id ) }}" class="btn btn-primary" title="{{ trans('cartype.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('cartype.delete') }}" onclick="return confirm(&quot;{{ trans('cartype.confirm_delete') }}?&quot;)">
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
            <dt>{{ trans('cartype.name') }}</dt>
            <dd>{{ $cartype->name }}</dd>            
			<dt>{{ trans('cartype.seats') }}</dt>
            <dd>{{ $cartype->seats }}</dd>
            <dt>{{ trans('cartype.is_active') }}</dt>
            <dd>{{ ($cartype->is_active) ? 'Yes' : 'No' }}</dd>

        </dl>
    </div>
    </div>
</div>
</div>

@endsection
