<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Offer;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function enable($id)
    {
        try {
            DB::beginTransaction();
            $offer = Offer::findOrFail($id);

            $project = Project::where('id', '=', $offer->project_id)->first();

            if ($project->user_id !== auth()->id()) {
                abort(403, 'غير مصرح لك بتنفيذ هذا الإجراء.');
            }

            $offer->status = '2';
            $offer->save();

            $project->status = 'قيد التنفيذ';
            $project->receiver_user_id = $offer->user_id;
            $project->prise = $offer->price;
            $project->save();

            Offer::where('project_id', $offer->project_id)
                ->where('user_id', '!=', $offer->user_id)
                ->update(['status' => '1']);

            
            $projectAmount = $project->prise;
            $sitesetting = SiteSetting::get()->first();

            $commissionRate = $sitesetting->commission_percentage;
            $commissionAmount = $projectAmount * ($commissionRate/100);
            $payoutAmount = $projectAmount - $commissionAmount;

            
            Transactions::create([
                'user_id' => $offer->user_id, 
                'project_id' => $project->id,
                'amount' => $commissionAmount,
                'type' => 'commission',
                'status' => 'pending',
                'description' => 'project_commission_fee',
            ]);

            Transactions::create([
                'user_id' => $offer->user_id,
                'project_id' => $project->id,
                'amount' => $payoutAmount,
                'type' => 'deposit',
                'status' => 'completed',
                'description' => 'dispute refund full',
            ]);

            $chat = new Chat();
            $chat->first_user = auth()->user()->id;
            $chat->second_user = $offer->user_id;
            $chat->save();
        
            $send = new ChatMessage();
            $send->type = 1;
            $send->content = ' تم قبول عرضك لستلام مشروع ' . $project->name . 'يسعدني ان اتعاون معك ';
            $send->chat_id = $chat->id;
            $send->sender_id = auth()->user()->id;
            $send->save();

            DB::commit();
            session()->flash('enable');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
