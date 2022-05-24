@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($company->name) ? $company->name : 'Company' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('companies.company.destroy', $company->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('companies.company.index') }}" class="btn btn-primary" title="{{ trans('companies.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>

                    <a href="{{ route('companies.company.create') }}" class="btn btn-success" title="{{ trans('companies.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>

                    <a href="{{ route('companies.company.edit', $company->id ) }}" class="btn btn-primary" title="{{ trans('companies.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('companies.delete') }}" onclick="return confirm(&quot;{{ trans('companies.confirm_delete') }}?&quot;)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
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
            <dt>{{ trans('companies.name') }}</dt>
            <dd>{{ $company->name }}</dd>
            <dt>{{ trans('companies.logo') }}</dt>
            @if($company->profile_image)
                <dd><img src="{{ url('storage/app/'.$company->profile_image) }}" width="100px"/></dd>
            @endif
            <dt>{{ trans('companies.email') }}</dt>
            <dd>{{ $company->email }}</dd>
            <dt>{{ trans('companies.phone') }}</dt>
            <dd>{{ $company->country_code }}  {{ $company->phone }}</dd>
            <dt>{{ trans('companies.address') }}</dt>
            <dd>{{ $company->address }}</dd>
            <dt>{{ trans('companies.city') }}</dt>
            <dd>{{ $company->city->name }}</dd>
            <dt>{{ trans('companies.country') }}</dt>
            <dd>{{ $company->country->name }}</dd>
            <dt>{{ trans('companies.latitude') }}</dt>
            <dd>{{ $company->latitude }}</dd>
            <dt>{{ trans('companies.longitude') }}</dt>
            <dd>{{ $company->longitude }}</dd>
            <dt>{{ trans('companies.cr_no') }}</dt>
            <dd>{{ $company->company->cr_no }}</dd>
            <dt>{{ trans('companies.cr_doc') }}</dt>
            @if($company->company->cr_doc)
                <dd><img src="{{ url('storage/app/'.$company->company->cr_doc) }}" width="100px"/></dd>
            @endif
            <dt>{{ trans('companies.is_active') }}</dt>
            <dd>{{ ($company->is_active) ? 'Yes' : 'No' }}</dd>
            <dt>{{ trans('companies.created_at') }}</dt>
            <dd>{{ $company->company->created_at }}</dd>
            <dt>{{ trans('companies.updated_at') }}</dt>
            <dd>{{ $company->company->updated_at }}</dd>

        </dl>
    </div>
    </div>
</div>
</div>

@endsection
