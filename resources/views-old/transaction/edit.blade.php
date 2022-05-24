@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ !empty($title) ? $title : 'Transaction' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">

        <a href="{{ route('transaction.index') }}" class="btn btn-primary" title="{{ trans('transaction.show_all') }}">
            <i class="fas fa-list-alt"></i>
        </a>

        <a href="{{ route('transaction.create') }}" class="btn btn-success" title="{{ trans('transaction.create') }}">
            <i class="fas fa-plus-circle"></i>
        </a>

    </div>
@stop

@section('content')

    <div class="panel panel-default">
    <div class="card card-primary card-outline">
    <div class="card-body">




        <div class="panel-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('transaction.update', $transaction->id) }}" id="edit_transaction_form" name="edit_transaction_form" accept-charset="UTF-8" class="form-horizontal" enctype='multipart/form-data'>
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('transaction.form', [
                                        'transaction' => $transaction,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('transaction.update') }}">
                    </div>
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection

@section('js')
<script type="text/javascript">
   $(function () {
   $('#booking_id').select2({
        placeholder: 'Select Booking',
        ajax: {
            url: '{{ route("transaction.search.booking") }}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.booking_no,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    }).on('change',function() {
        var id = $(this).val();
        if(id){
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            $.ajax({

                url : '{{ route("transaction.booking.request") }}',
                type : 'POST',
                data : {
                    'id' : id
                },
                dataType:'json',
                success : function(data) {
                    var newCustomer = new Option(data.customer_name, data.customer_id, true, true);
                    $('#sender_id').find('option').remove();
                    $('#sender_id').append(newCustomer).trigger('change');
                    var newDriver = new Option(data.driver_name, data.driver_id, true, true);
                    $('#receiver_id').find('option').remove();
                    $('#receiver_id').append(newDriver).trigger('change');
                    console.log(data);
                }
            });
        }
    });
    <?php if(isset($transaction->booking->booking_no)) { ?>
        var newBooking = new Option('{{$transaction->booking->booking_no}}', '{{$transaction->booking_id}}', true, true);
        $('#booking_id').append(newBooking).trigger('change');
    <?php } ?>
    $('#sender_id').select2({
        placeholder: 'Select Customer',
        ajax: {
            url: '{{ route("transaction.search.sender") }}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
    <?php if(isset($transaction->sender->name)) { ?>
        var newCustomer = new Option('{{$transaction->sender->name}}', '{{$transaction->sender_id}}', true, true);
        $('#sender_id').append(newCustomer).trigger('change');
    <?php } ?>
    $('#receiver_id').select2({
        placeholder: 'Select Driver',
        ajax: {
            url: '{{ route("transaction.search.receiver") }}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
    <?php if(isset($transaction->receiver->name)) { ?>
        var newDriver = new Option('{{$transaction->receiver->name}}', '{{$transaction->receiver_id}}', true, true);
        $('#receiver_id').append(newDriver).trigger('change');
    <?php } ?>
});
</script>
@endsection
