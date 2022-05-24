@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Booking' }}</h1>

@stop

@section('content')

<div class="panel panel-default">
<div class="card card-primary card-outline">
<div class="card-body">
    <div class="panel-body">

        <!-- Main content -->
        <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4>
                <i class="fas fa-globe"></i> Safwa, Inc.
                <small class="float-right">Date:  {{  Carbon\Carbon::now()->format('d-m-Y') }}</small>
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
      <table class="invoice_table" style="width:100%;">
        <tr>
            <td>
            From
          <address>
            <strong>{{ $trip->driver->name }}</strong><br>
            Phone: {{ $trip->driver->phone }}<br>
            Email: {{ $trip->driver->email }}
          </address>
            </td>

            <td>
            To
          <address>
            <strong>{{ $trip->customer->name }}</strong><br>
            {{ $trip->customer->address }} <br>
            {{ $trip->customer->zipcode }}<br>
            Phone:  {{ $trip->customer->phone  }}<br>
            Email: {{ $trip->customer->email  }}
          </address>
            </td>

            <td>
          <b>Trip No {{$trip->trip_no}}</b><br>
            </td>
        </tr>
      </table>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                   <thead>
                    <tr>
                      <th>Pick Up</th>
                      <th>Drop Off</th>
                      <th>Distance</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{$trip->from_address}}</td>
                      <td>{{$trip->to_address}}</td>
                      <td>{{$trip->distance}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

      <table class="invoice_table">
        <tr>
        <!-- accepted payments column -->
          <td style="width:60%">
          <p class="lead">Payment Methods:</p>

                <img src="{{asset('images/visa.png')}}" alt="Visa">
                <img src="{{ asset('images/mastercard.png') }}" alt="Mastercard">
                <img src="{{ asset('images/american-express.png') }}" alt="American Express">
                <img src="{{ asset('images/paypal2.png') }}" alt="Paypal">
          <p class="text-muted well well-sm shadow-none" style="visibility: hidden;margin-top: 10px;">
            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr
            jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
          </p>
        </td>
        <!-- /.col -->
        <td>
           @if($trip->payment_staus == 1)
              <p class="lead">Amount Paid {{$trip->created_at->format('d/m/Y')}}</p>
          @else
              <p class="lead">Amount Due {{$trip->created_at->format('d/m/Y')}}</p>
          @endif

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th>Subtotal:</th>
                <td>SR {{$trip->amount}}</td>
              </tr>
              <tr>
                <th>Tax (0%)</th>
                <td>SR0</td>
              </tr>
              <tr>
                <th>Total:</th>
                <td>SR {{$trip->final_amount}}</td>
              </tr>
            </table>
          </div>
        </td>
        <!-- /.col -->
      </tr>
      </table>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <a href="{{ route('trip.invoice.print', $trip->id) }}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                {{-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                  Payment
                </button> --}}
                <a href="{{ route('trip.invoice.pdf', $trip->id) }}" rel="noopener" target="_blank" class="btn btn-primary float-right"><i class="fas fa-download"></i> Generate PDF</a>
              </div>
            </div>
          </div>
          <!-- /.invoice -->



    </div>
    </div>
</div>
</div>

@endsection
