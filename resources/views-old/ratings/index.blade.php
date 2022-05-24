@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('ratings.model_plural') }}</h1>
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
                            <label class="mb-2 mr-sm-2">{{ trans('ratings.filters') }} : </label>
                        </div>
                        <div class="form-group ">
                            <label for="phone" class="mb-2 mr-sm-2">{{ trans('ratings.rated_by_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="rated_by_filter" name="rated_by_filter" required="true">
                                <option value="0">
                                    {{ trans('ratings.rated_by_filter__placeholder') }}</option>
                                @foreach ($users as $key => $us)
                                <option value="{{ $key }}">
                                    {{ $us }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ">
                            <label for="phone" class="mb-2 mr-sm-2">{{ trans('ratings.rated_for_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="rated_for_filter" name="rated_for_filter" required="true">
                                <option value="0">
                                    {{ trans('ratings.rated_for_filter__placeholder') }}</option>
                                @foreach ($users as $key => $us)
                                <option value="{{ $key }}">
                                    {{ $us }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ">
                            <label for="phone" class="mb-2 mr-sm-2">{{ trans('ratings.trip_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="trip_filter" name="trip_filter" required="true">
                                <option value="0">
                                    {{ trans('ratings.trip_filter__placeholder') }}</option>
                                @foreach ($trips as $key => $tr)
                                <option value="{{ $key }}">
                                    {{ $tr }}
                                </option>
                                @endforeach
                            </select>
                        </div>                        
                        <button type="submit" class="btn btn-primary mb-2 mr-sm-2">{{ trans('ratings.search') }}</button>
                    </form>
                </div>
            </div>
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table id="dataList" class="display table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ trans('ratings.slno') }}</th>
                            <th>{{ trans('ratings.trip_id') }}</th>
                            <th>{{ trans('ratings.rated_by') }}</th>
                            <th>{{ trans('ratings.rated_for') }}</th>
                            <th>{{ trans('ratings.done_by') }}</th>

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
                    url: "{{ route('rating.index') }}",
                    data: function (d) {
                        d.rated_by = $('#rated_by_filter').val();
                        d.rated_for = $('#rated_for_filter').val();
                        d.trip = $('#trip_filter').val();
                    }
                },                
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'trip.trip_no', name: 'trip_id'},
                    {data: 'rated_by.name', name: 'rated_by'},
                    {data: 'rated_for.name', name: 'rated_for'},
                    {data: 'done_by.name', name: 'is_active'},
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
