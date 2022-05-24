@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Fuel Type' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('fuel_types.fuel_type.destroy', $fuelType->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('fuel_types.fuel_type.index') }}" class="btn btn-primary" title="{{ trans('fuel_types.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>

                    <a href="{{ route('fuel_types.fuel_type.create') }}" class="btn btn-success" title="{{ trans('fuel_types.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>

                    <a href="{{ route('fuel_types.fuel_type.edit', $fuelType->id ) }}" class="btn btn-primary" title="{{ trans('fuel_types.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('fuel_types.delete') }}" onclick="return confirm(&quot;{{ trans('fuel_types.confirm_delete') }}?&quot;)">
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
                                       <dt>{{ trans('fuel_types.fuel_type') }}</dt>
            <dd>{{ $fuelType->fuel_type }}</dd> 
                                    </div>
                                    <div class="col md-6"> 
                                    <dt>{{ trans('fuel_types.created_at') }}</dt>
            <dd>{{ $fuelType->created_at }}</dd>
                                    </div>
                                </div>   
                                <div class="row">
                                    <div class="col md-6">        
                                       <dt>{{ trans('fuel_types.updated_at') }}</dt>
            <dd>{{ $fuelType->updated_at }}</dd> 
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
