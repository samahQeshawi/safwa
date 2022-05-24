<form method="POST" action=" {{ route('cartype.destroy', $cartype->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('cartype.show', $cartype->id) }} " class="btn btn-info" title=" {{ trans('cartype.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('cartype.edit', $cartype->id) }}" class="btn btn-primary" title="{{ trans('cartype.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('cartype.delete') }}"
            onclick="return confirm('{{ trans('cartype.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
