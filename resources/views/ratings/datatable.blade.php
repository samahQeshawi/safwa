<form method="POST" action=" {{ route('rating.destroy', $rating->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        @can("view ratings")
        <a href=" {{ route('rating.show', $rating->id) }} " class="btn btn-info" title=" {{ trans('ratings.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        @endcan
        @can("edit ratings")
        <a href="{{ route('rating.edit', $rating->id) }}" class="btn btn-primary" title="{{ trans('ratings.edit') }}">
            <i class="fas fa-edit"></i>
        </a>
        @endcan
        @can("delete ratings")
        <button type="submit" class="btn btn-danger" title="{{ trans('ratings.delete') }}"
            onclick="return confirm('{{ trans('ratings.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
        @endcan
    </div>
</form>
