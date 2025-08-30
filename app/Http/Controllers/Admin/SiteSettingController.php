<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteSettingController extends Controller
{

    public function index()
    {
        try {

            $sitesetting = SiteSetting::first();
            return view("Dashboard.Admin.sitesetting.index", compact('sitesetting'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'withdrawal_account_number' => 'required|string|max:255',
            'commission_percentage'     => 'required|numeric|min:0|max:100',
            'minimum_withdrawal_amount' => 'required|numeric|min:0',
            'transaction_fee'           => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $sitesetting = SiteSetting::first();
            if (!$sitesetting) {
                $sitesetting = new SiteSetting();
            }

            $sitesetting->withdrawal_account_number = $request->withdrawal_account_number;
            $sitesetting->commission_percentage     = $request->commission_percentage;
            $sitesetting->minimum_withdrawal_amount = $request->minimum_withdrawal_amount;
            $sitesetting->transaction_fee           = $request->transaction_fee;

            $sitesetting->save();

            DB::commit();

            session()->flash('update', trans('dashboard.update'));

            return redirect()->route('Site_Setting');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'error' => trans('meesage.An_error_occurred_please_try_again_later')
            ]);
        }
    }
}
