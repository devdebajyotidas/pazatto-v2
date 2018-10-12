<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceGroup;
use Illuminate\Http\Request;

class ServiceGroupController extends Controller
{
    public function index()
    {
        $data['page'] = 'discount';
        $data['role'] = session('role');

        $data['groups'] = ServiceGroup::with(['service'])->get();

        return view('services.groups', $data);
    }

    public function store(Request $request)
    {
        ServiceGroup::create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $service = ServiceGroup::find($id);
        $service->fill($request->all());
        $service->save();

        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $service = ServiceGroup::find($id);
        $service->destroy();

        return redirect()->back();
    }
}
