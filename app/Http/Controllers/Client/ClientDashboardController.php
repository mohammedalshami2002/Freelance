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
            // Get the authenticated user's ID
            $userId = Auth::id();

            // Count offers received by the client's projects
            // This is more relevant to a client than counting their own offers (which they don't make)
            $offersReceived = Offer::whereHas('project', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->count();

            // Get projects created by the client
            $projects = Project::where('user_id', $userId)->latest()->get();

            // Count client-related disputes
            $disputesPendingCount = Dispute::where('status', 'open_for_reply')
                                            ->where('client_id', $userId)
                                            ->count();

            $disputesResolvedCount = Dispute::where('status', 'resolved')
                                            ->where('client_id', $userId)
                                            ->count();
            
            // This count is for projects the client has initiated and are currently in progress
            $projectsInProgress = Project::where('user_id', $userId)
                                           ->where('status', 'in_progress')
                                           ->count();
            
            // A simple placeholder for commission, this would likely be fetched from a config or database
            $commission_percentage = 10;

            // Pass the relevant data to the view
            return view('Dashboard.Client.dashboard', compact(
                'offersReceived',
                'projects',
                'disputesPendingCount',
                'disputesResolvedCount',
                'projectsInProgress',
                'commission_percentage'
            ));

        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
