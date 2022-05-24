@extends('adminlte::page')

@section('content')
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-12">
          <h2 class="page-header">
            <i class="fas fa-globe"></i> Safwa, Inc.
            <small class="float-right">Date:  {{  Carbon\Carbon::now()->format('d-m-Y') }}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <table class="invoice_table" style="width:100%">
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
    </section>
    <!-- /.content -->
  </div>
  <!-- ./wrapper -->
  <!-- Page specific script -->
  <script>
    window.addEventListener("load", window.print());
  </script>


@endsection
