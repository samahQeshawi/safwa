<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sender_id', 'receiver_id','trip_id','message_type','message','status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
