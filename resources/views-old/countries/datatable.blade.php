<form method="POST" action=" {{ route('countries.country.destroy', $country->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('countries.country.show', $country->id) }} " class="btn btn-info" title=" {{ trans('countries.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('countries.country.edit', $country->id) }}" class="btn btn-primary" title="{{ trans('countries.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('countries.delete') }}"
            onclick="return confirm('{{ trans('countries.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
