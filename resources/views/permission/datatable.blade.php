<form method="POST" action=" {{ route('permission.destroy', $permission->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        @can("edit user_manage")
        <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-primary" title="{{ trans('permission.edit') }}">
            <i class="fas fa-edit"></i>
        </a>
        @endcan
        @can("delete user_manage")
        <button type="submit" class="btn btn-danger" title="{{ trans('permission.delete') }}"
            onclick="return confirm('{{ trans('permission.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
        @endcan
    </div>
</form>
