<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile_Service_provider;
use App\Models\Request as ModelsRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $requests = ModelsRequest::paginate(10);
            return view('Dashboard.Admin.request.index',compact('requests'));
        }
        catch(Exception $e){
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
    public function not_enable($id)
    {
        try{
            DB::beginTransaction();
            $request = ModelsRequest::findOrFail($id);
            $request->status = 2;
            $request->save();
            $profile = Profile_Service_provider::findOrFail($request->user_id);
            $profile->authenticated = false;
            $profile->save();
            DB::commit();
            session()->flash("update");
            return redirect()->back();
        }
        catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
    public function enable($id)
    {
        try{
            DB::beginTransaction();
            $request = ModelsRequest::where('id','=',$id)->first();
            $request->status = 1;
            $request->save();
            $profile = Profile_Service_provider::where('user_id','=',$request->user_id)->first();
            $profile->authenticated = true;
            $profile->save();
            DB::commit();
            session()->flash("update");
            return redirect()->route('request.index');
        }
        catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
