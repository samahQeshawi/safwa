@if(isset($booking))
<div class="form-group {{ $errors->has('booking_no') ? 'has-error' : '' }}">
    <label for="booking_no" class="col-md-3 control-label">{{ trans('booking.booking_no') }}</label>
    <div class="col-md-9">
        <input class="form-control" name="booking_no" type="text" id="booking_no" value="{{ old('booking_no', optional($booking)->booking_no) }}" min="0" max="255" placeholder="{{ trans('booking.booking_no__placeholder') }}" readonly>
        {!! $errors->first('booking_no', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@endif
<div class="row">
<div class="col-md-6">
<div class="form-group {{ $errors->has('customer_id') ? 'has-error' : '' }}">
    <label for="customer_id" class="col-md-3 control-label">{{ trans('booking.customer_id') }}</label>
    <div class="col-md-9">
        <select class="form-control" id="customer_id" name="customer_id" required="true">
        	    <option value="" style="display: none;" {{ old('customer_id', optional($booking)->customer_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('booking.customer_id__placeholder') }}</option>
        	@foreach ($customer as $key => $value)
			    <option value="{{ $key }}" {{ old('customer_id', optional($booking)->customer_id) == $key ? 'selected' : '' }}>
			    	{{ $value }}
			    </option>
			@endforeach
        </select>
        {!! $errors->first('customer_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('start_destination') ? 'has-error' : '' }}">
    <label for="start_destination" class="col-md-6 control-label">{{ trans('booking.start_destination') }}</label>
    <div class="col-md-9">
        <input class="form-control" name="start_destination" type="text" id="start_destination" value="{{ old('start_destination', optional($booking)->start_destination) }}" min="0" max="255" placeholder="{{ trans('booking.start_destination__placeholder') }}">
		<input type="hidden" name="start_latitude" class="start_latitude" value="{{ (old('start_latitude', optional($booking)->start_latitude) == '' ?  '12.9716' : old('start_latitude', optional($booking)->start_latitude)) }}">
		<input type="hidden" name="start_longitude" class="start_longitude" value="{{ (old('start_longitude', optional($booking)->start_longitude) == '' ?  '77.5946' : old('start_longitude', optional($booking)->start_longitude)) }}">
        {!! $errors->first('start_destination', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('end_destination') ? 'has-error' : '' }}">
    <label for="end_destination" class="col-md-6 control-label">{{ trans('booking.end_destination') }}</label>
    <div class="col-md-9">
        <input class="form-control" name="end_destination" type="text" id="end_destination" value="{{ old('end_destination', optional($booking)->end_destination) }}" min="0" max="255" placeholder="{{ trans('booking.end_destination__placeholder') }}">
		<input type="hidden" name="end_latitude" class="end_latitude" value="{{ (old('end_latitude', optional($booking)->end_latitude) == '' ?  '12.9716' : old('end_latitude', optional($booking)->end_latitude)) }}">
		<input type="hidden" name="end_longitude" class="end_longitude" value="{{ (old('end_longitude', optional($booking)->end_longitude) == '' ?  '77.5946' : old('end_longitude', optional($booking)->end_longitude)) }}">
        {!! $errors->first('end_destination', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('distance') ? 'has-error' : '' }}">
    <label for="distance" class="col-md-3 control-label">{{ trans('booking.distance') }}</label>
    <div class="col-md-9">
        <input class="form-control" name="distance" type="text" id="distance" value="{{ old('distance', optional($booking)->distance) }}" min="0" max="255" placeholder="{{ trans('booking.distance__placeholder') }}" readonly>
        {!! $errors->first('distance', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
    <label for="amount" class="col-md-3 control-label">{{ trans('booking.amount') }}</label>
    <div class="col-md-9">
        <input class="form-control" name="amount" type="text" id="amount" value="{{ old('amount', optional($booking)->amount) }}" min="0" max="255" placeholder="{{ trans('booking.amount__placeholder') }}">
        {!! $errors->first('amount', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
<div class="col-md-6">
	<div id="map-canvas"></div>
</div>
</div>
<div class="row">
<div class="col-md-6">
<div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
    <label for="start_date" class="col-md-4 control-label">{{ trans('booking.start_date') }}</label>
    <div class="col-md-10">
        <input class="form-control date-picker" name="start_date" type="text" id="start_date" value="{{ old('start_date', optional($booking)->start_date) }}" min="0" max="255" placeholder="{{ trans('booking.start_date__placeholder') }}" autocomplete="off">
        {!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
<div class="col-md-6">
<div class="form-group {{ $errors->has('start_time') ? 'has-error' : '' }}">
    <label for="start_time" class="col-md-4 control-label">{{ trans('booking.start_time') }}</label>
    <div class="col-md-10">
        <input class="form-control time-picker" name="start_time" type="text" id="start_time" value="{{ old('start_time', optional($booking)->start_time) }}" min="0" max="255" placeholder="{{ trans('booking.start_time__placeholder') }}" autocomplete="off">
        {!! $errors->first('start_time', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-6">
<div class="form-group {{ $errors->has('landmark') ? 'has-error' : '' }}">
    <label for="landmark" class="col-md-4 control-label">{{ trans('booking.landmark') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="landmark" type="text" id="landmark" value="{{ old('landmark', optional($booking)->landmark) }}" min="0" max="255" placeholder="{{ trans('booking.landmark__placeholder') }}">
        {!! $errors->first('landmark', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
<div class="col-md-6">
<div class="form-group {{ $errors->has('start_address') ? 'has-error' : '' }}">
    <label for="start_address" class="col-md-6 control-label">{{ trans('booking.start_address') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="start_address" type="text" id="start_address" value="{{ old('start_address', optional($booking)->start_address) }}" min="0" max="255" placeholder="{{ trans('booking.start_address__placeholder') }}">
        {!! $errors->first('start_address', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-6">
<div class="form-group {{ $errors->has('car_type_id') ? 'has-error' : '' }}">
    <label for="car_type_id" class="col-md-2 control-label">{{ trans('booking.car_type_id') }}</label>
    <div class="col-md-10">
        <select class="form-control" id="car_type_id" name="car_type_id" required="true">
        	    <option value="" style="display: none;" {{ old('car_type_id', optional($booking)->car_type_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('booking.car_type_id__placeholder') }}</option>
        	@foreach ($cartype as $key => $ctype)
			    <option value="{{ $key }}" {{ old('car_type_id', optional($booking)->car_type_id) == $key ? 'selected' : '' }}>
			    	{{ $ctype }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('car_type_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
<div class="col-md-6">
<div class="form-group {{ $errors->has('driver_id') ? 'has-error' : '' }}">
    <label for="driver_id" class="col-md-2 control-label">{{ trans('booking.driver_id') }}</label>
    <div class="col-md-10">
        <select class="form-control" id="driver_id" name="driver_id" required="true">
        	    <option value="" style="display: none;" {{ old('driver_id', optional($booking)->driver_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('booking.driver_id__placeholder') }}</option>
        	@foreach ($driver as $key => $driver_value)
			    <option value="{{ $key }}" {{ old('driver_id', optional($booking)->driver_id) == $key ? 'selected' : '' }}>
			    	{{ $driver_value }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('driver_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
</div>

<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
    <label for="status" class="col-md-2 control-label">{{ trans('booking.status') }}</label>
    <div class="col-md-10">
        <select class="form-control" id="status" name="status" required="true">
                <option value="" style="display: none;" {{ old('status', optional($booking)->status ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('booking.status__placeholder') }}</option>
            <?php $status_list = array('inprogress' => 'Inprogress','completed' => 'Completed','started' => 'Started','cancelled' => 'Cancelled'); ?>
            @foreach ($status_list as $key => $status_value)
                <option value="{{ $key }}" {{ old('status', optional($booking)->status) == $key ? 'selected' : '' }}>
                    {{ $status_value }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

