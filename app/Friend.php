<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    public function friendUser()
    {
        return $this->belongsTo(User::class,'friend_id','id');
    }
}
