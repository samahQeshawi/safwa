<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8" />
  </head>
  <body>
    <h2>Car Rental  Booking Details</h2>
        <dl class="dl-horizontal">
            <dt>{{ trans('booking.booking_no') }}</dt>
            <dd>{{ $booking->booking_no }}</dd>             
            <dt>{{ trans('booking.customer_id') }}</dt>
            <dd>{{ $booking->customer->name }}</dd>            
            <dt>{{ trans('booking.start_destination') }}</dt>
            <dd>{{ $booking->start_destination }}</dd>
            <dt>{{ trans('booking.end_destination') }}</dt>
            <dd>{{ $booking->end_destination }}</dd>
            <dt>{{ trans('booking.distance') }}</dt>
            <dd>{{ $booking->distance }}</dd>
            <dt>{{ trans('booking.amount') }}</dt>
            <dd>{{ $booking->amount }}</dd>
            <dt>{{ trans('booking.start_date') }}</dt>
            <dd>{{ $booking->start_date }}</dd>
            <dt>{{ trans('booking.start_time') }}</dt>
            <dd>{{ $booking->start_time }}</dd>
            <dt>{{ trans('booking.landmark') }}</dt>
            <dd>{{ $booking->landmark }}</dd>
            <dt>{{ trans('booking.start_address') }}</dt>
            <dd>{{ $booking->start_address }}</dd>
            <dt>{{ trans('booking.car_type_id') }}</dt>
            <dd>{{ $booking->cartype->name }}</dd>
            <dt>{{ trans('booking.driver_id') }}</dt>
            <dd>{{ $booking->driver->name }}</dd>
        </dl>
  </body>
</html>
