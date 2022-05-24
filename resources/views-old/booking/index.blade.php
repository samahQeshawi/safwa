@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('booking.model_plural') }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <a href="{{ route('booking.create') }}" class="btn btn-success" title="{{ trans('booking.create') }}">
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
                            <label class="mb-2 mr-sm-2">Filters : </label>
                        </div>
                        <div class="form-group ">
                            <label for="phone" class="mb-2 mr-sm-2">{{ trans('booking.car_type_filter') }}</label>
                            <select class="form-control  mb-2 mr-sm-2" id="car_type_filter" name="car_type_filter" required="true">
                                <option value="0">
                                    {{ trans('booking.car_type_filter__placeholder') }}</option>
                                @foreach ($car_type as $key => $ct)
                                <option value="{{ $key }}">
                                    {{ $ct }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keyword" class="mb-2 mr-sm-2">{{__('booking.keyword_filter')}}</label>
                            <input type="textbox" class="form-control mb-2 mr-sm-2" name="keyword" id="keyword"
                                value="">
                        </div>                        
                        <div class="form-group "> 
                            <label for="phone" class="mb-2 mr-sm-2">{{ trans('booking.start_date_filter') }}</label>  
                            <input  class="form-control  mb-2 mr-sm-2 date-picker" id="start_date_filter" name="start_date_filter" autocomplete="off" />
                        </div>
                        <button type="submit" class="btn btn-primary mb-2 mr-sm-2">Search</button>
                    </form>
                </div>
            </div>
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table id="dataList" class="display table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th>{{ trans('booking.slno') }}</th>
                            <th>{{ trans('booking.customer_id') }}</th>
                            <th>{{ trans('booking.booking_no') }}</th>
                            <th>{{ trans('booking.customer') }}</th>
                            <th>{{ trans('booking.start_address') }}</th>
                            <th>{{ trans('booking.status') }}</th>

                            <th></th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>

</div>
        </div>
    </div>
<div class="modal fade" id="modal-lg">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="ajax-loader">
        <img src="{{ asset('images/loader.gif') }}" />
    </div>
    <div class="modal-header">
      <h4 class="modal-title">{{ trans('booking.booking_email') }}</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form method="POST" action="{{ route('booking.email') }}" accept-charset="UTF-8" id="create_amount_form" name="create_amount_form" class="form-horizontal">    
    <div class="modal-body">
            {{ csrf_field() }}
            <input type="hidden" name="booking_id" id="booking_id" value="" />     
            <div class="form-group">
                <label for="email" class="col-md-2 control-label">{{ trans('booking.email') }}</label>
                <div class="col-md-10">
                    <textarea class="form-control" name="email" cols="10" rows="6" id="email" required="true" placeholder="{{ trans('booking.email__placeholder') }}"></textarea>
                </div>
            </div>                  

    </div>
    <div class="modal-footer justify-content-between">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary">{{ trans('booking.send_email') }}</button>
    </div>
    </form>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
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
                    url: "{{ route('booking.index') }}",
                    data: function (d) {
                        d.car_type = $('#car_type_filter').val();
                        d.start_date = $('#start_date_filter').val();
                        d.keyword = $('#keyword').val();
                    }
                },                
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'customer.name', name: 'name'},
                    {data: 'booking_no', name: 'booking_no'},
                    {data: 'customer.name', name: 'customer'},
                    {data: 'start_address', name: 'start_address'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        $('#search-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        }); 
        $('.date-picker').datepicker({
                   format: 'd-mm-yyyy'
        });             
         $('body').on('click','.email-booking-modal',function(){
            var booking = $(this).data('booking-id'); 
            $('#booking_id').val(booking);       
            $('#modal-lg').modal('show');
            $('.ajax-loader').hide();
            $('#email').html('');
        }); 
    $('.ajax-loader').hide();      
    $("#create_amount_form").on("submit", function(e) {
        var postData = $(this).serializeArray();
            $('.ajax-loader').show();
            $.ajax({
                url: "{{ route('booking.email') }}",
                type: "POST",
                data: postData,
                dataType: 'json',
                success: function(data) {
                    if(data.status) {
                        alert("Email is sent successfully");
                    }
                   // window.location.reload();
                    $('#modal-lg').modal('hide');
                    $('.ajax-loader').hide();
                },
                error: function(jqXHR, status, error) {
                    console.log(status + ": " + error);
                }
            });
        e.preventDefault();
    });                  
    } );
</script>
@stop
