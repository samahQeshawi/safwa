<form method="POST" action=" {{ route('paymentmethod.destroy', $paymentmethod->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        @can("view setting")
        <a href=" {{ route('paymentmethod.show', $paymentmethod->id) }} " class="btn btn-info" title=" {{ trans('paymentmethod.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        @endcan
        @can("edit setting")
        <a href="{{ route('paymentmethod.edit', $paymentmethod->id) }}" class="btn btn-primary" title="{{ trans('paymentmethod.edit') }}">
            <i class="fas fa-edit"></i>
        </a>
        @endcan
        @can("delete setting")
        <button type="submit" class="btn btn-danger" title="{{ trans('paymentmethod.delete') }}"
            onclick="return confirm('{{ trans('paymentmethod.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
        @endcan
    </div>
</form>
