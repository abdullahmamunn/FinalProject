<?php

namespace App\Http\Controllers\Mess\MealManagement;

use App\Enum\UserRole;
use App\Model\Meal\Mess\UserMess;
use App\User;

use Carbon\Carbon;

use App\Model\Role;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $userMess = UserMess::where('user_id', auth()->user()->id)->first();

            $userIds = UserMess::where('mess_id', $userMess->mess_id)
                ->where('user_id', '!=', $userMess->user_id)
                ->get()
                ->pluck('user_id');

            $users = User::with('userRole')
                ->orderBy('id', 'desc')
                ->whereIn('id', $userIds)
                ->paginate($request->perPage);

            return $users;
        }

        return view('mess.meal.member.index', [
            'roleList' => Role::where('role_name', UserRole::$MANAGER)
                ->orWhere('role_name', UserRole::$MEMBER)
                ->get()
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
            'role_id'=>'required',
            'username' => 'required|unique:users',
            'password'=>'required|min:6|confirmed',
            'password_confirmation'=>'required',
            'email' => 'nullable|email|max:255|unique:users',
        ]);

        $input['name']          = $request->name;
        $input['email']         = $request->email;
        $input['username']      = $request->username;
        $input['status']        = $request->status;
        $input['role_id']       = $request->role_id;
        $input['remember_token']= str_random(10);
        $input['password']      = Hash::make($request->password);
        $input['created_by']    = Auth::user()->id;
        $input['created_at']    = Carbon::now();

        try{
            $user = User::create($input);

            $loggedUser = User::whereHas('userRole')->with('mess')->find(Auth::user()->id);

            if ($loggedUser) {
                UserMess::create([
                    'user_id' => $user->id,
                    'mess_id' => $loggedUser->mess->mess_id,
                ]);
            }

            return response()->json(['status'=>'success','message'=>'User successfully saved !']);
        } catch(\Exception $e){
            return response()->json(['status'=>'error','message'=>'Something Error Found !, Please try again']);
        }
    }

    public function edit($id)
    {
        try {
            $data = User::findOrFail($id);
            return response()->json(['status'=>'success','data'=>$data]);
        } catch(\Exception $e){
            return response()->json(['status'=>'error','data'=>[]]);
        }
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
            'role_id'=>'required',
            'username'      => 'required|unique:users,username,'.$id,
            'email' => 'nullable|email|max:255|unique:users,email,'.$id,
        ]);

        $input['name']          = $request->name;
        $input['email']         = $request->email;
        $input['username']      = $request->username;
        $input['status']        = $request->status;
        $input['role_id']       = $request->role_id;

        try{
            $data = User::FindOrFail($id);
            $data->update($input);
            return response()->json(['status'=>'success','message'=>'User successfully updated !']);
        } catch(\Exception $e){
            return response()->json(['status'=>'error','message'=>'Something Error Found !, Please try again']);
        }
    }

    public function destroy($id)
    {
        try{
            $data = User::FindOrFail($id);
            $data->delete();
            return response()->json(['status'=>'success','message'=>'User successfully deleted !']);
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
            if ($bug == 1451) {
                return response()->json(['status'=>'error','message'=>'This data is used another table,can not delete data']);
            } else {
                return response()->json(['status'=>'error','message'=>'Something Error Found !, Please try again']);
            }
        }
    }
}
