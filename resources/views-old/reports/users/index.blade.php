@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ trans('reports.users.model_plural') }}</h1>
@stop
@section('content')

{{-- Filters --}}
<div class="panel panel-default">
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">{{ trans('reports.users.filters') }}</h3>
        </div>

        <div class="card-body">
            <form method="POST" id="search-form" class="form-inline" role="form">
                <div class="row" style="width:100%;">
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label for="city" class="mb-2 mr-sm-2">{{ trans('reports.users.city_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="city" name="city" required="true">
                                <option value="0">
                                    {{ trans('reports.users.city_filter__placeholder') }}</option>
                                @foreach ($cities as $key => $city)
                                <option value="{{ $key }}">
                                    {{ $city }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label for="user_type"
                                class="mb-2 mr-sm-2">{{ trans('reports.users.user_type_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="user_type" name="user_type" required="true">
                                <option value="0">
                                    {{ trans('reports.users.user_type_filter__placeholder') }}</option>
                                <option value="3">
                                    Driver
                                </option>
                                <option value="4">
                                    Customer
                                </option>
                                <option value="5">
                                    Company
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="keyword" class="mb-2 mr-sm-2">{{__('reports.users.keyword_filter')}}</label>
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
{{-- Filters --}}

<div class="panel panel-default">
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="panel-body panel-body-with-table">
                <div class="table-responsive">
                    <table id="dataList" class="display table table-striped">
                        <thead>
                            <tr>
                                <th>{{ trans('reports.users.slno') }}</th>
                                <th>{{ trans('reports.users.name') }}</th>
                                <th>{{ trans('reports.users.email') }}</th>
                                <th>{{ trans('reports.users.phone') }}</th>
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
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6f'>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
                processing: true,
                serverSide: true,
                ajax: {
                    url:"{{ route('users.reports.listing') }}",
                    data: function (d) {
                        d.city = $('#city').val();
                        d.keyword = $('#keyword').val();
                        d.user_type = $('#user_type').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                ]
            });
            $('#search-form').on('submit', function(e) {
                table.draw();
                e.preventDefault();
            });

            $('#export-excel').on('click', function(e) {
                e.preventDefault();
                var city = $('#city').val();
                var user_type = $('#user_type').val();
                var keyword = $('#keyword').val();
                window.location = "{{ route('users.excel.report') }}" + '?city='+ city +'&user_type='+ user_type +'&keyword='+ keyword;
            });

            $('#export-pdf').on('click', function(e) {
                e.preventDefault();
                var city = $('#city').val();
                var user_type = $('#user_type').val();
                var keyword = $('#keyword').val();
                window.location = "{{ route('users.pdf.report') }}" + '?city='+ city +'&user_type='+ user_type +'&keyword='+ keyword;
            });
    } );
</script>
@stop
