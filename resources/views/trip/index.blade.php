@extends('adminlte::page')

@section('content_header')
    @if($trip_type == '1')
        <h1 class="m-0 text-dark">{{ trans('trip.model_plural_now') }}</h1>
    @elseif($trip_type == '2')
        <h1 class="m-0 text-dark">{{ trans('trip.model_plural_later') }}</h1>
    @else
        <h1 class="m-0 text-dark">{{ trans('trip.model_plural_later') }}</h1>
    @endif
    <div class="btn-group btn-group-sm pull-right" role="group">
        @can("add trips")
        <!-- <a href="{{ route('trip.create') }}" class="btn btn-success" title="{{ trans('trip.create') }}">
            <i class="fas fa-plus-circle"></i>
        </a> -->
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
                            <label class="mb-2 mr-sm-2">Filters : </label>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class="mb-2 mr-sm-2">{{__('customer.keyword_filter')}}</label>
                            <input type="textbox" class="form-control mb-2 mr-sm-2" name="keyword" id="keyword"
                                value="">
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
                            <th>{{ trans('trip.slno') }}</th>
                            <th>{{ trans('trip.trip_no') }}</th>
                            <th>{{ trans('trip.final_amount') }}</th>
                            <th>{{ trans('trip.from_address') }}</th>
                            <th>{{ trans('trip.to_address') }}</th>
                            <th>{{ trans('trip.status') }}</th>

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
    <?php if($trip_type)  $url_trip = 'trips/trip_type/'.$trip_type; else  $url_trip = 'trips'; ?>
    $(document).ready(function() {
            var table = $('#dataList').DataTable({
                scrollX : 'false',
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url($url_trip) }}",
                    data: function (d) {
                        d.trip_status = $('#trip_status_filter').val();
                        d.keyword = $('#keyword').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'trip_no', name: 'trip_no'},
                    {data: 'final_amount', name: 'final_amount'},
                    {data: 'from_address', name: 'from_address'},
                    {data: 'to_address', name: 'to_address'},
                    {data: 'trip_status', name: 'trip_status'},
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
