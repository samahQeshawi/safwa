
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">{{ trans('paymentmethod.name') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($paymentmethod)->name) }}" minlength="1" placeholder="{{ trans('paymentmethod.name__placeholder') }}">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('image_file') ? 'has-error' : '' }}">
    <label for="image_file" class="col-md-3 control-label">{{ trans('paymentmethod.image_file') }}</label>
    <div class="col-md-9">
        @if(optional($paymentmethod)->image_file)
            <img src="{{ url('storage/app/'.optional($paymentmethod)->image_file) }}" width="100px"/>
        @endif
        <input class="form-control" name="image_file" type="file" id="image_file"  placeholder="{{ trans('paymentmethod.image_file__placeholder') }}">
        {!! $errors->first('image_file', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">{{ trans('paymentmethod.is_active') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($paymentmethod)->is_active) == 'Yes' ? 'checked' : '' }}>
                {{ trans('paymentmethod.is_active_1') }}
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

