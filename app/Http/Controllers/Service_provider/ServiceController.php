<?php

namespace App\Http\Controllers\Service_provider;

use App\Models\Service;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Categorie;
use Exception;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{

    public function index()
    {
        try{
            $servicers = Service::where('user_id', '=', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            $Categories = Categorie::get();
            return view("Dashboard.service_provider.service.index",compact(['servicers','Categories']));
        }
        catch(\Exception $e){
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    public function create()
    {
        //
    }

    public function store(StoreServiceRequest $request)
    {
        try{
            DB::beginTransaction();
            $service = new Service();
            $service->name = $request->name;
            $service->description = $request->description;
            $service->price = $request->price;
            $service->categorie_id = $request->categorie_id;
            $service->user_id = auth()->user()->id;
            $service->status = true;
            $service->save();
            DB::commit();
            session()->flash("add");
            return redirect()->back();

        }
        catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(Service $service)
    {
        //
    }

    public function edit(Service $service)
    {
        //
    }

    public function update(UpdateServiceRequest $request, $id)
    {
        try{
            DB::beginTransaction();
            $service =  Service::findOrFail($id);
            $service->name = $request->name;
            $service->description = $request->description;
            $service->price = $request->price;
            $service->categorie_id = $request->categorie_id;
            $service->user_id = auth()->user()->id;
            $service->status = $request->status;
            $service->save();
            DB::commit();
            session()->flash("update");
            return redirect()->back();

        }
        catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            Service::destroy($id);
            session()->flash("delete");
            DB::commit();
            return redirect()->route('service.index');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('meesage.An_error_occurred_please_try_again_later')]);
        }
    }
}
