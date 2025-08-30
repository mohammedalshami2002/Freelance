<?php

namespace App\Http\Controllers\Client;

use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Categorie;
use App\Models\Duration;
use App\Models\Experience;
use App\Models\Skill;
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
        // استرداد المهارات المرتبطة بالقسم من قاعدة البيانات
        $skills = Skill::where('categorie_id', '=', $id)->get();

        // إعادة الاستجابة بصيغة JSON
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
            $project = Project::where('id', $id) ->where('user_id', auth()->user()->id)->firstOrFail();
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

            // البحث عن المشروع بناءً على الـ id
            $project = Project::findOrFail($id);

            // تحديث بيانات المشروع
            $project->update([
                'name' => $request->name,
                'prise' => $request->prise,
                'description' => $request->description,
                'status' => $project->status, // لا تغيير في الحالة
                'user_id' => auth()->user()->id,
                'categorie_id' => $request->categorie_id,
                'duration_id' => $request->duration_id,
                'experience_id' => $request->experience_id,
            ]);

            // التحقق من وجود مهارات جديدة في الطلب
            if ($request->has('skills')) {
                // حذف المهارات القديمة
                $project->skills()->detach();
                // إرفاق المهارات الجديدة
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
