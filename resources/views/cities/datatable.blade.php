<form method="POST" action=" {{ route('cities.city.destroy', $city->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('cities.city.show', $city->id) }} " class="btn btn-info" title=" {{ trans('cities.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('cities.city.edit', $city->id) }}" class="btn btn-primary" title="{{ trans('cities.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('cities.delete') }}"
            onclick="return confirm('{{ trans('cities.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
