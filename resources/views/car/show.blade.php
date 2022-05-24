@extends('adminlte::page')


@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Car Rental'}}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('car.destroy', $car->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    @can("view cars")
                    <a href="{{ route('car.index') }}" class="btn btn-primary" title="{{ trans('car.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>
                    @endcan
                    @can("add cars")
                    <a href="{{ route('car.create') }}" class="btn btn-success" title="{{ trans('car.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>
                    @endcan
                    @can("edit cars")
                    <a href="{{ route('car.edit', ['car' => $car->id, 'service_type'=>$car->service_id]) }}" class="btn btn-primary" title="{{ trans('car.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    @endcan
                    @can("delete cars")
                    <button type="submit" class="btn btn-danger" title="{{ trans('car.delete') }}" onclick="return confirm(&quot;{{ trans('car.confirm_delete') }}?&quot;)">
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
             @php
                            $title = "Cars";
                            if( $car->service->service == "Rent Car"){
                                    $title = "Rent Car";
                            }elseif( $car->service->service == "Airport Taxi"){
                                $title = "Airport Taxi";
                            }elseif( $car->service->service == "Smart Car"){
                                $title = "Smart Car";
                            }


                    @endphp
         <div class="card-header text-white bg-primary mb-3">{{ $title}} Information</div>
                            <div class="card-body">
                                 <div class="row">
                                    <div class="col md-6">        
                                          <dt>{{ trans('car.service_id') }}</dt>
            <dd>{{ optional($car->service)->service }}</dd>  
                                    </div>
                                    <div class="col md-6">
                                    @if( optional($car->location)->name) 
                                       <dt>{{ trans('car.branch_id') }}</dt>
            <dd>{{ optional($car->location)->name }}</dd>
                    @endif
                                    </div>
                                </div>   
                                <div class="row">
                                    <div class="col md-6">        
                                       <dt>{{ trans('car.car_name') }}</dt>
            <dd>{{ $car->car_name }}</dd> 
                                    </div>
                                    <div class="col md-6"> 
                                         <dt>{{ trans('car.category_id') }}</dt>
            <dd>{{ optional($car->category)->category }}</dd>
                                    </div>
                                </div> 
                                 <div class="row">
                                    <div class="col md-6">        
                                        <dt>{{ trans('car.car_make_id') }}</dt>
            <dd>{{ optional($car->carMake)->car_make }}</dd>
                                    </div>
                                    <div class="col md-6"> 
                                          <dt>{{ trans('car.car_type_id') }}</dt>
            <dd>{{ optional($car->carType)->name }}</dd>
                                    </div>
                                </div> 
                                 <div class="row">
                                    <div class="col md-6">        
                                        <dt>{{ trans('car.seats') }}</dt>
            <dd>{{ $car->seats }}</dd>
                                    </div>
                                    <div class="col md-6"> 
                                           <dt>{{ trans('car.model_year') }}</dt>
            <dd>{{ $car->model_year }}</dd>
                                    </div>
                                </div>   
                                <div class="row">
                                    <div class="col md-6">        
                                       <dt>{{ trans('car.fuel_type_id') }}</dt>
            <dd>{{ optional($car->carFuel)->fuel_type }}</dd>
                                    </div>
                                    <div class="col md-6"> 
                                            <dt>{{ trans('car.transmission') }}</dt>
            <dd>{{ $car->transmission }}</dd>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col md-6">        
                                      <dt>{{ trans('car.color') }}</dt>
            <dd>{{ $car->color }}</dd>
                                    </div>
                                    <div class="col md-6"> 
                                           @if( $car->service->service != "Rent Car")
                                            <dt>{{ trans('car.cancellation_before') }}</dt>
            <dd>{{ optional($car)->cancellation_before }}</dd>  
                                           @endif
                                    </div>
                                </div>    
                                 <div class="row">
                                    <div class="col md-6">        
                                      <dt>{{ trans('car.engine_no') }}</dt>
            <dd>{{ $car->engine_no }}</dd>

                                    </div>
                                    <div class="col md-6"> 
                                        <dt>{{ trans('car.description') }}</dt>
            <dd>{!! $car->description !!}</dd>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col md-6">        
                                      <dt>{{ trans('car.description') }}</dt>
            <dd>{!! $car->description !!}</dd>
            
                                    </div>
                                    <div class="col md-6"> 
                                          <dt>{{ trans('car.registration_no') }}</dt>
            <dd>{{ $car->registration_no }}</dd>
                                    </div>
                                </div> 
                                 <div class="row">
                                    <div class="col md-6">        
                                       <dt>{{ trans('car.registration_file') }}</dt>
            @if($car->registration_file)
                <dd><img src="{{ url('storage/app/'.$car->registration_file) }}" width="100px"/></dd>
            @endif
            
                                    </div>
                                    <div class="col md-6"> 
                                         
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col md-6">        
                                       <dt>{{ trans('car.insurance_file') }}</dt>
            @if($car->insurance_file)
                <dd><img src="{{ url('storage/app/'.$car->insurance_file) }}" width="100px"/></dd>
            @endif
            
                                    </div>
                                    <div class="col md-6"> 
                                         <dt>{{ trans('car.photo_upload') }}</dt>
             @if(@$car->carPhotos())
                <dd><ul class="list-photos">
                @foreach($car->carPhotos as $photo)
                    <li><img src="{{ url('storage/app/'.$photo->photo_file) }}" width="100px"/></li>
                @endforeach
            </ul></dd>
             @endif
                                    </div>
                                </div>        
                            </div>
                        
                            </div>
                             @if( $car->service->service == "Rent Car")
                              <div class="card bg-light mb-3">
                                 <div class="card-header text-white bg-primary mb-3">{{ trans('car.renting') }}</div>
                            <div class="card-body">
                                 <div class="row">
                                    <div class="col md-6">        
                                          <dt>{{ trans('car.rent_daily') }}</dt>
            <dd>{{ optional($car)->rent_daily }}</dd>  
                                    </div>
                                    <div class="col md-6">
                                       <dt>{{ trans('car.rent_weekly') }}</dt>
            <dd>{{optional($car)->rent_weekly }}</dd>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col md-6">        
                                          <dt>{{ trans('car.rent_monthly') }}</dt>
            <dd>{{ optional($car)->rent_monthly }}</dd>  
                                    </div>
                                    <div class="col md-6">
                                       <dt>{{ trans('car.rent_yearly') }}</dt>
            <dd>{{optional($car)->rent_yearly }}</dd>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col md-6">        
                                          <dt>{{ trans('car.cancellation_before') }}</dt>
            <dd>{{ optional($car)->cancellation_before }}</dd>  
                                    </div>
                                    <div class="col md-6">
                                       
                                    </div>
                                </div>
                                
                                </div>
                                </div>   
                             @endif
    </div>
    </div>
</div>
</div>

@endsection
