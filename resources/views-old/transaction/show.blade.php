@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Transaction' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('transaction.destroy', $transaction->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('transaction.index') }}" class="btn btn-primary" title="{{ trans('transaction.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>

                    <a href="{{ route('transaction.create') }}" class="btn btn-success" title="{{ trans('transaction.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>

                    <a href="{{ route('transaction.edit', $transaction->id ) }}" class="btn btn-primary" title="{{ trans('transaction.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('transaction.delete') }}" onclick="return confirm(&quot;{{ trans('transaction.confirm_delete') }}?&quot;)">
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
            <dt>{{ trans('transaction.booking_id') }}</dt>
            <dd>{{ $transaction->booking->booking_no }}</dd>            
			<dt>{{ trans('transaction.sender_id') }}</dt>
            <dd>{{ $transaction->sender->name }}</dd>
            <dt>{{ trans('transaction.receiver_id') }}</dt>
            <dd>{{ $transaction->receiver->name }}</dd>
            <dt>{{ trans('transaction.amount') }}</dt>
            <dd>{{ $transaction->amount }}</dd>
            <dt>{{ trans('transaction.note') }}</dt>
            <dd>{{ $transaction->note }}</dd>
            <dt>{{ trans('transaction.done_by') }}</dt>
            <dd>{{ $transaction->doneBy->name }}</dd>
        </dl>
    </div>
    </div>
</div>
</div>

@endsection
