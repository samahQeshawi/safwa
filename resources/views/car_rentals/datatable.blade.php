<form method="POST" action=" {{ route('car_rentals.destroy',  $car_rental->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        @can("view booking")
        <a href=" {{ route('car_rentals.show', $car_rental->id) }} " class="btn btn-info" title=" {{ trans('car_rental.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        @endcan
        @can("edit booking")
        <a href="{{ route('car_rentals.edit', $car_rental->id) }}" class="btn btn-primary" title="{{ trans('car_rental.edit') }}">
            <i class="fas fa-edit"></i>
        </a>
        @endcan
        @can("view booking")
        <a href="{{ route('car_rentals.car_rental.invoice', $car_rental->id) }}" class="btn btn-secondary" title="{{ trans('car_rental.invoice') }}">
            <i class="fas fa-file-invoice"></i>
        </a>     
        @endcan
        @can("delete booking")   
        <button type="submit" class="btn btn-danger" title="{{ trans('car_rental.delete') }}"
            onclick="return confirm('{{ trans('car_rental.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
        @endcan
    </div>
</form>
