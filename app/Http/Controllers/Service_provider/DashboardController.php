<?php

namespace App\Http\Controllers\Service_provider;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Transactions;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        try{

            $SiteSetting = SiteSetting::first();

            $commission_percentage = $SiteSetting->commission_percentage;

            $user = auth()->user();
             $totalDeposits = Transactions::where('user_id', $user->id)
                ->whereIn('type', ['credit','refund'])
                ->where('status', 'completed')
                ->sum('amount');

            $totalWithdrawals = Transactions::where('user_id', auth()->user()->id)
                ->whereIn('type', ['withdrawal', 'commission'])
                ->where('status', 'completed')
                ->sum('amount');

            $currentBalance = $totalDeposits - $totalWithdrawals;

            $projects = Project::latest()->get();
            return view("Dashboard.service_provider.dashboard",compact(['projects','commission_percentage','currentBalance']));

        }catch(Exception $e){

            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
