@extends('adminlte::page')

@section('content_header')
        @if($service_id == '1' )
        <h1 class="m-0 text-dark">{{ trans('categories.airport') }}</h1>
        @elseif($service_id == '2')
        <h1 class="m-0 text-dark">{{ trans('categories.taxi') }}</h1>       
        @elseif($service_id == '3')
        <h1 class="m-0 text-dark">{{ trans('categories.rent') }}</h1>
        @elseif($service_id == '5')
        <h1 class="m-0 text-dark">{{ trans('categories.smart') }}</h1>
        @endif
    <div class="btn-group btn-group-sm pull-right" role="group">
        <a href="{{ route('categories.category.create',['service_type'=>$service_id]) }}" class="btn btn-success" title="{{ trans('categories.create') }}">
            <i class="fas fa-plus-circle"></i>
        </a>
    </div>
@stop

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="panel panel-default">
<div class="card card-primary card-outline">
    <div class="card-body">

        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table id="dataList" class="display table table-striped">
                    <thead>
                        <tr>
                            <th>{{ trans('categories.slno') }}</th>
                            <th>{{ trans('categories.category') }}</th>
                            <th>{{ trans('categories.status') }}</th>

                            <th></th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>

</div>
        </div>
    </div>
@endsection
@section('plugins.Datatables', true)
@section('js')
<script>
    $(document).ready(function() {
            var table = $('#dataList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('categories/category_type').'/'.$service_id }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'category', name: 'category'},
                    {data: 'is_active', name: 'is_active'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
    } );
</script>
@stop
