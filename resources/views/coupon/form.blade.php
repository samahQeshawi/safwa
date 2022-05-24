
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="coupon_name" class="col-md-2 control-label">{{ trans('coupon.name') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="coupon_name" type="text" id="coupon_name" value="{{ old('coupon_name', optional($coupon)->coupon_name) }}" minlength="1" maxlength="255" placeholder="{{ trans('coupon.name__placeholder') }}">
        {!! $errors->first('coupon_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="use_percentage" class="col-md-6 control-label">{{ trans('coupon.description') }}</label>
    <div class="col-md-10">
        <textarea class="form-control" name="description"  id="description"  placeholder="{{ trans('coupon.description__placeholder') }}">{{ old('description', optional($coupon)->description) }}</textarea>
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group row {{ $errors->has('use_percentage') ? 'has-error' : '' }}">
    <label for="use_percentage" class="col-md-2 control-label">{{ trans('coupon.use_percentage') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="use_percentage">
                <input id="use_percentage" class="" name="use_percentage" type="checkbox" value="1" {{ old('use_percentage', optional($coupon)->use_percentage) == '1' ? 'checked' : '' }}>
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="row discount_data">
    <div class="col-md-6">
        <div class="form-group  {{ $errors->has('coupon_discount_percentage') ? 'has-error' : '' }}">
            <label for="coupon_discount_percentage" class="col-md-6 control-label">{{ trans('coupon.coupon_discount_percentage') }}</label>
           <div class="col-md-10">
                <input type="text" id="coupon_discount_percentage" class="form-control" name="coupon_discount_percentage" placeholder="{{ trans('coupon.coupon_discount_percentage') }}" value="{{ old('coupon_discount_percentage', optional($coupon)->coupon_discount_percentage) }}" />
                {!! $errors->first('coupon_discount_percentage', '<p class="help-block">:message</p>') !!}   
            </div>  
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('coupon_max_discount_amount') ? 'has-error' : '' }}">
            <label for="coupon_max_discount_amount" class="col-md-6 control-label">{{ trans('coupon.coupon_max_discount_amount') }}</label>
           <div class="col-md-10">
                <input type="text" id="coupon_max_discount_amount" class="form-control" name="coupon_max_discount_amount" placeholder="{{ trans('coupon.coupon_max_discount_amount') }}" value="{{ old('coupon_max_discount_amount', optional($coupon)->coupon_max_discount_amount) }}" />
                {!! $errors->first('coupon_max_discount_amount', '<p class="help-block">:message</p>') !!}   
            </div>  
        </div>
    </div>
</div>
<div class="form-group discount_amt {{ $errors->has('coupon_discount_amount') ? 'has-error' : '' }}">
    <label for="coupon_discount_amount" class="col-md-2 control-label">{{ trans('coupon.coupon_discount_amount') }}</label>
   <div class="col-md-10">
        <input type="text" id="coupon_discount_amount" class="form-control" name="coupon_discount_amount" placeholder="{{ trans('coupon.coupon_discount_amount') }}" value="{{ old('coupon_discount_amount', optional($coupon)->coupon_discount_amount) }}" />
        {!! $errors->first('coupon_discount_amount', '<p class="help-block">:message</p>') !!}   
    </div>  
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('coupon_code') ? 'has-error' : '' }}">
            <label for="coupon_code" class="col-md-6 control-label">{{ trans('coupon.coupon_code') }}</label>
           <div class="col-md-10">
                <input type="text" id="coupon_code" class="form-control" name="coupon_code" placeholder="{{ trans('coupon.coupon_code') }}" value="{{ old('coupon_code', optional($coupon)->coupon_code) }}" />
                {!! $errors->first('coupon_code', '<p class="help-block">:message</p>') !!} 
            </div>  
        </div>
    </div>    
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('coupon_image') ? 'has-error' : '' }}">
            <label for="coupon_image" class="col-md-3 control-label">{{ trans('coupon.coupon_image') }}</label>
            <div class="col-md-9">
                @if(optional($coupon)->coupon_image)
                    <img src="{{ url('storage/app/'.optional($coupon)->coupon_image) }}" width="100px"/>
                @endif
                <input class="form-control" name="coupon_image" type="file" id="coupon_image"  placeholder="{{ trans('coupon.coupon_image__placeholder') }}">
                {!! $errors->first('coupon_image', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('coupon_type') ? 'has-error' : '' }}">
            <label for="coupon_type" class="col-md-6 control-label">{{ trans('coupon.coupon_type') }}</label>
           <div class="col-md-10">
                <select class="form-control" id="coupon_type" name="coupon_type" required="true">
                        <option value="" style="display: none;" {{ old('coupon_type', optional($coupon)->coupon_type ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('coupon.coupon_type__placeholder') }}</option>
                        <?php $coupon_type = ['1'=> 'Unlimited','2' => 'N times']; ?>
                    @foreach ($coupon_type as $key => $value)
                        <option value="{{ $key }}" {{ old('coupon_type', optional($coupon)->coupon_type) == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>  
                {!! $errors->first('coupon_type', '<p class="help-block">:message</p>') !!} 
            </div>  
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group limit_coupon {{ $errors->has('coupon_limit') ? 'has-error' : '' }}">
            <label for="coupon_limit" class="col-md-6 control-label">{{ trans('coupon.coupon_limit') }}</label>
           <div class="col-md-10">
                <input type="text" id="coupon_limit" class="form-control" name="coupon_limit" placeholder="{{ trans('coupon.coupon_limit') }}" value="{{ old('coupon_limit', optional($coupon)->coupon_limit) }}" />
                {!! $errors->first('coupon_limit', '<p class="help-block">:message</p>') !!} 
            </div>  
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('coupon_from_date') ? 'has-error' : '' }}">
        	<label for="coupon_from_date" class="col-md-2 control-label">{{ trans('coupon.coupon_from_date') }}</label>
           <div class="col-md-10">
        		<input type="text" id="coupon_from_date" class="form-control date-picker" name="coupon_from_date" placeholder="{{ trans('coupon.coupon_from_date') }}" value="{{ old('coupon_from_date', optional($coupon)->coupon_from_date) }}" autocomplete="off" />
        		{!! $errors->first('coupon_from_date', '<p class="help-block">:message</p>') !!}	
        	</div>	
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('coupon_to_date') ? 'has-error' : '' }}">
        	<label for="coupon_to_date" class="col-md-2 control-label">{{ trans('coupon.coupon_to_date') }}</label>
           <div class="col-md-10">
        		<input type="text" id="coupon_to_date" class="form-control date-picker" name="coupon_to_date" placeholder="{{ trans('coupon.coupon_to_date') }}" value="{{ old('coupon_to_date', optional($coupon)->coupon_to_date) }}"  />
        		{!! $errors->first('coupon_to_date', '<p class="help-block">:message</p>') !!}	
        	</div>	
        </div>
    </div>
</div>
<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">{{ trans('coupon.is_active') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($coupon)->is_active) == 'Yes' ? 'checked' : '' }}>
                {{ trans('coupon.is_active_1') }}
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

