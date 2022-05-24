<form method="POST" action=" {{ route('trip.destroy', $trip->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('trip.show', $trip->id) }} " class="btn btn-info" title=" {{ trans('trip.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('trip.edit', $trip->id) }}" class="btn btn-primary" title="{{ trans('trip.edit') }}">
            <i class="fas fa-edit"></i>
        </a>
        <a href="{{ route('trip.invoice', $trip->id) }}" class="btn btn-secondary" title="{{ trans('trip.invoice') }}">
            <i class="fas fa-file-invoice"></i>
        </a>
        <button type="submit" class="btn btn-danger" title="{{ trans('trip.delete') }}"
            onclick="return confirm('{{ trans('trip.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
