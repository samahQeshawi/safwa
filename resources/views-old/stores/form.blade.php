
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">{{ trans('stores.name') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($store)->name) }}" minlength="1" maxlength="255" placeholder="{{ trans('stores.name__placeholder') }}">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
    <label for="phone" class="col-md-2 control-label">{{ trans('stores.phone') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="phone" type="text" id="phone" value="{{ old('phone', optional($store)->phone) }}" minlength="1" placeholder="{{ trans('stores.phone__placeholder') }}">
        {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
    <label for="address" class="col-md-2 control-label">{{ trans('stores.address') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="address" type="text" id="address" value="{{ old('address', optional($store)->address) }}" minlength="1" placeholder="{{ trans('stores.address__placeholder') }}">
        {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('company_id') ? 'has-error' : '' }}">
    <label for="company_id" class="col-md-2 control-label">{{ trans('stores.company_id') }}</label>
    <div class="col-md-10">
        <select class="form-control" id="company_id" name="company_id">
        	    <option value="" style="display: none;" {{ old('company_id', optional($store)->company_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('stores.company_id__placeholder') }}</option>
        	@foreach ($companies as $key => $company)
			    <option value="{{ $key }}" {{ old('company_id', optional($store)->company_id) == $key ? 'selected' : '' }}>
			    	{{ $company }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('company_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">{{ trans('stores.is_active') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($store)->is_active) == 'Active' ? 'checked' : '' }}>
                {{ trans('stores.is_active_1') }}
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

