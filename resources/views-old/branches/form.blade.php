<div class="row">
<div class="col-lg-12 p-3 bg-primary">
    {{ trans('branch.general_info') }}
</div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('branch_code') ? 'has-error' : '' }}">
            <label for="branch_code" class="col-md-6 control-label">{{ trans('branch.branch_code') }} <span style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <input class="form-control" name="branch_code" type="text" id="branch_code"
                    value="{{ old('branch_code', optional($branch)->branch_code) }}" min="0" max="255"
                    placeholder="{{ trans('branch.branch_code__placeholder') }}" required="true">
                {!! $errors->first('branch_code', '<p class="help-block">:message</p>') !!}
            </div>
        </div>        
    </div>
    <div class="col-md-6">    
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name" class="col-md-6 control-label">{{ trans('branch.name') }} <span style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($branch)->name) }}"
                    min="0" max="255" placeholder="{{ trans('branch.name__placeholder') }}" required="true">
                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="email" class="col-md-6 control-label">{{ trans('branch.email') }}<span style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <input class="form-control" name="email" type="text" id="email"
                    value="{{ old('email', optional($branch)->email) }}" min="0" max="255"
                    placeholder="{{ trans('branch.email__placeholder') }}" required="true">
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6"> 
        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
            <label for="phone" class="col-md-6 control-label">{{ trans('branch.phone') }}<span style="color:#f00;">*</span></label>
            <div class="col-md-10 input-group">
                <div class="input-group-prepend">
                    <select class="form-control" name="country_code" id="country_code"  required="true">
                            <option value="" style="display: none;"
                            {{ old('nationality', optional($branch)->country_id ?: '') == '' ? 'selected' : '' }}
                            disabled selected>{{ trans('branch.country_code__placeholder') }}</option>
                        @foreach ($country_code as $key => $phone_code)
                        <option value="{{ $key }}"
                            {{ ((old('country_code', optional($branch)->country_id) == '' && '+966' == $phone_code ) ?  'selected' : ( old('country_code', optional($branch)->country_id) == $key  ? 'selected' : '')) }}>
                            {{ $phone_code }}
                        </option>
                        @endforeach
                    </select>
                </div> 
                <input class="form-control" name="phone" type="text" id="phone"
                    value="{{ old('phone', optional($branch)->phone) }}" min="0" max="255"
                    placeholder="{{ trans('branch.phone__placeholder') }}" required="true">
                {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
            <label for="country" class="col-md-6 control-label">{{ trans('branch.country') }}<span style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <select class="form-control" id="country" name="country" required="true">
                    <option value="" style="display: none;"
                        {{ old('country', optional($branch)->country_id ?: '') == '' ? 'selected' : '' }} disabled selected>
                        {{ trans('branch.country__placeholder') }}</option>
                    @foreach ($countries as $key => $country)
                    <option value="{{ $key }}" {{ ((old('country',  optional($branch)->country_id) == '' && '1' == $key ) ?  'selected' : ( old('country',  optional($branch)->country_id) == $key  ? 'selected' : '')) }}>
                        {{ $country }}
                    </option>
                    @endforeach
                </select>

                {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
     <div class="col-md-6">
                <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
            <label for="city" class="col-md-2 control-label">{{ trans('branch.city') }}<span style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <select class="form-control" id="city" name="city" required="true">
                    <option value="" style="display: none;"
                        {{ old('city', optional($branch)->city_id ?: '') == '' ? 'selected' : '' }} disabled selected>
                        {{ trans('branch.city__placeholder') }}</option>
                    @foreach ($cities as $key => $city)
                    <option value="{{ $key }}" {{ old('city', optional($branch)->city_id) == $key ? 'selected' : '' }}>
                        {{ $city }}
                    </option>
                    @endforeach
                </select>

                {!! $errors->first('city_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>


<div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
    <label for="address" class="control-label">{{ trans('branch.address') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="address" type="text" id="address"
            value="{{ old('address', optional($branch)->address) }}" min="0" max="255"
            placeholder="{{ trans('branch.address__placeholder') }}">
        {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@php
$location = optional($branch)->latitude ? optional($branch)->latitude. ', ' .optional($branch)->longitude : '';
@endphp

<div class="form-group {{ $errors->has('location') ? 'has-error' : '' }}">
    <label for="location" class="col-md-2 control-label">{{ trans('branch.location') }}</label>
    <div class="col-md-10">
        <input readonly class="form-control" name="location" type="text" id="location" 
         value="{{ old('location', $location) }}"
            placeholder="{{ trans('branch.location__placeholder') }}" required="true">
        {!! $errors->first('location', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div id="map_location"></div>

<input  name="latitude" type="hidden" id="latitude"
            value="{{ old('latitude', optional($branch)->latitude) }}">
<input name="longitude" type="hidden" id="longitude"
            value="{{ old('longitude', optional($branch)->longitude) }}">

<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-3 control-label">{{ trans('branch.is_active') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
                <input id="is_active_1" class="" name="is_active" type="checkbox" value="1"
                    {{ old('is_active', optional($branch)->is_active) == 'Active' ? 'checked' : '' }}>
                {{ trans('branch.is_active_1') }}
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

</div>
