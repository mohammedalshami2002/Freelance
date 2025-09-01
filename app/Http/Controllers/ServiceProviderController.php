<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{

    public function withdraw()
    {

        try {

            $user = auth()->user();

            $totalDeposits = Transactions::where('user_id', $user->id)
                ->whereIn('type', ['credit','refund'])
                ->where('status', 'completed')
                ->sum('amount');

            $totalWithdrawals = Transactions::where('user_id', auth()->user()->id)
                ->whereIn('type', ['withdrawal'])
                ->where('status', 'completed')
                ->sum('amount');

            $currentBalance = $totalDeposits - $totalWithdrawals;
            
            $settings = SiteSetting::first();
            $minimumWithdrawal = $settings->minimum_withdrawal_amount;
            $transactionFee = $settings->transaction_fee;

            $withdrawals = Transactions::where('user_id', $user->id)
                ->latest()
                ->get();

            return view('Dashboard.service_provider.withdrawals', compact('user', 'withdrawals', 'transactionFee', 'currentBalance', 'minimumWithdrawal'));
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    public function requestWithdrawal(Request $request)
    {
        try {

            $user = User::where('type_user','admin')->first();
            $settings = SiteSetting::first();
            $minimumWithdrawal = $settings->minimum_withdrawal_amount;
            $transaction_fee = $settings->transaction_fee;

            $request->validate([
                'amount' => 'required|numeric|min:' . $minimumWithdrawal,
                'method' => 'required|string',
                'details' => 'nullable|string',
            ]);

            $totalDeposits = Transactions::where('user_id', auth()->user()->id)
                ->whereIn('type', ['credit','refund'])
                ->where('status', 'completed')
                ->sum('amount');

            $totalWithdrawals = Transactions::where('user_id', auth()->user()->id)
                ->whereIn('type', ['withdrawal'])
                ->where('status', 'completed')
                ->sum('amount');

            $currentBalance = $totalDeposits - $totalWithdrawals;

            if (($request->amount + $transaction_fee) > $currentBalance) {
                return redirect()->back()->withErrors(['error' => trans('dashborad.The_amount_you_wish_to_withdraw_exceeds_your_current_balance')]);
            }

            Transactions::create([
                'user_id' => auth()->id(),
                'amount' => $request->amount - $transaction_fee,
                'type' => 'withdrawal',
                'status' => 'completed',
            ]);

            Transactions::create([
                'user_id' => auth()->id(),
                'amount' => $transaction_fee,
                'type' => 'commission',
                'status' => 'completed',
            ]);

            session()->flash('withdrawal');
            return  redirect()->back();
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
