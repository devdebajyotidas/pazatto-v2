<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->all();
            $group = Group::create($data);

            if(!empty($data['vendors']))
            {
                $group->vendors()->sync($data['vendors']);
            }

            DB::commit();

            return redirect()->back()->with(['success' => 'Group has been added successfully']);
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->all();
            $group = Group::find($id);
            $group->fill($data);
            $group->save();

            if(!empty($data['vendors']))
            {
                $group->vendors()->sync($data['vendors']);
            }

            DB::commit();

            return redirect()->back()->with(['success' => 'Group has been updated successfully']);
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try
        {
            $group = Group::find($id);
            $group->vendors()->detach();
            $group->delete();

            DB::commit();

            return redirect()->back()->with(['success' => 'Group has been deleted successfully']);
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
}
