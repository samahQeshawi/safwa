@extends('adminlte::page')



@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('setting.general') }}</h1>
@stop

@section('content')

    <div class="panel panel-default">

<div class="card card-primary card-outline">
    <div class="card-body">

        <div class="panel-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('setting.general.store') }}" accept-charset="UTF-8" id="create_general_form" name="create_general  _form" class="form-horizontal">
            {{ csrf_field() }}
               
                <div class="form-group {{ $errors->has('delivery_amount') ? 'has-error' : '' }}">
                    <label for="delivery_amount" class="col-md-2 control-label">{{ optional($delivery)->name }}</label>
                    <div class="col-md-10">
                        <input class="form-control" name="delivery_amount" type="text" id="delivery_amount" value="{{ old('delivery_amount', optional($delivery)->value) }}" minlength="1" maxlength="300" placeholder="{{ trans('setting.delivery_amount__placeholder') }}" required>
                        {!! $errors->first('delivery_amount', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('tax') ? 'has-error' : '' }}">
                    <label for="tax" class="col-md-2 control-label">{{ optional($tax)->name }}</label>
                    <div class="col-md-10">
                        <input class="form-control" name="tax" type="text" id="tax" value="{{ old('tax', optional($tax)->value) }}" minlength="1" maxlength="300" placeholder="{{ trans('setting.tax__placeholder') }}" required>
                        {!! $errors->first('tax', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" name="setting_add" value="{{ trans('setting.setting_add') }}">
                    </div>
                </div>

            </form>

        </div>
    </div>
    </div>
    </div>

@endsection

@section('js')
<script type="text/javascript">
   $(function () {
    $('.text-editor').summernote({
        height: 100,
        toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph' ] ],
            [ 'insert', [ 'link'] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ]
    });
  })
</script>
@endsection

