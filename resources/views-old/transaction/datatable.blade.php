<form method="POST" action=" {{ route('transaction.destroy', $transaction->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('transaction.show', $transaction->id) }} " class="btn btn-info" title=" {{ trans('transaction.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('transaction.edit', $transaction->id) }}" class="btn btn-primary" title="{{ trans('transaction.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('transaction.delete') }}"
            onclick="return confirm('{{ trans('transaction.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
