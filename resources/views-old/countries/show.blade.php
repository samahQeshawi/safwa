@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($country->name) ? $country->name : 'Country' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('countries.country.destroy', $country->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('countries.country.index') }}" class="btn btn-primary" title="{{ trans('countries.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>

                    <a href="{{ route('countries.country.create') }}" class="btn btn-success" title="{{ trans('countries.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>

                    <a href="{{ route('countries.country.edit', $country->id ) }}" class="btn btn-primary" title="{{ trans('countries.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('countries.delete') }}" onclick="return confirm(&quot;{{ trans('countries.confirm_delete') }}?&quot;)">
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
            <dt>{{ trans('countries.name') }}</dt>
            <dd>{{ $country->name }}</dd>
            <dt>{{ trans('countries.code') }}</dt>
            <dd>{{ $country->code }}</dd>
            <dt>{{ trans('countries.phone_code') }}</dt>
            <dd>{{ $country->phone_code }}</dd>
            <dt>{{ trans('countries.is_active') }}</dt>
            <dd>{{ ($country->is_active) ? 'Yes' : 'No' }}</dd>

        </dl>
    </div>
    </div>
</div>
</div>

@endsection
