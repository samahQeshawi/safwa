@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ trans('reports.trips.model_plural') }}</h1>
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
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">{{ trans('reports.trips.filters') }}</h3>
        </div>

        <div class="card-body">
            <form method="POST" id="search-form" class="form-inline" role="form">
                <div class="row" style="width:100%;">
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label for="phone" class="mb-2 mr-sm-2">{{ trans('reports.trips.trip_status_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="trip_status_filter" name="trip_status_filter" required="true">
                                <option value="0">
                                    {{ trans('reports.trips.trip_status_filter__placeholder') }}</option>
                                <option value="Confirmed">{{ trans('reports.trips.confirmed') }}</option>
                                <option value="Canceled">{{ trans('reports.trips.canceled') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="keyword" class="mb-2 mr-sm-2">{{__('reports.trips.keyword_filter')}}</label>
                            <input type="textbox" class="form-control mb-2 mr-sm-2" name="keyword" id="keyword"
                                value="">
                        </div>
                    </div>
                </div>
                <div class="row" style="width:100%;">
                    <div class="col-md-1">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mb-2 mr-sm-2">Search</button>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <a id="export-excel" href="#" class="btn bg-gradient-success btn-block">
                            <i class="fas fa-file-excel">&nbsp;Export Excel</i>
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a id="export-pdf" href="#" class="btn bg-gradient-danger btn-block">
                            <i class="fas fa-file-pdf">&nbsp;Export Pdf</i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>        
<div class="card card-primary card-outline">
    <div class="card-body">

        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table id="dataList" class="display table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ trans('reports.trips.slno') }}</th>
                            <th>{{ trans('reports.trips.trip_number') }}</th>
                            <th>{{ trans('reports.trips.trip_status') }}</th>
                            <th>{{ trans('reports.trips.trip_type') }}</th>
                            <th>{{ trans('reports.trips.trip_pick_up') }}</th>
                            <th>{{ trans('reports.trips.trip_drop_off') }}</th>
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
                scrollX : 'false',
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('trips.reports.listing') }}",
                    data: function (d) {
                        d.trip_status = $('#trip_status_filter').val();
                        d.keyword = $('#keyword').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'trip_number', name: 'trip_number'},
                    {data: 'trip_status', name: 'trip_status'},
                    {data: 'trip_type', name: 'trip_type'},
                    {data: 'trip_pick_up', name: 'trip_pick_up'},
                    {data: 'trip_drop_off', name: 'trip_drop_off'},
                ]
            });
            $('#search-form').on('submit', function(e) {
                table.draw();
                e.preventDefault();
            }); 
            $('#export-excel').on('click', function(e) {
                e.preventDefault();
                var trip_status = $('#trip_status_filter').val();
                var keyword = $('#keyword').val();
                window.location = "{{ route('trips.excel.report') }}" + '?trip_status='+ trip_status +'&keyword='+ keyword;
            });

            $('#export-pdf').on('click', function(e) {
                e.preventDefault();
                var trip_status = $('#trip_status_filter').val();
                var keyword = $('#keyword').val();
                window.location = "{{ route('trips.pdf.report') }}" + '?trip_status='+ trip_status +'&keyword='+ keyword;
            });            
    } );
</script>
@stop
