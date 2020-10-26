<?php

namespace App\Http\Controllers\Auth;

use App\Enum\UserStatus;
use App\Model\Meal\Mess\Mess;
use App\Model\Meal\Mess\UserMess;
use App\Model\Role;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $messAdminRole = Role::where('role_name', 'Mess Admin')->first();

        if ($messAdminRole) {
            $mess = Mess::create([
                'title' => rand()
            ]);

            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'role_id' => $messAdminRole->role_id,
                'email' => $data['email'],
                'status' => (string) UserStatus::$ACTIVE,
                'password' => Hash::make($data['password']),
            ]);

            UserMess::create([
                'user_id' => $user->id,
                'mess_id' => $mess->id,
            ]);
            return $user;
        } else {
            dd('Mess Admin Role Not Found');
        }


    }

    public function showSignupForm()
    {
        return view('registration');
    }
}
