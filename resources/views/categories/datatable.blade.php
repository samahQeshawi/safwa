<form method="POST" action=" {{ route('categories.category.destroy', $category->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        @can("view categories")
        <a href=" {{ route('categories.category.show', $category->id) }} " class="btn btn-info" title=" {{ trans('categories.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        @endcan
        @can("edit categories")
        <a href="{{ route('categories.category.edit',  ['category' => $category->id, 'service_type'=>$category->service_id]) }}" class="btn btn-primary" title="{{ trans('categories.edit') }}">
            <i class="fas fa-edit"></i>
        </a>
        @endcan
        @can("delete categories")
        <button type="submit" class="btn btn-danger" title="{{ trans('categories.delete') }}"
            onclick="return confirm('{{ trans('categories.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
        @endcan
    </div>
</form>
