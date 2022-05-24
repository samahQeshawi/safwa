@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Category' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('categories.category.destroy', $category->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('categories.category.view_categories', $category->service_id) }}" class="btn btn-primary" title="{{ trans('categories.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>

                    <a href="{{ route('categories.category.create',['service_type'=>$category->service_id]) }}" class="btn btn-success" title="{{ trans('categories.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>

                    <a href="{{ route('categories.category.edit', ['category' => $category->id, 'service_type'=>$category->service_id]) }}" class="btn btn-primary" title="{{ trans('categories.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('categories.delete') }}" onclick="return confirm(&quot;{{ trans('categories.confirm_delete') }}?&quot;)">
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
            <dt>{{ trans('categories.category') }}</dt>
            <dd>{{ $category->category }}</dd>
            <dt>{{ trans('categories.service_id') }}</dt>
            <dd>{{ $category->service->service }}</dd>
            <dt>{{ trans('categories.image_file') }}</dt>
            @if($category->image_file)
                <dd><img src="{{ url('storage/app/'.$category->image_file) }}" width="100px"/></dd>
            @endif             
            <dt>{{ trans('categories.is_active') }}</dt>
            <dd>{{ ($category->is_active) ? 'Yes' : 'No' }}</dd>

        </dl>
    </div>
    </div>
</div>
</div>

@endsection
