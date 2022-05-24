<form method="POST" action=" {{ route('car.destroy', $car->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('car.show', $car->id) }} " class="btn btn-info" title=" {{ trans('car.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('car.edit', ['car' => $car->id, 'service_type'=>$car->service_id]) }}" class="btn btn-primary" title="{{ trans('car.edit') }}">
            <i class="fas fa-edit"></i>
        </a>

        <button type="submit" class="btn btn-danger" title="{{ trans('car.delete') }}"
            onclick="return confirm('{{ trans('car.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
