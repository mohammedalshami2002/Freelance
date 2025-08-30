<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\DisputeMessage;
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
    /**
     * عرض جميع النزاعات (خاص بالمدير).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * عرض تفاصيل نزاع معين (خاص بالمدير).
     *
     * @param  \App\Models\Dispute  $dispute
     * @return \Illuminate\Http\Response
     */
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
    /**
     * Resolve a dispute and handle financial transactions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dispute  $dispute
     * @return \Illuminate\Http\RedirectResponse
     */
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
                    break;
                case 'pay_service_provider':
                    // دفع المبلغ كاملاً لمقدم الخدمة مع خصم العمولة
                    $commissionRate = $sitesetting->commission_percentage;
                    $commissionAmount = $projectAmount * ($commissionRate/100);
                    $payoutAmount = $projectAmount - $commissionAmount;

                    // سجل الدفع لمقدم الخدمة
                    Transactions::create([
                        'user_id' => $dispute->service_provider_id,
                        'project_id' => $project->id,
                        'amount' => $payoutAmount,
                        'type' => 'credit',
                        'status' => 'completed',
                        'description' => 'dispute_payment_full',
                    ]);

                    // سجل عمولة المنصة
                    Transactions::create([
                        'user_id' => Auth::id(),
                        'project_id' => $project->id,
                        'amount' => $commissionAmount,
                        'type' => 'commission',
                        'status' => 'completed',
                        'description' => 'project_commission_fee',
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
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * Display a listing of the disputes for the authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all disputes where the authenticated user is either the client or the service provider.
        $disputes = Dispute::where('client_id', Auth::id())
            ->orWhere('service_provider_id', Auth::id())
            ->with(['project', 'client', 'serviceProvider'])
            ->get();

        return view('Dashboard.disputes.index', compact('disputes'));
    }

    /**
     * Display the specified dispute details.
     *
     * @param  \App\Models\Dispute  $dispute
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
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

    /**
     * Store a newly created dispute in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'project_id' => [
                    'required',
                    'exists:projects,id',
                    // التحقق من أن المشروع يخص المستخدم الحالي (العميل)
                    Rule::exists('projects', 'id')->where(function ($query) {
                        return $query->where('client_id', Auth::id());
                    }),
                ],
                'initial_reason' => 'required|string|max:1000',
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);

            $user = Auth::user();

            // جلب المشروع من خلال المستخدم الحالي للتأكد من الملكية
            $project = $user->project()->findOrFail($validatedData['project_id']);

            $dispute = Dispute::create([
                'project_id' => $validatedData['project_id'],
                'client_id' => $user->id,
                'service_provider_id' => $project->service_provider_id,
                'initial_reason' => $validatedData['initial_reason'],
                'status' => 'open',
            ]);

            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $this->uploadImage($request->hasFile('attachment'), '/assets/image/Dispute');

                if ($attachmentPath == false) {
                    return redirect()->back()->withErrors(['error' => trans('meesage.Failed_to_upload_image')]);
                }
            }

            // إضافة رسالة أولية للنزاع
            DisputeMessage::create([
                'dispute_id' => $dispute->id,
                'user_id' => $user->id,
                'message' => $validatedData['initial_reason'],
                'attachment_path' => $attachmentPath,
            ]);

            return response()->json(['message' => 'Dispute created successfully.', 'dispute' => $dispute]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    /**
     * Add a message to a dispute (for client or service provider).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dispute  $dispute
     * @return \Illuminate\Http\JsonResponse
     */
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
