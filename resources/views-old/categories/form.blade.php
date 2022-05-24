
<input type="hidden" name="service_id" id="service_id" value="{{$service_id}}" />
<div class="form-group {{ $errors->has('image_file') ? 'has-error' : '' }}">
    <label for="image_file" class="col-md-3 control-label">{{ trans('categories.image_file') }}</label>
    <div class="col-md-9">
        @if(optional($category)->image_file)
            <img src="{{ url('storage/app/'.optional($category)->image_file) }}" width="100px"/>
        @endif
        <input class="form-control" name="image_file" type="file" id="image_file"  placeholder="{{ trans('categories.image_file__placeholder') }}">
        {!! $errors->first('image_file', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
    <label for="category" class="col-md-2 control-label">{{ trans('categories.category') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="category" type="text" id="category" value="{{ old('category', optional($category)->category) }}" minlength="1" placeholder="{{ trans('categories.category__placeholder') }}">
        {!! $errors->first('category', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@if(optional($category)->service_id == '2')
<div class="ratings">
<div class="form-group {{ $errors->has('minimum_charge') ? 'has-error' : '' }}">
    <label for="minimum_charge" class="col-md-2 control-label">{{ trans('categories.minimum_charge') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="minimum_charge" type="text" id="minimum_charge" value="{{ old('minimum_charge', optional($category_config)->minimum_charge) }}" minlength="1" placeholder="{{ trans('categories.minimum_charge__placeholder') }}">
        {!! $errors->first('minimum_charge', '<p class="help-block">:message</p>') !!}
    </div>
</div> 
<div class="form-group {{ $errors->has('km_charge') ? 'has-error' : '' }}">
    <label for="km_charge" class="col-md-2 control-label">{{ trans('categories.km_charge') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="km_charge" type="text" id="km_charge" value="{{ old('km_charge', optional($category_config)->km_charge) }}" minlength="1" placeholder="{{ trans('categories.km_charge__placeholder') }}">
        {!! $errors->first('km_charge', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('cancellation_charge') ? 'has-error' : '' }}">
    <label for="cancellation_charge" class="col-md-2 control-label">{{ trans('categories.cancellation_charge') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="cancellation_charge" type="text" id="cancellation_charge" value="{{ old('cancellation_charge', optional($category_config)->cancellation_charge) }}" minlength="1" placeholder="{{ trans('categories.cancellation_charge__placeholder') }}">
        {!! $errors->first('cancellation_charge', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
@elseif($service_id == '2')
<div class="ratings">
<div class="form-group {{ $errors->has('minimum_charge') ? 'has-error' : '' }}">
    <label for="minimum_charge" class="col-md-2 control-label">{{ trans('categories.minimum_charge') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="minimum_charge" type="text" id="minimum_charge" value="{{ old('minimum_charge') }}" minlength="1" placeholder="{{ trans('categories.minimum_charge__placeholder') }}">
        {!! $errors->first('minimum_charge', '<p class="help-block">:message</p>') !!}
    </div>
</div> 
<div class="form-group {{ $errors->has('km_charge') ? 'has-error' : '' }}">
    <label for="km_charge" class="col-md-2 control-label">{{ trans('categories.km_charge') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="km_charge" type="text" id="km_charge" value="{{ old('km_charge') }}" minlength="1" placeholder="{{ trans('categories.km_charge__placeholder') }}">
        {!! $errors->first('km_charge', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('cancellation_charge') ? 'has-error' : '' }}">
    <label for="cancellation_charge" class="col-md-2 control-label">{{ trans('categories.cancellation_charge') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="cancellation_charge" type="text" id="cancellation_charge" value="{{ old('cancellation_charge') }}" minlength="1" placeholder="{{ trans('categories.cancellation_charge__placeholder') }}">
        {!! $errors->first('cancellation_charge', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
@endif
<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">{{ trans('categories.is_active') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($category)->is_active) == 'Yes' ? 'checked' : '' }}>
                {{ trans('categories.is_active_1') }}
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>


