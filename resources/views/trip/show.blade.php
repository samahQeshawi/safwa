@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Trip' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    <form method="POST" action="{!! route('trip.destroy', $trip->id) !!}" accept-charset="UTF-8">
        <input name="_method" value="DELETE" type="hidden">
        {{ csrf_field() }}
        <div class="btn-group btn-group-sm" role="group">
            @can("view trips")
            <a href="{{ route('trip.index') }}" class="btn btn-primary" title="{{ trans('trip.show_all') }}">
                <i class="fas fa-list-alt"></i>
            </a>
            @endcan
            @can("add trips")
           <!--  <a href="{{ route('trip.create') }}" class="btn btn-success" title="{{ trans('trip.create') }}">
                <i class="fas fa-plus-circle"></i>
            </a> -->
            @endcan
            @can("edit trips")
            <a href="{{ route('trip.edit', $trip->id ) }}" class="btn btn-primary" title="{{ trans('trip.edit') }}">
                <i class="fas fa-edit"></i>
            </a>
            @endcan
            @can("delete trips")
            <button type="submit" class="btn btn-danger" title="{{ trans('trip.delete') }}"
                onclick="return confirm(&quot;{{ trans('trip.confirm_delete') }}?&quot;)">
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
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-body">
                        <div class="card bg-light mb-3">
                            <div class="card-header text-white bg-primary mb-3">Trip Information</div>
                            <div class="card-body">
                                  <div class="row">
                            <div class="col md-6">                    
                                <dt>{{ trans('trip.trip_no') }}</dt>
                            <dd>{{ optional($trip)->trip_no }}</dd>
                            </div>
                            <div class="col md-6">

                                 <dt>Request Type</dt>
                            <dd>{{ optional($trip)->is_now_trip ? 'Now' : 'Later' }}</dd>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col md-6">                    
                                <dt>{{ trans('trip.status') }}</dt>
                                @if($trip->status == 1)
<dd>New</dd>
@elseif($trip->status == 2)
<dd>Pending</dd>
@elseif($trip->status == 3)
<dd>No Driver Available</dd>
@elseif($trip->status == 4)
<dd>Driver Accepted</dd>
@elseif($trip->status == 5)
<dd>Driver Reached Pickup</dd>
@elseif($trip->status == 6)
<dd>Trip Started</dd>
@elseif($trip->status == 7)
<dd>Reached Desitnation</dd>
@elseif($trip->status == 8)
<dd>Completed Trip</dd>
@elseif($trip->status == 9)
<dd>Money Collected</dd>
@elseif($trip->status == 10)
<dd>Trip Cancelled by Driver</dd>
@elseif($trip->status == 11)
<dd>Cancelled by Driver</dd>
@endif
                           
                            </div>
                            <div class="col md-6">
                              <dt>{{ trans('trip.payment_status') }}</dt>
                              @if(optional($trip)->payment_status == 1)
                            {{ trans('trip.paid') }}
                            @else
                            <dd>{{ trans('trip.unpaid') }}</dd>
                            @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">                    
                                <dt>{{ trans('trip.pickup_on') }}</dt>
                            <dd>{{ optional($trip)->pickup_on }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('trip.dropoff_on') }}</dt>
                            <dd>{{ optional($trip)->dropoff_on }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">                    
                               <dt>{{ trans('trip.from_address') }}</dt>
                            <dd>{{ optional($trip)->from_address }}</dd>
                            </div>
                            <div class="col md-6">
                                 <dt>{{ trans('trip.from_location') }}</dt>
                                 @php
                                 list($long,$lat) = explode(" ",optional($trip)->from_location);
                                 @endphp
                            <dd>{{ $lat}},{{ $long}}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">                    
                               <dt>{{ trans('trip.to_address') }}</dt>
                            <dd>{{ optional($trip)->to_address }}</dd>
                            </div>
                            <div class="col md-6">
                                 <dt>{{ trans('trip.to_location') }}</dt>
                                   @php
                                 list($long,$lat) = explode(" ",optional($trip)->to_location);
                                 @endphp
                            <dd>{{ $lat}},{{ $long}}</dd>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col md-6">                    
                             
                            <dt>{{ trans('trip.car_id') }}</dt>
                            <dd>{{ optional(optional($trip)->car)->car_name }}</dd>
                            </div>
                            <div class="col md-6">
                               <dt>{{ trans('trip.service_id') }}</dt>
                            <dd>{{ optional(optional($trip)->service)->service }}</dd>
                            </div>
                        </div>

                       
                        
                         <div class="row">
                            <div class="col md-6">                    
                                <dt>{{ trans('trip.category_id') }}</dt>
                            <dd>{{ optional(optional($trip)->category)->category }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('trip.payment_method') }}</dt>
                            <?php if(isset(optional($trip)->payment_method_id)) { ?>
                            <dd>{{ optional(optional($trip)->paymentMethod)->name}}</dd>
                            <?php } else { ?>
                            <dd></dd>
                            <?php } ?>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col md-6"> 
                             <dt>{{ trans('trip.driver_id') }}</dt>
                            <dd>{{ optional(optional($trip)->driver)->name }}</dd>                   
                            </div>
        
                            <div class="col md-6">
                                <dt>{{ trans('trip.customer_id') }}</dt>
                            <dd>{{ optional(optional($trip)->customer)->name }}</dd>
                            </div>
                        </div>
                         
                        <div class="row">
                            <div class="col md-6">                    
                              <dt>{{ trans('trip.created_at') }}</dt>
                            <dd>{{ $trip->created_at }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('trip.updated_at') }}</dt>
                            <dd>{{ $trip->updated_at }}</dd>
                            </div>
                        </div>
                            </div>
                        </div>
                        <div class="card bg-light mb-3">
                            <div class="card-header text-white bg-primary mb-3">Driver Information</div>
                            <div class="card-body">
                                 <div class="row">
                                    <div class="col md-6">                    
                                        <dt>{{ trans('trip.driver_name') }}</dt>
                                        <dd>{{ optional(optional($trip)->driver)->name }}</dd>
                                    </div>
                                    <div class="col md-6">
                                      <dt>{{ trans('trip.driver_phone') }}</dt>
                                        <dd>{{ optional(optional($trip)->driver)->phone }}</dd>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col md-6">                    
                                       <dt>{{ trans('trip.driver_email') }}</dt>
                                     <dd>{{ optional(optional($trip)->driver)->email }}</dd>
                                    </div>
                                    <div class="col md-6">
                                         <dt>{{ trans('trip.driver_address') }}</dt>
                                     <dd>{{ optional(optional($trip)->driver)->address }}</dd>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="col md-6">                    
                                       <dt>{{ trans('trip.driver_rating') }}</dt>
                                        @php
                                                    $val = 0;
                                                    if(!empty( optional(optional($trip)->customer))){
                                                        $rating = App\Models\Rating::where('trip_id',$trip->id)->where('rated_for',$trip->customer->id)->first();
                                                        if(!empty($rating)){
                                                             $val= $rating->rating;   
                                                        }    
                                                    }
                                                    
                                            @endphp
                                        <dd>
                                            <div class="stars" style="--rating: <?php echo $val;?>;"></div>    
                                        </dd>   
                                    </div>
                                    <div class="col md-6">
                                       
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                        <div class="card bg-light mb-3">
                            <div class="card-header text-white bg-primary mb-3">Customer Information</div>
                            <div class="card-body">
                                 <div class="row">
                                    <div class="col md-6">                    
                                        <dt>{{ trans('trip.customer_name') }}</dt>
                                        <dd>{{ optional(optional($trip)->customer)->name }}</dd>
                                    </div>
                                    <div class="col md-6">
                                      <dt>{{ trans('trip.customer_phone') }}</dt>
                                        <dd>{{ optional(optional($trip)->customer)->phone }}</dd>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col md-6">                    
                                       <dt>{{ trans('trip.customer_email') }}</dt>
                                     <dd>{{ optional(optional($trip)->customer)->email }}</dd>
                                    </div>
                                    <div class="col md-6">
                                         <dt>{{ trans('trip.customer_address') }}</dt>
                                     <dd>{{ optional(optional($trip)->customer)->address }}</dd>
                                    </div>
                                </div>
                                    <div class="row">
                                    <div class="col md-6">                    
                                       <dt>{{ trans('trip.customer_rating') }}</dt>
                                        <dd>
                                            @php
                                                    $val = 0;
                                                    if(!empty( optional(optional($trip)->customer))){
                                                        $rating = App\Models\Rating::where('trip_id',$trip->id)->where('rated_for',$trip->customer->id)->first();
                                                        if(!empty($rating)){
                                                             $val= $rating->rating;   
                                                        }    
                                                    }
                                                    
                                            @endphp

                                            <div class="stars" style="--rating: <?php echo $val;?>"></div>    
                                        </dd>   
                                    </div>
                                    <div class="col md-6">
                                       
                                    </div>
                                </div>
                                 
                              
                            </div>
                        </div>
                        <div class="card bg-light mb-3">
                            <div class="card-header text-white bg-primary mb-3">Fare Information</div>
                            <div class="card-body">
                                 <div class="row">
                                    <div class="col md-6">                    
                                        <dt>{{ trans('trip.distance') }}</dt>
                                    <dd>{{ optional($trip)->distance }}</dd>
                                    </div>
                                    <div class="col md-6">
                                        <dt>{{ trans('trip.km_charge') }}</dt>
                                    <dd>{{ optional($trip)->km_charge }}</dd>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col md-6">                    
                                       <dt>{{ trans('trip.cancellation_charge') }}</dt>
                                    <dd>{{ optional($trip)->cancellation_charge }}</dd>
                                    </div>
                                    <div class="col md-6">
                                         <dt>{{ trans('trip.amount') }}</dt>
                                    <dd>{{ optional($trip)->amount }}</dd>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col md-6">                    
                                       <dt>{{ trans('trip.discount') }}</dt>
                                    <dd>{{ optional($trip)->discount }}</dd>
                                    </div>
                                    <div class="col md-6">
                                        <dt>{{ trans('trip.tax') }}</dt>
                                    <dd>{{ optional($trip)->tax }}</dd>
                                    </div>
                                </div>
                                <div class="row">
                            <div class="col md-6">                    
                               <dt>{{ trans('trip.final_amount') }}</dt>
                            <dd>{{ optional($trip)->final_amount }}</dd>
                            </div>
                           
                            </div>
                        </div>
                        
                </div>
                <div class="col-md-6"><trips :trip="{{ $trip->id }}"></trips></div>
            </div>
        </div>
    </div>
</div>
@endsection

