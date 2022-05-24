<div class="row">
<div class="col-md-6">
<div class="form-group {{ $errors->has('driver_id') ? 'has-error' : '' }}">
    <label for="driver_id" class="col-md-2 control-label">{{ trans('trip.driver_id') }}</label>
    <div class="col-md-10">
        <select class="form-control" id="driver_id" readonly name="driver_id" required="true">
                <option value="" style="display: none;" {{ old('driver_id', optional($trip)->driver_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('trip.driver_id__placeholder') }}</option>
            @foreach ($driver as $key => $driver_value)
                <option value="{{ $key }}" {{ old('driver_id', optional($trip)->driver_id) == $key ? 'selected' : '' }}>
                    {{ $driver_value }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('driver_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
<div class="col-md-6">
<div class="form-group {{ $errors->has('customer_id') ? 'has-error' : '' }}">
    <label for="customer_id" class="col-md-3 control-label">{{ trans('trip.customer_id') }}</label>
    <div class="col-md-9">
        <select class="form-control" id="customer_id" name="customer_id" required="true" disabled>
                <option value="" style="display: none;" {{ old('customer_id', optional($trip)->customer_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('trip.customer_id__placeholder') }}</option>
            @foreach ($customer as $key => $value)
                <option value="{{ $key }}" {{ old('customer_id', optional($trip)->customer_id) == $key ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('customer_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('service_id') ? 'has-error' : '' }}">
            <label for="service_id" class="col-md-3 control-label">{{ trans('trip.service_id') }}</label>
            <div class="col-md-9">
                <select class="form-control" id="service_id" name="service_id" required="true" disabled>
                        <option value="" style="display: none;" {{ old('service_id', optional($trip)->service_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('trip.service_id__placeholder') }}</option>
                        @foreach ($services as $key => $value)
                            @if(in_array($key,array('1','2')))
                            <option value="{{ $key }}" {{ old('service_id', optional($trip)->service_id) == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                            @endif
                        @endforeach
                </select>
                {!! $errors->first('service_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('is_now_trip') ? 'has-error' : '' }}">
    <label for="is_now_trip" class="col-md-6 control-label">Request Type</label>
    <div class="col-md-9">
                <input id="payment_status" class="form-control" readonly name="is_now_trip" type="text" value=" {{ optional($trip)->is_now_trip ? 'Now' : 'Later' }}"
                    {{ old('payment_status', optional($trip)->is_now_trip) == '1' ? 'checked' : '' }}>
        {!! $errors->first('is_now_trip', '<p class="help-block">:message</p>') !!}
    </div>
</div>
        
    </div>
</div>
<div class="row">
<div class="col-md-6">
<div class="form-group {{ $errors->has('pickup_on') ? 'has-error' : '' }}">
    <label for="pickup_on" class="col-md-3 control-label">{{ trans('trip.pickup_on') }}</label>
    <div class="col-md-9">
        <input class="form-control date-picker" name="pickup_on" readonly type="text" id="pickup_on" value="{{ old('pickup_on', optional($trip)->pickup_on) }}" placeholder="{{ trans('trip.pickup_on__placeholder') }}" autocomplete="off">
        {!! $errors->first('pickup_on', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
<div class="col-md-6">
<div class="form-group {{ $errors->has('dropoff_on') ? 'has-error' : '' }}">
    <label for="dropoff_on" class="col-md-3 control-label">{{ trans('trip.dropoff_on') }}</label>
    <div class="col-md-9">
        <input class="form-control date-picker" name="dropoff_on" readonly type="text" id="dropoff_on" value="{{ old('dropoff_on', optional($trip)->dropoff_on) }}" placeholder="{{ trans('trip.dropoff_on__placeholder') }}" autocomplete="off">
        {!! $errors->first('dropoff_on', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
</div>
@php
$from_location = optional($trip)->trip_pickup_latitude ? optional($trip)->trip_pickup_latitude. ', ' .optional($trip)->trip_pickup_longitude : '';
@endphp
<div class="row">
    <div class="col-md-6">
<div class="form-group {{ $errors->has('from_address') ? 'has-error' : '' }}">
    <label for="from_address" class="col-md-6 control-label">{{ trans('trip.from_address') }}</label>
    <div class="col-md-9">
        <input class="form-control" name="from_address" readonly type="text" id="from_address" value="{{ old('from_address', optional($trip)->from_address) }}"  placeholder="{{ trans('trip.from_address__placeholder') }}">
		<input type="hidden" name="trip_pickup_latitude" class="trip_pickup_latitude" value="{{ (old('trip_pickup_latitude', optional($trip)->trip_pickup_latitude) == '' ?  '24.774265' : old('trip_pickup_latitude', optional($trip)->trip_pickup_latitude)) }}">
		<input type="hidden" name="trip_pickup_longitude" class="trip_pickup_longitude" value="{{ (old('trip_pickup_longitude', optional($trip)->trip_pickup_longitude) == '' ?  '46.738586' : old('trip_pickup_longitude', optional($trip)->trip_pickup_longitude)) }}">
        <input type="hidden" name="from_location" class="from_location" value="{{ $from_location }}">
        {!! $errors->first('from_address', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@php
$to_location = optional($trip)->trip_pickup_latitude ? optional($trip)->trip_drop_latitude. ', ' .optional($trip)->trip_drop_longitude : '';
@endphp

</div>
<div class="col-md-6">
<div class="form-group {{ $errors->has('to_address') ? 'has-error' : '' }}">
    <label for="to_address" class="col-md-6 control-label">{{ trans('trip.to_address') }}</label>
    <div class="col-md-9">
        <input class="form-control" name="to_address" readonly type="text" id="to_address" value="{{ old('to_address', optional($trip)->to_address) }}"  placeholder="{{ trans('trip.to_address__placeholder') }}">
		<input type="hidden" name="trip_drop_latitude" class="trip_drop_latitude" value="{{ (old('trip_drop_latitude', optional($trip)->trip_drop_latitude) == '' ?  '24.774265' : old('trip_drop_latitude', optional($trip)->trip_drop_latitude)) }}">
		<input type="hidden" name="trip_drop_longitude" class="trip_drop_longitude" value="{{ (old('trip_drop_longitude', optional($trip)->trip_drop_longitude) == '' ?  '46.738586' : old('trip_drop_longitude', optional($trip)->trip_drop_longitude)) }}">
        <input type="hidden" name="to_location" class="to_location" value="{{ $to_location }}">
        {!! $errors->first('to_address', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
</div>

<div class="row">
    <div class="col-md-6">
<div class="form-group {{ $errors->has('distance') ? 'has-error' : '' }}">
    <label for="distance" class="col-md-3 control-label">{{ trans('trip.distance') }}</label>
    <div class="col-md-9">
        <input class="form-control" name="distance" readonlytype="text" id="distance" value="{{ old('distance', optional($trip)->distance) }}" placeholder="{{ trans('trip.distance__placeholder') }}" readonly>
        {!! $errors->first('distance', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
<div class="col-md-6">
<div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
    <label for="amount" class="col-md-3 control-label">{{ trans('trip.amount') }}</label>
    <div class="col-md-9">
        <input class="form-control" name="amount" readonly type="text" id="amount" value="{{ old('amount', optional($trip)->amount) }}" placeholder="{{ trans('trip.amount__placeholder') }}">
        {!! $errors->first('amount', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
</div>
<div class="row">
    <div class="col-md-6">
<div class="form-group {{ $errors->has('km_charge') ? 'has-error' : '' }}">
    <label for="km_charge" class="col-md-3 control-label">{{ trans('trip.km_charge') }}</label>
    <div class="col-md-9">
        <input class="form-control" name="km_charge" readonly type="text" id="km_charge" value="{{ old('km_charge', optional($trip)->km_charge) }}" placeholder="{{ trans('trip.km_charge__placeholder') }}" autocomplete="off">
        {!! $errors->first('km_charge', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
<div class="col-md-6">
<div class="form-group {{ $errors->has('minimum_charge') ? 'has-error' : '' }}">
    <label for="minimum_charge" class="col-md-3 control-label">{{ trans('trip.minimum_charge') }}</label>
    <div class="col-md-9">
        <input class="form-control" name="minimum_charge" readonly type="text" id="minimum_charge" value="{{ old('minimum_charge', optional($trip)->minimum_charge) }}" placeholder="{{ trans('trip.minimum_charge__placeholder') }}">
        {!! $errors->first('minimum_charge', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
</div>

<div class="row">
<div class="col-md-6">
<div class="form-group {{ $errors->has('discount') ? 'has-error' : '' }}">
    <label for="discount" class="col-md-2 control-label">{{ trans('trip.discount') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="discount" type="text" id="discount" readonly value="{{ old('discount', optional($trip)->discount) }}" placeholder="{{ trans('trip.discount__placeholder') }}">
        {!! $errors->first('discount', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
<div class="col-md-6">
<div class="form-group {{ $errors->has('tax') ? 'has-error' : '' }}">
    <label for="tax" class="col-md-2 control-label">{{ trans('trip.tax') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="tax" type="text" id="tax" readonly value="{{ old('tax', optional($trip)->tax) }}"  placeholder="{{ trans('trip.tax__placeholder') }}">
        {!! $errors->first('tax', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-6">
<div class="form-group {{ $errors->has('final_amount') ? 'has-error' : '' }}">
    <label for="tax" class="col-md-6 control-label">{{ trans('trip.final_amount') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="final_amount" type="text" readonly id="final_amount" value="{{ old('tax', optional($trip)->final_amount) }}"  placeholder="{{ trans('trip.final_amount__placeholder') }}">
        {!! $errors->first('final_amount', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
<div class="col-md-6">
<div class="form-group {{ $errors->has('car_id') ? 'has-error' : '' }}">
    <label for="car_id" class="col-md-2 control-label">{{ trans('trip.car_id') }}</label>
    <div class="col-md-10">
        <select class="form-control" id="car_id" readonly name="car_id" required="true" disabled>
        	    <option value="" style="display: none;" {{ old('car_id', optional($trip)->car_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('trip.car_id__placeholder') }}</option>
        	@foreach ($car as $key => $ctype)
			    <option value="{{ $key }}" {{ old('car_rent_id', optional($trip)->car_id) == $key ? 'selected' : '' }}>
			    	{{ $ctype }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('car_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
</div>
<div class="row">

<div class="col-md-6">
<div class="form-group {{ $errors->has('payment_method') ? 'has-error' : '' }}">
    <label for="payment_method" class="col-md-3 control-label">{{ trans('trip.payment_method') }}</label>
    <div class="col-md-9">
       
        <select class="form-control" id="payment_method" name="payment_method" required="true" disabled>
                <option value="" style="display: none;" {{ old('payment_method', optional($trip)->payment_method ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('trip.payment_method__placeholder') }}</option>
                @foreach ($payment_method as $key => $value)
                    <option value="{{ $key }}" {{ old('payment_method', optional($trip)->payment_method) == $value ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
        </select>
        {!! $errors->first('payment_method', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
<div class="col-md-6">
<div class="form-group {{ $errors->has('payment_status') ? 'has-error' : '' }}">
    <label for="payment_status" class="col-md-6 control-label">{{ trans('trip.payment_status') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="payment_status">
                <input id="payment_status" class="" name="payment_status" type="checkbox" value="1" 
                    {{ old('payment_status', optional($trip)->payment_status) == '1' ? 'checked' : '' }}>
                {{ trans('trip.payment_status_paid') }}
            </label>
        </div>
        {!! $errors->first('payment_status', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-6">
<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
    <label for="driver_id" class="col-md-2 control-label">{{ trans('trip.status') }}</label>
    <div class="col-md-10">
         @php
            $status = array(
                "2" => "Pending",
                "3" => "No Driver Available",
                "4" => "Driver Accepted",
                "5" => "Driver Reached  pickup location",
                "6" => "Trip Started",
                "7" => "Reached Destination",
                "8" => "Completed Trip",
                "9" => "Money Collected",
                "10" => "Trip Cancelled by driver",
                "11" => "Trip Cancelled by Customer",
            );
        @endphp
        <select class="form-control" id="status" name="status" required="true">
                <option value="" style="display: none;" {{ old('driver_id', optional($trip)->status ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('trip.driver_id__placeholder') }}</option>
            @foreach ($status as $key => $s_value)
                <option value="{{ $key }}" {{ old('driver_id', optional($trip)->status) == $key ? 'selected' : '' }}>
                    {{ $s_value }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('driver_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
</div>

<trips :trip="{{ optional($trip)->id }}"></trips>

