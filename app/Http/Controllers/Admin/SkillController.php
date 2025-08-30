<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categorie;
use App\Models\Skill;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = Categorie::get();
            $skills = Skill::paginate(10);
            return view("Dashboard.Admin.skill.index", compact('skills','categories'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSkillRequest $request)
    {
        try {
            DB::beginTransaction();
            $skiil = new Skill();
            $skiil->name = $request->name;
            $skiil->categorie_id = $request->categorie_id;
            $skiil->save();
            DB::commit();
            session()->flash("add");
            return redirect()->route('skill.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkillRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $skiil = Skill::findOrFail($id);
            $skiil->name = $request->name;
            $skiil->categorie_id = $request->categorie_id;
            $skiil->save();
            DB::commit();
            session()->flash("update");
            return redirect()->route('skill.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            Skill::destroy($id);
            session()->flash("delete");
            DB::commit();
            return redirect()->route('skill.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
