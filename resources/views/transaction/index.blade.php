@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('transaction.model_plural') }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        @can("add wallet")
        <a href="{{ route('transaction.create') }}" class="btn btn-success" title="{{ trans('transaction.create') }}">
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
            <div class="col-md-4 "></div>
            <div class="col-md-8">
                <form method="POST" id="search-form" class="form-inline" role="form">
                    <div class="form-group ">
                        <label class="mb-2 mr-sm-2">{{ trans('transaction.filters') }} : </label>
                    </div>
                    <div class="form-group ">
                        <label for="phone" class="mb-2 mr-sm-2">{{ trans('transaction.sender_filter') }}</label>
                        <select class="form-control  mb-2 mr-sm-2" id="sender_filter" name="sender_filter" required="true">
                            <option value="0">
                                {{ trans('transaction.sender_filter__placeholder') }}</option>
                                @foreach ($user_list as $key => $us)
                                <option value="{{ $key }}">
                                    {{ $us }}
                                </option>
                                @endforeach                                
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mb-2 mr-sm-2">{{ trans('car_rental.search') }}</button>
                </form>
            </div>
        </div>
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table id="dataList" class="display table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ trans('transaction.slno') }}</th>
                            <th>{{ trans('transaction.datetime') }}</th>
                            <th>{{ trans('transaction.sender_id') }}</th>
                            <th>{{ trans('transaction.receiver_id') }}</th>
                            <th>{{ trans('transaction.amount') }}</th>

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
                    url: "{{ route('transaction.index') }}",
                    data: function (d) {
                        d.sender = $('#sender_filter').val();
                    }
                },                
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'created_at', name: 'created_at',"defaultContent": ""},
                    {data: 'sender.name', name: 'sender_id',"defaultContent": ""},
                    {data: 'receiver.name', name: 'receiver_id',"defaultContent": ""},
                    {data: 'amount', name: 'amount'},
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
