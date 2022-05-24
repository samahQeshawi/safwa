<?php

namespace App\Exports;

use App\Models\Car;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CarsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $branch;
    protected $category;
    protected $car_make;
    protected $car_model;
    protected $keyword;

    public function __construct(Request $request)
    {
        $this->branch = $request->branch;
        $this->category = $request->category;
        $this->car_make = $request->car_make;
        $this->car_model = $request->car_model;
        $this->keyword = $request->keyword;
    }

    public function headings(): array
    {
        return [
            'Service',
            'Rent Hourly',
            'Rent Daily',
            'Rent Weekly',
            'Rent Monthly',
            'Rent Yearly',
            'Branch',
            'Car Name',
            'Category',
            'Car Type',
            'Car Make',
            'Fuel Type',
            'Modal Year',
            'Seats',
            'Transmission',
            'Color',
            'Engine',
            'Engine No',
            'Short Description',
            'Description',
            'Amount',
            'Start Address',
            'Registration No',            
            'Insurance Expiry Date',
        ];
    }

    public function map($car): array
    {
        return [
            $car->service->service,
            $car->rent_hourly,
            $car->rent_daily,
            $car->rent_weekly,
            $car->rent_monthly,
            $car->rent_yearly,
            $car->location->name,
            $car->car_name,
            $car->category->category,
            $car->cartype->name,
            $car->carmake->car_make,
            $car->carfuel->fuel_type,
            $car->model_year,
            $car->seats,
            $car->transmission,
            $car->color,
            $car->engine,
            $car->engine_no,
            $car->short_description,
            $car->description,
            $car->amount,
            $car->start_address,
            $car->registration_no,
            $car->insurance_expiry_date,
        ];
    }

    public function query()
    {
        $car  =   Car::query();
        if ($this->branch)
            $car = $car->where('branch_id', $this->branch);
        if ($this->category)
            $car = $car->where('category_id', $this->category);
        if ($this->car_make)
            $car = $car->where('car_make_id', $this->car_make);
        if ($this->car_model)
            $car = $car->where('model_year', $this->car_model);
        if ($this->keyword) {
            $keyword = $this->keyword;
            $car = $car->whereHas('carmake', function($q) use($keyword) {
                            $q->where('car_make', 'like', '%' .$keyword . '%');
                        })->orWhere('car_name', 'like', '%' .$this->keyword. '%');
        }
        return $car;
    }
}

