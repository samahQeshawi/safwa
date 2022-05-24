@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ trans('drivers.model_plural') }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
     @can("add drivers")
    <a href="{{ route('drivers.driver.create') }}" class="btn btn-success" title="{{ trans('drivers.create') }}">
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

            <div class="row">
                <div class="col-md-12">
                    <form method="POST" id="search-form" class="form-inline" role="form">
                        <div class="form-group ">
                            <label class="mb-2 mr-sm-2">Filters : </label>
                        </div>
                        <div class="form-group ">
                            <label for="phone" class="mb-2 mr-sm-2">{{ trans('drivers.city_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="city" name="city" required="true">
                                <option value="0">
                                    {{ trans('drivers.city_filter__placeholder') }}</option>
                                @foreach ($cities as $key => $city)
                                <option value="{{ $key }}">
                                    {{ $city }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class="mb-2 mr-sm-2">{{__('drivers.keyword_filter')}}</label>
                            <input type="textbox" class="form-control mb-2 mr-sm-2" name="keyword" id="keyword"
                                value="">
                        </div>
                        <div class="form-group">
                            <label for="is_safwa_driver"
                                class="mb-2 mr-sm-2">{{__('drivers.is_safwa_driver_filter')}}</label>
                            <input type="checkbox" class="form-control mb-2 mr-sm-2" name="is_safwa_driver"
                                id="is_safwa_driver" value="1">
                        </div>

                        <button type="submit" class="btn btn-primary mb-2 mr-sm-2">Search</button>
                    </form>
                </div>
            </div>

            <div class="panel-body panel-body-with-table">
                <div class="table-responsive">
                    <table id="dataList" class="display table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ trans('drivers.slno') }}</th>
                                <th>{{ trans('drivers.first_name') }}</th>
                                <th>{{ trans('drivers.last_name') }}</th>
                                <th>{{ trans('drivers.phone_no') }}</th>
                                <th>{{ trans('drivers.status') }}</th>
                                <th></th>
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
                scrollX : 'false',
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6f'>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('drivers.driver.index') }}",
                    data: function (d) {
                        d.city = $('#city').val();
                        d.keyword = $('#keyword').val();
                        d.safwa_driver = $('input[name=is_safwa_driver]').is(":checked") ? 1:0;
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'surname', name: 'surname'},
                    {data: 'phone', name: 'phone'},
                    {data: 'driver.is_active', name: 'is_active',defaultContent:'Inactive'},
                    {data: 'city_id', name: 'city_id', visible: false},
                    //{data: 'driver.is_safwa_driver', name: 'is_safwa_driver', visible: false},
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
