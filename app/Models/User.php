<?php

namespace App\Models;

use App\Components\Contracts\Gate as GateContract;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;



    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                    'name',
                    'surname',
                    'email',
                    'phone',
                    'user_type_id',
                    'password',
                    'gender',
                    'address',
                    'zipcode',
                    'country_id',
                    'city_id',
                    'email_verified_at',
                    'password',
                    'remember_token',
                    'socket_token',
                    'profile_image',
                    'is_active',
                    'is_online',
                    'admin_user'
                ];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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
     * Get the coupon for this model.
     *
     * @return App\Models\UserCoupon
     */
    public function coupon()
    {
        return $this->belongsTo('App\Models\UserCoupon','user_id');
    }

    /**
     * Get the company record associated with the user.
     */
    public function company()
    {
        return $this->hasOne('App\Models\Company');
    }
    /**
     * Get the driver record associated with the user.
     */
    public function driver()
    {
        return $this->hasOne('App\Models\Driver');
    }
    /**
     * Get the passenger record associated with the user.
     */
    public function customer()
    {
        return $this->hasOne('App\Models\Customer');
    }

    /**
     * Get the userType for this model.
     *
     * @return App\Models\UserType
     */
    public function userType()
    {
        return $this->belongsTo('App\Models\UserType','user_type_id');
    }

    /**
     * Get the userType for this model.
     *
     * @return App\Models\UserType
     */
    public function permission()
    {
        return $this->belongsTo('App\Models\Permission','admin_user');
    }

    /**
     * Get the country for this model.
     *
     * @return App\Models\Country
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country','country_id');
    }


    /**
     * Get the city for this model.
     *
     * @return App\Models\City
     */
    public function city()
    {
        return $this->belongsTo('App\Models\City','city_id');
    }

    /**
     * Get the city for this model.
     *
     * @return App\Models\Rating
     */
    public function rating()
    {
        return $this->hasMany('App\Models\Rating','rated_for');
    }

    /**
     * Get the city for this model.
     *
     * @return App\Models\Rating
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction','done_by');
    }

    /**
     * Get the city for this model.
     *
     * @return App\Models\Rating
     */
    public function userRating($id)
    {
        $ratingObj    =   Rating::where('rated_for', $id);
        $rating       =   round($ratingObj->avg('rating'), 2);
        return $rating;
    }

    /**
     * Set the email_verified_at.
     *
     * @param  string  $value
     * @return void
     */
    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = !empty($value) ? Carbon::parse($value)->isoFormat('[% date_format %]') : null;

    }

    /**
     * Get email_verified_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getEmailVerifiedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('MMMM Do YYYY, h:mm:ss a');

    }

    /**
     * Get created_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('MMMM Do YYYY, h:mm:ss a');

    }

    /**
     * Get updated_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('MMMM Do YYYY, h:mm:ss a');

    }
    /**
     * Get the User Status.
     *
     * @param  string  $value
     * @return string
     */
    public function getIsActiveAttribute($value)
    {
        return $value ? 'Active': 'Inactive';
    }

    public function adminlte_image()
    {
        return 'https://picsum.photos/300/300';
    }

    public function adminlte_desc()
    {
        return 'That\'s a nice guy';
    }

    public function adminlte_profile_url()
    {
        return 'profile/username';
    }

    /**
     * Scope a query to only include active coupons.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    //For chat messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function hasPermissionTo($oper, $id) {
        return PermissionRole::where('role_id',$this->admin_user)->where('role_permission_id',$id)->where($oper,1)->count();
      }

      public function getRoleNames(){
        return UserType::find($this->user_type_id)->pluck('user_type');
      }

      public function hasAccess($oper){
         list($oper,$perm)  = explode(" ",$oper);
        return PermissionRole::where('role_id',$this->admin_user)->whereHas('permmissionRole',function($query) use ($perm) {
            $query->where('code',$perm);
        })->where($oper,1)->count();
      }
}
