@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ trans('reports.cars.model_plural') }}</h1>
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
            <h3 class="card-title">{{ trans('reports.cars.filters') }}</h3>
        </div>

        <div class="card-body">
            <form method="POST" id="search-form" class="form-inline" role="form">
                <div class="row" style="width:100%;">
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label for="branch_filter" class="mb-2 mr-sm-2">{{ trans('reports.cars.branch_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="branch_filter" name="branch_filter" required="true">
                                <option value="0">
                                    {{ trans('car.branch_filter__placeholder') }}</option>
                                @foreach ($branchs as $key => $br)
                                <option value="{{ $key }}">
                                    {{ $br }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label for="category_filter" class="mb-2 mr-sm-2">{{ trans('reports.cars.category_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="category_filter" name="category_filter" required="true">
                                <option value="0">
                                    {{ trans('reports.cars.category_filter__placeholder') }}</option>
                                @foreach ($categories as $key => $cat)
                                <option value="{{ $key }}">
                                    {{ $cat }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label for="car_make_filter" class="mb-2 mr-sm-2">{{ trans('reports.cars.car_make_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="car_make_filter" name="car_make_filter" required="true">
                                <option value="0">
                                    {{ trans('reports.cars.car_make_filter__placeholder') }}</option>
                                @foreach ($carmake as $key => $cm)
                                <option value="{{ $key }}">
                                    {{ $cm }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label for="car_model_filter" class="mb-2 mr-sm-2">{{ trans('reports.cars.car_model_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="car_model_filter" name="car_model_filter" required="true">
                                <option value="0">
                                    {{ trans('reports.cars.car_model_filter__placeholder') }}</option>
                                @foreach ($carmodel as $cd)
                                <option value="{{ $cd }}">
                                    {{ $cd }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>                    
                </div>
                <div class="row" style="width:100%;">
                    <div class="col-md-4">
                        <div class="form-group "> 
                            <label for="phone" class="mb-2 mr-sm-2">{{ trans('reports.cars.keyword_filter') }}</label>  
                            <input  class="form-control  mb-2 mr-sm-2" id="keyword_filter" name="keyword_filter" autocomplete="off" />
                        </div>                        
                    </div>                    
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
                            <th>{{ trans('reports.cars.slno') }}</th>
                            <th>{{ trans('reports.cars.car_name') }}</th>
                            <th>{{ trans('reports.cars.car_make') }}</th>
                            <th>{{ trans('reports.cars.model_year') }}</th>
                            <th>{{ trans('reports.cars.category') }}</th>
                            <th>{{ trans('reports.cars.registration_no') }}</th>
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
                    url: "{{ route('cars.reports.listing') }}",
                    data: function (d) {
                        d.branch = $('#branch_filter').val();
                        d.category = $('#category_filter').val();
                        d.car_make = $('#car_make_filter').val();
                        d.car_model = $('#car_model_filter').val();
                        d.keyword = $('#keyword_filter').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'car_name', name: 'car_name'},
                    {data: 'carmake.car_make', name: 'car_make'},
                    {data: 'model_year', name: 'model_year'},
                    {data: 'category.category', name: 'category'},
                    {data: 'registration_no', name: 'registration_no'},
                ]
            });
            $('#search-form').on('submit', function(e) {
                table.draw();
                e.preventDefault();
            }); 
            $('#export-excel').on('click', function(e) {
                e.preventDefault();
                var branch = $('#branch_filter').val();
                var category = $('#category_filter').val();
                var car_make = $('#car_make_filter').val();
                var car_model = $('#car_model_filter').val();
                var keyword = $('#keyword_filter').val();
                window.location = "{{ route('cars.excel.report') }}" + '?branch='+ branch +'&category='+ category  +'&car_make='+ car_make   +'&car_model='+ car_model  +'&keyword='+ keyword;
            });

            $('#export-pdf').on('click', function(e) {
                e.preventDefault();
                var branch = $('#branch_filter').val();
                var category = $('#category_filter').val();
                var car_make = $('#car_make_filter').val();
                var car_model = $('#car_model_filter').val();
                var keyword = $('#keyword_filter').val();
                window.location = "{{ route('cars.pdf.report') }}"+ '?branch='+ branch +'&category='+ category  +'&car_make='+ car_make   +'&car_model='+ car_model  +'&keyword='+ keyword;
            });                        
    } );

</script>
@stop
