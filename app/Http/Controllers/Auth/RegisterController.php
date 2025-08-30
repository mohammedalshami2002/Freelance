<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    use UploadTrait;
    public function index()
    {
        try {
            return view('auth.register');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'min:8', 'same:password'],
            'type_user' => ['required', 'string', 'in:service_provider,client'],
        ]);
        try {
            DB::beginTransaction();
            
            $image = $this->uploadImage($request->file('image'), 'assets/image/Profile');

            if ($image == false) {
                // فشل التحميل
                return redirect()->back()->withErrors(['error' => trans('meesage.Failed_to_upload_image')]);
            }
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->image = $image;
            $user->type_user = $request->type_user;
            $user->password = Hash::make($request->password);
            $code = rand(100000, 999999);
            $user->verification_expires_at = now()->addMinutes(5);
            $user->is_verified = false;
            $user->save();
            // إرسال الكود عبر البريد الإلكتروني
            Mail::to($request->email)->send(new VerificationCodeMail($code));
            DB::commit();
            return redirect()->route('verification',['user']);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
