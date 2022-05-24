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
            <strong>{{ Auth::user()->name }}</strong><br>
            Phone: {{ Auth::user()->phone }}<br>
            Email: {{ Auth::user()->email }}
          </address>
            </td>

            <td>
            To
          <address>
            <strong>{{ $car_rental->user->name }}</strong><br>
            {{ $car_rental->user->address }} <br>
            Phone:  {{ $car_rental->user->phone  }}<br>
            Email: {{ $car_rental->user->email  }}
          </address>
            </td>

            <td>
          <b>Booking No {{$car_rental->booking_no}}</b><br>
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
                  <th>No</th>
                  <th>Booking No</th>
                  <th>Pickup On</th>
                  <th>Dropoff On</th>
                  <th>Car</th>
                  <th>Amount</th
                </tr>
              </thead>
              <tbody>
                <tr>
                    <td>1</td>
                    <td>{{$car_rental->booking_no}}</td>
                    <td>{{$car_rental->pickup_on}}</td>
                    <td>{{$car_rental->dropoff_on}}</td>
                    <td>{{$car_rental->car->car_name}}</td>
                    <td>SR {{$car_rental->amount}}</td>
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
          <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr
            jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
          </p>
        </td>
        <!-- /.col -->
        <td>
          <p class="lead">Amount Due 2/22/2014</p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th>Subtotal:</th>
                <td>SR {{$car_rental->amount}}</td>
              </tr>
              <tr>
                <th>Tax (9.3%)</th>
                <td>SR0</td>
              </tr>
              <tr>
                <th>Total:</th>
                <td>SR {{$car_rental->amount}}</td>
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
