<?php

namespace App\Http\Controllers\Mess\MealManagement;

use App\Model\Meal\Mess\Balance;
use App\Model\Meal\Mess\UserMess;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $meals = Balance::with(['updatedBy', 'member'])->latest()->paginate($request->perPage);

            return $meals;
        }

        $loggedUserMess = UserMess::where('user_id', Auth::user()->id)->first();

        if (!$loggedUserMess) {
            abort(404);
        }

        $users = UserMess::with('user')
            ->where('mess_id', $loggedUserMess->mess_id)
            ->get();

        $messMembers = [];
        foreach ($users as $itemObj) {
            if ($itemObj->user) {
                $messMembers[] = $itemObj->user;
            }
        }

        $data = [
            'members' => $messMembers
        ];

        return view('mess.meal.balance.index', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'member' => 'required',
            'amount'=>'required',
        ]);

        $input['date']              = $request->date;
        $input['member']            = $request->member['id'];
        $input['amount']            = $request->amount;
        $input['remarks']           = $request->remarks;
        $input['updated_by']        = Auth::user()->id;

        try{
            $previousBalance = Balance::where('member' , $request->member['id'])->first();

            if ($previousBalance) {
                $previousBalance->update([
                    'amount' => (int) $previousBalance->amount + (int) $request->amount,
                    'remarks' => $request->remarks,
                    'updated_by' => Auth::user()->id,
                ]);
            }else {
                Balance::create($input);
            }

            return response()->json(['status'=>'success','message'=>'Balance successfully saved !']);
        } catch(\Exception $e){
            return response()->json(['status'=>'error','message'=>'Something Error Found !, Please try again']);
        }
    }

    public function edit($id)
    {
        try {
            $data = Balance::with('member')->findOrFail($id);
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
            'amount'=>'required',
        ]);

        $input['date']              = $request->date;
        $input['member']            = $request->member['id'];
        $input['amount']              = $request->amount;
        $input['remarks']           = $request->remarks;
        $input['updated_by']        = Auth::user()->id;

        try{
            $data = Balance::FindOrFail($id);
            $data->update($input);
            return response()->json(['status'=>'success','message'=>'Balance successfully updated !']);
        } catch(\Exception $e){
            return response()->json(['status'=>'error','message'=>'Something Error Found !, Please try again']);
        }
    }

    public function destroy($id)
    {
        try{
            $data = Balance::FindOrFail($id);
            $data->delete();
            return response()->json(['status'=>'success','message'=>'Balance successfully deleted !']);
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
