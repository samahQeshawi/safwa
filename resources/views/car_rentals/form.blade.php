@if(isset($car_rental))
<div class="form-group {{ $errors->has('booking_no') ? 'has-error' : '' }}">
    <label for="booking_no" class="col-md-3 control-label">{{ trans('car_rental.booking_no') }}</label>
    <div class="col-md-9">
        <input class="form-control" name="booking_no" type="text" id="booking_no" value="{{ old('booking_no', optional($car_rental)->booking_no) }}" min="0" max="255" placeholder="{{ trans('car_rental.booking_no__placeholder') }}" readonly>
        {!! $errors->first('booking_no', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@endif

<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    <label for="user_id" class="col-md-3 control-label">{{ trans('car_rental.user_id') }}</label>
    <div class="col-md-9">
        <select class="form-control" id="user_id" name="user_id" required="true">
        	    <option value="" style="display: none;" {{ old('user_id', optional($car_rental)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('car_rental.user_id__placeholder') }}</option>
        	@foreach ($users as $key => $value)
			    <option value="{{ $key }}" {{ old('user_id', optional($car_rental)->user_id) == $key ? 'selected' : '' }}>
			    	{{ $value }}
			    </option>
			@endforeach
        </select>
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('car_id') ? 'has-error' : '' }}">
    <label for="car_id" class="col-md-3 control-label">{{ trans('car_rental.car_id') }}</label>
    <div class="col-md-9">
        <select class="form-control" id="car_id" name="car_id" required="true">
                <option value="" style="display: none;" {{ old('car_id', optional($car_rental)->car_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('car_rental.car_id__placeholder') }}</option>
            @foreach ($cars as $key => $value)
                <option value="{{ $key }}" {{ old('car_id', optional($car_rental)->car_id) == $key ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('pickup_on') ? 'has-error' : '' }}">
    <label for="pickup_on" class="col-md-3 control-label">{{ trans('car_rental.pickup_on') }}</label>
    <div class="col-md-9">
        <input required class="form-control" name="pickup_on" type="text" id="pickup_on" value="{{ old('pickup_on', optional($car_rental)->pickup_on) }}" min="0" max="255" placeholder="{{ trans('car_rental.pickup_on__placeholder') }}">
        {!! $errors->first('pickup_on', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('dropoff_on') ? 'has-error' : '' }}">
    <label for="dropoff_on" class="col-md-3 control-label">{{ trans('car_rental.dropoff_on') }}</label>
    <div class="col-md-9">
        <input required class="form-control" name="dropoff_on" type="text" id="dropoff_on" value="{{ old('dropoff_on', optional($car_rental)->dropoff_on) }}" min="0" max="255" placeholder="{{ trans('car_rental.dropoff_on__placeholder') }}">
        {!! $errors->first('dropoff_on', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
    <label for="amount" class="col-md-3 control-label">{{ trans('car_rental.amount') }}</label>
    <div class="col-md-9">
        <input readonly class="form-control" name="amount" type="text" id="amount" value="{{ old('amount', optional($car_rental)->amount) }}" min="0" max="255" placeholder="{{ trans('car_rental.amount__placeholder') }}">
        {!! $errors->first('amount', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('duration_in_days') ? 'has-error' : '' }}">
    <label for="duration_in_days" class="col-md-3 control-label">{{ trans('car_rental.duration_in_days') }}</label>
    <div class="col-md-9">
        <input readonly class="form-control" name="duration_in_days" type="text" id="duration_in_days" value="{{ old('duration_in_days', optional($car_rental)->duration_in_days) }}" min="0" max="255" placeholder="{{ trans('car_rental.duration_in_days__placeholder') }}">
        {!! $errors->first('duration_in_days', '<p class="help-block">:message</p>') !!}
    </div>
</div>

