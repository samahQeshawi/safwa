<div class="row">
    <div class="col-md-6">
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">{{ trans('user_admin.first_name') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($user_admin)->name) }}" min="0" max="255" placeholder="{{ trans('user_admin.first_name__placeholder') }}">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
<div class="col-md-6">
<div class="form-group {{ $errors->has('surname') ? 'has-error' : '' }}">
    <label for="surname" class="col-md-2 control-label">{{ trans('user_admin.surname') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="surname" type="text" id="surname" value="{{ old('surname', optional($user_admin)->surname) }}" min="0" max="255" placeholder="{{ trans('user_admin.surname__placeholder') }}">
        {!! $errors->first('surname', '<p class="help-block">:message</p>') !!}
    </div>
</div>

</div>
</div>
<div class="row">
    <div class="col-md-6">
<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label">{{ trans('user_admin.email') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="email" type="text" id="email" value="{{ old('email', optional($user_admin)->email) }}" min="0" max="255" placeholder="{{ trans('user_admin.email__placeholder') }}">
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

</div>
<div class="col-md-6">

<div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
    <label for="phone" class="col-md-2 control-label">{{ trans('user_admin.phone') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="phone" type="text" id="phone" value="{{ old('phone', optional($user_admin)->phone) }}" min="0" max="255" placeholder="{{ trans('user_admin.phone__placeholder') }}">
        {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
</div>
<div class="row">
    <div class="col-md-6">
<div class="form-group {{ $errors->has('country') ? 'has-error' : '' }}">
    <label for="country" class="col-md-2 control-label">{{ trans('user_admin.country') }}</label>
    <div class="col-md-10">
        <select class="form-control" id="country" name="country" required="true">
                <option value="" style="display: none;" {{ old('country', optional($user_admin)->country_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('user_admin.country__placeholder') }}</option>
            @foreach ($countries as $key => $country)
                <option value="{{ $key }}" {{ old('country', optional($user_admin)->country_id) == $key ? 'selected' : '' }}>
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
    <label for="city" class="col-md-2 control-label">{{ trans('user_admin.city') }}</label>
    <div class="col-md-10">
        <select class="form-control" id="city" name="city" required="true">
                <option value="" style="display: none;" {{ old('city', optional($user_admin)->city_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('user_admin.city__placeholder') }}</option>
            @foreach ($cities as $key => $city)
                <option value="{{ $key }}" {{ old('city', optional($user_admin)->city_id) == $key ? 'selected' : '' }}>
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
     <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label">{{ trans('user_admin.permission') }}</label>
    <div class="col-md-10">
        <select class="form-control" id="admin_user" name="admin_user" required="true">
                <option value="" style="display: none;" {{ old('admin_user', optional($user_admin)->admin_user ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('user_admin.country__placeholder') }}</option>
            @foreach ($permissions as $key => $permission)
                <option value="{{ $permission->id }}" {{ old('admin_user', optional($user_admin)->admin_user) == $permission->id ? 'selected' : '' }}>
                    {{ $permission->user_type }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('admin_user', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
</div>
   <div class="col-md-6">
     @if(!$user_admin)
<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
    <label for="password" class="col-md-2 control-label">{{ trans('user_admin.password') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="password" type="password" id="password" value="{{ old('password', optional($user_admin)->password) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('user_admin.password__placeholder') }}">
        {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
@endif
   </div>
   

</div>
<div class="row">
     <div class="col-md-6">
<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">{{ trans('user_admin.is_active') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
                <input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($user_admin)->is_active) == 'Active' ? 'checked' : '' }}>
                {{ trans('user_admin.is_active_1') }}
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
</div>