<form method="POST" action=" {{ route('stores.store.destroy', $store->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('stores.store.show', $store->id) }} " class="btn btn-info" title=" {{ trans('stores.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('stores.store.edit', $store->id) }}" class="btn btn-primary" title="{{ trans('stores.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('stores.delete') }}"
            onclick="return confirm('{{ trans('stores.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
