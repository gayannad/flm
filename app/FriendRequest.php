<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class,'user_to','id');
    }

    public function userFrom()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
