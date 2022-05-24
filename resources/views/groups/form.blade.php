<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title" class="col-md-2 control-label">{{ trans('groups.title') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($group)->title) }}" minlength="1" maxlength="255" required="true" placeholder="{{ trans('groups.title__placeholder') }}">
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description" class="col-md-2 control-label">{{ trans('groups.description') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($group)->description) }}" maxlength="500">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <label for="country_id" class="col-md-2 control-label">Group Members</label>
    <div class="col-md-10">
        <select id="users" class="form-control select2bs4" id="users" name="users[]" multiple="multiple">
        @foreach($users as $key=>$user)
            <option value="{{ $key }}"
                @if(isset($group->users) && in_array($key, old('users', $group->users->pluck('id')->toArray())))
                    selected
                @endif
            >{{ $user }}</option>
        @endforeach
        </select>
    </div>
</div>

<div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
    <label for="is_active" class="col-md-2 control-label">{{ trans('groups.is_active') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', optional($group)->is_active) == '1' ? 'checked' : '' }}>
                {{ trans('groups.is_active_1') }}
            </label>
        </div>

        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>





<div class="row">

    <div class="col-md-12">




      {{-- <select multiple="multiple" size="10" name="duallistbox_demo2[]" class="demo2">
        @foreach ($users as $key => $user)
        <option value="{{ $key }}">
            {{ $user }}
        </option>
        @endforeach --}}
        {{-- <option value="option1">Option 1</option>
        <option value="option2">Option 2</option>
        <option value="option3" selected="selected">Option 3</option>
        <option value="option4">Option 4</option>
        <option value="option5">Option 5</option>
        <option value="option6" selected="selected">Option 6</option>
        <option value="option7">Option 7</option>
        <option value="option8">Option 8</option>
        <option value="option9">Option 9</option>
        <option value="option0">Option 10</option>
        <option value="option0">Option 11</option>
        <option value="option0">Option 12</option>
        <option value="option0">Option 13</option>
        <option value="option0">Option 14</option>
        <option value="option0">Option 15</option>
        <option value="option0">Option 16</option>
        <option value="option0">Option 17</option>
        <option value="option0">Option 18</option>
        <option value="option0">Option 19</option>
        <option value="option0">Option 20</option>
      </select>--}}
      @section('js')
      <script>

                //Initialize Select2 Elements
        //$('.select2bs4').select2({
            //theme: 'bootstrap4'
        //});
        $('#users').select2({
            theme: 'bootstrap4'
        })
        /* var demo2 = $('.demo2').bootstrapDualListbox({
          nonSelectedListLabel: 'Non-selected Drivers',
          selectedListLabel: 'Selected Drivers',
          preserveSelectionOnMove: 'moved',
          moveOnSelect: false,
          //nonSelectedFilter: 'ion ([7-9]|[1][0-2])'
        }); */
      </script>
      @stop
    </div>
  </div>
  <hr>
