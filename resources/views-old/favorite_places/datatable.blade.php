<form method="POST" action=" {{ route('favorite_places.destroy', $favorite_place->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('favorite_places.show', $favorite_place->id) }} " class="btn btn-info" title=" {{ trans('favorite_places.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('favorite_places.edit', $favorite_place->id) }}" class="btn btn-primary" title="{{ trans('favorite_places.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('favorite_places.delete') }}"
            onclick="return confirm('{{ trans('favorite_places.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
