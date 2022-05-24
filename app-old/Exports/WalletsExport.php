<?php

namespace App\Exports;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WalletsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $user_type;
    protected $keyword;

    public function __construct(Request $request)
    {
        $this->user_type = $request->user_type;
        $this->keyword = $request->keyword;
    }

    public function headings(): array
    {
        return [
            'User',
            'Amount',
            'User Type',
        ];
    }

    public function map($wallet): array
    {
        return [
            $wallet->user->name,
            $wallet->amount,
            $wallet->user->userType->user_type,
        ];
    }

    public function query()
    {
        $wallet  =   Wallet::query();
        if ($this->user_type)
            $wallet = $wallet->where('user_type', $this->user_type);
        if ($this->keyword) {
            $wallet = $wallet->whereHas('user', function($q) use($keyword) {
                            $q->where('name', 'like', '%' .$keyword . '%');
                        });
        }
        return $wallet;
    }
}

