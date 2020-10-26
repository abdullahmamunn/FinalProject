<?php

namespace App;

use App\Model\Meal\Mess\Balance;
use App\Model\Meal\Mess\Market;
use App\Model\Meal\Mess\Meal;
use App\Model\Meal\Mess\UserMess;
use App\Model\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    public $timestamps = false;

    protected $table = 'users';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->hasOne(Role::class,'role_id','role_id');
    }

    public function mess()
    {
        return $this->hasOne(UserMess::class, 'user_id');
    }

    public function userRole()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function meals()
    {
        return $this->hasMany(Meal::class, 'member');
    }

    public function balances()
    {
        return $this->hasMany(Balance::class, 'member');
    }

    public function markets()
    {
        return $this->hasMany(Market::class, 'member');
    }


}
