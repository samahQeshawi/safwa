@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ trans('reports.wallets.model_plural') }}</h1>
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
            <h3 class="card-title">{{ trans('reports.wallets.filters') }}</h3>
        </div>

        <div class="card-body">
            <form method="POST" id="search-form" class="form-inline" role="form">
                <div class="row" style="width:100%;">
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label for="phone" class="mb-2 mr-sm-2">{{ trans('reports.wallets.user_type_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="user_type_filter" name="user_type_filter" required="true">
                                <option value="0">
                                    {{ trans('reports.wallets.user_type_filter__placeholder') }}</option>
                                @foreach ($user_type as $key => $ut)
                                <option value="{{ $key }}">
                                    {{ $ut }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="keyword" class="mb-2 mr-sm-2">{{__('reports.wallets.keyword_filter')}}</label>
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
                            <th>{{ trans('reports.wallets.slno') }}</th>
                            <th>{{ trans('reports.wallets.user') }}</th>
                            <th>{{ trans('reports.wallets.user_type') }}</th>
                            <th>{{ trans('reports.wallets.amount') }}</th>
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
                    url: "{{ route('wallets.reports.listing') }}",
                    data: function (d) {
                        d.user_type = $('#user_type_filter').val();
                        d.keyword = $('#keyword').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'user.name', name: 'name'},
                    {data: 'user.user_type.user_type', name: 'user_type'},
                    {data: 'amount', name: 'amount'},
                ],
            });
            $('#search-form').on('submit', function(e) {
                table.draw();
                e.preventDefault();
            }); 
            $('#export-excel').on('click', function(e) {
                e.preventDefault();
                var user_type = $('#user_type_filter').val();
                var keyword = $('#keyword').val();
                window.location = "{{ route('wallets.excel.report') }}" + '?user_type='+ user_type +'&keyword='+ keyword;
            });

            $('#export-pdf').on('click', function(e) {
                e.preventDefault();
                var user_type = $('#user_type_filter').val();
                var keyword = $('#keyword').val();
                window.location = "{{ route('wallets.pdf.report') }}" + '?user_type='+ user_type +'&keyword='+ keyword;
            });            
    } );
</script>
@stop
