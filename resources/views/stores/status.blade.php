<form id="status" method="POST" action=" {{ route('stores.store.update', $store->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="PUT">
    {{ csrf_field() }}
    <div class="btn-group btn-group-xs pull-right" role="group">
        <div class="custom-control custom-switch">
            <input name="status" type="checkbox" class="custom-control-input" value="1" id="customSwitch1" title="{{ trans('stores.delete') }}"
            onclick="return updateStatus()">
            <label class="custom-control-label" for="customSwitch1">Switch staus</label>
          </div>
    </div>
</form>
<script>
function updateStatus(){
    $("#status").submit();
    /* if (confirm({{ trans('stores.confirm_delete') }})){
        $("#status").submit();
        return true;
    }
    return false; */
}
</script>
