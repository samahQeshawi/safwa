<form method="POST" action=" {{ route('fuel_types.fuel_type.destroy', $fuel_type->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        @can("view setting")
        <a href=" {{ route('fuel_types.fuel_type.show', $fuel_type->id) }} " class="btn btn-info" title=" {{ trans('fuel_types.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        @endcan
        @can("edit setting")
        <a href="{{ route('fuel_types.fuel_type.edit', $fuel_type->id) }}" class="btn btn-primary" title="{{ trans('fuel_types.edit') }}">
            <i class="fas fa-edit"></i>
        </a>
        @endcan
        @can("delete setting")
        <button type="submit" class="btn btn-danger" title="{{ trans('fuel_types.delete') }}"
            onclick="return confirm('{{ trans('fuel_types.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
        @endcan
    </div>
</form>
