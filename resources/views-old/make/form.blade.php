
<div class="form-group {{ $errors->has('car_make') ? 'has-error' : '' }}">
    <label for="car_make" class="col-md-2 control-label">{{ trans('make.car_make') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="car_make" type="text" id="car_make" value="{{ old('car_make', optional($make)->car_make) }}" minlength="1" placeholder="{{ trans('make.car_make__placeholder') }}">
        {!! $errors->first('car_make', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">{{ trans('make.is_active') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($make)->is_active) == 'Yes' ? 'checked' : '' }}>
                {{ trans('make.is_active_1') }}
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

