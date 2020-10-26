<?php

namespace App\Http\Controllers\Mess\MealManagement;

use App\Model\Meal\Mess\UserMess;

use App\Model\Meal\Mess\Market;
use App\User;

use Carbon\Carbon;

use App\Model\Role;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

class MarketController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $markets = Market::with(['updatedBy', 'member'])->latest()->paginate($request->perPage);

            return $markets;
        }

        $loggedUserMess = UserMess::where('user_id', Auth::user()->id)->first();

        $users = UserMess::with('user')->where('mess_id', $loggedUserMess->mess_id)->get();

        $messMembers = [];
        foreach ($users as $user) {
            $messMembers[] = $user->user;
        }

        $data = [
            'members' => $messMembers
        ];

        return view('mess.meal.market.index', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'member' => 'required',
            'cost'=>'required',
        ]);

        $input['date']              = $request->date;
        $input['member']            = $request->member['id'];
        $input['cost']              = $request->cost;
        $input['remarks']           = $request->remarks;
        $input['updated_by']        = Auth::user()->id;

        try{
            $market = Market::create($input);

            return response()->json(['status'=>'success','message'=>'User successfully saved !']);
        } catch(\Exception $e){
            return response()->json(['status'=>'error','message'=>'Something Error Found !, Please try again']);
        }
    }

    public function edit($id)
    {
        try {
            $data = Market::with('member')->findOrFail($id);
            return response()->json(['status'=>'success','data'=>$data]);
        } catch(\Exception $e){
            return response()->json(['status'=>'error','data'=>[]]);
        }
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'date' => 'required',
            'member' => 'required',
            'cost'=>'required',
        ]);

        $input['date']              = $request->date;
        $input['member']            = $request->member['id'];
        $input['cost']              = $request->cost;
        $input['remarks']           = $request->remarks;
        $input['updated_by']        = Auth::user()->id;

        try{
            $data = Market::FindOrFail($id);
            $data->update($input);
            return response()->json(['status'=>'success','message'=>'Market successfully updated !']);
        } catch(\Exception $e){
            return response()->json(['status'=>'error','message'=>'Something Error Found !, Please try again']);
        }
    }

    public function destroy($id)
    {
        try{
            $data = Market::FindOrFail($id);
            $data->delete();
            return response()->json(['status'=>'success','message'=>'Market successfully deleted !']);
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
