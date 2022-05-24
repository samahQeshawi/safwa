@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('sms.create') }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
<!--         <a href="{{ route('sms.index') }}" class="btn btn-primary" title="{{ trans('cartype.show_all') }}">
            <i class="fas fa-list-alt"></i>
        </a> -->
    </div>
@stop

@section('content')

    <div class="panel panel-default">

<div class="card card-primary card-outline">
    <div class="card-body">
        @if(Session::has('success_message'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {!! session('success_message') !!}

                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
        @endif
        @if(Session::has('error_message'))
            <div class="alert alert-danger">
                <i class="fas fa-check-circle"></i>
                {!! session('error_message') !!}

                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
        @endif        
        <div class="panel-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('sms.send') }}" accept-charset="UTF-8" id="create_send_to_form" name="create_send_to_form" class="form-horizontal">
            {{ csrf_field() }}
                <div class="form-group {{ $errors->has('send_to') ? 'has-error' : '' }}">
                    <label for="name" class="col-md-2 control-label">{{ trans('sms.send_to') }}</label>
                    <div class="col-md-10">
                        <input class="form-control" name="send_to" type="text" id="send_to" value="{{ old('send_to') }}" minlength="1" placeholder="{{ trans('sms.send_to__placeholder') }}">
                        {!! $errors->first('send_to', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
               <div class="form-group {{ $errors->has('text_message') ? 'has-error' : '' }}">
                    <label for="name" class="col-md-2 control-label">{{ trans('sms.text_message') }}</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="text_message"  id="text_message"  minlength="1" placeholder="{{ trans('sms.text_message__placeholder') }}">{{ old('text_message') }}</textarea>
                        {!! $errors->first('text_message', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>                
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('sms.send') }}">
                    </div>
                </div>

            </form>

        </div>
    </div>
    </div>
    </div>

@endsection


