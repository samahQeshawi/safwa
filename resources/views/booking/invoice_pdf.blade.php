<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="L4ZUqJ5ImzCt42qjo6JXXrnD6dcH04fa9WTbe5vL">   
    <title> SAFWA        Admin        Portal    </title>
    <link rel="stylesheet" href="{{url('css/app.css') }}">
    <link rel="stylesheet"  href="{{url('css/app-custom.css') }}">   
    <style type="text/css">
      table.invoice_table {
        width:100%;
      }
      table.invoice_table td,table.invoice_table th, .lead {
        font-size: 12px;
      }
      .font-16 {
           font-size: 16px;
      }
    </style> 
</head>

<body>

    
<div class="wrapper">
    <!-- Main content -->
    <div class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-12">
          <h2 class="page-header font-16">
            <i class="fas fa-globe"></i> Safwa, Inc.
            <small class="float-right">Date:  {{  Carbon\Carbon::now()->format('d-m-Y') }}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->

      <table class="invoice_table">
        <tr>
            <td>
            From
          <address>
            <strong>{{ $booking->driver->name }}</strong><br>
            Phone: {{ $booking->driver->phone }}<br>
            Email: {{ $booking->driver->email }}
          </address>
            </td>

            <td>
            To
          <address>
            <strong>{{ $booking->customer->name }}</strong><br>
            {{ $booking->customer->address }} <br>
            Phone:  {{ $booking->customer->phone  }}<br>
            Email: {{ $booking->customer->email  }}
          </address>
            </td>

            <td>
          <b>Booking No {{$booking->booking_no}}</b><br>
            </td>
        </tr>
      </table>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-12 table-responsive">
          <table class="table table-striped invoice_table">
            <thead>
            <tr>
              <th>No</th>
              <th>Booking No</th>
              <th>Start Destination</th>
              <th>Ending Destination</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>1</td>
              <td>{{$booking->booking_no}}</td>
              <td>{{$booking->start_destination}}</td>
              <td>{{$booking->end_destination}}</td>
              <td>SR {{$booking->amount}}</td>
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
          <td>
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
                <td>SR {{$booking->amount}}</td>
              </tr>
              <tr>
                <th>Tax (9.3%)</th>
                <td>SR0</td>
              </tr>
              <tr>
                <th>Total:</th>
                <td>SR {{$booking->amount}}</td>
              </tr>
            </table>
          </div>
        </td>
        <!-- /.col -->
      </tr>
      </table>
      <!-- /.row -->
    </div>
    <!-- /.content -->
  </div>
  <!-- ./wrapper -->
  <!-- Page specific script --> 
</body>
</html>
