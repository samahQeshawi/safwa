<?php

namespace App\Exports;

use App\Models\Booking;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $car_type;
    protected $start_date;
    protected $keyword;

    public function __construct(Request $request)
    {
        $this->car_type = $request->car_type;
        $this->start_date = $request->start_date;
        $this->keyword = $request->keyword;
    }

    public function headings(): array
    {
        return [
            'Booking Number',
            'Customer',
            'Start Destination',
            'End Destination',
            'Distance',
            'Start Date',
            'Start Time',
            'Car Type',
            'Amount',
            'Start Address',
            'Driver',
        ];
    }

    public function map($booking): array
    {
        return [
            $booking->booking_no,
            $booking->customer->name,
            $booking->start_destination,
            $booking->end_destination,
            $booking->distance,
            $booking->start_date,
            $booking->start_time,
            $booking->cartype->car_type,
            $booking->amount,
            $booking->start_address,
            $booking->driver->name,
        ];
    }

    public function query()
    {
        $booking  =   Booking::query();
        if ($this->start_date)
            $booking = $booking->where('start_date', $this->start_date);
        if ($this->car_type)
            $booking = $booking->where('car_type_id', $this->car_type);
        if ($this->keyword) {
            $keyword = $this->keyword;
            $booking = $booking->whereHas('customer', function($q) use($keyword) {
                            $q->where('name', 'like', '%' .$keyword . '%');
                        })->orWhere('booking_no', 'like', '%' .$this->keyword. '%');
        }
        return $booking;
    }
}

