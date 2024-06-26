<form method="POST" action=" {{ route('notification.destroy', $notification->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('notification.show', $notification->id) }} " class="btn btn-info" title=" {{ trans('notification.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('notification.edit', $notification->id) }}" class="btn btn-primary" title="{{ trans('notification.edit') }}">
            <i class="fas fa-edit"></i>
        </a>
        <a href="{{ route('notification.send', $notification->id) }}" class="btn btn-primary" title="{{ trans('notification.edit') }}">
            <i class="fas fa-sms"></i>
        </a>
        <button type="submit" class="btn btn-danger" title="{{ trans('notification.delete') }}"
            onclick="return confirm('{{ trans('notification.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
