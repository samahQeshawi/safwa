@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ trans('reports.car_rentals.model_plural') }}</h1>
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
            <h3 class="card-title">{{ trans('reports.car_rentals.filters') }}</h3>
        </div>

        <div class="card-body">
            <form method="POST" id="search-form" class="form-inline" role="form">
                <div class="row" style="width:100%;">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="keyword" class="mb-2 mr-sm-2">{{__('reports.car_rentals.keyword_filter')}}</label>
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
                            <th>{{ trans('reports.car_rentals.slno') }}</th>
                            <th>{{ trans('reports.car_rentals.booking_no') }}</th>
                            <th>{{ trans('reports.car_rentals.user') }}</th>
                            <th>{{ trans('reports.car_rentals.pickup_on') }}</th>
                            <th>{{ trans('reports.car_rentals.dropoff_on') }}</th>
                            <th>{{ trans('reports.car_rentals.amount') }}</th>
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
                    url: "{{ route('car_rentals.reports.listing') }}",
                    data: function (d) {
                        d.keyword = $('#keyword').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'booking_no', name: 'booking_no'},
                    {data: 'user.name', name: 'name'},
                    {data: 'pickup_on', name: 'pickup_on'},
                    {data: 'dropoff_on', name: 'dropoff_on'},
                    {data: 'amount', name: 'amount'},
                ]
            });
            $('#search-form').on('submit', function(e) {
                table.draw();
                e.preventDefault();
            }); 
            $('#export-excel').on('click', function(e) {
                e.preventDefault();
                var keyword = $('#keyword').val();
                window.location = "{{ route('car_rentals.excel.report') }}" + '?keyword='+ keyword;
            });

            $('#export-pdf').on('click', function(e) {
                e.preventDefault();
                var keyword = $('#keyword').val();
                window.location = "{{ route('car_rentals.pdf.report') }}" + '?keyword='+ keyword;
            });                       
    } );

</script>
@stop
