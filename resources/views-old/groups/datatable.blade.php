<form method="POST" action=" {{ route('groups.group.destroy', $group->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('groups.group.show', $group->id) }} " class="btn btn-info" title=" {{ trans('groups.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('groups.group.edit', $group->id) }}" class="btn btn-primary" title="{{ trans('groups.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('groups.delete') }}"
            onclick="return confirm('{{ trans('groups.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
