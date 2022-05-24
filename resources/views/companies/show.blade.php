@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($company->name) ? $company->name : 'Company' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('companies.company.destroy', $company->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    @can("view companies")
                    <a href="{{ route('companies.company.index') }}" class="btn btn-primary" title="{{ trans('companies.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>
                    @endcan
                    @can("add companies")
                    <a href="{{ route('companies.company.create') }}" class="btn btn-success" title="{{ trans('companies.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>
                    @endcan
                    @can("edit companies")
                    <a href="{{ route('companies.company.edit', $company->id ) }}" class="btn btn-primary" title="{{ trans('companies.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    @endcan
                    @can("delete companies")
                    <button type="submit" class="btn btn-danger" title="{{ trans('companies.delete') }}" onclick="return confirm(&quot;{{ trans('companies.confirm_delete') }}?&quot;)">
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
                    <div class="card-header text-white bg-primary mb-3">Company Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <dt>{{ trans('companies.name') }}</dt>
                                <dd>{{ $company->name }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('companies.logo') }}</dt>
                                @if($company->profile_image)
                                    <dd><img src="{{ url('storage/app/'.$company->profile_image) }}" width="100px"/></dd>
                                @endif
                            </div>
                            <div class="col md-6">
                               <dt>{{ trans('companies.email') }}</dt>
                                <dd>{{ $company->email }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('companies.phone') }}</dt>
                                <dd>{{ $company->country_code }}  {{ $company->phone }}</dd>
                            </div>
                            <div class="col md-6">
                               <dt>{{ trans('companies.city') }}</dt>
                                <dd>{{ $company->city->name }}</dd>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col md-6">
                               <dt>{{ trans('companies.country') }}</dt>
                               <dd>{{ $company->country->name }}</dd>
                            </div>
                            <div class="col md-6">

                               <dt>{{ trans('companies.is_active') }}</dt>
                               <dd>{{ ($company->is_active) ? 'Yes' : 'No' }}</dd>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col md-6">
                                 <dt>{{ trans('companies.cr_no') }}</dt>
                                 <dd>{{ @$company->company->cr_no }}</dd>
                            </div>
                            <div class="col md-6">
                               <dt>{{ trans('companies.cr_doc') }}</dt>
                                @if(@$company->company->cr_doc)
                                    <dd><img src="{{ url('storage/app/'.$company->company->cr_doc) }}" width="100px"/></dd>
                                @endif

                            </div>
                        </div>
                         <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('companies.created_at') }}</dt>
                                 <dd>{{ $company->created_at }}</dd>
                            </div>
                            <div class="col md-6">
                               <dt>{{ trans('companies.updated_at') }}</dt>
                               <dd>{{ $company->updated_at }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

    </div>
    </div>
</div>
</div>

@endsection
