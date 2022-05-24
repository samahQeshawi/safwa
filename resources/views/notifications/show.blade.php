@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Notification' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('notification.destroy', $notification->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    @can("view notifications")
                    <a href="{{ route('notification.index') }}" class="btn btn-primary" title="{{ trans('notification.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>
                    @endcan
                    @can("add notifications")
                    <a href="{{ route('notification.create') }}" class="btn btn-success" title="{{ trans('notification.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>
                    @endcan
                    @can("edit notifications")
                    <a href="{{ route('notification.edit', $notification->id ) }}" class="btn btn-primary" title="{{ trans('notification.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    @endcan
                    @can("delete notifications")
                    <button type="submit" class="btn btn-danger" title="{{ trans('notification.delete') }}" onclick="return confirm(&quot;{{ trans('notification.confirm_delete') }}?&quot;)">
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
         <div class="card-header text-white bg-primary mb-3">Notifications Information</div>
                            <div class="card-body">
                                 <div class="row">
                                    <div class="col md-6">        
                                            <dt>{{ trans('notification.title') }}</dt>
            <dd>{{ $notification->title }}</dd> 
                                    </div>
                                    <div class="col md-6"> 
                                 
            <dt>{{ trans('notification.body') }}</dt>
            <dd>{{ $notification->body }}</dd> 
                                    </div>
                                </div>        
                                <div class="row">
                                    <div class="col md-6">        
                                           
                                  <dt>{{ trans('notification.is_active') }}</dt>
            <dd>{{ ($notification->is_active) ? 'Yes' : 'No' }}</dd>  
                                    </div>
                                    <div class="col md-6"> 
                                 
                                    </div>
                                </div>    
                            </div>
                        
                            </div>
       
    </div>
    </div>
</div>
</div>

@endsection
