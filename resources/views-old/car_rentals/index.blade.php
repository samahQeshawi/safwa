@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('car_rental.model_plural') }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <a href="{{ route('car_rentals.create') }}" class="btn btn-success" title="{{ trans('car_rental.create') }}">
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
                            <label class="mb-2 mr-sm-2">{{ trans('car_rental.filters') }} : </label>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class="mb-2 mr-sm-2">{{__('car_rental.keyword_filter')}}</label>
                            <input type="textbox" class="form-control mb-2 mr-sm-2" name="keyword" id="keyword"
                                value="">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2 mr-sm-2">{{ trans('car_rental.search') }}</button>
                    </form>
                </div>
            </div>
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table id="dataList" class="display table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th>{{ trans('car_rental.slno') }}</th>
                            <th>{{ trans('car_rental.booking_no') }}</th>
                            {{-- <th>{{ trans('car_rental.user_id') }}</th> --}}
                            <th>{{ trans('car_rental.pickup_on') }}</th>
                            <th>{{ trans('car_rental.dropoff_on') }}</th>
                            <th>{{ trans('car_rental.amount') }}</th>
                            <th>{{ trans('car_rental.payment_status') }}</th>
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
                        "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('car_rentals.index') }}",
                    data: function (d) {
                        d.keyword = $('#keyword').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'booking_no', name: 'booking_no'},
                    /* {data: 'user.name', name: 'name'}, */
                    {data: 'pickup_on', name: 'pickup_on'},
                    {data: 'dropoff_on', name: 'dropoff_on'},
                    {data: 'amount', name: 'amount'},
                    {data: 'payment_status', name: 'Payment'},
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
