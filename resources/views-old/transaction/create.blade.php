@extends('adminlte::page')
@section('content_header')
    <h1 class="m-0 text-dark">{{ trans('transaction.create') }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <a href="{{ route('transaction.index') }}" class="btn btn-primary" title="{{ trans('transaction.show_all') }}">
            <i class="fas fa-list-alt"></i>
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

            <form method="POST" action="{{ route('transaction.store') }}" accept-charset="UTF-8" id="create_transaction_form" name="create_transaction_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('transaction.form', [
                                        'transaction' => null,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('transaction.add') }}">
                    </div>
                </div>

            </form>

        </div>
    </div>
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
                    $('#sender_id').append(newCustomer).trigger('change');
                    var newDriver = new Option(data.driver_name, data.driver_id, true, true);
                    $('#receiver_id').append(newDriver).trigger('change');
                    console.log(data);
                }
            });
        }
    });
    $('#sender_id').select2({
        placeholder: 'Select sender',
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
    $('#receiver_id').select2({
        placeholder: 'Select receiver',
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
});
</script>
@endsection
