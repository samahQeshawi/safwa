@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('branch.model_plural') }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <a href="{{ route('branches.create') }}" class="btn btn-success" title="{{ trans('branch.create') }}">
            <i class="fas fa-plus-circle"></i>
        </a>
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
                            <label class="mb-2 mr-sm-2">{{ trans('branch.filters') }} : </label>
                        </div>
                        <div class="form-group ">
                            <label for="branch_code_filter" class="mb-2 mr-sm-2">{{ trans('branch.branch_code_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="branch_code_filter" name="branch_code_filter" required="true">
                                <option value="0">
                                    {{ trans('branch.branch_code_filter__placeholder') }}</option>
                                @foreach ($branch_code as $key => $bc)
                                <option value="{{ $bc }}">
                                    {{ $bc }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ">
                            <label for="city_filter" class="mb-2 mr-sm-2">{{ trans('branch.city_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="city_filter" name="city_filter" required="true">
                                <option value="0">
                                    {{ trans('branch.city_filter__placeholder') }}</option>
                                @foreach ($cities as $key => $cty)
                                <option value="{{ $key }}">
                                    {{ $cty }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class="mb-2 mr-sm-2">{{__('branch.keyword_filter')}}</label>
                            <input type="textbox" class="form-control mb-2 mr-sm-2" name="keyword" id="keyword"
                                value="">
                        </div>                         
                        <button type="submit" class="btn btn-primary mb-2 mr-sm-2">{{ trans('branch.search') }}</button>
                    </form>
                </div>
            </div>
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table id="dataList" class="display table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ trans('branch.slno') }}</th>
                            <th>{{ trans('branch.name') }}</th>
                            <th>{{ trans('branch.branch_code') }}</th>
                            <th>{{ trans('branch.phone') }}</th>
                            <th>{{ trans('branch.status') }}</th>

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
                    url: "{{ route('branches.index') }}",
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
                    {data: 'is_active', name: 'is_active'},
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
