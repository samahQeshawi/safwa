
<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title" class="col-md-2 control-label">{{ trans('notification.title') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($notification)->title) }}" minlength="1" placeholder="{{ trans('notification.title__placeholder') }}">
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
    <label for="body" class="col-md-2 control-label">{{ trans('notification.body') }}</label>
    <div class="col-md-10">
        <textarea class="form-control" name="body"  id="body" rows="5"  minlength="1" placeholder="{{ trans('notification.body__placeholder') }}">{{ old('body', optional($notification)->body) }}</textarea>
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">{{ trans('notification.is_active') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($notification)->is_active) == 'Yes' ? 'checked' : '' }}>
                {{ trans('notification.is_active_1') }}
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

