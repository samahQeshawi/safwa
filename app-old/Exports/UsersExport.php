<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $city;
    protected $user_type;
    protected $keyword;

    public function __construct(Request $request)
    {
        $this->city = $request->city;
        $this->user_type = $request->user_type;
        $this->keyword = $request->keyword;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
        ];
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            $user->phone,
            //Date::dateTimeToExcel($invoice->created_at),
        ];
    }

    public function query()
    {
        $users  =   User::query();
        if ($this->city)
            $users = $users->where('city_id', $this->city);
        if ($this->user_type)
            $users = $users->where('user_type_id', $this->user_type);
        if ($this->keyword)
            $users = $users->where('phone', 'like', '%' .$this->keyword. '%')
                        ->orWhere('name',  'like', '%' .$this->keyword. '%')
                        ->orWhere('email',  'like', '%' .$this->keyword. '%');
        return $users;
    }
}

