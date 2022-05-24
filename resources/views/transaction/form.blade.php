<div class="row">
<div class="col-md-6">
<div class="form-group {{ $errors->has('sender_id') ? 'has-error' : '' }}">
    <label for="sender_id" class="col-md-3 control-label">{{ trans('transaction.sender_id') }}</label>
    <div class="col-md-9">
        <select class="form-control" id="sender_id" name="sender_id" required="true">
                <option value="" style="display: none;" {{ old('sender_id', optional($transaction)->sender_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('transaction.sender_id__placeholder') }}</option>
        </select>
        {!! $errors->first('sender_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
<div class="col-md-6">
<div class="form-group {{ $errors->has('receiver_id') ? 'has-error' : '' }}">
    <label for="receiver_id" class="col-md-3 control-label">{{ trans('transaction.receiver_id') }}</label>
    <div class="col-md-9">
        <select class="form-control" id="receiver_id" name="receiver_id" required="true">
                <option value="" style="display: none;" {{ old('receiver_id', optional($transaction)->receiver_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('transaction.receiver_id__placeholder') }}</option>
        </select>

        {!! $errors->first('receiver_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-6">
<div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
    <label for="amount" class="col-md-3 control-label">{{ trans('transaction.amount') }}</label>
    <div class="col-md-9">
        <input class="form-control" name="amount" type="text" id="amount" value="{{ old('amount', optional($transaction)->amount) }}" minlength="1" placeholder="{{ trans('transaction.amount__placeholder') }}">
        {!! $errors->first('amount', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
@if(!empty( optional($transaction)->booking_id))
<div class="col-md-6">
<div class="form-group {{ $errors->has('booking_id') ? 'has-error' : '' }}">
    <label for="booking_id" class="col-md-3 control-label">{{ trans('transaction.booking_id') }}</label>
    <div class="col-md-9">
        <select class="form-control" id="booking_id" name="booking_id">
                <option value="" style="display: none;" {{ old('booking_id', optional($transaction)->booking_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('transaction.booking_id__placeholder') }}</option>
        </select>

        {!! $errors->first('booking_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
@else
<div class="col-md-6">
<div class="form-group {{ $errors->has('booking_id') ? 'has-error' : '' }}">
    <label for="trip_id" class="col-md-3 control-label">{{ trans('transaction.trip_no') }}</label>
    <div class="col-md-9">
        <select class="form-control" id="trip_id" name="trip_id">
                <option value="" style="display: none;" {{ old('trip_id', optional($transaction)->trip_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('transaction.trip_id__placeholder') }}</option>
        </select>

        {!! $errors->first('booking_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
@endif
</div>
<div class="form-group {{ $errors->has('note') ? 'has-error' : '' }}">
    <label for="note" class="col-md-2 control-label">{{ trans('transaction.note') }}</label>
    <div class="col-md-10">
        <textarea class="form-control" name="note" cols="10" rows="6" id="note" required="true" placeholder="{{ trans('transaction.note__placeholder') }}">{{ old('note', optional($transaction)->note) }}</textarea>
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
</div>