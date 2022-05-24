
<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    <label for="user_id" class="col-md-3 control-label">{{ trans('wallet.user_id') }}</label>
    <div class="col-md-9">
        <input type="hidden" name="user_type" value="<?php echo isset($_GET['user_type']) ? $_GET['user_type'] : optional($wallet)->user_type; ?>"/>
        <select class="form-control" id="user_id" name="user_id" required="true">
                <option value="" style="display: none;" {{ old('user_id', optional($wallet)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('wallet.user_id__placeholder') }}</option>
            @foreach ($users as $key => $value)
                <option value="{{ $key }}" {{ old('user_id', optional($wallet)->user_id) == $key ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('customer_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
    <label for="amount" class="col-md-2 control-label">{{ trans('wallet.amount') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="amount" type="text" id="amount" value="{{ old('amount', optional($wallet)->amount) }}" minlength="1" placeholder="{{ trans('wallet.amount__placeholder') }}">
        {!! $errors->first('amount', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">{{ trans('wallet.is_active') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
                <input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($wallet)->is_active) == 'Yes' ? 'checked' : '' }}>
                {{ trans('wallet.is_active_1') }}
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>
