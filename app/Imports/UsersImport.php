<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $pass = Str::random(8);

        return new User([
            'name' => $row[0],
            'surname' => $pass,
            'phone' => $row[1],
            'country_id' => $row[2],
            'city_id' => $row[3],
            'gender' => $row[4],
            'user_type_id' => $row[5],
            'email' => $row[7], // temp data
            // 'email_verified_at' => $row[0],
            'phone_verified_at' => Carbon::now()->toDateTimeString(),
            'password' => Hash::make($pass),
            'socket_token' => Str::random(50),
            'is_active' => 1,
            'created_at' => now(),
            'language' => 'en',
        ]);
    }
}
