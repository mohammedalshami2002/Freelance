<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\Project;
use App\Models\Request as ModelsRequest;
use App\Models\Service;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // جلب جميع المشاريع والمستخدمين
            $projects = Project::all();
            $users = User::all();

            $requests = ModelsRequest::all();

            // حساب عدد النزاعات المفتوحة
            $openDisputesCount = Dispute::where('status', 'open_for_reply')->count();

            // حساب إجمالي المبالغ في المعاملات المكتملة
            $totalCompletedTransactions = Transactions::where('status','=', 'completed')->sum('amount');
            
            return view('Dashboard.Admin.dashboard', compact([
                'projects',
                'users',
                'openDisputesCount',
                'totalCompletedTransactions',
                'requests'
            ]));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
