<form method="POST" action=" {{ route('services.service.destroy', $service->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('services.service.show', $service->id) }} " class="btn btn-info" title=" {{ trans('services.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('services.service.edit', $service->id) }}" class="btn btn-primary" title="{{ trans('services.edit') }}">
            <i class="fas fa-edit"></i>
        </a>
{{--
        <button type="submit" class="btn btn-danger" title="{{ trans('services.delete') }}"
            onclick="return confirm('{{ trans('services.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button> --}}
    </div>
</form>
