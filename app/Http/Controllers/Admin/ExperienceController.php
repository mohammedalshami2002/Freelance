<?php

namespace App\Http\Controllers\Admin;

use App\Models\Experience;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExperienceRequest;
use App\Http\Requests\UpdateExperienceRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class ExperienceController extends Controller
{

    public function index()
    {
        try {
            $experiences = Experience::paginate(10);
            return view("Dashboard.Admin.experience.index", compact('experiences'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getmessage()]);
        }
    }


    public function create()
    {
        //
    }


    public function store(StoreExperienceRequest $request)
    {
        try {
            DB::beginTransaction();
            $experience = new Experience();
            $experience->name = $request->name;
            $experience->save();
            DB::commit();
            session()->flash("add");
            return redirect()->route('experience.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }


    public function show(Experience $experience)
    {
        //
    }


    public function edit(Experience $experience)
    {
        //
    }


    public function update(UpdateExperienceRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $experience = Experience::findOrFail($id);
            $experience->name = $request->name;
            $experience->save();
            DB::commit();
            session()->flash("update");
            return redirect()->route('experience.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }


    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            Experience::destroy($id);
            session()->flash("delete");
            DB::commit();
            return redirect()->route('experience.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
