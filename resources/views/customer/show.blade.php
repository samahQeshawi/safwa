@extends('adminlte::page')
@section('content_header')
<h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Customer' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    <form method="POST" action="{!! route('customer.destroy', $customer->id) !!}" accept-charset="UTF-8">
        <input name="_method" value="DELETE" type="hidden">
        {{ csrf_field() }}
        <div class="btn-group btn-group-sm" role="group">
            @can("view customers")
            <a href="{{ route('customer.index') }}" class="btn btn-primary" title="{{ trans('customer.show_all') }}">
                <i class="fas fa-list-alt"></i>
            </a>
            @endcan
            @can("add customers")
            <a href="{{ route('customer.create') }}" class="btn btn-success" title="{{ trans('customer.create') }}">
                <i class="fas fa-plus-circle"></i>
            </a>
            @endcan
            @can("edit customers")
            <a href="{{ route('customer.edit', $customer->id ) }}" class="btn btn-primary"
                title="{{ trans('customer.edit') }}">
                <i class="fas fa-edit"></i>
            </a>
            @endcan
            @can("delete customers")
            <button type="submit" class="btn btn-danger" title="{{ trans('customer.delete') }}"
                onclick="return confirm(&quot;{{ trans('customer.confirm_delete') }}?&quot;)">
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
                <div class="card bg-light mb-3">
                    <div class="card-header text-white bg-primary mb-3">Personal Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <dt>{{ trans('customer.profile_image') }}</dt>
                                @if($customer->profile_image)
                                <dd><img src="{{ url('storage/app/'.$customer->profile_image) }}" width="100px" /></dd>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('users.name') }}</dt>
                                <dd>{{ optional($customer)->name }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('customer.surname') }}</dt>
                                <dd>{{ optional($customer)->surname }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('customer.email') }}</dt>
                                <dd>{{ optional($customer)->email }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('customer.phone') }}</dt>
                                <dd>{{ optional($customer)->phone }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('customer.gender') }}</dt>
                                <dd>{{ optional($customer)->gender }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('customer.dob') }}</dt>
                                <dd>{{ @$customer->customer->dob }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('customer.country') }}</dt>
                                <dd>{{ optional($customer->country)->name }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('customer.city') }}</dt>
                                <dd>{{ optional($customer->city)->name }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('customer.nationality_id') }}</dt>
                                <dd>{{ optional(@$customer->customer->nationality)->name }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('customer.national_id') }}</dt>
                                <dd>{{ @$customer->customer->national_id }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('customer.is_active') }}</dt>
                                <dd>{{ optional($customer->customer)->is_active }}</dd>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card bg-light mb-3">
                    <div class="card-header text-white bg-primary mb-3">Attachments</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('customer.national_file') }}</dt>
                                @if(@$customer->customer->national_file)
                                <dd><img src="{{ url('storage/app/'.optional($customer->customer)->national_file) }}"
                                        width="100px" />
                                </dd>
                                @endif
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('customer.license_file') }}</dt>
                                @if(optional($customer->customer)->license_file)
                                <dd><img src="{{ url('storage/app/'.optional($customer->customer)->license_file) }}"
                                        width="100px" /></dd>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card bg-light mb-3">
                    <div class="card-header text-white bg-primary mb-3">Other Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('customer.created_at') }}</dt>
                                <dd>{{ $customer->created_at }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('customer.updated_at') }}</dt>
                                <dd>{{ $customer->updated_at }}</dd>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>
@endsection
