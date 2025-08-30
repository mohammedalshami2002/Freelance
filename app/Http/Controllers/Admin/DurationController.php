<?php

namespace App\Http\Controllers\Admin;

use App\Models\Duration;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDurationRequest;
use App\Http\Requests\UpdateDurationRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class DurationController extends Controller
{

    public function index()
    {
        try {

            $durations = Duration::paginate(10);
            return view("Dashboard.Admin.duration.index", compact('durations'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(StoreDurationRequest $request)
    {
        try {
            DB::beginTransaction();
            $duration = new Duration();
            $duration->duration_name = $request->duration_name;
            $duration->number = $request->number;
            $duration->save();
            DB::commit();
            session()->flash("add");
            return redirect()->route('duration.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Duration $duration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Duration $duration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDurationRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $duration = Duration::findOrFail($id);
            $duration->duration_name = $request->duration_name;
            $duration->number = $request->number;
            $duration->save();
            DB::commit();
            session()->flash("update");
            return redirect()->route('duration.index');
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
            Duration::destroy($id);
            session()->flash("delete");
            DB::commit();
            return redirect()->route('duration.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
