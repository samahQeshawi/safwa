@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ !empty($title) ? $title : 'Category' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        @can("view categories")
        <a href="{{ route('categories.category.view_categories',$category->service_id) }}" class="btn btn-primary" title="{{ trans('categories.show_all') }}">
            <i class="fas fa-list-alt"></i>
        </a>
        @endcan
        @can("add categories")
        <a href="{{ route('categories.category.create',['service_type'=>$category->service_id]) }}" class="btn btn-success" title="{{ trans('categories.create') }}">
            <i class="fas fa-plus-circle"></i>
        </a>
        @endcan
    </div>
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

            <form method="POST" action="{{ route('categories.category.update', $category->id) }}" id="edit_category_form" name="edit_category_form" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('categories.form', [
                                        'category' => $category,
                                        'category_config ' => $category_config,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('categories.update') }}">
                    </div>
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection