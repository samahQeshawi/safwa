@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('coupon.model_plural') }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        @can("add promo_codes")
        <a href="{{ route('coupon.create') }}" class="btn btn-success" title="{{ trans('coupon.create') }}">
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
                            <label class="mb-2 mr-sm-2">{{ trans('coupon.filters') }} : </label>
                        </div>
                        <div class="form-group ">
                            <label for="phone" class="mb-2 mr-sm-2">{{ trans('coupon.coupon_code_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="coupon_code_filter" name="coupon_code_filter" required="true">
                                <option value="0">
                                    {{ trans('coupon.coupon_code_filter__placeholder') }}</option>
                                @foreach ($coupon_code as $key => $cc)
                                <option value="{{ $cc }}">
                                    {{ $cc }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class="mb-2 mr-sm-2">{{__('coupon.keyword_filter')}}</label>
                            <input type="textbox" class="form-control mb-2 mr-sm-2" name="keyword" id="keyword"
                                value="">
                        </div>                        
                        <button type="submit" class="btn btn-primary mb-2 mr-sm-2">{{ trans('coupon.search') }}</button>
                    </form>
                </div>
            </div>
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table id="dataList" class="display table table-striped">
                    <thead>
                        <tr>
                            <th>{{ trans('coupon.slno') }}</th>
                            <th>{{ trans('coupon.name') }}</th>
                            <th>{{ trans('coupon.coupon_code') }}</th>
                            <th>{{ trans('coupon.status') }}</th>

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
                    url: "{{ route('coupon.index') }}",
                    data: function (d) {
                        d.coupon_code = $('#coupon_code_filter').val();
                        d.city = $('#city_filter').val();
                        d.keyword = $('#keyword').val();
                    }
                },                
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'coupon_name', name: 'name'},
                    {data: 'coupon_code', name: 'coupon_code'},
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
