@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('complaints.model_plural') }}</h1>
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
                        <label class="mb-2 mr-sm-2">{{ trans('complaints.filters') }} : </label>
                    </div>
                    <div class="form-group ">
                        <label for="user_type_filter" class="mb-2 mr-sm-2">{{ trans('complaints.user_type_filter') }}</label>
                        <select class="form-control  mb-2 mr-sm-2" id="user_type_filter" name="user_type_filter" required="true">
                            <option value="0">
                                {{ trans('complaints.user_type_filter__placeholder') }}</option>
                            @foreach ($user_type as $key => $ut)
                            <option value="{{ $key }}">
                                {{ $ut }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="service_filter" class="mb-2 mr-sm-2">{{ trans('complaints.service_filter') }}</label>
                        <select class="form-control  mb-2 mr-sm-2" id="service_filter" name="service_filter" required="true">
                            <option value="0">
                                {{ trans('complaints.service_filter__placeholder') }}</option>
                            @foreach ($service as $key => $ut)
                            <option value="{{ $key }}">
                                {{ $ut }}
                            </option>
                            @endforeach
                        </select>
                    </div>    
                    <div class="form-group ">
                        <label for="status_filter" class="mb-2 mr-sm-2">{{ trans('complaints.status_filter') }}</label>
                        <select class="form-control  mb-2 mr-sm-2" id="status_filter" name="status_filter" required="true">
                            <option value="0">
                                {{ trans('complaints.status_filter__placeholder') }}</option>
                            @foreach ($status as $key => $ut)
                            <option value="{{ $key }}">
                                {{ $ut }}
                            </option>
                            @endforeach
                        </select>
                    </div>     
                    <div class="form-group">
                        <label for="keyword" class="mb-2 mr-sm-2">{{__('complaints.keyword_filter')}}</label>
                        <input type="textbox" class="form-control mb-2 mr-sm-2" name="keyword" id="keyword"
                            value="">
                    </div>                                                   
                    <button type="submit" class="btn btn-primary mb-2 mr-sm-2">{{ trans('complaints.search') }}</button>
                </form>
            </div>
        </div>
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table id="dataList" class="display table table-striped">
                    <thead>
                        <tr>
                            <th>{{ trans('complaints.slno') }}</th>
                            <th>{{ trans('complaints.complaint_no') }}</th>
                            <th>{{ trans('complaints.service') }}</th>
                            <th>{{ trans('complaints.from_user') }}</th>
                            <th>{{ trans('complaints.against_user') }}</th>
                            <th>{{ trans('complaints.status') }}</th>

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
                    url: "{{ route('complaint.index') }}",
                    data: function (d) {
                        d.user_type = $('#user_type_filter').val();
                        d.service = $('#service_filter').val();
                        d.status = $('#status_filter').val();
                        d.keyword = $('#keyword').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'complaint_no', name: 'complaint_no'},
                    {data: 'service.service', name: 'service'},
                    {data: 'from_user.name', name: 'from_user'},
                    {data: 'against_user.name', name: 'against_user'},
                    {data: 'status', name: 'status'},
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
