<?php

namespace App\Exports;

use App\Models\Branch;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BranchesExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $branch_code;
    protected $city;
    protected $keyword;

    public function __construct(Request $request)
    {
        $this->branch_code = $request->branch_code;
        $this->city = $request->city;
        $this->keyword = $request->keyword;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Address',
            'Zipcode',
            'Phone',
            'Email',
            'Branch Code',
            'Service',
            'Country',
            'City',
        ];
    }

    public function map($branch): array
    {
        return [
            $branch->name,
            $branch->address,
            $branch->zipcode,
            $branch->phone,
            $branch->email,
            $branch->branch_code,
            $branch->service->service,
            $branch->country->name,
            $branch->city->name,
        ];
    }

    public function query()
    {
        $branch  =   Branch::query();
        if ($this->branch_code)
            $branch = $branch->where('branch_code', $this->branch_code);
        if ($this->city)
            $branch = $branch->where('city_id', $this->city);        
        if ($this->keyword) {
            $branch =  $branch->where('name', 'like', '%' .$this->keyword. '%');
        }
        return $branch;
    }
}

