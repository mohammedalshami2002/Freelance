<?php

namespace App\Http\Controllers\Service_provider;

use App\Models\My_Work;
use App\Http\Controllers\Controller;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class MyWorkController extends Controller
{
    use UploadTrait;

    // عرض الأعمال
    public function index()
    {
        try {
            $works = My_Work::where('user_id', auth()->id())->paginate(10);
            return view('Dashboard.service_provider.mywork.index',compact(['works']));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    // إضافة عمل جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'nullable|url',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $work = new My_Work();
            $work->name = $request->name;
            $work->description = $request->description;
            $work->link = $request->link;
            $work->user_id = auth()->user()->id;

            if ($request->hasFile('image')) {
                $imageName = $this->uploadImage($request->file('image'), 'assets/image/myworks');
                if ($imageName == false) {
                    return redirect()->back()->withErrors(['error' => trans('meesage.Failed_to_upload_image')]);
                }
            }
            $work->image = $imageName;

            $work->save();

            DB::commit();
            session()->flash('add');
            return redirect()->route('MyWork.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    // تعديل عمل موجود
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $work = My_Work::where('user_id', auth()->id())->findOrFail($id);
            $work->name = $request->name;
            $work->description = $request->description;
            $work->link = $request->link;

            if ($request->hasFile('image')) {
                // حذف الصورة القديمة
                $this->deleteImage('assets/image/myworks', $work->image); 

                $imageName = $this->uploadImage($request->file('image'), 'assets/image/myworks');
                if ($imageName == false) {
                    return redirect()->back()->withErrors(['error' => trans('meesage.Failed_to_upload_image')]);
                }
            }
            $work->image = $imageName;

            $work->save();

            DB::commit();
            session()->flash('update');
            return redirect()->route('MyWork.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    // حذف عمل
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $work = My_Work::where('user_id', auth()->id())->findOrFail($id);

            // حذف الصورة من السيرفر 
            $this->deleteImage('assets/image/myworks', $work->image); 

            $work->delete();

            DB::commit();
            session()->flash('delete');
            return redirect()->route('MyWork.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
