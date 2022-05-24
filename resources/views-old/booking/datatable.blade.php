<form method="POST" action=" {{ route('booking.destroy', $booking->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('booking.show', $booking->id) }} " class="btn btn-info" title=" {{ trans('booking.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('booking.edit', $booking->id) }}" class="btn btn-primary" title="{{ trans('booking.edit') }}">
            <i class="fas fa-edit"></i>
        </a>
        <a href="{{ route('bookings.booking.invoice', $booking->id) }}" class="btn btn-secondary" title="{{ trans('booking.invoice') }}">
            <i class="fas fa-file-invoice"></i>
        </a>
        <button type="button" class="btn btn-warning email-booking-modal" data-booking-id="{{$booking->id}}" data-toggle="modal" data-target="#modal-lg">
           <i style="color:white" class="fas fa-envelope"></i>
        </button>
        <button type="submit" class="btn btn-danger" title="{{ trans('booking.delete') }}"
            onclick="return confirm('{{ trans('booking.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
