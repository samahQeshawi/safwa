
<div class="form-group {{ $errors->has('user_type') ? 'has-error' : '' }}">
    <label for="user_type" class="col-md-2 control-label">{{ trans('permission.role') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="user_type" type="text" id="user_type" value="{{ old('user_type', optional($permission)->user_type) }}" minlength="1" placeholder="{{ trans('permission.name__placeholder') }}">
        {!! $errors->first('user_type', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<table  class="display table table-striped">
<tr>
    <th></th>
    <th>{{ trans('permission.view') }}</th>
    <th>{{ trans('permission.add') }}</th>
    <th>{{ trans('permission.edt') }}</th>
    <th>{{ trans('permission.delete') }}</th>
</tr>
@foreach($role_master as $perm)
<tr>
    <td>{{$perm->name}}</td>
    <td><div class="checkbox">
            
            <input class="" name="role_permission_id[{{$perm->id}}][view]" type="checkbox" value="1" @if(isset($permission_roles[$perm->id]) && $permission_roles[$perm->id]['view'] == 1)  checked @endif >
               
        </div>
    </td>
    <td><div class="checkbox">
            
            <input class="" name="role_permission_id[{{$perm->id}}][add]" type="checkbox" value="1" @if(isset($permission_roles[$perm->id]) && $permission_roles[$perm->id]['add'] == 1)  checked @endif >
               
        </div>
    </td>
     <td><div class="checkbox">
            
            <input class="" name="role_permission_id[{{$perm->id}}][edit]" type="checkbox" value="1" @if(isset($permission_roles[$perm->id]) && $permission_roles[$perm->id]['edit'] == 1)  checked @endif >
               
        </div>
    </td>
     <td><div class="checkbox">
            
            <input class="" name="role_permission_id[{{$perm->id}}][delete]" type="checkbox" value="1" @if(isset($permission_roles[$perm->id]) && $permission_roles[$perm->id]['delete'] == 1)  checked @endif>
               
        </div>
    </td>
</tr>
@endforeach
</table>

