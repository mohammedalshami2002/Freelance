<?php

namespace App\Http\Controllers\Client;

use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Categorie;
use App\Models\Duration;
use App\Models\Experience;
use App\Models\Rating;
use Illuminate\Http\Request;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{

    public function index()
    {
        try {
            $projects = Project::where('user_id', '=', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return view("Dashboard.Client.project.index", compact(['projects']));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    public function rating(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'project_id' => 'required|exists:projects,id',
                'rating' => 'required|integer|min:1|max:5',
            ]);

            $user = Auth::user();

            $project = Project::where('id', $request->project_id)
                ->where('user_id', $user->id)
                ->first();
            if ($project == null) {
                return redirect()->back()->withErrors(['error' => trans('dashboard.I_have_rated_this_project_before')]);
            }
            $ratingValue = $validatedData['rating'];

            if (Rating::where('project_id', $project->id)->where('user_id', $user->receiver_user_id)->exists()) {
                return redirect()->back()->withErrors(['error' => trans('dashboard.I_have_rated_this_project_before')]);
            }

            if($project->status = 'قيد التنفيذ' || $project->status == 'مكتمل' ){
                Rating::create([
                    'user_id' => $project->receiver_user_id,
                    'project_id' => $project->id,
                    'rating' => $ratingValue,
                ]);
    
                session()->flash('add');
                return redirect()->back();
            }
            return redirect()->back()->withErrors(['error' => trans('dashboard.You_cannot_add_a_rating')]);
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function create()
    {
        try {
            $Categories = Categorie::get();
            $Durations = Duration::get();
            $Experiences = Experience::get();
            return view("Dashboard.Client.project.add", compact(['Categories', 'Experiences', 'Durations']));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
    public function skill($id)
    {

        $skills = Skill::where('categorie_id', '=', $id)->get();

        return response()->json($skills);
    }


    public function store(StoreProjectRequest $request)
    {
        try {
            DB::beginTransaction();
            $project = Project::create([
                'name' => $request->name,
                'prise' => $request->prise,
                'description' => $request->description,
                'status' => 'قيد الانتظار',
                'user_id' => auth()->user()->id,
                'categorie_id' => $request->categorie_id,
                'duration_id' => $request->duration_id,
                'experience_id' => $request->experience_id,
            ]);
            // إرفاق المهارات المختارة بالخدمة
            if ($request->has('skills')) {
                $project->skills()->attach($request->skills);
            }
            DB::commit();
            session()->flash('add');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    public function show($id)
    {
        try {
            $project = Project::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();
            return view("Dashboard.Client.project.show", compact(['project']));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    public function edit($id)
    {
        try {
            $project = Project::findOrFail($id);
            $categories = Categorie::get();
            $durations = Duration::get();
            $experiences = Experience::get();
            return view("Dashboard.Client.project.update", compact(['project', 'categories', 'experiences', 'durations']));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $project = Project::findOrFail($id);

            $project->update([
                'name' => $request->name,
                'prise' => $request->prise,
                'description' => $request->description,
                'status' => $project->status, 
                'user_id' => auth()->user()->id,
                'categorie_id' => $request->categorie_id,
                'duration_id' => $request->duration_id,
                'experience_id' => $request->experience_id,
            ]);

            if ($request->has('skills')) {
                
                $project->skills()->detach();
                $project->skills()->attach($request->skills);
            }

            DB::commit();
            session()->flash('update');
            return redirect()->route('Prosodic.index'); // التوجيه إلى صفحة المشاريع أو صفحة أخرى حسب الرغبة
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }


    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $project = Project::findOrFail($id);
            $project->delete();
            DB::commit();
            session()->flash('delete');
            return redirect()->route('Prosodic.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
