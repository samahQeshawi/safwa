<?php

namespace App\Exports;

use App\Models\Trip;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TripsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $trip_status;
    protected $keyword;

    public function __construct(Request $request)
    {
        $this->trip_status = $request->trip_status;
        $this->keyword = $request->keyword;
    }

    public function headings(): array
    {
        return [
            'Trip Number',
            'Trip Status',
            'Trip Type',
            'Trip Start Date',
            'Trip End Date',
            'Trip Pick Up',
            'Trip Drop Off',
            'Trip Customer',
            'Trip Driver',
            //'Trip Car',
            'Trip Distance',
            'Trip Per Km',
            'Trip Waiting',
            'Total Amount',
            'Discount',
            'Tax',
        ];
    }

    public function map($trip): array
    {
        return [
            $trip->trip_number,
            $trip->trip_status,
            $trip->trip_type,
            $trip->trip_start_date,
            $trip->trip_end_date,
            $trip->trip_pick_up,
            $trip->trip_drop_off,
            $trip->customer->name,
            $trip->driver->name,
            //$trip->car->car_name,
            $trip->trip_distance,
            $trip->per_km_charge,
            $trip->waiting_charge,
            $trip->total_amount,
            $trip->discount,
            $trip->tax,
            //Date::dateTimeToExcel($invoice->created_at),
        ];
    }

    public function query()
    {
        $trips  =   Trip::query();
        if ($this->trip_status)
            $trips = $trips->where('trip_status', $this->trip_status);
        if ($this->keyword)
            $trips = $trips->where('trip_number', 'like', '%' .$this->keyword. '%');
        return $trips;
    }
}

