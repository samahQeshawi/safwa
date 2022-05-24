@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('car.model_plural') }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        @can("add cars")
        <a href="{{ route('car.create') }}" class="btn btn-success" title="{{ trans('car.create') }}">
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
            <div class="form-group container-fluid text-center">
                <label class="mb-2 mr-sm-2">{{ trans('car.filters') }} : </label>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" id="search-form" class="form-inline" role="form">
                        <div class="form-group ">
                            <label for="branch_filter" class="mb-2 mr-sm-2">{{ trans('car.branch_filter') }}</label>
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
                        <div class="form-group ">
                            <label for="category_filter" class="mb-2 mr-sm-2">{{ trans('car.category_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="category_filter" name="category_filter" required="true">
                                <option value="0">
                                    {{ trans('car.category_filter__placeholder') }}</option>
                                @foreach ($categories as $key => $cat)
                                <option value="{{ $key }}">
                                    {{ $cat }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ">
                            <label for="car_make_filter" class="mb-2 mr-sm-2">{{ trans('car.car_make_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="car_make_filter" name="car_make_filter" required="true">
                                <option value="0">
                                    {{ trans('car.car_make_filter__placeholder') }}</option>
                                @foreach ($carmake as $key => $cm)
                                <option value="{{ $key }}">
                                    {{ $cm }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ">
                            <label for="car_model_filter" class="mb-2 mr-sm-2">{{ trans('car.car_model_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="car_model_filter" name="car_model_filter" required="true">
                                <option value="0">
                                    {{ trans('car.car_model_filter__placeholder') }}</option>
                                @foreach ($carmodel as $cd)
                                <option value="{{ $cd }}">
                                    {{ $cd }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class="mb-2 mr-sm-2">{{__('car.keyword_filter')}}</label>
                            <input type="textbox" class="form-control mb-2 mr-sm-2" name="keyword" id="keyword"
                                value="">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2 mr-sm-2">{{ trans('car.search') }}</button>
                    </form>
                </div>
            </div>

        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table id="dataList" class="display table table-striped">
                    <thead>
                        <tr>
                            <th>{{ trans('car.slno') }}</th>
                            <th>{{ trans('car.plate_no') }}</th>
                            <th>{{ trans('car.model_year') }}</th>
                            <th>{{ trans('car.car_make') }}</th>
                            <th>{{ trans('car.car_category') }}</th>

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
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6f'>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('car.index') }}",
                    data: function (d) {
                        d.branch = $('#branch_filter').val();
                        d.category = $('#category_filter').val();
                        d.car_make = $('#car_make_filter').val();
                        d.car_model = $('#car_model_filter').val();
                        d.keyword = $('#keyword').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'registration_no', name: 'registration_no'},
                    {data: 'model_year', name: 'model_year'},
                    {data: 'carmake.car_make', name: 'car_make'},
                    {data: 'category.category', name: 'category'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            $('#search-form').on('submit', function(e) {
                table.draw();
                e.preventDefault();
            });
    } );
</script>
@stop
