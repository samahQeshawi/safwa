@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ trans('reports.bookings.model_plural') }}</h1>
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
            <h3 class="card-title">{{ trans('reports.branches.filters') }}</h3>
        </div>

        <div class="card-body">
            <form method="POST" id="search-form" class="form-inline" role="form">
                <div class="row" style="width:100%;">
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label for="phone" class="mb-2 mr-sm-2">{{ trans('reports.bookings.car_type_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="car_type_filter" name="car_type_filter" required="true">
                                <option value="0">
                                    {{ trans('reports.bookings.car_type_filter__placeholder') }}</option>
                                @foreach ($car_type as $key => $ct)
                                <option value="{{ $key }}">
                                    {{ $ct }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="keyword" class="mb-2 mr-sm-2">{{__('reports.bookings.keyword_filter')}}</label>
                            <input type="textbox" class="form-control mb-2 mr-sm-2" name="keyword" id="keyword"
                                value="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group "> 
                            <label for="phone" class="mb-2 mr-sm-2">{{ trans('reports.bookings.start_date_filter') }}</label>  
                            <input  class="form-control  mb-2 mr-sm-2 date-picker" id="start_date_filter" name="start_date_filter" autocomplete="off" />
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
                            <th>{{ trans('reports.bookings.slno') }}</th>
                            <th>{{ trans('reports.bookings.customer_id') }}</th>
                            <th>{{ trans('reports.bookings.booking_no') }}</th>
                            <th>{{ trans('reports.bookings.distance') }}</th>
                            <th>{{ trans('reports.bookings.amount') }}</th>
                            <th>{{ trans('reports.bookings.start_address') }}</th>
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
                    url: "{{ route('bookings.reports.listing') }}",
                    data: function (d) {
                        d.car_type = $('#car_type_filter').val();
                        d.start_date = $('#start_date_filter').val();
                        d.keyword = $('#keyword').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'customer.name', name: 'customer_id'},
                    {data: 'booking_no', name: 'booking_no'},
                    {data: 'distance', name: 'distance'},
                    {data: 'amount', name: 'amount'},
                    {data: 'start_address', name: 'start_address'},
                ]
            });
            $('#search-form').on('submit', function(e) {
                table.draw();
                e.preventDefault();
            }); 
            $('#export-excel').on('click', function(e) {
                e.preventDefault();
                var car_type = $('#car_type_filter').val();
                var start_date = $('#start_date_filter').val();
                var keyword = $('#keyword').val();
                window.location = "{{ route('bookings.excel.report') }}" + '?car_type='+ car_type +'&start_date='+ start_date +'&keyword='+ keyword;
            });

            $('#export-pdf').on('click', function(e) {
                e.preventDefault();
                var car_type = $('#car_type_filter').val();
                var start_date = $('#start_date_filter').val();
                var keyword = $('#keyword').val();
                window.location = "{{ route('bookings.pdf.report') }}" + '?car_type='+ car_type +'&start_date='+ start_date +'&keyword='+ keyword;
            });  
            $('.date-picker').datepicker({
                   format: 'd-mm-yyyy'
            });                       
    } );

</script>
@stop
