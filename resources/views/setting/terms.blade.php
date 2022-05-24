@extends('adminlte::page')



@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('setting.terms') }}</h1>
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
                <div class="form-group {{ $errors->has('terms_conditions') ? 'has-error' : '' }}">
                    <label for="terms_conditions" class="col-md-2 control-label">{{ optional($terms)->name }}</label>
                    <div class="col-md-10">
                        <textarea class="form-control  @if(optional($terms)->is_editor) text-editor @endif" name="terms_conditions" type="text" id="terms_conditions" rows="6" placeholder="{{ trans('setting.terms_description__placeholder') }}">{{ old('terms_conditions', optional($terms)->value) }}</textarea>
                        {!! $errors->first('terms_conditions', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" name="setting_add" value="{{ trans('setting.setting_update') }}">
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
        height: 400,
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

