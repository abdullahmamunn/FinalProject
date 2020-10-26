<?php

namespace App\Http\Controllers\Mess\MealManagement;

use App\Http\Controllers\Controller;
use App\Model\Meal\Mess\UserMess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->dashboardData();
        }

        return view('mess.meal.dashboard');
    }

    public function dashboardData()
    {
        $loggedUserMess = UserMess::where('user_id', Auth::user()->id)->first();

        $users = UserMess::with(['user.meals' => function ($q) {
            $q->whereMonth('date', Carbon::now()->month);
        }, 'user.balances' => function ($q) {
            $q->whereMonth('date', Carbon::now()->month);
        }, 'user.markets' => function ($q) {
            $q->whereMonth('date', Carbon::now()->month);
        }])
            ->where('mess_id', $loggedUserMess->mess_id)
            ->get();

        $totalMembers = $users->count();

        $totalBalance = 0;
        $totalMarket = 0;
        $totalMeals = 0;
        $tHead['Date'] = 'Date';
        $footer['title'] = 'Total';
        foreach ($users as $item) {
            $tHead[$item->user->name] = $item->user->name;
            $footer[$item->user->name] = 0;

            if (!$item->user->balances->count() > 0) {
                $totalBalance += 0;
            } else {
                foreach ($item->user->balances as $balance) {
                    $totalBalance += $balance->amount;
                }
            }

            if (!$item->user->markets->count() > 0) {
                $totalMarket += 0;
            } else {
                foreach ($item->user->markets as $market) {
                    $totalMarket += $market->cost;
                }
            }

            if (!$item->user->meals->count() > 0) {
                $totalMeals += 0;
            } else {
                foreach ($item->user->meals as $meal) {
                    $totalMeals += $meal->total_meal;
                }
            }
        }


        foreach ($tHead as $key => $headItem) {
            for ($i = 1; $i <= date('t'); $i++) {
                $date = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
                $tBody[$date]['Date'] = $date;

                foreach ($users as $item) {
                    foreach ($item->user->meals as $meal) {
                        $tBody[$meal->date][$item->user->name] = $meal->total_meal;
                    }

                }
            }
        }

        foreach ($tBody as $bodyKey => $item) {

            $newArray[$bodyKey] = $tHead;
            foreach ($newArray[$bodyKey] as  $Headkey => $headItem) {
                if (isset($item[$Headkey])) {
                    $newArray[$bodyKey][$Headkey] = $item[$Headkey];
                } else {
                    $newArray[$bodyKey][$Headkey] = 0;
                }
            }
        }

        $totalMeal = 0;
        foreach ($tBody as $bodyKey => $body) {
            foreach ($footer as $key => $item) {
                if (isset($body[$key])) {
                    $footer[$key] += $body[$key];
                    $totalMeal += $body[$key];
                }
            }
        }

        $footer['month_total'] = $totalMeal;

        $meals = array_values($newArray);
        usort($meals, 'date_compare');

        $data = [
            'current_month' => Carbon::now()->format('M d, Y'),
            'head' => $tHead,
            'meals' => $meals,
            'footer' => $footer,
            'card_data' => [
                'total_members' => $totalMembers,
                'total_balance' => $totalBalance,
                'total_market' => $totalMarket,
                'total_meal' => $totalMeals,
            ],
        ];

        return response()->json($data, 200);
    }



}
