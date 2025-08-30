<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\Forget_password;
use App\Models\User;
use App\Traits\UserRedirectTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use UserRedirectTrait;

    public function welcome()
    {
        try {
            return view('welcome');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
    public function index()
    {
        try {
            return view('auth.login');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'min:8'],
        ]);
        try {
            $user = User::where('email', $request->email)->first();
            if ($user->is_blocked) {
                return redirect()->back()->withErrors(['error' => trans('meesage.This_account_is_banned')]);
            }
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                if ($user->is_verified == false) {
                    $code = random_int(100000, 999999);
                    $user->code_verifie = $code;
                    $user->verification_expires_at = now()->addMinutes(10);
                    $user->save();
                    Mail::to($request->email)->send(new VerificationCodeMail($code));
                    return redirect()->route('verification');
                }
                return $this->redirectUserByType($user);
            } else {

                return redirect()->back()->withErrors(['error' => trans('validation.current_password')]);
            }
        } catch (Exception $e) {

            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    public function verification()
    {
        $user = auth()->user();
        return view('auth.verification', compact('user'));
    }
    
    public function check(Request $request)
    {
        try {
            $request->validate([
                'code' => ['required', 'numeric', 'digits:6']
            ]);
            $user = User::where('email', auth()->user()->email)->first();
            $expiresAt = Carbon::parse($user->verification_expires_at);

            if (!$expiresAt || $expiresAt->isPast()) {
                return back()->withErrors([
                    'code' => trans('meesage.The_verification_code_has_expired')
                ]);
            }
            if ($user->code_verifie == $request->code) {
                $user->is_verified = true;
                $user->code_verifie = null;
                $user->verification_expires_at = null;
                $user->save();
                return $this->redirectUserByType($user);
            } else {
                
                return back()->withErrors(['errors' => trans('meesage.The_verification_code_is_incorrect')]);
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.index');
    }
    public function password()
    {
        try {
            return view('auth.password');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
    public function forget_password(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);
        $user = User::where('email', '=', $request->email)->first();
        $password = Forget_password::where('user_id', '=', $user->id)->get();
        if ($password->count()) {
            $password = Forget_password::where('user_id', '=', $user->id)->delete();
        }
        $forget_password = new Forget_password();
        $code = random_int(100000, 999999);
        $forget_password->code_verifie = $code;
        $forget_password->user_id = $user->id;
        $forget_password->verification_expires_at = now()->addMinutes(5);
        $forget_password->save();
        Mail::to($request->email)->send(new VerificationCodeMail($code));
        return view('auth.verification_password', compact('user'));
    }
    public function virfction_password(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email', 'exists:users,email'],
                'code' => ['required', 'numeric', 'digits:6']
            ]);
            $user = User::where('email', '=', $request->email)->first();
            $forget_password = Forget_password::where('user_id', $user->id)->latest()->first();
            $expiresAt = Carbon::parse($forget_password->verification_expires_at);
            if ($expiresAt->isPast()) {
                return redirect()->back()->withErrors(['code' => trans('meesage.The_verification_code_has_expired')]);
            }
            if ($request->code == $forget_password->code_verifie) {
                $forget_password->delete();
                return view('auth.password_change', compact('user'));
            } else {
                return redirect()->back()->withErrors(['code' => trans('meesage.The_verification_code_is_incorrect')]);
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
    public function change_password(Request $request)
    {
        $request->validate([
            'new_password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'min:8', 'same:new_password'],
            'email' => ['required', 'email', 'exists:users,email'],
        ]);
        try {
            $user = User::where('email', '=', $request->email)->first();
            $user->password = Hash::make($request->new_password);
            $user->save();
            $password = Forget_password::where('user_id', '=', $user->id)->get();
            if ($password->count()) {
                $password = Forget_password::where('user_id', '=', $user->id)->delete();
            }
            return redirect()->route('login.index');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
