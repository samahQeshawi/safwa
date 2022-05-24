@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Transaction' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('transaction.destroy', $transaction->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    @can("view wallet")
                    <a href="{{ route('transaction.index') }}" class="btn btn-primary" title="{{ trans('transaction.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>
                    @endcan
                    @can("add wallet")
                    <a href="{{ route('transaction.create') }}" class="btn btn-success" title="{{ trans('transaction.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>
                    @endcan
                    @can("edit wallet")
                    <a href="{{ route('transaction.edit', $transaction->id ) }}" class="btn btn-primary" title="{{ trans('transaction.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    @endcan
                    @can("delete wallet")
                    <button type="submit" class="btn btn-danger" title="{{ trans('transaction.delete') }}" onclick="return confirm(&quot;{{ trans('transaction.confirm_delete') }}?&quot;)">
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
         <div class="card-header text-white bg-primary mb-3">Transaction Information</div>
                            <div class="card-body">
                                 <div class="row">
                                    <div class="col md-6">  
                                    @if(!empty(@$transaction->booking->booking_no ))      
                                        <dt>{{ trans('transaction.booking_id') }}</dt>
            <dd>{{ @$transaction->booking->booking_no }}</dd>  
            @else
             <dt>{{ trans('transaction.trip_no') }}</dt>
            <dd>{{ @$transaction->trip->trip_no }}</dd>  
            @endif
                                    </div>
                                    <div class="col md-6"> 
                                   <dt>{{ trans('transaction.sender_id') }}</dt>
            <dd>{{ @$transaction->sender->name }}</dd>
                                    </div>
                                </div>   
                                <div class="row">
                                    <div class="col md-6">        
                                        <dt>{{ trans('transaction.receiver_id') }}</dt>
            <dd>{{ @$transaction->receiver->name }}</dd>
                                    </div>
                                    <div class="col md-6"> 
                                         <dt>{{ trans('transaction.amount') }}</dt>
            <dd>{{ @$transaction->amount }}</dd>
                                    </div>
                                </div>   
                                 <div class="row">
                                    <div class="col md-6">        
                                       <dt>{{ trans('transaction.datetime') }}</dt>
            <dd>{{ @$transaction->created_at }}</dd>
                                    </div>
                                    <div class="col md-6"> 
                                         <dt>{{ trans('transaction.note') }}</dt>
            <dd>{{ @$transaction->note }}</dd>
                                    </div>
                                </div>      
                                <div class="row">
                                    <div class="col md-6">        
                                       
                                    </div>
                                    <div class="col md-6"> 
                                        
                                    </div>
                                </div>     
                            </div>
                        
                            </div>
                            <div class="card bg-light mb-3">
         <div class="card-header text-white bg-primary mb-3">Sender Information</div>
                            <div class="card-body">
                                 <div class="row">
                                    <div class="col md-6">  
                                      
                                        <dt>{{ trans('transaction.sender_name') }}</dt>
            <dd>{{ @$transaction->sender->name }}</dd>  
           
                                    </div>
                                    <div class="col md-6"> 
                                   <dt>{{ trans('transaction.sender_email') }}</dt>
            <dd>{{ @$transaction->sender->email }}</dd>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="col md-6">  
                                      
                                        <dt>{{ trans('transaction.sender_phone') }}</dt>
            <dd>{{ @$transaction->sender->phone }}</dd>  
           
                                    </div>
                                    <div class="col md-6"> 
                                   <dt>{{ trans('transaction.sender_address') }}</dt>
            <dd>{{ @$transaction->sender->address }}</dd>
                                    </div>
                                </div>   
                            </div>
                        </div>
                        <div class="card bg-light mb-3">
         <div class="card-header text-white bg-primary mb-3">Receiver Information</div>
                            <div class="card-body">
                                 <div class="row">
                                    <div class="col md-6">  
                                      
                                        <dt>{{ trans('transaction.receiver_name') }}</dt>
            <dd>{{ @$transaction->receiver->name }}</dd>  
           
                                    </div>
                                    <div class="col md-6"> 
                                   <dt>{{ trans('transaction.receiver_email') }}</dt>
            <dd>{{ @$transaction->receiver->email }}</dd>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="col md-6">  
                                      
                                        <dt>{{ trans('transaction.receiver_phone') }}</dt>
            <dd>{{ @$transaction->receiver->phone }}</dd>  
           
                                    </div>
                                    <div class="col md-6"> 
                                   <dt>{{ trans('transaction.receiver_address') }}</dt>
            <dd>{{ @$transaction->receiver->address }}</dd>
                                    </div>
                                </div>   
                            </div>
                        </div>
       
    </div>
    </div>
    </div>
</div>
</div>

@endsection
