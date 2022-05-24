@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('coupon_reports.model_plural') }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <a href="{{ route('coupon_reports.index') }}" class="btn btn-success" title="{{ trans('coupon_reports.show_all') }}">
            <i class="fas fa-list-alt"></i>
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
                            <label class="mb-2 mr-sm-2">Filters : </label>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class="mb-2 mr-sm-2">{{ trans('coupon_reports.keyword_filter')}}</label>
                            <input type="textbox" class="form-control mb-2 mr-sm-2" name="keyword" id="keyword"
                                value="">
                        </div>                        
                        <button type="submit" class="btn btn-primary mb-2 mr-sm-2">Search</button>
                    </form>
                </div>
            </div>
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table id="dataList" class="display table table-striped">
                    <thead>
                        <tr>
                            <th>{{ trans('coupon_reports.slno') }}</th>
                            <th>{{ trans('coupon_reports.coupon_code') }}</th>
                            <th>{{ trans('coupon_reports.user') }}</th>
                            <th>{{ trans('coupon_reports.service') }}</th>
                            <th>{{ trans('coupon_reports.car_rental') }}</th>

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
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",                
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('coupon_reports.view_coupons',$coupon_code) }}",
                    data: function (d) {
                        d.keyword = $('#keyword').val();
                    }
                },                
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'coupon_code', name: 'coupon_code'},
                    {data: 'user.name', name: 'user'},
                    {data: 'service.service', name: 'service'},
                    {data: 'car_rental.car.car_name', name: 'car_name'},
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
