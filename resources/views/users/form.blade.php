
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">{{ trans('users.name') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($user)->name) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('users.name__placeholder') }}">
        {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label">{{ trans('users.email') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="email" type="text" id="email" value="{{ old('email', optional($user)->email) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('users.email__placeholder') }}">
        {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
    <label for="phone" class="col-md-2 control-label">{{ trans('users.phone') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="phone" type="text" id="phone" value="{{ old('phone', optional($user)->phone) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('users.phone__placeholder') }}">
        {!! $errors->first('phone', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

@if(!$user)
<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
    <label for="password" class="col-md-2 control-label">{{ trans('users.password') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="password" type="password" id="password" value="{{ old('password', optional($user)->password) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('users.password__placeholder') }}">
        {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
@endif
<div class="row">
    <div class="col-md-6">
<div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
    <label for="country" class="col-md-2 control-label">{{ trans('users.country') }}</label>
    <div class="col-md-10">
        <select class="form-control" id="country" name="country" required="true">
                <option value="" style="display: none;" {{ old('country', optional($user)->country_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('users.country__placeholder') }}</option>
            @foreach ($countries as $key => $country)
                <option value="{{ $key }}" {{ old('country', optional($user)->country_id) == $key ? 'selected' : '' }}>
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
    <label for="city" class="col-md-2 control-label">{{ trans('users.city') }}</label>
    <div class="col-md-10">
        <select class="form-control" id="city" name="city" required="true">
                <option value="" style="display: none;" {{ old('city', optional($user)->city_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('users.city__placeholder') }}</option>
            @foreach ($cities as $key => $city)
                <option value="{{ $key }}" {{ old('city', optional($user)->city_id) == $key ? 'selected' : '' }}>
                    {{ $city }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('city_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
</div>
<input type="hidden" name="user_type_id" id="user_type_id" value="2" />
{{--
<div class="form-group {{ $errors->has('user_type_id') ? 'has-error' : '' }}">
    <label for="user_type_id" class="col-md-2 control-label">{{ trans('users.user_type_id') }}</label>
    <div class="col-md-10">
        <select class="form-control" id="user_type_id" name="user_type_id">
        	    <option value="" style="display: none;" {{ old('user_type_id', optional($user)->user_type_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('users.user_type_id__placeholder') }}</option>
        	@foreach ($user_types as $key => $user_type)
			    <option value="{{ $key }}" {{ old('user_type_id', optional($user)->user_type_id) == $key ? 'selected' : '' }}>
			    	{{ $user_type }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('user_type_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>--}}
