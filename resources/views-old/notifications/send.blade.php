@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('notification.send_notification') }}</h1>
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

            <form method="POST" action="{{ route('notification.send_notification') }}" accept-charset="UTF-8" id="create_notification_send_to_form" name="create_notification_send_to_form" class="form-horizontal">
            {{ csrf_field() }}
                <div class="form-group {{ $errors->has('send_to') ? 'has-error' : '' }}">
                    <input type="hidden" name="notification_id" value="{{$notification->id}}"/>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="name" class="control-label">{{ trans('notification.send_to') }}</label>
                        </div>
                        <div class="col-md-10">
                            <div class="col-md-12 p-2">
                                <input type="checkbox" name="all_users" value="4" />
                                <label for ="all_users">{{ trans('notification.all_users') }}</label>
                            </div>                            
                            <div class="col-md-12 p-2">
                                <input type="checkbox" name="all_user_type[]" value="4" />
                                <label for ="all_user_type">{{ trans('notification.all_customers') }}</label>
                            </div>
                            <div class="col-md-12 p-2">
                                <input type="checkbox" name="all_user_type[]" value="3" />
                                <label for ="all_user_type">{{ trans('notification.all_drivers') }}</label>
                            </div>   
                            <div class="col-md-12 p-2">
                                <input type="checkbox" name="all_user_type[]" value="5" />
                                <label for ="all_user_type">{{ trans('notification.all_companies') }}</label>
                            </div> 
                            <div class="col-md-12 p-2">
                                <input type="checkbox" name="all_user_type[]" value="2" />
                                <label for ="all_user_type">{{ trans('notification.all_admins') }}</label>
                            </div>                                                                                                              
                            <div class="col-md-12">
                                <select class="form-control" name="send_to[]" id="send_to" multiple="multiple">
                                    <option value="">{{ trans('notification.send_to__placeholder') }}</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                </div>    
                <div class="form-group {{ $errors->has('send_as') ? 'has-error' : '' }}">
                    <label for="name" class="col-md-2 control-label">{{ trans('notification.send_as') }}</label>
                    <div class="col-md-10">
                        <select class="form-control" name="send_as" id="send_as" required="true">
                            <option value="">{{ trans('notification.send_as__placeholder') }}</option>
                            <option value="sms">{{ trans('notification.sms') }}</option>
                            <option value="push_notification">{{ trans('notification.push_notification') }}</option>
                        </select>
                        {!! $errors->first('send_as', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>                          
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('notification.send') }}">
                    </div>
                </div>

            </form>

        </div>
    </div>
    </div>
    </div>

@endsection

@section('js')
@section('js')
<script type="text/javascript">
    $(function () {
       $('#send_to').select2({
            placeholder: 'Select User',
            ajax: {
                url: '{{ route("notification.search.user") }}',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
    });
</script>
@endsection
