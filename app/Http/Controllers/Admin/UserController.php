<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Exception;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function service_provider(){
        try{
            $users = User::where('type_user','=','service_provider')->paginate(10);
            return view('Dashboard.Admin.user.index_service_provider',compact('users'));
        }
        catch(Exception $e){
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
    public function client(){
        try{
            $users = User::where('type_user','=','client')->paginate(10);
            return view('Dashboard.Admin.user.index_client',compact('users'));
        }
        catch(Exception $e){
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
    public function delete($id){
        try{
            $user = User::findOrFail($id);
            $this->deleteImage('assets\image\Profile', $user->image);
            User::destroy($id);
            session()->flash("delete");
            return redirect()->back();
        }
        catch(Exception $e){
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
    public function is_blocked($id){
        try{
            $user = User::findOrFail($id);
            $user->is_blocked = true;
            $user->save();
            session()->flash("update");
            return redirect()->back();
        }
        catch(Exception $e){
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
    public function unblocked($id){
        try{
            $user = User::findOrFail($id);
            $user->is_blocked = false;
            $user->save();
            session()->flash("update");
            return redirect()->back();
        }
        catch(Exception $e){
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    public function show($id){
        try{
            $user = User::where('type_user','=','service_provider')->findOrFail($id);
            return view('Dashboard.Admin.user.show_service_provider',compact(['user']));
        }
        catch(Exception $e){
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
