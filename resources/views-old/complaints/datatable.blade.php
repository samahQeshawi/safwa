<form method="POST" action=" {{ route('complaint.destroy', $complaint->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('complaint.show', $complaint->id) }} " class="btn btn-info" title=" {{ trans('complaints.show') }}">
            <i class="fas fa-eye"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('complaints.delete') }}"
            onclick="return confirm('{{ trans('complaint.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
