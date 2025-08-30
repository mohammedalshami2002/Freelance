<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class Service_Provider_ProjectsController extends Controller
{

    public function index(){
        try{
            $servicers = Service::orderBy('created_at', 'desc')->paginate(10);
            return view("Dashboard.Admin.Service_Provider_Projects.index",compact(['servicers']));
        }
        catch(\Exception $e){
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    public function delete($id)
    {
        try {
            Service::destroy($id);
            session()->flash("delete");
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
