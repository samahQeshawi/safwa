<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Permission extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions1';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'user_type',
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Get the Category for this model.
     *
     * @return App\Models\Customer
     */
    public function permmissions()
    {
        return $this->belongsTo('App\Models\PermissionRole', 'role_id');
    }
   
}
