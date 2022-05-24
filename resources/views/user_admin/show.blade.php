@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Admin' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('user_admin.destroy', $user_admin->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    @can("view user_manage")
                    <a href="{{ route('user_admin.index') }}" class="btn btn-primary" title="{{ trans('user_admin.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>
                    @endcan
                    @can("add user_manage")
                    <a href="{{ route('user_admin.create') }}" class="btn btn-success" title="{{ trans('user_admin.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>
                    @endcan
                    @can("edit user_manage")
                    <a href="{{ route('user_admin.edit', $user_admin->id ) }}" class="btn btn-primary" title="{{ trans('user_admin.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    @endcan
                    @can("delete user_manage")
                    <button type="submit" class="btn btn-danger" title="{{ trans('user_admin.delete') }}" onclick="return confirm(&quot;{{ trans('user_admin.confirm_delete') }}?&quot;)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    @endcan
                </div>
            </form>
    </div>
@stop

@section('content')

<div class="panel panel-default">
<div class="card card-primary card-outline">
<div class="card-body">
    <div class="panel-body">
        <dl class="dl-horizontal">
             <div class="card bg-light mb-3">
            <div class="card-header text-white bg-primary mb-3">Admin Information</div>
            <div class="card-body">
                                 <div class="row">
                                    <div class="col md-6">        
                                              <dt>{{ trans('user_admin.name') }}</dt>
            <dd>{{ optional($user_admin)->name }}</dd>
                                    </div>
                                    <div class="col md-6"> 
                                  <dt>{{ trans('user_admin.surname') }}</dt>
            <dd>{{ optional($user_admin)->surname }}</dd>
                                    </div>
                                </div>        
                                <div class="row">
                                    <div class="col md-6">        
                                  <dt>{{ trans('user_admin.email') }}</dt>
            <dd>{{ optional($user_admin)->email }}</dd>
                                    </div>
                                    <div class="col md-6"> 
                                       <dt>{{ trans('user_admin.phone') }}</dt>
            <dd>{{ optional($user_admin)->phone }}</dd>
                                    </div>
                                </div>    

                                <div class="row">
                                    <div class="col md-6"> 

                                         
                                       <dt>{{ trans('user_admin.country') }}</dt>
            <dd>{{ optional($user_admin->country)->name }}</dd>
                                    </div>
                                    <div class="col md-6"> <dt>{{ trans('user_admin.city') }}</dt>
            <dd>{{ optional($user_admin->city)->name }}</dd> 
                                    </div>
                                </div>  
                                 <div class="row">
                                    <div class="col md-6"> 
                                         <dt>{{ trans('user_admin.permission') }}</dt>
                                          <dd>{{ $user_admin->permission->user_type }}</dd>
                                    </div>
                                    <div class="col md-6"> 
                                          <dt>{{ trans('user_admin.is_active') }}</dt>
            <dd>{{ ($user_admin->is_active == 'Active') ? 'Yes' : 'No' }}</dd>
                                    </div>
                                </div>  
                                 <div class="row">
                                     <div class="col md-6">     
                                   <dt>{{ trans('user_admin.created_at') }}</dt>
            <dd>{{ $user_admin->created_at }}</dd>
                                    </div>
                                    <div class="col md-6"> 
                                          <dt>{{ trans('user_admin.updated_at') }}</dt>
            <dd>{{ $user_admin->updated_at }}</dd>
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
