<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categorie;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use App\Traits\UploadTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class CategorieController extends Controller
{
    use UploadTrait;
    public function index()
    {
        try {
            $categories = Categorie::paginate(10);
            return view("Dashboard.Admin.Categorie.index", compact('categories'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    public function store(StoreCategorieRequest $request)
    {
        try {
            DB::beginTransaction();
            $Categorie = new Categorie();
            $Categorie->name = $request->name;
            $Categorie->description = $request->description;
            $Categorie->save();
            DB::commit();
            session()->flash("add");
            return redirect()->route('categories.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    public function update(UpdateCategorieRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $categorie = Categorie::findOrFail($id);
            $categorie->name = $request->name;
            $categorie->description = $request->description;
            $categorie->save();
            DB::commit();
            session()->flash("update");
            return redirect()->route('categories.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            Categorie::destroy($id);
            DB::commit();
            session()->flash("delete");
            return redirect()->route('categories.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
