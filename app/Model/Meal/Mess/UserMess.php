<?php

namespace App\Model\Meal\Mess;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserMess extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
