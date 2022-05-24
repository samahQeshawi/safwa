<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class NotificationDetail extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notification_details';

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
                  'notification_id',
                  'format',
                  'user_type_id',
                  'user_id',
                  'sent_by',
                  'send_on'
              ];

    /**
     * The attributes to disable timestamp.
     *
     * @var boolean
     */
    public $timestamps = false;

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

}
