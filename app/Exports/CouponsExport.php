<?php

namespace App\Exports;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CouponsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $branch_code;
    protected $city;
    protected $keyword;

    public function __construct(Request $request)
    {
        $this->coupon_code = $request->coupon_code;
        $this->city = $request->city;
        $this->keyword = $request->keyword;
    }

    public function headings(): array
    {
        return [
            'Place',
            'Coupon Name',
            'Coupon Code',
            'Coupon Reward',
            'Coupon Limit',
            'From Date',
            'To Date',
        ];
    }

    public function map($coupon): array
    {
        return [
            $coupon->city->name,
            $coupon->coupon_name,
            $coupon->coupon_code,
            $coupon->coupon_reward,
            $coupon->coupon_limit,
            $coupon->coupon_from_date,
            $coupon->coupon_to_date,
        ];
    }

    public function query()
    {
        $coupon  =   Coupon::query();
        if ($this->coupon_code)
            $coupon = $coupon->where('coupon_code', $this->coupon_code);
        if ($this->city)
            $coupon = $coupon->where('place_id', $this->city);        
        if ($this->keyword) {
            $coupon =  $coupon->where('coupon_name', 'like', '%' .$this->keyword. '%')
                            ->orWhere('coupon_code', 'like', '%' .$this->keyword. '%');
        }
        return $coupon;
    }
}

