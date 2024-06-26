@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($coupon->coupon_name) ? $coupon->coupon_name : 'Coupon' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('coupon.destroy', $coupon->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('coupon.index') }}" class="btn btn-primary" title="{{ trans('coupon.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>

                    <a href="{{ route('coupon.create') }}" class="btn btn-success" title="{{ trans('coupon.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>

                    <a href="{{ route('coupon.edit', $coupon->id ) }}" class="btn btn-primary" title="{{ trans('coupon.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('coupon.delete') }}" onclick="return confirm(&quot;{{ trans('coupon.confirm_delete') }}?&quot;)">
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
            <dt>{{ trans('coupon.name') }}</dt>
            <dd>{{ $coupon->coupon_name }}</dd>
            <dt>{{ trans('coupon.description') }}</dt>
            <dd>{{ $coupon->description }}</dd>
            <dt>{{ trans('coupon.coupon_code') }}</dt>
            <dd>{{ $coupon->coupon_code }}</dd>
            <dt>{{ trans('coupon.place_id') }}</dt>
            <dd>{{ optional($coupon->city)->name }}</dd>
			<dt>{{ trans('coupon.coupon_discount_percentage') }}</dt>
            <dd>{{ $coupon->coupon_discount_percentage }}</dd>
            <dt>{{ trans('coupon.coupon_max_discount_amount') }}</dt>
            <dd>{{ $coupon->coupon_max_discount_amount }}</dd>
            <dt>{{ trans('coupon.coupon_discount_amount') }}</dt>
            <dd>{{ $coupon->coupon_discount_amount }}</dd>
            <dt>{{ trans('coupon.coupon_limit') }}</dt>
            <dd>{{ $coupon->coupon_limit }}</dd>
            <dt>{{ trans('coupon.coupon_image') }}</dt>
            @if($coupon->coupon_image)
                <dd><img src="{{ url('storage/app/'.$coupon->coupon_image) }}" width="100px"/></dd>
            @endif
            <dt>{{ trans('coupon.coupon_from_date') }}</dt>
            <dd>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $coupon->coupon_from_date)->format('d-m-Y') }}</dd>
			<dt>{{ trans('coupon.coupon_to_date') }}</dt>
            <dd>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $coupon->coupon_to_date)->format('d-m-Y') }}</dd>
			<dt>{{ trans('coupon.is_active') }}</dt>
            <dd>{{ $coupon->is_active }}</dd>

        </dl>
    </div>
    </div>
</div>
</div>

@endsection
