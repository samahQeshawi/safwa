
<div class="form-group {{ $errors->has('service') ? 'has-error' : '' }}">
    <label for="service" class="col-md-2 control-label">{{ trans('services.service') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="service" type="text" id="service" value="{{ old('service', optional($service)->service) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('services.service__placeholder') }}">
        {!! $errors->first('service', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('service_image') ? 'has-error' : '' }}">
    <label for="service_image" class="col-md-3 control-label">{{ trans('services.service_image') }}</label>
    <div class="col-md-9">
        @if(optional($service)->service_image)
            <img src="{{ url('storage/app/'.optional($service)->service_image) }}" width="100px"/>
        @endif
        <input class="form-control" name="service_image" type="file" id="service_image"  placeholder="{{ trans('services.service_image__placeholder') }}">
        {!! $errors->first('service_image', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">{{ trans('services.is_active') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($service)->is_active) == 'Yes' ? 'checked' : '' }}>
                {{ trans('services.is_active_1') }}
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

