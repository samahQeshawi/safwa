@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ trans('reports.transactions.model_plural') }}</h1>
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
            <h3 class="card-title">{{ trans('reports.transactions.filters') }}</h3>
        </div>

        <div class="card-body">
            <form method="POST" id="search-form" class="form-inline" role="form">
                <div class="row" style="width:100%;">
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label for="phone" class="mb-2 mr-sm-2">{{ trans('reports.transactions.sender_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="sender_filter" name="sender_filter" required="true">
                                <option value="0">
                                    {{ trans('reports.transactions.sender_filter__placeholder') }}</option>
                                    @foreach ($users as $key => $us)
                                    <option value="{{ $key }}">
                                        {{ $us }}
                                    </option>
                                    @endforeach                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="keyword" class="mb-2 mr-sm-2">{{__('reports.transactions.keyword_filter')}}</label>
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
                            <th>{{ trans('reports.transactions.slno') }}</th>
                            <th>{{ trans('reports.transactions.sender_id') }}</th>
                            <th>{{ trans('reports.transactions.receiver_id') }}</th>
                            <th>{{ trans('reports.transactions.booking_id') }}</th>
                            <th>{{ trans('reports.transactions.amount') }}</th>
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
                    url: "{{ route('transactions.reports.listing') }}",
                    data: function (d) {
                        d.sender = $('#sender_filter').val();
                        d.keyword = $('#keyword').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'sender.name', name: 'sender',"defaultContent": ""},
                    {data: 'receiver.name', name: 'receiver',"defaultContent": ""},
                    {data: 'booking.booking_no', name: 'booking',"defaultContent": ""},
                    {data: 'amount', name: 'amount'},
                ],
            });
            $('#search-form').on('submit', function(e) {
                table.draw();
                e.preventDefault();
            }); 
            $('#export-excel').on('click', function(e) {
                e.preventDefault();
                var sender_id = $('#sender_filter').val();
                var keyword = $('#keyword').val();
                window.location = "{{ route('transactions.excel.report') }}" + '?sender_id='+ sender_id +'&keyword='+ keyword;
            });

            $('#export-pdf').on('click', function(e) {
                e.preventDefault();
                var sender_id = $('#sender_filter').val();
                var keyword = $('#keyword').val();
                window.location = "{{ route('transactions.pdf.report') }}" + '?sender_id='+ sender_id +'&keyword='+ keyword;
            });            
    } );
</script>
@stop
