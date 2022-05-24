@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Category' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('categories.category.destroy', $category->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    @can("view categories")
                    <a href="{{ route('categories.category.view_categories', $category->service_id) }}" class="btn btn-primary" title="{{ trans('categories.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>
                    @endcan
                    @can("add categories")
                    <a href="{{ route('categories.category.create',['service_type'=>$category->service_id]) }}" class="btn btn-success" title="{{ trans('categories.create') }}">
                        <i class="fas fa-plus-circle"></i>
                    </a>
                    @endcan
                    @can("edit categories")
                    <a href="{{ route('categories.category.edit', ['category' => $category->id, 'service_type'=>$category->service_id]) }}" class="btn btn-primary" title="{{ trans('categories.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    @endcan
                    @can("delete categories")
                    <button type="submit" class="btn btn-danger" title="{{ trans('categories.delete') }}" onclick="return confirm(&quot;{{ trans('categories.confirm_delete') }}?&quot;)">
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
                    @php
                            $title = "Taxi";
                            if( $category->service->service == "Request Taxi"){
                                    $title = "Taxi";
                            }elseif( $category->service->service == "Airport Taxi"){
                                $title = "Airport Taxi";
                            }elseif( $category->service->service == "Rent Car"){
                                $title = " Rent Car";
                            }


                    @endphp
                    <div class="card-header text-white bg-primary mb-3">{{ $title}} Information</div>
                    <div class="card-body">
                         <div class="row">
                            <div class="col md-6">
                                 <dt>{{ trans('categories.category') }}</dt>
                                <dd>{{ $category->category }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('categories.service_id') }}</dt>
                                 @if( $category->service->service == "Request Taxi")
                                        Taxi
                                 @else

                                <dd>{{ $category->service->service }}</dd>
                                 @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('categories.image_file') }}</dt>
                                @if($category->image_file)
                                    <dd><img src="{{ url('storage/app/'.$category->image_file) }}" width="100px"/></dd>
                                @endif 
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('categories.is_active') }}</dt>
                                <dd>{{ ($category->is_active) ? 'Yes' : 'No' }}</dd>
                            </div>
                        </div>
                        @if( $category->service->service != "Rent Car")
                         <div class="row">
                            <div class="col md-6">
                               
                                <dt>{{ trans('categories.minimum_charge') }}</dt>
                                <dd>{{ $category->categoryConfiguration->minimum_charge }}</dd>
                            </div>
                            <div class="col md-6">
                                 
                              
                                <dt>{{ trans('categories.km_charge') }}</dt>
                                <dd>{{ $category->categoryConfiguration->km_charge }}</dd>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col md-6">
                               
                                <dt>{{ trans('categories.cancellation_charge') }}</dt>
                                <dd>{{ $category->categoryConfiguration->cancellation_charge }}</dd>
                            </div>
                            <div class="col md-6">
                                 
                              
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
        </div>
    </div>
    </div>
</div>
</div>

@endsection
