<?php

namespace App\Http\Controllers\Mess\MealManagement;

use App\Model\Meal\Mess\UserMess;

use App\Model\Meal\Mess\Meal;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class MealController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $meals = Meal::with(['updatedBy', 'member'])
                ->latest()
                ->whereMonth('date', Carbon::now()->month)
                ->get();

            $result = [];
            foreach($meals as $meal){
                $result[$meal->date][] = $meal;
            }

            return response()->json(['data' => $result], 200);
        }

        $loggedUserMess = UserMess::where('user_id', Auth::user()->id)->first();

        $users = UserMess::with('user')
            ->where('mess_id', $loggedUserMess->mess_id)
            ->get();

        $messMembers = [];
        foreach ($users as $user) {
            $messMembers[] = $user->user;
        }

        $data = [
            'members' => $messMembers
        ];

        return view('mess.meal.meal.index', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'meals' => 'required',
        ]);

        try{
            foreach ($request->meals as $meal) {
                $previousEntries = Meal::whereDate('date', Carbon::parse($request->date)->toDateString())
                    ->where('member', $meal['member']['id'])
                    ->get();

                if ($previousEntries->count() > 0) {
                    foreach ($previousEntries as $item) {
                        $item->whereDate('date', Carbon::parse($request->date)->toDateString())
                            ->where('member', $meal['member']['id'])
                            ->update([
                                'total_meal' => $meal['total_meal'] + $item->total_meal,
                                'remarks' => $meal['remarks'] ? $meal['remarks']  : $item->remarks,
                                'updated_by' => Auth::user()->id,
                            ]);
                    }
                } else {
                    Meal::create([
                        'date'             => $request->date,
                        'member'           => $meal['member']['id'],
                        'total_meal'        => $meal['total_meal'],
                        'remarks'          => $meal['remarks'],
                        'updated_by'        => Auth::user()->id
                    ]);
                }
            }


            return response()->json(['status'=>'success','message'=>'Meal successfully saved !']);
        } catch(\Exception $e){
            return response()->json(['status'=>'error','message'=>'Something Error Found !, Please try again']);
        }
    }

    public function edit($date)
    {
        try {
            $data = [
                'meals' => Meal::with('member')->where('date', $date)->get(),
                'date' => $date
            ];

            return response()->json(['status'=>'success','data' => $data]);
        } catch(\Exception $e){
            return response()->json(['status'=>'error','data'=>[]]);
        }
    }

    public function update(Request $request,$date)
    {
        $this->validate($request, [
            'date' => 'required',
            'meals' => 'required',
        ]);

        try{
            foreach ($request->meals as $meal) {
                $previousEntries = Meal::whereDate('date', Carbon::parse($request->date)->toDateString())
                    ->where('member', $meal['member']['id'])
                    ->get();

                if ($previousEntries->count() > 0) {
                    foreach ($previousEntries as $item) {
                        $item->whereDate('date', Carbon::parse($request->date)->toDateString())
                            ->where('member', $meal['member']['id'])
                            ->update([
                                'total_meal' => $meal['total_meal'],
                                'remarks' => $meal['remarks'] ? $meal['remarks']  : '',
                                'updated_by' => Auth::user()->id,
                            ]);
                    }
                } else {
                    Meal::create([
                        'date'             => Carbon::parse($request->date)->toDateString(),
                        'member'           => $meal['member']['id'],
                        'total_meal'        => $meal['total_meal'],
                        'remarks'          => $meal['remarks'],
                        'updated_by'        => Auth::user()->id
                    ]);
                }
            }


            return response()->json(['status'=>'success','message'=>'Meal successfully updated !']);
        } catch(\Exception $e){
            return response()->json(['status'=>'error','message'=>'Something Error Found !, Please try again']);
        }
    }

    public function destroy($date)
    {
        try{
            $data = Meal::where('date', $date)->delete();

            return response()->json(['status'=>'success','message'=>'Meals successfully deleted !']);
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
