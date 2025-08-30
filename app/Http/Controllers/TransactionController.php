<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * عرض جميع المعاملات (خاص بالمدير).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexForAdmin()
    {
        try {

            $transactions = Transactions::with(['user', 'project'])
                                       ->latest()
                                       ->paginate(10);

            return view('Dashboard.Admin.transactions.index',compact(['transactions']));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    /**
     * عرض المعاملات الخاصة بالعميل.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexForClient()
    {
        try {
            $transactions = Transactions::with(['user', 'project'])->where('user_id', auth()->user()->id)
                                       ->latest()
                                       ->paginate(10);

            return view('Dashboard.service_provider.transactions',(['transactions']));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    /**
     * عرض المعاملات الخاصة بمقدم الخدمة.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexForServiceProvider()
    {
        try {
            $transactions = Transactions::where('user_id', auth()->user()->id)
                                       ->latest()
                                       ->paginate(10);

            return view('Dashboard.service_provider.transactions',compact(['transactions']));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
