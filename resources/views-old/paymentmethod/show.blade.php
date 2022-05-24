@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Payment Method' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('paymentmethod.destroy', $paymentmethod->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('paymentmethod.index') }}" class="btn btn-primary" title="{{ trans('paymentmethod.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>

                    <a href="{{ route('paymentmethod.create') }}" class="btn btn-success" title="{{ trans('paymentmethod.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>

                    <a href="{{ route('paymentmethod.edit', $paymentmethod->id ) }}" class="btn btn-primary" title="{{ trans('paymentmethod.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('paymentmethod.delete') }}" onclick="return confirm(&quot;{{ trans('paymentmethod.confirm_delete') }}?&quot;)">
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
            <dt>{{ trans('paymentmethod.name') }}</dt>
            <dd>{{ $paymentmethod->name }}</dd>
            <dt>{{ trans('paymentmethod.is_active') }}</dt>
            <dd>{{ ($paymentmethod->is_active) ? 'Yes' : 'No' }}</dd>

        </dl>
    </div>
    </div>
</div>
</div>

@endsection
