@extends('adminlte::page')

@section('content_header')
    <?php if($utype == 3 ) { ?>
    <h1 class="m-0 text-dark">{{ trans('wallet.model_plural_driver') }}</h1>
    <?php } elseif($utype == 4 ) { ?>
    <h1 class="m-0 text-dark">{{ trans('wallet.model_plural_customer') }}</h1>        
    <?php } else { ?>
    <h1 class="m-0 text-dark">{{ trans('wallet.model_plural') }}</h1>
    <?php } ?>
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
            
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table id="dataList" class="display table table-striped">
                    <thead>
                        <tr>
                            <th>{{ trans('wallet.slno') }}</th>
                            <th>{{ trans('wallet.customer_name') }}</th>
                            <th>{{ trans('wallet.amount') }}</th>
                            <th>{{ trans('wallet.status') }}</th>

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
    <div class="modal-header">
      <h4 class="modal-title">Pay Amount</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form method="POST" action="{{ route('wallet.amount') }}" accept-charset="UTF-8" id="create_amount_form" name="create_amount_form" class="form-horizontal">    
    <div class="modal-body">
            {{ csrf_field() }}
            <input type="hidden" name="user_id" id="user_id" value="" />
            <input type="hidden" name="transaction_type" id="transaction_type" value="" />
            <div class="form-group">
                <label for="amount" class="col-md-2 control-label">{{ trans('wallet.amount') }}</label>
                <div class="col-md-10">
                    <input class="form-control" name="amount" type="text" id="amount" value="" minlength="1" placeholder="{{ trans('wallet.amount__placeholder') }}">
                    {!! $errors->first('amount', '<p class="help-block">:message</p>') !!}
                </div>
            </div>      
            <div class="form-group">
                <label for="note" class="col-md-2 control-label">{{ trans('wallet.note') }}</label>
                <div class="col-md-10">
                    <textarea class="form-control" name="note" cols="10" rows="6" id="note" required="true" placeholder="{{ trans('wallet.note__placeholder') }}"></textarea>
                    {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
                </div>
            </div>                  

    </div>
    <div class="modal-footer justify-content-between">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary">Save changes</button>
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
    <?php if($utype)  $url_wallet = 'wallets/wallet_type/'.$utype; else  $url_wallet = 'wallets'; 
    $show_search = '';
    if($utype) $show_search = 'f';
    ?>
    $(document).ready(function() {        
            var table = $('#dataList').DataTable({
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'{{$show_search}}>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",                
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url($url_wallet) }}",
                    data: function (d) {
                        d.user_type = $('#user_type_filter').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'user.name', name: 'name'},
                    {data: 'amount', name: 'amount'},
                    {data: 'is_active', render: function(data){
                            if(data == 0) return 'No';  else return 'Yes';
                          }},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        $('#search-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });            
    } );

     $('body').on('click','.amount-modal',function(){
        var user = $(this).data('user-id');
        $('.last_edit').removeClass('last_edit');
        $(this).closest('tr').addClass('last_edit');        
        $('#user_id').val(user);
        $('#amount').val('');
        $('#transaction_type').val('add');        
        $('#modal-lg').modal('show');
    });
     $('body').on('click','.amount-minus-modal',function(){
        var user = $(this).data('user-id');
        $('.last_edit').removeClass('last_edit');
        $(this).closest('tr').addClass('last_edit');
        $('#user_id').val(user);
        $('#amount').val('');
        $('#transaction_type').val('subtract');
        $('#modal-lg').modal('show');
    });    
    $("#create_amount_form").on("submit", function(e) {
        var postData = $(this).serializeArray();
        if($('#transaction_type').val() == 'add') {
            $.ajax({
                url: "{{ route('wallet.amount') }}",
                type: "POST",
                data: postData,
                dataType: 'json',
                success: function(data) {
                    if(data.status) {
                        alert("Transaction is added successfully");
                        $('.last_edit').find("td:eq(2)").html(data.amount);
                    }
                   // window.location.reload();
                    $('#modal-lg').modal('hide');
                },
                error: function(jqXHR, status, error) {
                    console.log(status + ": " + error);
                }
            });
        } else if ($('#transaction_type').val() == 'subtract') {
            $.ajax({
                url: "{{ route('wallet.subract.amount') }}",
                type: "POST",
                data: postData,
                dataType: 'json',
                success: function(data) {
                    if(data.status) {
                        alert("Transaction is debited successfully");
                        $('.last_edit').find("td:eq(2)").html(data.amount);
                    }
                   // window.location.reload();
                    $('#modal-lg').modal('hide');
                },
                error: function(jqXHR, status, error) {
                    console.log(status + ": " + error);
                }
            });            
        }
        e.preventDefault();
    });     
</script>
@stop
