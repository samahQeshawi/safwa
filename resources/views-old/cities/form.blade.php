
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">{{ trans('cities.name') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($city)->name) }}" minlength="1" maxlength="255" placeholder="{{ trans('cities.name__placeholder') }}">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
    <label for="country_id" class="col-md-2 control-label">{{ trans('cities.country_id') }}</label>
    <div class="col-md-10">
        <select class="form-control" id="country_id" name="country_id">
        	    <option value="" style="display: none;" {{ old('country_id', optional($city)->country_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('cities.country_id__placeholder') }}</option>
        	@foreach ($countries as $key => $country)
			    <option value="{{ $key }}" {{ old('country_id', optional($city)->country_id) == $key ? 'selected' : '' }}>
			    	{{ $country }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">{{ trans('cities.is_active') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($city)->is_active) == 'Yes' ? 'checked' : '' }}>
                {{ trans('cities.is_active_1') }}
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

