<form method="POST" action=" {{ route('drivers.driver.destroy', $driver->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('drivers.driver.show', $driver->id) }} " class="btn btn-info" title=" {{ trans('drivers.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('drivers.driver.edit', $driver->id) }}" class="btn btn-primary" title="{{ trans('drivers.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('drivers.delete') }}"
            onclick="return confirm('{{ trans('drivers.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
