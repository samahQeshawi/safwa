@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('cartype.model_plural') }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        @can("add setting")
        <a href="{{ route('cartype.create') }}" class="btn btn-success" title="{{ trans('cartype.create') }}">
            <i class="fas fa-plus-circle"></i>
        </a>
        @endcan
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
                            <th>{{ trans('cartype.slno') }}</th>
                            <th>{{ trans('cartype.cartype') }}</th>
                            <th>{{ trans('cartype.seats') }}</th>
                            <th>{{ trans('cartype.status') }}</th>

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
                ajax: "{{ route('cartype.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'seats', name: 'seats'},
                    {data: 'is_active', name: 'is_active'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
    } );
</script>
@stop
