<form method="POST" action=" {{ route('customer.destroy', $customer->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        @can("view customers")
        <a href=" {{ route('customer.show', $customer->id) }} " class="btn btn-info" title=" {{ trans('customer.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        @endcan
        @can("edit customers")
        <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-primary" title="{{ trans('customer.edit') }}">
            <i class="fas fa-edit"></i>
        </a>
        @endcan
        @can("delete customers")
        <button type="submit" class="btn btn-danger" title="{{ trans('customer.delete') }}"
            onclick="return confirm('{{ trans('customer.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
        @endcan
    </div>
</form>
