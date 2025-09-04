<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\DisputeMessage;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\Transactions;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DisputeController extends Controller
{

    use UploadTrait;
    
    public function indexForAdmin()
    {
        try {

            $disputes = Dispute::with(['client', 'serviceProvider', 'project'])
                ->latest()
                ->get();

            return view('Dashboard.Admin.disputes.index', compact(['disputes']));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    
    public function showForAdmin($id)
    {
        try {

            $dispute = Dispute::with(['client', 'serviceProvider', 'project'])
                ->findOrFail($id);

            return view('Dashboard.Admin.disputes.show', compact(['dispute']));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    public function add()
    {
        try {
            $projects = Project::whereIn('status',[ 'قيد التنفيذ' , 'مكتمل'])->where('user_id',auth()->user()->id)->get();
            
            return view('Dashboard.disputes.add', compact('projects'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('message.An_error_occurred_please_try_again_later')]);
        }
    }
    

    public function resolve(Request $request, Dispute $dispute)
    {
        DB::beginTransaction();

        try {

            $project = $dispute->project;
            if ($project == null) {
                return redirect()->back()->withErrors(['error' => trans('message.project_not_found')]);
            }

            $dispute->update([
                'status' => 'resolved',
                'resolved_at' => now(),
                'resolved_by_user_id' => Auth::id(),
            ]);
            
            $projectAmount = $project->prise;
            $resolutionType = $request->input('resolution_type');
            $sitesetting = SiteSetting::get()->first();

            // التعامل مع المعاملات المالية بناءً على نوع الحل
            switch ($resolutionType) {
                case 'refund':
                    // إعادة المبلغ كاملاً للعميل
                    Transactions::create([
                        'user_id' => $dispute->client_id,
                        'project_id' => $project->id,
                        'amount' => $projectAmount,
                        'type' => 'refund',
                        'status' => 'completed',
                        'description' => 'dispute refund full',
                    ]);

                    Transactions::where('project_id', $project->project_id)
                                ->where('user_id', '=', $dispute->service_provider_id)
                                ->where('type', '=', 'commission')
                                ->update([
                                            'status' => 'failed',
                                            'description' => ' null',
                    ]);

                    Transactions::where('project_id', $project->project_id)
                                ->where('user_id', '=', $dispute->service_provider_id)
                                ->where('type', '=', 'deposit')
                                ->update([
                                            'status' => 'failed',
                                            'description' => ' null',
                    ]);
                    break;
                case 'pay_service_provider':

                    $transaction = Transactions::where('project_id', $project->project_id)
                                ->where('user_id', '=', $dispute->service_provider_id)
                                ->where('type', '=', 'commission')->first();

                    $transaction->status = 'completed';
                    $transaction->save();

                    $transaction = Transactions::where('project_id', $project->project_id)
                                ->where('user_id', '=', $dispute->service_provider_id)
                                ->where('type', '=', 'deposit')
                                ->first();
                                
                    // سجل الدفع لمقدم الخدمة
                    Transactions::create([
                        'user_id' => $dispute->service_provider_id,
                        'project_id' => $project->id,
                        'amount' => $transaction->amount,
                        'type' => 'credit',
                        'status' => 'completed',
                        'description' => 'dispute_payment_full',
                    ]);
                    break;
            }

            // إضافة رسالة النزاع
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $this->uploadImage($request->hasFile('attachment'), '/assets/image/Dispute');

                if ($attachmentPath == false) {
                    return redirect()->back()->withErrors(['error' => trans('meesage.Failed_to_upload_image')]);
                }
            }
            $dispute->messages()->create([
                'user_id' => Auth::id(),
                'message' => $request->input('message'),
                'attachment_path' => $attachmentPath,
            ]);

            DB::commit();

            session()->flash('add');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }


    
    public function index()
    {
        // Get all disputes where the authenticated user is either the client or the service provider.
        $disputes = Dispute::where('client_id', Auth::id())
            ->orWhere('service_provider_id', Auth::id())
            ->with(['project', 'client', 'serviceProvider'])
            ->latest()
            ->get();

        return view('Dashboard.disputes.index', compact('disputes'));
    }

    
    public function show(Dispute $dispute)
    {
        // Ensure the authenticated user is a party to this dispute.
        if (Auth::id() !== $dispute->client_id && Auth::id() !== $dispute->service_provider_id) {
            return back()->with('error', 'Unauthorized access.');
        }

        // Eager load related models to prevent N+1 query problem.
        $dispute->load(['project', 'client', 'serviceProvider', 'messages.user']);

        return view('Dashboard.disputes.show', compact('dispute'));
    }

    
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'project_id' => [
                    'required',
                    'exists:projects,id',
                    Rule::exists('projects', 'id')->where(function ($query) {
                        return $query->where('user_id', Auth::id());
                    }),
                ],
                'initial_reason' => 'required|string|max:1000',
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);

            $user = Auth::user();

            $project = Project::findOrFail($validatedData['project_id']);

            
            if (Dispute::where('project_id', $project->id)->where('status', 'open_for_reply')->exists()) {
                DB::rollBack();
                return redirect()->back()->withErrors(['error' => trans('dashboard.There_is_already_an_open_dispute_for_this_project')]);
            }

            $dispute = Dispute::create([
                'project_id' => $validatedData['project_id'],
                'client_id' => $user->id,
                'service_provider_id' => $project->receiver_user_id,
                'initial_reason' => $validatedData['initial_reason'],
                'status' => 'open_for_reply',
            ]);

            $attachmentPath = null;
            if ($request->hasFile('attachment')) {

                $attachmentPath = $this->uploadImage($request->file('attachment'), '/assets/image/Dispute');

                if ($attachmentPath == false) {

                    DB::rollBack();
                    return redirect()->back()->withErrors(['error' => trans('message.Failed_to_upload_image')]);
                }
            }

            DisputeMessage::create([
                'dispute_id' => $dispute->id,
                'user_id' => $user->id,
                'message' => $validatedData['initial_reason'],
                'attachment_path' => $attachmentPath,
            ]);

            DB::commit();

            session()->flash('add');
            return redirect()->back();
            
        } catch (\Exception $e) {

            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

   
    public function addMessage(Request $request, Dispute $dispute)
    {
        try {
            $validatedData = $request->validate([
                'message' => 'required|string|max:1000',
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);

            $user = Auth::user();

            // Ensure the user is a party to the dispute and the dispute is not resolved.
            if ($user->id !== $dispute->client_id && $user->id !== $dispute->service_provider_id) {
                return response()->json(['error' => 'Unauthorized.'], 403);
            }
            if ($dispute->status === 'resolved') {
                return response()->json(['error' => 'This dispute has been resolved, you cannot add messages.'], 403);
            }

            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $this->uploadImage($request->hasFile('attachment'), '/assets/image/Dispute');

                if ($attachmentPath == false) {
                    return redirect()->back()->withErrors(['error' => trans('meesage.Failed_to_upload_image')]);
                }
            }

            DisputeMessage::create([
                'dispute_id' => $dispute->id,
                'user_id' => $user->id,
                'message' => $validatedData['message'],
                'attachment_path' => $attachmentPath,
            ]);
            session()->flash('add');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
