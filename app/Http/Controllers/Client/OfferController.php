<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Offer;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function enable($id)
    {
        try {
            DB::beginTransaction();
            // البحث عن العرض الذي سيتم قبوله
            $offer = Offer::findOrFail($id);

            $project = Project::where('id', '=', $offer->project_id)->first();

            if ($project->user_id !== auth()->id()) {
                abort(403, 'غير مصرح لك بتنفيذ هذا الإجراء.');
            }
            // تغيير حالة العرض المقبول إلى "مقبول"
            $offer->status = '2';
            $offer->save();
            $project->status = 'قيد التنفيذ';
            $project->receiver_user_id = $offer->user_id;
            $project->save();
            // تحديث باقي العروض المرتبطة بنفس المشروع إلى "مستبعدة"
            Offer::where('project_id', $offer->project_id)
                ->where('user_id', '!=', $offer->user_id)
                ->update(['status' => '1']);
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
            // إرسال رسالة نجاح
            DB::commit();
            session()->flash('enable');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
