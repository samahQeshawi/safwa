<form method="POST" action=" {{ route('coupon.destroy', $coupon->id) }}" accept-charset="UTF-8">
    <input name="_method" value="DELETE" type="hidden">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('coupon.show', $coupon->id) }} " class="btn btn-info" title=" {{ trans('coupon.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn btn-primary" title="{{ trans('coupon.edit') }}">
            <i class="fas fa-edit"></i>
        </a>
{{--
        <a href="{{ route('coupon_reports.view_coupons', $coupon->coupon_code) }}" class="btn btn-success" title="{{ trans('coupon.coupon_report') }}">
            <i class="fas fa-car"></i>
        </a> --}}
        <button type="submit" class="btn btn-danger" title="{{ trans('coupon.delete') }}"
            onclick="return confirm('{{ trans('coupon.confirm_delete') }}')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>
</form>
