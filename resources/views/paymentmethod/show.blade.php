@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Payment Method' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('paymentmethod.destroy', $paymentmethod->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    @can("view setting")
                    <a href="{{ route('paymentmethod.index') }}" class="btn btn-primary" title="{{ trans('paymentmethod.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>
                    @endcan
                    @can("add setting")
                    <a href="{{ route('paymentmethod.create') }}" class="btn btn-success" title="{{ trans('paymentmethod.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>
                    @endcan
                    @can("edit setting")
                    <a href="{{ route('paymentmethod.edit', $paymentmethod->id ) }}" class="btn btn-primary" title="{{ trans('paymentmethod.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    @endcan
                    @can("delete setting")
                    <button type="submit" class="btn btn-danger" title="{{ trans('paymentmethod.delete') }}" onclick="return confirm(&quot;{{ trans('paymentmethod.confirm_delete') }}?&quot;)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    @endcan
                </div>
            </form>
    </div>
@stop

@section('content')

<div class="panel panel-default">
<div class="card card-primary card-outline">
<div class="card-body">
    <div class="panel-body">
          <div class="card bg-light mb-3">
         <div class="card-header text-white bg-primary mb-3">Cities Information</div>
                            <div class="card-body">
                                 <div class="row">
                                    <div class="col md-6">        
                                          <dt>{{ trans('paymentmethod.name') }}</dt>
            <dd>{{ $paymentmethod->name }}</dd>
                                    </div>
                                    <div class="col md-6"> 
                                              
                                     
            <dt>{{ trans('paymentmethod.is_active') }}</dt>
            <dd>{{ ($paymentmethod->is_active) ? 'Yes' : 'No' }}</dd>
                                    </div>
                                </div>            
                            </div>
                        
                            </div>
        
    </div>
    </div>
</div>
</div>

@endsection
