<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

     /**
     * Get the users for each user type.
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
