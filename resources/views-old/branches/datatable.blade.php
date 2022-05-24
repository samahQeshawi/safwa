<form method="POST" action=" {{ route('branches.destroy', $branch->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('branches.show', $branch->id) }} " class="btn btn-info" title=" {{ trans('branch.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('branches.edit', $branch->id) }}" class="btn btn-primary" title="{{ trans('branch.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('branch.delete') }}"
            onclick="return confirm('{{ trans('branch.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
