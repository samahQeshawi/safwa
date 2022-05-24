@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Wallet' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
            <div class="btn-group btn-group-sm" role="group">
                <a href="{{ route('wallet.index') }}" class="btn btn-primary" title="{{ trans('wallet.show_all') }}">
                    <i class="fas fa-list-alt"></i>
                </a>
            </div>
    </div>
@stop

@section('content')

<div class="panel panel-default">
<div class="card card-primary card-outline">
<div class="card-body">
    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>{{ trans('wallet.user_id') }}</dt>
            <dd>{{ optional($wallet->user)->name }}</dd>
            <dt>{{ trans('wallet.user_type') }}</dt>
            <dd>{{ optional(optional($wallet->user)->userType)->user_type }}</dd>
			<dt>{{ trans('wallet.amount') }}</dt>
            <dd>{{ $wallet->amount }}</dd>
            <dt>{{ trans('wallet.is_active') }}</dt>
            <dd>{{ ($wallet->is_active) ? 'Yes' : 'No' }}</dd>
        </dl>
    </div>
    </div>
</div>
</div>

@endsection
