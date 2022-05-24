<form method="POST" action=" {{ route('user_admin.destroy', $user_admin->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('user_admin.show', $user_admin->id) }} " class="btn btn-info" title=" {{ trans('user_admin.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('user_admin.edit', $user_admin->id) }}" class="btn btn-primary" title="{{ trans('user_admin.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('user_admin.delete') }}"
            onclick="return confirm('{{ trans('user_admin.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
