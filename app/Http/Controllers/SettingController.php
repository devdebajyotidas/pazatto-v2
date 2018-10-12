<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $data['page'] = 'settings';
        $data['role'] = session('role');
        $data['prefix']  = session('role');

        $data['settings'] = Setting::find(1);

        return view('settings', $data);
    }

    public function store(Request $request)
    {
        Setting::create($request->all());
        return redirect()->back();

    }

    public function update(Request $request, $id)
    {
        $settings = Setting::find($id);
        $settings->fill($request->all());
        $settings->save();

        return redirect()->back();
    }
}
