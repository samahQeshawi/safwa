@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('user_admin.model_plural') }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        @can("add user_manage")
        <a href="{{ route('user_admin.create') }}" class="btn btn-success" title="{{ trans('user_admin.create') }}">
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

        {{-- Filters --}}
        <div class="row">
            <div class="col-md-12">
                <form method="POST" id="search-form" class="form-inline" role="form">
                    <div class="form-group ">
                        <label class="mb-2 mr-sm-2">Filters : </label>
                    </div>
                    <div class="form-group ">
                        <label for="phone" class="mb-2 mr-sm-2">City</label>
                        <select class="form-control  mb-2 mr-sm-2" id="city" name="city">
                            <option value="0">
                                {{ trans('user_admin.city_filter__placeholder') }}</option>
                            @foreach ($cities as $key => $city)
                            <option value="{{ $key }}">
                                {{ $city }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keyword" class="mb-2 mr-sm-2">{{__('user_admin.keyword_filter')}}</label>
                        <input type="textbox" class="form-control mb-2 mr-sm-2" name="keyword" id="keyword"
                            value="">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2 mr-sm-2">Search</button>
                </form>
            </div>
        </div>
        {{-- Filters --}}

        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table id="dataList" class="display table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ trans('user_admin.slno') }}</th>
                            <th>{{ trans('user_admin.first_name') }}</th>
                            <th>{{ trans('user_admin.last_name') }}</th>
                            <th>{{ trans('user_admin.email') }}</th>
                            <th>{{ trans('user_admin.phone_no') }}</th>
                            <th>{{ trans('user_admin.permission') }}</th>
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
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('user_admin.index') }}",
                    data: function (d) {
                        d.city = $('#city').val();
                        d.keyword = $('#keyword').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'surname', name: 'surname'},
                    {data: 'phone', name: 'phone'},
                    {data: 'email', name: 'email'},
                    {data: 'permission.user_type', name: 'permission.user_type'},
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
