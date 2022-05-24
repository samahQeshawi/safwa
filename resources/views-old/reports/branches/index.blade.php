@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ trans('reports.branches.model_plural') }}</h1>
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
                            <label for="phone" class="mb-2 mr-sm-2">{{ trans('reports.branches.branch_code_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="branch_code_filter" name="branch_code_filter" required="true">
                                <option value="0">
                                    {{ trans('reports.branches.branch_code_filter__placeholder') }}</option>
                                @foreach ($branch_code as $key => $bc)
                                <option value="{{ $bc }}">
                                    {{ $bc }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label for="phone" class="mb-2 mr-sm-2">{{ trans('reports.branches.city_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="city_filter" name="city_filter" required="true">
                                <option value="0">
                                    {{ trans('reports.branches.city_filter__placeholder') }}</option>
                                @foreach ($cities as $key => $cty)
                                <option value="{{ $key }}">
                                    {{ $cty }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="keyword" class="mb-2 mr-sm-2">{{__('reports.branches.keyword_filter')}}</label>
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
                            <th>{{ trans('reports.branches.slno') }}</th>
                            <th>{{ trans('reports.branches.name') }}</th>
                            <th>{{ trans('reports.branches.branch_code') }}</th>
                            <th>{{ trans('reports.branches.phone') }}</th>
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
                    url: "{{ route('branches.reports.listing') }}",
                    data: function (d) {
                        d.branch_code = $('#branch_code_filter').val();
                        d.city = $('#city_filter').val();
                        d.keyword = $('#keyword').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'branch_code', name: 'branch_code'},
                    {data: 'phone', name: 'phone'},
                ],
            });
            $('#search-form').on('submit', function(e) {
                table.draw();
                e.preventDefault();
            }); 
            $('#export-excel').on('click', function(e) {
                e.preventDefault();
                var branch_code = $('#branch_code_filter').val();
                var city = $('#city_filter').val();
                var keyword = $('#keyword').val();
                window.location = "{{ route('branches.excel.report') }}" + '?branch_code='+ branch_code +'&city='+ city  +'&keyword='+ keyword;
            });

            $('#export-pdf').on('click', function(e) {
                e.preventDefault();
                var branch_code = $('#branch_code_filter').val();
                var city = $('#city_filter').val();
                var keyword = $('#keyword').val();
                window.location = "{{ route('branches.pdf.report') }}" + '?branch_code='+ branch_code +'&city='+ city  +'&keyword='+ keyword;
            });            
    } );
</script>
@stop
