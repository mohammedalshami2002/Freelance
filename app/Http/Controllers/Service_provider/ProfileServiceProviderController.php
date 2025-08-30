<?php

namespace App\Http\Controllers\Service_provider;

use App\Models\Profile_Service_provider;
use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Request as MRequest;
use App\Models\Skill;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;

class ProfileServiceProviderController extends Controller
{
    use UploadTrait;
    public function index()
    {
        try {
            $user = User::findOrFail(auth()->user()->id);
            $profiles = Profile_Service_provider::where('user_id', '=', auth()->user()->id)->first();
            $Categories = Categorie::get();
            $skills = Skill::get();
            return view('Dashboard.service_provider.profile', compact(['user', 'profiles', 'Categories', 'skills']));
        } catch (Exception $e) {
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'string'],
            'profile' => ['required', 'min:10', 'string'],
            'phone_number' => ['required', 'min:8', 'string'],
            'university_name' => ['required', 'min:8', 'string'],
        ]);

        try {
            DB::beginTransaction();

            $user = User::where('email', auth()->user()->email)->first();
            $user->name = $request->name;

            // تحديث الصورة الشخصية
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                ]);

                $image = $this->uploadImage($request->file('image'), 'assets/image/Profile');
                if ($image === false) {
                    return redirect()->back()->withErrors(['error' => trans('meesage.Failed_to_upload_image')]);
                }

                $this->deleteImage('assets/image/Profile', $user->image);
                $user->image = $image;
            }

            // تغيير كلمة المرور
            if ($request->password_old && Hash::check($request->password_old, $user->password) && $request->new_password) {
                $request->validate([
                    'password_old' => ['min:8'],
                    'new_password' => ['min:8'],
                    'confirm_password' => ['min:8', 'same:new_password'],
                ]);

                $user->password = Hash::make($request->new_password);
            }

            $user->save();

            // تحديث الملف الشخصي لمقدم الخدمة
            $profile = Profile_Service_provider::where('user_id', auth()->id())->first() ?? new Profile_Service_provider();
            $profile->user_id = auth()->id();
            $profile->phone_number = $request->phone_number;
            $profile->university_name = $request->university_name;
            $profile->specialization = $request->specialization;
            $profile->profile = $request->profile;
            $profile->categorie_id = $request->categorie_id;
            $profile->save();

            // إدارة طلب التحقق
            $Request1 = MRequest::where('user_id', auth()->id())->first();
            if ($Request1 == null) {
                $Request1 = new MRequest();
                $Request1->user_id = auth()->id();
                $Request1->status = 0;
            }

            if ($request->hasFile('image_authenticated')) {
                $request->validate([
                    'image_authenticated' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                ]);

                $imagePath = $this->uploadImage($request->file('image_authenticated'), 'assets/image/request');

                if ($Request1->status == 2) {
                    $this->deleteImage('assets/image/request', $Request1->image);
                }

                if ($imagePath === false) {
                    return redirect()->back()->withErrors(['error' => trans('meesage.Failed_to_upload_image')]);
                }

                $Request1->image = $imagePath;
                $Request1->save();
            }

            // تحديث المهارات
            $user->skills()->sync($request->skills ?? []);

            DB::commit();
            session()->flash("update");
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
