
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">{{ trans('countries.name') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($country)->name) }}" minlength="1" maxlength="255" placeholder="{{ trans('countries.name__placeholder') }}">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<!--<div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
    <label for="code" class="col-md-2 control-label">{{ trans('countries.code') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="code" type="text" id="code" value="{{ old('code', optional($country)->code) }}" minlength="1" placeholder="{{ trans('countries.code__placeholder') }}">
        {!! $errors->first('code', '<p class="help-block">:message</p>') !!}
    </div>
</div>
-->
<div class="form-group {{ $errors->has('phone_code') ? 'has-error' : '' }}">
    <label for="phone_code" class="col-md-2 control-label">{{ trans('countries.phone_code') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="phone_code" type="text" id="phone_code" value="{{ old('phone_code', optional($country)->phone_code) }}" minlength="1" placeholder="{{ trans('countries.phone_code__placeholder') }}">
        {!! $errors->first('phone_code', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<!--<div class="form-group {{ $errors->has('nationality') ? 'has-error' : '' }}">
    <label for="nationality" class="col-md-2 control-label">{{ trans('countries.nationality') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="nationality" type="text" id="nationality" value="{{ old('nationality', optional($country)->nationality) }}" minlength="1" placeholder="{{ trans('countries.phone_code__placeholder') }}">
        {!! $errors->first('nationality', '<p class="help-block">:message</p>') !!}
    </div>
</div>-->
<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">{{ trans('countries.is_active') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($country)->is_active) == 'Yes' ? 'checked' : '' }}>
                {{ trans('countries.is_active_1') }}
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

