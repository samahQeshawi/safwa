<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
            <label for="user_id" class="col-md-3 control-label">{{ trans('favorite_places.user_id') }}</label>
            <div class="col-md-9">
                <select class="form-control" id="user_id" name="user_id" required="true">
                        <option value="" style="display: none;" {{ old('user_id', optional($favorite_places)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('favorite_places.user_id__placeholder') }}</option>
                </select>
                {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>        
    </div>
    <div class="col-md-6">    
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            <label for="title" class="col-md-6 control-label">{{ trans('favorite_places.title') }} <span style="color:#f00;">*</span></label>
            <div class="col-md-10">
                <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($favorite_places)->title) }}"
                    min="0" max="255" placeholder="{{ trans('favorite_places.title__placeholder') }}" required="true">
                {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
    <label for="address" class="control-label">{{ trans('favorite_places.address') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="address" type="text" id="address"
            value="{{ old('address', optional($favorite_places)->address) }}" min="0" max="255"
            placeholder="{{ trans('favorite_places.address__placeholder') }}" autocomplete="off" required="true">
        {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@php
$location = optional($favorite_places)->latitude ? optional($favorite_places)->latitude. ', ' .optional($favorite_places)->longitude : '';
@endphp

<div class="form-group {{ $errors->has('location') ? 'has-error' : '' }}">
    <label for="location" class="col-md-2 control-label">{{ trans('favorite_places.location') }}</label>
    <div class="col-md-10">
        <input readonly class="form-control" name="location" type="text" id="location"
            value="{{ old('location', $location) }}"
            placeholder="{{ trans('favorite_places.location__placeholder') }}"  required="true">
        {!! $errors->first('location', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div id="map_location"></div>

<input  name="latitude" type="hidden" id="latitude"
            value="{{ old('latitude', optional($favorite_places)->latitude) }}">
<input name="longitude" type="hidden" id="longitude"
            value="{{ old('longitude', optional($favorite_places)->longitude) }}">

