
<div class="form-group {{ $errors->has('fuel_type') ? 'has-error' : '' }}">
    <label for="fuel_type" class="col-md-2 control-label">{{ trans('fuel_types.fuel_type') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="fuel_type" type="text" id="fuel_type" value="{{ old('fuel_type', optional($fuelType)->fuel_type) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('fuel_types.fuel_type__placeholder') }}">
        {!! $errors->first('fuel_type', '<p class="help-block">:message</p>') !!}
    </div>
</div>

