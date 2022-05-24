<div class="row">
    <div class="col-lg-12 p-3 bg-primary">
        {{ trans('drivers.personal_info') }}
    </div>
</div>

{{-- <div class="row">
    <div class="col-md-6">
        <div class="form-group ">
            <label for="name" class="col-md-6 control-label">Lat<span
                    style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <input class="form-control" name="lat" type="text" id="lat"
                    value="" min="0" max="255">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group ">
            <label for="name" class="col-md-6 control-label">Lng<span
                    style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <input class="form-control" name="lng" type="text" id="lng"
                    value="" min="0" max="255">
            </div>
        </div>
    </div>
</div>
 --}}




<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name" class="col-md-6 control-label">{{ trans('drivers.first_name') }}<span
                    style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <input class="form-control" name="name" type="text" id="name"
                    value="{{ old('name', optional($driver)->name) }}" min="0" max="255"
                    placeholder="{{ trans('drivers.first_name__placeholder') }}" required>
                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('surname') ? 'has-error' : '' }}">
            <label for="surname" class="col-md-6 control-label">{{ trans('drivers.last_name') }} </label>
            <div class="col-md-10">
                <input class="form-control" name="surname" type="text" id="surname"
                    value="{{ old('surname', optional($driver)->surname) }}" min="0" max="255"
                    placeholder="{{ trans('drivers.last_name__placeholder') }}">
                {!! $errors->first('surname', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
            <label for="phone" class="col-md-2 control-label">{{ trans('drivers.phone') }} <span
                    style="color:#f00;">*</span></label>
            <div class="col-md-10 input-group">
                <div class="input-group-prepend">
                    <select class="form-control" name="country_code" id="country_code" requried>
                        <option value="" style="display: none;"
                            {{ old('country_code', optional($driver)->country_id ?: '') == '' ? 'selected' : '' }}
                            disabled selected>{{ trans('drivers.country_code__placeholder') }}</option>
                        @foreach ($country_code as $key => $phone_code)
                        <option value="{{ $key }}"
                            {{ ((old('country_code', optional($driver)->country_id) == '' && '+966' == $phone_code ) ?  'selected' : ( old('country_code', optional($driver)->country_id) == $key  ? 'selected' : '')) }}>
                            {{ $phone_code }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <input class="form-control" name="phone" type="text" id="phone"
                    value="{{ old('phone', optional($driver)->phone) }}" min="0" max="255"
                    placeholder="{{ trans('drivers.phone__placeholder') }}" required>
                {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="email" class="col-md-2 control-label">{{ trans('drivers.email') }} <span
                    style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <input class="form-control" name="email" type="text" id="email"
                    value="{{ old('email', optional($driver)->email) }}" min="0" max="255"
                    placeholder="{{ trans('drivers.email__placeholder') }}" required>
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('nationality_id') ? 'has-error' : '' }}">
            <label for="nationality_id" class="col-md-6 control-label">{{ trans('drivers.nationality_id') }} <span
                    style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <select class="form-control" id="nationality_id" name="nationality_id" required="true">
                    <option value="" style="display: none;"
                        {{ old('nationality_id', optional(optional($driver)->driver)->nationality_id ?: '') == '' ? 'selected' : '' }}
                        disabled selected>{{ trans('drivers.nationality__placeholder') }}</option>
                    @foreach ($nationalities as $key => $nationality)
                    <option value="{{ $key }}"
                        {{ ((old('nationality_id', optional(optional($driver)->driver)->nationality_id) == '' && '1' == $key ) ?  'selected' : ( old('nationality_id', optional(optional($driver)->driver)->nationality_id) == $key  ? 'selected' : '')) }}>
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
            <label for="city" class="col-md-2 control-label">{{ trans('drivers.city') }} <span
                    style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <select class="form-control" id="city" name="city" required="true">
                    <option value="" style="display: none;"
                        {{ old('city', optional($driver)->city_id ?: '') == '' ? 'selected' : '' }} disabled selected>
                        {{ trans('drivers.city__placeholder') }}</option>
                    @foreach ($cities as $key => $city)
                    <option value="{{ $key }}" {{ old('city', optional($driver)->city_id) == $key ? 'selected' : '' }}>
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
    <label for="national_id" class="col-md-4 control-label">{{ trans('drivers.national_id') }} /
        {{ trans('drivers.iqama_no') }} <span style="color:#f00;">*</span></label>
    <div class="col-md-10">
        <input class="form-control" name="national_id" type="text" id="national_id"
            value="{{ old('national_id', optional(optional($driver)->driver)->national_id) }}" maxlength="255"
            placeholder="{{ trans('drivers.national_id__placeholder') }} /  {{ trans('drivers.iqama_no__placeholder') }}"
            required>
        {!! $errors->first('national_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
            <label for="gender" class="col-md-2 control-label">{{ trans('drivers.gender') }}</label>
            <div class="col-md-10">
                <select class="form-control" id="gender" name="gender">
                    <option value="" style="display: none;"
                        {{ old('gender', optional($driver)->gender ?: '') == '' ? 'selected' : '' }} disabled selected>
                        {{ trans('drivers.gender__placeholder') }}</option>
                    @foreach (['Male' => trans('drivers.gender_male'),
                    'Female' => trans('drivers.gender_female'),
                    'Others' => trans('drivers.gender_others')] as $key => $text)
                    <option value="{{ $key }}" {{ old('gender', optional($driver)->gender) == $key ? 'selected' : '' }}>
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
            <label for="dob" class="col-md-6 control-label">{{ trans('drivers.dob') }}</label>
            <div class="col-md-10">
                <input class="form-control date-picker" name="dob" type="text" id="dob"
                    value="{{ old('dob', optional(optional($driver)->driver)->dob) }}"
                    placeholder="{{ trans('drivers.dob__placeholder') }}">
                {!! $errors->first('dob', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">

        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <label for="password" class="col-md-6 control-label">{{ trans('drivers.password') }}@if(!$driver)<span
                    style="color:#f00;"> *</span>@endif</label>
            <div class="col-md-10">
            <input class="form-control" name="password" type="password" id="password" value="{{ old('password') }}" minlength="1"
                    maxlength="255" placeholder="{{ trans('drivers.password__placeholder') }}" @if(!$driver) required
                    @endif>
                {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
            </div>
        </div>
        @if($driver)
        <div class="form-group {{ $errors->has('is_safwa_driver') ? 'has-error' : '' }}">
            <label for="is_safwa_driver" class="col-md-6 control-label">{{ trans('drivers.is_safwa_driver') }}</label>
            <div class="col-md-10">
                <div class="checkbox">
                    <label for="is_safwa_driver">
                        <input id="is_safwa_driver" class="" name="is_safwa_driver" type="checkbox" value="1"
                            {{ old('is_safwa_driver', optional(optional($driver)->driver)->is_safwa_driver) == '1' ? 'checked' : '' }}>
                        {{ trans('drivers.is_safwa_driver_yes') }}
                    </label>
                </div>
                {!! $errors->first('is_safwa_driver', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('profile_image') ? 'has-error' : '' }}">
            <label for="profile_image" class="col-md-3 control-label">{{ trans('drivers.profile_image') }}</label>
            <div class="col-md-9">
                @if(optional(optional($driver)->driver)->profile_image)
                <img src="{{ url('storage/app/'.optional(optional($driver)->driver)->profile_image) }}" width="100px" />
                @endif
                <input class="form-control" name="profile_image" type="file" id="profile_image"
                    placeholder="{{ trans('drivers.profile_image__placeholder') }}">
                {!! $errors->first('profile_image', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
@if(!$driver)
<div class="form-group {{ $errors->has('is_safwa_driver') ? 'has-error' : '' }}">
    <label for="is_safwa_driver" class="col-md-6 control-label">{{ trans('drivers.is_safwa_driver') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_safwa_driver">
                <input id="is_safwa_driver" class="" name="is_safwa_driver" type="checkbox" value="1"
                    {{ old('is_safwa_driver', optional(optional($driver)->driver)->is_safwa_driver) == '1' ? 'checked' : '' }}>
                {{ trans('drivers.is_safwa_driver_yes') }}
            </label>
        </div>
        {!! $errors->first('is_safwa_driver', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@endif
<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">{{ trans('drivers.is_active') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
                <input id="is_active_1" class="" name="is_active" type="checkbox" value="1"
                    {{ old('is_active', optional(optional($driver)->driver)->is_active) == 'Active' ? 'checked' : '' }}>
                {{ trans('drivers.is_active_1') }}
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="row">
    <div class="col-lg-12 p-3 bg-primary">
        {{ trans('drivers.attachments') }}
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('birth_certificate_file') ? 'has-error' : '' }}">
            <label for="birth_certificate_file" class="col-md-5 control-label">{{ trans('drivers.birth') }}</label>
            <div class="col-md-10">
                @if(optional(optional($driver)->driver)->birth_certificate_file)
                <img src="{{ url('storage/app/'.optional(optional($driver)->driver)->birth_certificate_file) }}"
                    width="100px" />
                @endif
                <input class="form-control" name="birth_certificate_file" type="file" id="birth_certificate_file"
                    placeholder="{{ trans('drivers.birth_file__placeholder') }}">
                {!! $errors->first('birth_certificate_file', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('passport_file') ? 'has-error' : '' }}">
            <label for="passport_file" class="col-md-3 control-label">{{ trans('drivers.passport_file') }}</label>
            <div class="col-md-10">
                @if(optional(optional($driver)->driver)->passport_file)
                <img src="{{ url('storage/app/'.optional(optional($driver)->driver)->passport_file) }}" width="100px" />
                @endif
                <input class="form-control" name="passport_file" type="file" id="passport_file"
                    placeholder="{{ trans('drivers.passport_file__placeholder') }}">
                {!! $errors->first('passport_file', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('license_file') ? 'has-error' : '' }}">
            <label for="license_file" class="col-md-4 control-label">{{ trans('drivers.license_file') }} <span
                    style="color:#f00;">*</span></label>
            <div class="col-md-10">
                @if(optional(optional($driver)->driver)->license_file)
                <img src="{{ url('storage/app/'.optional(optional($driver)->driver)->license_file) }}" width="100px" />
                @endif
                <input class="form-control" name="license_file" type="file" id="license_file"
                    placeholder="{{ trans('drivers.license_file__placeholder') }}"
                    @if(!optional(optional($driver)->driver)->license_file) required @endif>
                {!! $errors->first('license_file', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('national_file') ? 'has-error' : '' }}">
            <label for="national_file" class="col-md-8 control-label">{{ trans('drivers.national_file') }} /
                {{ trans('drivers.iqama_file') }} <span style="color:#f00;">*</span></label>
            <div class="col-md-10">
                @if(optional(optional($driver)->driver)->national_file)
                <img src="{{ url('storage/app/'.optional(optional($driver)->driver)->national_file) }}" width="100px" />
                @endif
                <input class="form-control" name="national_file" type="file" id="national_file"
                    placeholder="{{ trans('drivers.national_file__placeholder') }} / {{ trans('drivers.iqama_file__placeholder') }}"
                    @if(!optional(optional($driver)->driver)->national_file) required @endif>
                {!! $errors->first('national_file', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>

<hr>
{{-- Car --}}
<div class="row">
    <div class="col-lg-12 p-3 bg-primary">
        {{ trans('drivers.vehicle_info') }}
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('service_id') ? 'has-error' : '' }}">
            <label for="service_id" class="col-md-3 control-label">{{ trans('car.service_id') }} <span
                    style="color:#f00;">*</span></label>
            <div class="col-md-9">
                <select class="form-control" id="service_id" name="service_id" required>
                    <option value="" style="display: none;"
                        {{ old('service_id', optional($car)->service_id ?: '') == '' ? 'selected' : '' }} disabled
                        selected>{{ trans('car.service_id__placeholder') }}</option>
                    @foreach ($services as $key => $service)
                    <option value="{{ $key }}"
                        {{ old('service_id', optional($car)->service_id) == $key ? 'selected' : '' }}>
                        {{ $service }}
                    </option>
                    @endforeach
                </select>

                {!! $errors->first('service_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
            <label for="category_id" class="col-md-6 control-label">{{ trans('car.category_id') }} <span
                    style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="" style="display: none;"
                        {{ old('category_id', optional($car)->category_id ?: '') == '' ? 'selected' : '' }} disabled
                        selected>{{ trans('car.category_id__placeholder') }}</option>
                    @if(isset($categories))
                    @foreach ($categories as $key => $category)
                    <option value="{{ $key }}"
                        {{ old('category_id', optional($car)->category_id) == $key ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                    @endforeach
                    @endif
                </select>

                {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('car_name') ? 'has-error' : '' }}">
            <label for="car_name" class="col-md-26control-label">{{ trans('car.car_name') }} <span
                    style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <input class="form-control" name="car_name" type="text" id="car_name"
                    value="{{ old('car_name', optional($car)->car_name) }}" minlength="1" maxlength="300"
                    placeholder="{{ trans('car.car_name__placeholder') }}" required>
                {!! $errors->first('car_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
            <label for="description" class="col-md-2 control-label">{{ trans('car.description') }}</label>
            <div class="col-md-10">
                <textarea class="form-control" name="description" type="text" id="description" rows="6"
                    placeholder="{{ trans('car.description__placeholder') }}">{{ old('description', optional($car)->description) }}</textarea>
                {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('car_type_id') ? 'has-error' : '' }}">
            <label for="car_type_id" class="col-md-3 control-label">{{ trans('car.car_type_id') }} <span
                    style="color:#f00;">*</span></label>
            <div class="col-md-9">
                <select class="form-control" id="car_type_id" name="car_type_id" required>
                    <option value="" style="display: none;"
                        {{ old('car_type_id', optional($car)->car_type_id ?: '') == '' ? 'selected' : '' }} disabled
                        selected>{{ trans('car.car_type_id__placeholder') }}</option>
                    @foreach ($cartype as $key => $ctype)
                    <option value="{{ $key }}"
                        {{ old('car_type_id', optional($car)->car_type_id) == $key ? 'selected' : '' }}>
                        {{ $ctype }}
                    </option>
                    @endforeach
                </select>

                {!! $errors->first('car_type_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('car_make_id') ? 'has-error' : '' }}">
            <label for="car_make_id" class="col-md-3 control-label">{{ trans('car.car_make_id') }} <span
                    style="color:#f00;">*</span></label>
            <div class="col-md-9">
                <select class="form-control" id="car_make_id" name="car_make_id">
                    <option value="" style="display: none;"
                        {{ old('car_make_id', optional($car)->car_make_id ?: '') == '' ? 'selected' : '' }} disabled
                        selected>{{ trans('car.car_make_id__placeholder') }}</option>
                    @foreach ($carmake as $key => $cmake)
                    <option value="{{ $key }}"
                        {{ old('car_make_id', optional($car)->car_make_id) == $key ? 'selected' : '' }}>
                        {{ $cmake }}
                    </option>
                    @endforeach
                </select>

                {!! $errors->first('car_make_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('model_year') ? 'has-error' : '' }}">
            <label for="model_year" class="col-md-3 control-label">{{ trans('car.model_year') }} <span
                    style="color:#f00;">*</span></label>
            <div class="col-md-9">
                <select class="form-control" id="model_year" name="model_year" required>
                    <option value="" style="display: none;"
                        {{ old('model_year', optional($car)->model_year ?: '') == '' ? 'selected' : '' }} disabled
                        selected>{{ trans('car.model_year__placeholder') }}</option>
                    @php
                    $start_date = date('Y') - 6;
                    @endphp
                    @foreach (range(date('Y'), $start_date) as $x)
                    <option value="{{ $x }}" {{ old('model_year',optional($car)->model_year) == $x ? 'selected' : '' }}>
                        {{ $x }}
                    </option>
                    @endforeach
                </select>

                {!! $errors->first('model_year', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('fuel_type_id') ? 'has-error' : '' }}">
            <label for="fuel_type_id" class="col-md-3 control-label">{{ trans('car.fuel_type_id') }}</label>
            <div class="col-md-9">
                <select class="form-control" id="fuel_type_id" name="fuel_type_id">
                    <option value="" style="display: none;"
                        {{ old('fuel_type_id', optional($car)->fuel_type_id ?: '') == '' ? 'selected' : '' }} disabled
                        selected>{{ trans('car.fuel_type_id__placeholder') }}</option>
                    @foreach ($fueltype as $key => $ftype)
                    <option value="{{ $key }}"
                        {{ old('fuel_type_id', optional($car)->fuel_type_id) == $key ? 'selected' : '' }}>
                        {{ $ftype }}
                    </option>
                    @endforeach
                </select>

                {!! $errors->first('fuel_type_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('transmission') ? 'has-error' : '' }}">
            <label for="transmission" class="col-md-3 control-label">{{ trans('car.transmission') }} <span
                    style="color:#f00;">*</span></label>
            <div class="col-md-9">
                <select class="form-control" id="transmission" name="transmission" required>
                    <option value="" style="display: none;"
                        {{ old('transmission', optional($car)->transmission ?: '') == '' ? 'selected' : '' }} disabled
                        selected>{{ trans('car.transmission__placeholder') }}</option>
                    <option value="Manual"
                        {{ old('transmission', optional($car)->transmission) == 'Manual' ? 'selected' : '' }}>
                        {{ trans('car.manual') }}
                    </option>
                    <option value="Automatic"
                        {{ old('transmission', optional($car)->transmission) == 'Automatic' ? 'selected' : '' }}>
                        {{ trans('car.automatic') }}
                    </option>
                    <option value="Others"
                        {{ old('transmission', optional($car)->transmission) == 'Others' ? 'selected' : '' }}>
                        {{ trans('car.others') }}
                    </option>
                </select>

                {!! $errors->first('transmission', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('color') ? 'has-error' : '' }}">
            <label for="color" class="col-md-3 control-label">{{ trans('car.color') }}</label>
            <div class="col-md-9">
                <input class="form-control" name="color" type="text" id="color"
                    value="{{ old('color', optional($car)->color) }}" minlength="1" maxlength="300"
                    placeholder="{{ trans('car.color__placeholder') }}">
                {!! $errors->first('color', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('registration_no') ? 'has-error' : '' }}">
            <label for="registration_no" class="col-md-3 control-label">{{ trans('car.plate_no') }} <span
                    style="color:#f00;">*</span></label>
            <div class="col-md-9">
                <input class="form-control" name="registration_no" type="text" id="registration_no"
                    value="{{ old('registration_no', optional($car)->registration_no) }}" minlength="1" maxlength="20"
                    placeholder="{{ trans('car.registration_no__placeholder') }}" required>
                {!! $errors->first('registration_no', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('engine_no') ? 'has-error' : '' }}">
            <label for="engine_no" class="col-md-6 control-label">{{ trans('car.engine_no') }}</label>
            <div class="col-md-9">
                <input class="form-control" name="engine_no" type="text" id="engine_no"
                    value="{{ old('engine_no', optional($car)->engine_no) }}" minlength="1" maxlength="300"
                    placeholder="{{ trans('car.engine_no__placeholder') }}">
                {!! $errors->first('engine_no', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('registration_file') ? 'has-error' : '' }}">
            <label for="registration_file" class="col-md-4 control-label">{{ trans('car.registration_file') }}</label>
            <div class="col-md-10">
                @if(optional($car)->registration_file)
                <img src="{{ url('storage/app/'.optional($car)->registration_file) }}" width="100px" />
                @endif
                <input class="form-control" name="registration_file" type="file" id="registration_file"
                    placeholder="{{ trans('car.registration_file__placeholder') }}">
                {!! $errors->first('registration_file', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('insurance_file') ? 'has-error' : '' }}">
            <label for="insurance_file" class="col-md-3 control-label">{{ trans('car.insurance_file') }}</label>
            <div class="col-md-9">
                @if(optional($car)->insurance_file)
                <img src="{{ url('storage/app/'.optional($car)->insurance_file) }}" width="100px" />
                @endif
                <input class="form-control" name="insurance_file" type="file" id="insurance_file"
                    placeholder="{{ trans('car.insurance_file__placeholder') }}">
                {!! $errors->first('insurance_file', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group {{ $errors->has('photo_upload') ? 'has-error' : '' }}">
    <label for="photo_upload" class="col-md-3 control-label">{{ trans('car.photo_upload') }}</label>
    <div class="col-md-9">
        <div id="image-preview">
            @if($car_photo)
            @foreach($car_photo as $key => $photo)
            <div class="image-wrapper">
                <img src="{{ url('storage/app/'.$photo) }}" width="100px" />
                <div class="image-index-wrapper"><input type="radio" name="main_image" value="{{ $key }}" /></div>
            </div>
            @endforeach
            @endif
        </div>
        <input class="form-control" name="photo_upload[]" type="file" id="photo_upload" multiple
            placeholder="{{ trans('car.photo_upload__placeholder') }}">
        {!! $errors->first('photo_upload', '<p class="help-block">:message</p>') !!}
    </div>
</div>
