<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PermissionRole extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions_role';

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
                  'role_id',
                  'role_permission_id',
                  'view',
                  'add',
                  'edit',
                  'delete'
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
    public function permmissionRole()
    {
        return $this->hasOne('App\Models\PermissionRoleMaster', 'role_permission_id');
    }
}
