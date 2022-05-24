<form method="POST" action=" {{ route('companies.company.destroy', $company->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        @can("view companies")
        <a href=" {{ route('companies.company.show', $company->id) }} " class="btn btn-info" title=" {{ trans('companies.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        @endcan
        @can("edit companies")
        <a href="{{ route('companies.company.edit', $company->id) }}" class="btn btn-primary" title="{{ trans('companies.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

        @endcan
        @can("delete companies")
        <button type="submit" class="btn btn-danger" title="{{ trans('companies.delete') }}"
            onclick="return confirm('{{ trans('companies.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
        @endcan
    </div>
</form>
