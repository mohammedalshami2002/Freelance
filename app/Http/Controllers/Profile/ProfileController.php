<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use UploadTrait;
    public function view()
    {
        try {
            $user = auth()->user();
            return view("auth.profile", compact("user"));
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'string'],
        ]);
        try {
            DB::beginTransaction();
            $user = User::where('email', '=', auth()->user()->email)->first();
            $user->name = $request->name;
            if ($request->image != null) {
                $request->validate([
                    'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                ]);
                $this->deleteImage('assets/image/Profile', $user->image);
                $image = $this->uploadImage($request->file('image'), '/assets/image/Profile');
                if ($image == false) {
                    // فشل التحميل
                    return redirect()->back()->withErrors(['error' => trans('meesage.Failed_to_upload_image')]);
                }
                $user->image = $image;
            }
            if (Hash::check($request->password_old, $user->password) && $request->new_password != null) {
                $request->validate([
                    'password_old' => ['min:8'],
                    'new_password' => ['min:8'],
                    'confirm_password' => ['min:8', 'same:new_password'],
                ]);
                $user->password = Hash::make($request->new_password);
            }
            $user->save();
            DB::commit();
            session()->flash("update");
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    public function show($id)
    {
        try {
            $service_provider = User::where('type_user', 'service_provider')
                ->where('id', $id)
                ->firstOrFail();
            return view('Dashboard.Client.profile_service_provider', compact('service_provider'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
