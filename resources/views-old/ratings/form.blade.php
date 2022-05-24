<div class="form-group {{ $errors->has('trip_id') ? 'has-error' : '' }}">
    <label for="trip_id" class="col-md-3 control-label">{{ trans('ratings.trip_id') }}</label>
    <div class="col-md-9">
        {{ optional($rating)->trip->trip_no }}
        {!! $errors->first('trip_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('rated_by') ? 'has-error' : '' }}">
    <label for="rated_by" class="col-md-3 control-label">{{ trans('ratings.rated_by') }}</label>
    <div class="col-md-9">
        {{ optional($rating)->ratedBy->name }}

        {!! $errors->first('rated_by', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('rated_for') ? 'has-error' : '' }}">
    <label for="rated_for" class="col-md-3 control-label">{{ trans('ratings.rated_for') }}</label>
    <div class="col-md-9">
        {{ optional($rating)->ratedFor->name }}
        {!! $errors->first('rated_for', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('rating') ? 'has-error' : '' }}">
    <label for="rating" class="col-md-3 control-label">{{ trans('ratings.rating') }}</label>
    <div class="col-md-9">
        <select class="form-control" id="rating" name="rating">
                <option value="" style="display: none;" {{ old('rated_by', optional($rating)->rating ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('ratings.rating__placeholder') }}</option>
                <?php $rating_value = ['0.5','1.0','1.5','2.0','2.5','3.0','3.5','4.0','4.5','5.0']; ?>
                @foreach($rating_value as $rating_value)
                <option value="{{$rating_value}}" {{ optional($rating)->rating == $rating_value  ? 'selected' : '' }}>{{$rating_value}}</option>
                @endforeach
        </select>

        {!! $errors->first('rating', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('rating_comment') ? 'has-error' : '' }}">
    <label for="rating_comment" class="col-md-2 control-label">{{ trans('ratings.rating_comment') }}</label>
    <div class="col-md-10">
        <textarea class="form-control" name="rating_comment" cols="10" rows="6" id="rating_comment" required="true" placeholder="{{ trans('ratings.rating_comment__placeholder') }}">{{ old('rating_comment', optional($rating)->rating_comment) }}</textarea>
        {!! $errors->first('rating_comment', '<p class="help-block">:message</p>') !!}
    </div>
</div>