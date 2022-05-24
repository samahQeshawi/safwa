
<div class="row">
<div class="col-lg-12 p-3 bg-primary">
    {{ trans('companies.general_info') }}
</div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name" class="col-md-2 control-label">{{ trans('companies.name') }} <span style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($company)->name) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('companies.name__placeholder') }}" required="true">
                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
            <label for="logo" class="col-md-3 control-label">{{ trans('companies.logo') }}</label>
            <div class="col-md-9">
                @if(optional($company)->profile_image)
                    <img src="{{ url('storage/app/'.optional($company)->profile_image) }}" width="100px"/>
                @endif
                <input class="form-control" name="logo" type="file" id="logo"  placeholder="{{ trans('companies.logo__placeholder') }}">
                {!! $errors->first('logo', '<p class="help-block">:message</p>') !!}
            </div>
        </div>        
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="email" class="col-md-2 control-label">{{ trans('companies.email') }} <span style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <input class="form-control" name="email" type="text" id="email" value="{{ old('email', optional($company)->email) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('companies.email__placeholder') }}" required="true">
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
            <label for="phone" class="col-md-2 control-label">{{ trans('companies.phone') }} <span style="color:#f00;">*</span></label>
            <div class="col-md-10 input-group">
                <div class="input-group-prepend">
                    <select class="form-control" name="country_code" id="country_code" requried="true">
                            <option value="" style="display: none;"
                            {{ old('nationality', optional($company)->country_id ?: '') == '' ? 'selected' : '' }}
                            disabled selected>{{ trans('companies.country_code__placeholder') }}</option>
                        @foreach ($country_code as $key => $phone_code)
                        <option value="{{ $key }}"
                            {{ ((old('country_code', optional($company)->country_id) == '' && '+966' == $phone_code ) ?  'selected' : ( old('country_code', optional($company)->country_id) == $key  ? 'selected' : '')) }}>
                            {{ $phone_code }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <input class="form-control" name="phone" type="text" id="phone" value="{{ old('phone', optional($company)->phone) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('companies.phone__placeholder') }}" required="true">
                {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
            </div>
        </div> 
    </div>    
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
            <label for="country" class="col-md-5 control-label">{{ trans('companies.country') }} <span style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <select class="form-control" id="country" name="country" required="true">
                        <option value="" style="display: none;" {{ old('country', optional($company)->country_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('companies.country__placeholder') }}</option>
                    @foreach ($countries as $key => $country)
                        <option value="{{ $key }}" {{ ((old('country',  optional($company)->country_id) == '' && '1' == $key ) ?  'selected' : ( old('country',  optional($company)->country_id) == $key  ? 'selected' : '')) }}>
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
            <label for="city" class="col-md-5 control-label">{{ trans('companies.city') }} <span style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <select class="form-control" id="city" name="city" required="true">
                        <option value="" style="display: none;" {{ old('city', optional($company)->city_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('companies.city__placeholder') }}</option>
                    @foreach ($cities as $key => $city)
                        <option value="{{ $key }}" {{ old('city', optional($company)->city_id) == $key ? 'selected' : '' }}>
                            {{ $city }}
                        </option>
                    @endforeach
                </select>

                {!! $errors->first('city_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div> 
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('cr_no') ? 'has-error' : '' }}">
            <label for="cr_no" class="col-md-5 control-label">{{ trans('companies.cr_no') }} <span style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <input class="form-control" name="cr_no" type="text" id="cr_no" value="{{ old('cr_no', optional(optional($company)->company)->cr_no) }}" maxlength="255" placeholder="{{ trans('companies.cr_no__placeholder') }}" required="true">
                {!! $errors->first('cr_no', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        @if(!$company)
        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <label for="password" class="col-md-2 control-label">{{ trans('companies.password') }} <span style="color:#f00;">*</span></label>
            <div class="col-md-11">
                <input class="form-control" name="password" type="password" id="password" value="{{ old('password', optional($company)->password) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('companies.password__placeholder') }}" required="true">
                {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
            </div>
        </div>
        @endif        
    </div>
</div>
<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">{{ trans('companies.is_active') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($company)->is_active) == 'Active' ? 'checked' : '' }}>
                {{ trans('companies.is_active_1') }}
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
            <label for="address" class="col-md-2 control-label">{{ trans('companies.address') }}</label>
            <div class="col-md-10">
                <textarea class="form-control" name="address" cols="10" rows="6" id="address" required="true" placeholder="{{ trans('companies.address__placeholder') }}">{{ old('address', optional($company)->address) }}</textarea>
                {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
            </div>
        </div>        
        <input class="form-control" name="latitude" type="hidden" id="latitude" value="{{ old('latitude', optional(optional($company)->company)->latitude) }}">
        <input class="form-control" name="longitude" type="hidden" id="longitude" value="{{ old('longitude', optional(optional($company)->company)->longitude) }}">       
    </div>
    <div class="col-md-6">
        <div id="map-canvas"></div>
    </div>    
</div>

<div class="row">
<div class="col-lg-12 p-3 bg-primary">
    {{ trans('companies.attachments') }}
</div>
</div>

        <div class="form-group {{ $errors->has('cr_doc') ? 'has-error' : '' }}">
            <label for="cr_doc" class="col-md-5 control-label">{{ trans('companies.cr_doc') }}</label>
            <div class="col-md-9">
                @if(optional(optional($company)->company)->cr_doc)
                    <img src="{{ url('storage/app/'.optional(optional($company)->company)->cr_doc) }}" width="100px"/>
                @endif
                <input class="form-control" name="cr_doc" type="file" id="cr_doc"  placeholder="{{ trans('cr_doc.cr_doc__placeholder') }}">
                {!! $errors->first('cr_doc', '<p class="help-block">:message</p>') !!}
            </div>
        </div>