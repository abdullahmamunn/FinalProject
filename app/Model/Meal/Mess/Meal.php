<?php

namespace App\Model\Meal\Mess;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $guarded = [];


    public function member()
    {
        return $this->belongsTo(User::class, 'member');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
