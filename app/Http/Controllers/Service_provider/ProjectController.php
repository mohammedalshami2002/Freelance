<?php

namespace App\Http\Controllers\Service_provider;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        try {
            $projects = Project::orderBy('created_at', 'desc')
                ->paginate(10);
            $Categories = Categorie::get();
            return view("Dashboard.service_provider.project.index", compact(['projects', 'Categories']));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
    public function show($id)
    {
        try {
            $project = Project::findOrFail($id);
            return view("Dashboard.service_provider.project.show", compact(['project']));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
    public function store_offer(Request $request, $id)
    {
        try {
            $request->validate([
                'description' => ['string', 'required', 'min:5'],
                'price' => ['numeric', 'required', 'min:5'],
            ]);
            DB::beginTransaction();
            Offer::create([
                'description' => $request->description,
                'price' => $request->price,
                'user_id' => auth()->user()->id,
                'project_id' => $id,
            ]);
            DB::commit();
            session()->flash('add');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
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
    public function search(Request $request)
    {
        try {
            $request->validate([
                'categorie_id' => 'required|exists:categories,id',
                'skills' => 'array',
                'skills.*' => 'exists:skills,id',
            ]);
            // الحصول على المدخلات من الطلب
            $categorie_id = $request->input('categorie_id'); // القسم المحدد
            $skills = $request->input('skills', []); // مصفوفة المهارات المختارة (قد تكون فارغة)
            // استعلام المشاريع
            $projects = Project::query();
            // إذا تم تحديد القسم
            if ($categorie_id) {
                $projects->where('categorie_id', $categorie_id);
            }
            // إذا تم تحديد مهارات
            if (!empty($skills)) {
                $projects->whereHas('skills', function ($query) use ($skills) {
                    $query->whereIn('skills.id', $skills);
                });
            }
            // تنفيذ الاستعلام مع جلب البيانات المرتبطة لتحسين الأداء
            $projects = $projects->with(['categorie', 'skills'])->paginate(10);

            $Categories = Categorie::get();
            // إرسال النتائج إلى واجهة العرض
            return view('Dashboard.service_provider.project.search', compact(['projects', 'Categories']));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
