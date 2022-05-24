<?php

namespace App\Exports;

use App\Models\CarRental;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CarRentalsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $keyword;

    public function __construct(Request $request)
    {
        $this->keyword = $request->keyword;
    }

    public function headings(): array
    {
        return [
            'Booking Number',
            'Car',
            'User',
            'Pickup On',
            'Duration in Days',
            'DropOff On',
            'Amount',
        ];
    }

    public function map($booking): array
    {
        return [
            $booking->booking_no,
            $booking->car->car_name,
            $booking->user->name,
            $booking->pickup_on,
            $booking->duration_in_days,
            $booking->dropoff_on,
            $booking->amount,
        ];
    }

    public function query()
    {
        $car_rental  =   CarRental::query();
        if ($this->keyword) {
            $keyword = $this->keyword;
            $car_rental = $car_rental->whereHas('users', function($q) use($keyword) {
                            $q->where('name', 'like', '%' .$keyword . '%');
                        })->orWhere('booking_no', 'like', '%' .$this->keyword. '%');
        }
        return $car_rental;
    }
}

