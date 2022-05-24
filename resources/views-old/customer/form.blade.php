<div class="row">
    <div class="col-lg-12 p-3 bg-primary">
        {{ trans('customer.personal_info') }}
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name" class="col-md-6 control-label">{{ trans('customer.name') }} <span
                    style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <input class="form-control" name="name" type="text" id="name"
                    value="{{ old('name', optional($customer)->name) }}" min="0" max="255"
                    placeholder="{{ trans('customer.name__placeholder') }}" required="true">
                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('surname') ? 'has-error' : '' }}">
            <label for="surname" class="col-md-6 control-label">{{ trans('customer.surname') }}</label>
            <div class="col-md-10">
                <input class="form-control" name="surname" type="text" id="surname"
                    value="{{ old('surname', optional($customer)->surname) }}" min="0" max="255"
                    placeholder="{{ trans('customer.surname__placeholder') }}">
                {!! $errors->first('surname', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
            <label for="country" class="col-md-2 control-label">{{ trans('customer.phone') }} <span
                    style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <select class="form-control" id="country" name="country" required="true">
                            <option value="" style="display: none;"
                                {{ old('country', optional($customer)->country_id ?: '') == '' ? 'selected' : '' }}
                                disabled selected>
                                {{ trans('customer.code__placeholder') }}</option>
                            @foreach ($country_code as $key => $code)
                            <option value="{{ $key }}"
                                {{ ((old('country', optional($customer)->country_id) == '' && '+966' == $code ) ?  'selected' : ( old('country', optional($customer)->country_id) == $key  ? 'selected' : '')) }}>
                                {{ $code }}
                            </option>
                            @endforeach
                        </select>

                        {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
                    </div>

                    <input class="form-control" name="phone" type="text" id="phone"
                        value="{{ old('phone', optional($customer)->phone) }}" min="0" max="255"
                        placeholder="{{ trans('customer.phone__placeholder') }}" required="true">
                    {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="email" class="col-md-2 control-label">{{ trans('customer.email') }} <span
                    style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <input class="form-control" name="email" type="text" id="email"
                    value="{{ old('email', optional($customer)->email) }}" min="0" max="255"
                    placeholder="{{ trans('customer.email__placeholder') }}" required>
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('nationality_id') ? 'has-error' : '' }}">
            <label for="nationality_id" class="col-md-10 control-label">{{ trans('customer.nationality_id') }}</label>
            <div class="col-md-10">
                <select class="form-control" id="nationality_id" name="nationality_id" required="true">
                    <option value="" style="display: none;"
                        {{ old('nationality_id', optional(optional($customer)->customer)->nationality_id ?: '') == '' ? 'selected' : '' }}
                        disabled selected>{{ trans('customer.nationality_id__placeholder') }}</option>
                    @foreach ($nationalities as $key => $nationality)
                    <option value="{{ $key }}"
                        {{ ((old('nationality_id', optional(optional($customer)->customer)->nationality_id) == '' && '1' == $key ) ?  'selected' : ( old('nationality_id', optional(optional($customer)->customer)->nationality_id) == $key  ? 'selected' : '')) }}>
                        {{ $nationality }}
                    </option>
                    @endforeach
                </select>

                {!! $errors->first('nationality_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
            <label for="city" class="col-md-10 control-label">{{ trans('customer.city') }} <span
                    style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <select class="form-control" id="city" name="city" required="true">
                    <option value="" style="display: none;"
                        {{ old('city', optional($customer)->city_id ?: '') == '' ? 'selected' : '' }} disabled selected>
                        {{ trans('customer.city__placeholder') }}</option>
                    @foreach ($cities as $key => $city)
                    <option value="{{ $key }}"
                        {{ old('city', optional($customer)->city_id) == $key ? 'selected' : '' }}>
                        {{ $city }}
                    </option>
                    @endforeach
                </select>

                {!! $errors->first('city_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group {{ $errors->has('national_id') ? 'has-error' : '' }}">
    <label for="national_id" class="col-md-6 control-label">{{ trans('customer.national_id') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="national_id" type="text" id="national_id"
            value="{{ old('national_id', optional(optional($customer)->customer)->national_id) }}" maxlength="255"
            placeholder="{{ trans('customer.national_id__placeholder') }}">
        {!! $errors->first('national_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="row">
    <div class="col-md-6">

        <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
            <label for="gender" class="col-md-2 control-label">{{ trans('customer.gender') }}</label>
            <div class="col-md-10">
                <select class="form-control" id="gender" name="gender">
                    <option value="" style="display: none;"
                        {{ old('gender', optional($customer)->gender ?: '') == '' ? 'selected' : '' }} disabled
                        selected>
                        {{ trans('customer.gender__placeholder') }}</option>
                    @foreach (['Male' => trans('customer.gender_male'),
                    'Female' => trans('customer.gender_female'),
                    'Others' => trans('customer.gender_others')] as $key => $text)
                    <option value="{{ $key }}"
                        {{ old('gender', optional($customer)->gender) == $key ? 'selected' : '' }}>
                        {{ $text }}
                    </option>
                    @endforeach
                </select>

                {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
            <label for="dob" class="col-md-4 control-label">{{ trans('customer.dob') }}</label>
            <div class="col-md-10">
                <input class="form-control date-picker" name="dob" type="text" id="dob"
                    value="{{ old('dob', optional(optional($customer)->customer)->dob) }}"
                    placeholder="{{ trans('customer.dob__placeholder') }}" autocomplete="off">
                {!! $errors->first('dob', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <label for="password" class="col-md-2 control-label">{{ trans('customer.password') }}</label>
            <div class="col-md-10">
                <input class="form-control" name="password" type="password" id="password"
                    value="" minlength="1" maxlength="255"
                     placeholder="{{ trans('customer.password__placeholder') }}" @if(!$customer) required
                     @endif>
                {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('profile_image') ? 'has-error' : '' }}">
            <label for="profile_image" class="col-md-3 control-label">{{ trans('customer.profile_image') }}</label>
            <div class="col-md-10">
                @if(optional($customer)->profile_image)
                <img src="{{ url('storage/app/'.optional($customer)->profile_image) }}" width="100px" />
                @endif
                <input class="form-control" name="profile_image" type="file" id="profile_image"
                    placeholder="{{ trans('customer.profile_image__placeholder') }}">
                {!! $errors->first('profile_image', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 p-3 bg-primary">
        {{ trans('customer.attachments') }}
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('national_file') ? 'has-error' : '' }}">
            <label for="national_file" class="col-md-3 control-label">{{ trans('customer.national_file') }}</label>
            <div class="col-md-10">
                @if(optional(optional($customer)->customer)->national_file)
                <img src="{{ url('storage/app/'.optional(optional($customer)->customer)->national_file) }}"
                    width="100px" />
                @endif
                <input class="form-control" name="national_file" type="file" id="national_file"
                    placeholder="{{ trans('customer.national_file__placeholder') }}">
                {!! $errors->first('national_file', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('license_file') ? 'has-error' : '' }}">
            <label for="license_file" class="col-md-3 control-label">{{ trans('customer.license_file') }}</label>
            <div class="col-md-10">
                @if(optional(optional($customer)->customer)->license_file)
                <img src="{{ url('storage/app/'.optional(optional($customer)->customer)->license_file) }}"
                    width="100px" />
                @endif
                <input class="form-control" name="license_file" type="file" id="license_file"
                    placeholder="{{ trans('customer.license_file__placeholder') }}">
                {!! $errors->first('license_file', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">{{ trans('customer.is_active') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
                <input id="is_active_1" class="" name="is_active" type="checkbox" value="1"
                    {{ old('is_active', optional($customer)->is_active) == 'Active' ? 'checked' : '' }}>
                {{ trans('customer.is_active_1') }}
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>
