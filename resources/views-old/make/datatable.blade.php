<form method="POST" action=" {{ route('make.destroy', $make->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('make.show', $make->id) }} " class="btn btn-info" title=" {{ trans('make.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('make.edit', $make->id) }}" class="btn btn-primary" title="{{ trans('make.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('make.delete') }}"
            onclick="return confirm('{{ trans('make.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
