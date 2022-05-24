@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($coupon_report->coupon_code) ? $coupon_report->coupon_code : 'Coupon' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
           <div class="btn-group btn-group-sm" role="group">
                <a href="{{ route('coupon_reports.index') }}" class="btn btn-primary" title="{{ trans('coupon_reports.show_all') }}">
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
            <dt>{{ trans('coupon_reports.user') }}</dt>
            <dd>{{ $coupon_report->user->name }}</dd>
            <dt>{{ trans('coupon_reports.coupon_code') }}</dt>
            <dd>{{ $coupon_report->coupon_code }}</dd>      
            <dt>{{ trans('coupon_reports.service') }}</dt>
            <dd>{{ $coupon_report->service->service }}</dd>  			
			<dt>{{ trans('coupon_reports.car_rental') }}</dt>
            <dd>{{ $coupon_report->carRental->car->car_name }}</dd>            
            <dt>{{ trans('coupon_reports.applied_on') }}</dt>
             <dd>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $coupon_report->applied_on)->format('d-m-Y') }}</dd>    
            <dt>{{ trans('coupon_reports.total_amount') }}</dt>
            <dd>{{ $coupon_report->total_amount }}</dd>
            <dt>{{ trans('coupon_reports.discount') }}</dt>
            <dd>{{ $coupon_report->coupon_discount_amount }}</dd>

        </dl>
    </div>
    </div>
</div>
</div>

@endsection
