@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Car Type' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('cartype.destroy', $cartype->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    @can("view setting")
                    <a href="{{ route('cartype.index') }}" class="btn btn-primary" title="{{ trans('cartype.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>
                    @endcan
                    @can("add setting")
                    <a href="{{ route('cartype.create') }}" class="btn btn-success" title="{{ trans('cartype.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>
                    @endcan
                    @can("edit setting")
                    <a href="{{ route('cartype.edit', $cartype->id ) }}" class="btn btn-primary" title="{{ trans('cartype.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    @endcan
                    @can("delete setting")
                    <button type="submit" class="btn btn-danger" title="{{ trans('cartype.delete') }}" onclick="return confirm(&quot;{{ trans('cartype.confirm_delete') }}?&quot;)">
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
                                         <dt>{{ trans('cartype.name') }}</dt>
            <dd>{{ $cartype->name }}</dd>    
                                    </div>
                                    <div class="col md-6"> 
                                      <dt>{{ trans('cartype.seats') }}</dt>
            <dd>{{ $cartype->seats }}</dd>
                                    </div>
                                </div>   
                                <div class="row">
                                    <div class="col md-6">        
                                         
            <dt>{{ trans('cartype.is_active') }}</dt>
            <dd>{{ ($cartype->is_active) ? 'Yes' : 'No' }}</dd>   
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
