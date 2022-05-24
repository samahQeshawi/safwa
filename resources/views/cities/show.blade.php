@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($city->name) ? $city->name : 'City' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('cities.city.destroy', $city->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('cities.city.index') }}" class="btn btn-primary" title="{{ trans('cities.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>

                    <a href="{{ route('cities.city.create') }}" class="btn btn-success" title="{{ trans('cities.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>

                    <a href="{{ route('cities.city.edit', $city->id ) }}" class="btn btn-primary" title="{{ trans('cities.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('cities.delete') }}" onclick="return confirm(&quot;{{ trans('cities.confirm_delete') }}?&quot;)">
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
          <div class="card bg-light mb-3">
         <div class="card-header text-white bg-primary mb-3">Cities Information</div>
                            <div class="card-body">
                                 <div class="row">
                                    <div class="col md-6">        
                                         <dt>{{ trans('cities.name') }}</dt>
                                            <dd>{{ $city->name }}</dd> 
                                    </div>
                                    <div class="col md-6"> 
                                              
                                       <dt>{{ trans('cities.country_id') }}</dt>
                                            <dd>{{ optional($city->country)->name }}</dd>
                                    </div>
                                </div>    
                                <div class="row">
                                    <div class="col md-6">        
                                        <dt>{{ trans('cities.is_active') }}</dt>
                                         <dd>{{ ($city->is_active) ? 'Yes' : 'No' }}</dd>
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
