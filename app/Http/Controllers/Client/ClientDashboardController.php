<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\Offer;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientDashboardController extends Controller
{
    public function index()
    {
        try {

            $userId = Auth::id();

            $offersReceived = Offer::whereHas('project', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->count();

            $projects = Project::where('user_id', $userId)->latest()->get();

            $disputesPendingCount = Dispute::where('status', 'open_for_reply')
                                            ->where('client_id', $userId)
                                            ->count();

            $disputesResolvedCount = Dispute::where('status', 'resolved')
                                            ->where('client_id', $userId)
                                            ->count();
            
            $projectsInProgress = Project::where('user_id', $userId)
                                           ->where('status', 'قيد التنفيذ')
                                           ->count();
            

            return view('Dashboard.Client.dashboard', compact(
                'offersReceived',
                'projects',
                'disputesPendingCount',
                'disputesResolvedCount',
                'projectsInProgress',
            ));

        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
