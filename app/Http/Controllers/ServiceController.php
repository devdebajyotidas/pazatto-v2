<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceGroup;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $data['page'] = 'services';
        $data['role'] = session('role');

        $data['services'] = Service::with(['groups'])->get();

//        $data['services'] = Service::with(['groups'])->get()->each(function ($service){
//            $service['groups'] = $service->groups()->get(['name'])->toArray();
//        });

//        dd($data['services']);
        return view('services.index', $data);
    }

    public function store(Request $request)
    {
        Service::create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $service = Service::find($id);
        $service->name = $request->get('name');
        $service->save();

        $groups = explode(',', $request->get('groups'));

        foreach ($groups as $group)
        {
            ServiceGroup::firstOrCreate(
                ['name' => $group], ['service_id' => $id]
            );
        }

        ServiceGroup::whereNotIn('name', $groups)->where('service_id', '=', $id)->delete();

        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $service = Service::destroy($id);
//        $service->destroy();

        return redirect()->back();
    }
}
