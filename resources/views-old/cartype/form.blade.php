
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">{{ trans('cartype.cartype') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($cartype)->name) }}" minlength="1" placeholder="{{ trans('cartype.cartype__placeholder') }}">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('seats') ? 'has-error' : '' }}">
    <label for="seats" class="col-md-2 control-label">{{ trans('cartype.seats') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="seats" type="text" id="seats" value="{{ old('seats', optional($cartype)->seats) }}" minlength="1" placeholder="{{ trans('cartype.seats__placeholder') }}">
        {!! $errors->first('seats', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">{{ trans('cartype.is_active') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($cartype)->is_active) == 'Yes' ? 'checked' : '' }}>
                {{ trans('cartype.is_active_1') }}
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

