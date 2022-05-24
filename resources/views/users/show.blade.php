@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($user->name) ? $user->name : 'User' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('users.user.destroy', $user->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('users.user.index') }}" class="btn btn-primary" title="{{ trans('users.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>

                   {{--  <a href="{{ route('users.user.create') }}" class="btn btn-success" title="{{ trans('users.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>

                    <a href="{{ route('users.user.edit', $user->id ) }}" class="btn btn-primary" title="{{ trans('users.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('users.delete') }}" onclick="return confirm(&quot;{{ trans('users.confirm_delete') }}?&quot;)">
                        <i class="fas fa-trash-alt"></i>
                    </button> --}}
                </div>
            </form>
    </div>
@stop

@section('content')

<div class="panel panel-default">
<div class="card card-primary card-outline">
<div class="card-body">
    <div class="panel-body">
         <div class="card bg-light mb-3">
                            <div class="card-header text-white bg-primary mb-3">User Information</div>
            <div class="card-body">
                                 <div class="row">
                                    <div class="col md-6">        
                                             <dt>{{ trans('users.name') }}</dt>
            <dd>{{ $user->name }}</dd>
                                    </div>
                                    <div class="col md-6"> 
                                 <dt>{{ trans('users.phone') }}</dt>
            <dd>{{ $user->phone }}</dd>
                                    </div>
                                </div>        
                                <div class="row">
                                    <div class="col md-6">        
                                 <dt>{{ trans('users.email') }}</dt>
            <dd>{{ $user->email }}</dd>
                                    </div>
                                    <div class="col md-6"> 
                                       <dt>{{ trans('users.city') }}</dt>
            <dd>{{ optional(optional($user)->city)->name }}</dd>
                                    </div>
                                </div>    

                                <div class="row">
                                    <div class="col md-6">        
                                 <dt>{{ trans('users.country') }}</dt>
            <dd>{{ optional(optional($user)->country)->name }}</dd>
                                    </div>
                                    <div class="col md-6"> 
                                        <dt>{{ trans('users.user_type_id') }}</dt>
            <dd>{{ optional(optional($user)->userType)->user_type }}</dd>
                                    </div>
                                </div>  
                                 <div class="row">
                                    <div class="col md-6">        
                                 <dt>{{ trans('users.created_at') }}</dt>
            <dd>{{ $user->created_at }}</dd>
                                    </div>
                                    <div class="col md-6"> 
                                         <dt>{{ trans('users.updated_at') }}</dt>
            <dd>{{ $user->updated_at }}</dd>
                                    </div>
                                </div>  
                            </div>
                        
                            </div>
                        </div>
                    </div>

    </div>
    </div>
</div>
</div>

@endsection
