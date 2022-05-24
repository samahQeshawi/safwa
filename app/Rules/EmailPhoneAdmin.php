<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;
use App\Models\Permission;
class EmailPhoneAdmin implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id,$type,$value)
    {
        $this->id = $id;
        $this->type = $type;        
        $this->value = $value;        
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $ids = Permission::pluck('id');
        if($this->type == 'phone'){
             
            if(User::whereIn('admin_user',$ids)->where('phone',$this->value)->where('id','!=',$this->id)->count()){

            } else {
                 return true;
            }
        }

        if($this->type == 'email'){

            if(User::whereIn('admin_user',$ids)->where('email',$this->value)->where('id','!=',$this->id)->count()){
               
            } else {
                 return true;
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if($this->type == "phone"){
            return 'Phone is already taken.';
        } else {
            return 'Email is already taken.';
        }
        
    }
}
