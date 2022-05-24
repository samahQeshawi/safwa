<div class="row">
<div class="col-lg-12 p-3 bg-primary">
    {{ trans('car.personal_info') }}
</div>
</div>
<input type="hidden" name="service_id" id="service_id" value="{{$service_id}}" />
{{-- <div class="form-group {{ $errors->has('service_id') ? 'has-error' : '' }}">
    <label for="service_id" class="col-md-2 control-label">{{ trans('car.service_id') }}</label>
    <div class="col-md-10">
        <select class="form-control" id="service_id" name="service_id">
                <option value="" style="display: none;" {{ old('service_id', optional($car)->service_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('car.service_id__placeholder') }}</option>
            @foreach ($services as $key => $ctype)
                <option value="{{ $key }}" {{ old('service_id', optional($car)->service_id) == $key ? 'selected' : '' }}>
                    {{ $ctype }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('service_id', '<p class="help-block">:message</p>') !!}
    </div>
</div> --}}
<div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
    <label for="category_id" class="col-md-6 control-label">{{ trans('car.category_id') }} <span style="color:#f00;">*</span></label>
    <div class="col-md-10">
        <select class="form-control" id="category_id" name="category_id" required>
                <option value="" style="display: none;" {{ old('category_id', optional($car)->category_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('car.category_id__placeholder') }}</option>
                @if(isset($categories))
                @foreach ($categories as $key => $category)
                <option value="{{ $key }}" {{ old('service_id', optional($car)->category_id) == $key ? 'selected' : '' }}>
                    {{ $category }}
                </option>
                @endforeach
                @endif
        </select>

        {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@if($service_id == 3)
<div class="form-group {{ $errors->has('branch_id') ? 'has-error' : '' }}">
    <label for="branch_id" class="col-md-6 control-label">{{ trans('car.branch_id') }} <span style="color:#f00;">*</span></label>
    <div class="col-md-10">
        <select class="form-control" id="branch_id" name="branch_id" required>
                <option value="" style="display: none;" {{ old('branch_id', optional($car)->branch_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('car.branch_id__placeholder') }}</option>
        </select>

        {!! $errors->first('branch_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@endif
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('car_name') ? 'has-error' : '' }}">
            <label for="car_name" class="col-md-6 control-label">{{ trans('car.car_name') }} <span style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <input class="form-control" name="car_name" type="text" id="car_name" value="{{ old('car_name', optional($car)->car_name) }}" minlength="1" maxlength="300" placeholder="{{ trans('car.car_name__placeholder') }}" required>
                {!! $errors->first('car_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('registration_no') ? 'has-error' : '' }}">
            <label for="registration_no" class="col-md-3 control-label">{{ trans('car.plate_no') }} <span style="color:#f00;">*</span></label>
            <div class="col-md-9">
                <input class="form-control" name="registration_no" type="text" id="registration_no" value="{{ old('registration_no', optional($car)->registration_no) }}" minlength="1" maxlength="20" placeholder="{{ trans('car.plate_no__placeholder') }}" required>
                {!! $errors->first('registration_no', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('car_make_id') ? 'has-error' : '' }}">
            <label for="car_make_id" class="col-md-3 control-label">{{ trans('car.car_make_id') }}<span style="color:#f00;">*</span></label>
            <div class="col-md-9">
                <select class="form-control" id="car_make_id" name="car_make_id" required>
                        <option value="" style="display: none;" {{ old('car_make_id', optional($car)->car_make_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('car.car_make_id__placeholder') }}</option>
                    @foreach ($carmake as $key => $cmake)
                        <option value="{{ $key }}" {{ old('car_make_id', optional($car)->car_make_id) == $key ? 'selected' : '' }}>
                            {{ $cmake }}
                        </option>
                    @endforeach
                </select>

                {!! $errors->first('car_make_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('car_type_id') ? 'has-error' : '' }}">
            <label for="car_type_id" class="col-md-3 control-label">{{ trans('car.car_type_id') }}</label>
            <div class="col-md-9">
                <select class="form-control" id="car_type_id" name="car_type_id">
                        <option value="" style="display: none;" {{ old('car_type_id', optional($car)->car_type_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('car.car_type_id__placeholder') }}</option>
                    @foreach ($cartype as $key => $ctype)
                        <option value="{{ $key }}" {{ old('car_type_id', optional($car)->car_type_id) == $key ? 'selected' : '' }}>
                            {{ $ctype }}
                        </option>
                    @endforeach
                </select>

                {!! $errors->first('car_type_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('model_year') ? 'has-error' : '' }}">
            <label for="model_year" class="col-md-3 control-label">{{ trans('car.model_year') }} <span style="color:#f00;">*</span></label>
            <div class="col-md-9">
                <select class="form-control" id="model_year" name="model_year" required>
                        <option value="" style="display: none;" {{ old('model_year', optional($car)->model_year ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('car.model_year__placeholder') }}</option>
                        @php
                        $start_date = date('Y') - 6;
                        @endphp
                    @foreach (range(date('Y'), $start_date) as $x)
                        <option value="{{ $x }}" {{ old('model_year', optional($car)->model_year) == $x ? 'selected' : '' }}>
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
                        <option value="" style="display: none;" {{ old('fuel_type_id', optional($car)->fuel_type_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('car.fuel_type_id__placeholder') }}</option>
                        @foreach ($fueltype as $key => $ftype)
                            <option value="{{ $key }}" {{ old('fuel_type_id', optional($car)->fuel_type_id) == $key ? 'selected' : '' }}>
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
            <label for="transmission" class="col-md-3 control-label">{{ trans('car.transmission') }} <span style="color:#f00;">*</span></label>
            <div class="col-md-9">
                <select class="form-control" id="transmission" name="transmission" required>
                        <option value="" style="display: none;" {{ old('transmission', optional($car)->transmission ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('car.transmission__placeholder') }}</option>
                        <option value="Manual" {{ old('transmission', optional($car)->transmission) == 'Manual' ? 'selected' : '' }}>
                            {{ trans('car.manual') }}
                        </option>
                        <option value="Automatic" {{ old('transmission', optional($car)->transmission) == 'Automatic' ? 'selected' : '' }}>
                            {{ trans('car.automatic') }}
                        </option>
                        <option value="Others" {{ old('transmission', optional($car)->transmission) == 'Others' ? 'selected' : '' }}>
                            {{ trans('car.others') }}
                        </option>
                </select>

                {!! $errors->first('transmission', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('engine_no') ? 'has-error' : '' }}">
            <label for="engine_no" class="col-md-3 control-label">{{ trans('car.engine_no') }}</label>
            <div class="col-md-9">
                <input class="form-control" name="engine_no" type="text" id="engine_no" value="{{ old('engine_no', optional($car)->engine_no) }}" minlength="1" maxlength="300" placeholder="{{ trans('car.engine_no__placeholder') }}">
                {!! $errors->first('engine_no', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('color') ? 'has-error' : '' }}">
            <label for="color" class="col-md-3 control-label">{{ trans('car.color') }}</label>
            <div class="col-md-9">
                <input class="form-control" name="color" type="text" id="color" value="{{ old('color', optional($car)->color) }}" minlength="1" maxlength="300" placeholder="{{ trans('car.color__placeholder') }}">
                {!! $errors->first('color', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('seats') ? 'has-error' : '' }}">
            <label for="seats" class="col-md-3 control-label">{{ trans('car.seats') }}</label>
            <div class="col-md-9">
                <input class="form-control" name="seats" type="text" id="seats" value="{{ old('seats', optional($car)->seats) }}" minlength="1" maxlength="300" placeholder="{{ trans('car.seats__placeholder') }}">
                {!! $errors->first('seats', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description" class="col-md-2 control-label">{{ trans('car.description') }}</label>
    <div class="col-md-10">
        <textarea class="form-control" name="description" type="text" id="description" rows="6" placeholder="{{ trans('car.description__placeholder') }}">{{ old('description', optional($car)->description) }}</textarea>
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@if($service_id == '3')
<div class="row">
<div class="col-lg-12 p-3 bg-primary">
    {{ trans('car.renting') }}
</div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('rent_daily') ? 'has-error' : '' }}">
            <label for="rent_daily" class="col-md-6 control-label">{{ trans('car.rent_daily') }}</label>
            <div class="col-md-10">
                <input class="form-control" name="rent_daily" type="text" id="rent_daily" value="{{ old('rent_daily', optional($car)->rent_daily) }}" minlength="1" maxlength="300" placeholder="{{ trans('car.rent_daily__placeholder') }}" required>
                {!! $errors->first('rent_daily', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('rent_weekly') ? 'has-error' : '' }}">
            <label for="rent_weekly" class="col-md-6 control-label">{{ trans('car.rent_weekly') }} </label>
            <div class="col-md-10">
                <input class="form-control" name="rent_weekly" type="text" id="rent_weekly" value="{{ old('rent_weekly', optional($car)->rent_weekly) }}" minlength="1" maxlength="300" placeholder="{{ trans('car.rent_weekly__placeholder') }}">
                {!! $errors->first('rent_weekly', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('rent_monthly') ? 'has-error' : '' }}">
            <label for="rent_monthly" class="col-md-6 control-label">{{ trans('car.rent_monthly') }}</label>
            <div class="col-md-10">
                <input class="form-control" name="rent_monthly" type="text" id="rent_monthly" value="{{ old('rent_monthly', optional($car)->rent_monthly) }}" minlength="1" maxlength="300" placeholder="{{ trans('car.rent_monthly__placeholder') }}">
                {!! $errors->first('rent_monthly', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('rent_yearly') ? 'has-error' : '' }}">
            <label for="rent_yearly" class="col-md-6 control-label">{{ trans('car.rent_yearly') }}</label>
            <div class="col-md-10">
                <input class="form-control" name="rent_yearly" type="text" id="rent_yearly" value="{{ old('rent_yearly', optional($car)->rent_yearly) }}" minlength="1" maxlength="300" placeholder="{{ trans('car.rent_yearly__placeholder') }}">
                {!! $errors->first('rent_yearly', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
{{--
<div class="form-group {{ $errors->has('short_description') ? 'has-error' : '' }}">
    <label for="short_description" class="col-md-2 control-label">{{ trans('car.short_description') }}</label>
    <div class="col-md-10">
        <textarea class="form-control" name="short_description" type="text" id="short_description" rows="4" placeholder="{{ trans('car.short_description__placeholder') }}">{{ old('short_description', optional($car)->short_description) }}</textarea>
        {!! $errors->first('short_description', '<p class="help-block">:message</p>') !!}
    </div>
</div> --}}


{{--<div class="row">

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('insurance_expiry_date') ? 'has-error' : '' }}">
            <label for="insurance_expiry_date" class="col-md-5 control-label">{{ trans('car.insurance_expiry_date') }}</label>
            <div class="col-md-9">
                <input class="form-control date-picker" name="insurance_expiry_date" type="text" id="insurance_expiry_date" value="{{ old('insurance_expiry_date', optional($car)->insurance_expiry_date) }}" minlength="1" maxlength="20" placeholder="{{ trans('car.insurance_expiry_date__placeholder') }}" required>
                {!! $errors->first('insurance_expiry_date', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <!--<div class="form-group {{ $errors->has('star') ? 'has-error' : '' }}">
            <label for="star" class="col-md-3 control-label">{{ trans('car.star') }}</label>
            <div class="col-md-9">
                <select class="form-control" id="star" name="star">
                        <option value="" style="display: none;" {{ old('star', optional($car)->star ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('car.star__placeholder') }}</option>
                        <option value="1" {{ old('star', optional($car)->star) == '1' ? 'selected' : '' }}>
                            {{ trans('car.one') }}
                        </option>
                        <option value="2" {{ old('star', optional($car)->star) == '2' ? 'selected' : '' }}>
                            {{ trans('car.two') }}
                        </option>
                        <option value="3" {{ old('star', optional($car)->star) == '3' ? 'selected' : '' }}>
                            {{ trans('car.three') }}
                        </option>
                        <option value="4" {{ old('star', optional($car)->star) == '4' ? 'selected' : '' }}>
                            {{ trans('car.four') }}
                        </option>
                        <option value="5" {{ old('star', optional($car)->star) == '5' ? 'selected' : '' }}>
                            {{ trans('car.five') }}
                        </option>
                </select>
                {!! $errors->first('star', '<p class="help-block">:message</p>') !!}
            </div>
        </div> -->
    </div>
</div>--}}
@endif

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('cancellation_before') ? 'has-error' : '' }}">
            <label for="cancellation_before" class="col-md-6 control-label">{{ trans('car.cancellation_before') }}</label>
            <div class="col-md-10">
                <input class="form-control" name="cancellation_before" type="text" id="cancellation_before" value="{{ old('cancellation_before', optional($car)->cancellation_before) }}" minlength="1" maxlength="300" placeholder="{{ trans('car.cancellation_before__placeholder') }}">
                {!! $errors->first('cancellation_before', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
            <label for="is_active" class="col-md-2 control-label">{{ trans('car.is_active') }}</label>
            <div class="col-md-10">
                <div class="checkbox">
                    <label for="is_active_1">
                        <input id="is_active_1" class="" name="is_active" type="checkbox" value="1"
                            {{ old('is_active', optional(optional($car)->active)->is_active) == 'Active' ? 'checked' : '' }}>
                        {{ trans('car.is_active_1') }}
                    </label>
                </div>

                {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>


<div class="row">
<div class="col-lg-12 p-3 bg-primary">
    {{ trans('car.attachments') }}
</div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('registration_file') ? 'has-error' : '' }}">
            <label for="registration_file" class="col-md-3 control-label">{{ trans('car.registration_file') }}</label>
            <div class="col-md-9">
                @if(optional($car)->registration_file)
                    <img src="{{ url('storage/app/'.optional($car)->registration_file) }}" width="100px"/>
                @endif
                <input class="form-control" name="registration_file" type="file" id="registration_file"  placeholder="{{ trans('car.registration_file__placeholder') }}">
                {!! $errors->first('registration_file', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('insurance_file') ? 'has-error' : '' }}">
            <label for="insurance_file" class="col-md-3 control-label">{{ trans('car.insurance_file') }}</label>
            <div class="col-md-9">
                @if(optional($car)->insurance_file)
                    <img src="{{ url('storage/app/'.optional($car)->insurance_file) }}" width="100px"/>
                @endif
                <input class="form-control" name="insurance_file" type="file" id="insurance_file"  placeholder="{{ trans('car.insurance_file__placeholder') }}">
                {!! $errors->first('insurance_file', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
<div class="col-lg-12 p-3 bg-primary">
    {{ trans('car.photos') }}
</div>
</div>
<div class="form-group {{ $errors->has('photo_upload') ? 'has-error' : '' }}">
    <label for="photo_upload" class="col-md-3 control-label">{{ trans('car.photo_upload') }}</label>
    <div class="col-md-9">
        <div id="image-preview">
        @if($car_photo)
        @foreach($car_photo as $key => $photo)
            <div class="image-wrapper">
                <img src="{{ url('storage/app/'.$photo) }}" width="100px"/>
                <div class="image-index-wrapper"><input type="radio" name="main_image" value="{{ $key }}"/></div>
            </div>
        @endforeach
        @endif
        </div>
        <input class="form-control" name="photo_upload[]" type="file" id="photo_upload"  multiple placeholder="{{ trans('car.photo_upload__placeholder') }}">
        {!! $errors->first('photo_upload', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<!--  <div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('meta_keyword') ? 'has-error' : '' }}">
            <label for="meta_keyword" class="col-md-3 control-label">{{ trans('car.meta_keyword') }}</label>
            <div class="col-md-9">
                <textarea class="form-control" name="meta_keyword" type="text" id="meta_keyword" rows="4" placeholder="{{ trans('car.meta_keyword__placeholder') }}">{{ old('meta_keyword', optional($car)->meta_keyword) }}</textarea>
                {!! $errors->first('meta_keyword', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('meta_description') ? 'has-error' : '' }}">
            <label for="meta_description" class="col-md-3 control-label">{{ trans('car.meta_description') }}</label>
            <div class="col-md-9">
                <textarea class="form-control" name="meta_description" type="text" id="meta_description" rows="4" placeholder="{{ trans('car.meta_description__placeholder') }}">{{ old('meta_description', optional($car)->meta_description) }}</textarea>
                {!! $errors->first('meta_description', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>-->
