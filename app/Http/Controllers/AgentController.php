<?php

namespace App\Http\Controllers;


use App\Models\Agent;
use App\Models\User;
use App\Models\Vendor;
use function dd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{

    public function index()
    {
        try
        {
            $data['page'] = 'agents';
            $data['role'] = session('role');

            $data['deliveryPersons'] = Agent::with(['user', 'vendors'])->get();
            $data['vendors'] = Vendor::all();

            return view('members.index', $data);
        }
        catch (\Exception $exception)
        {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }

    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $agent = Agent::create($request->get('agent'));
            $user = User::make($request->get('user'));
            $user->api_token = str_random(60);
            $agent->user()->save($user);
            $user->attachRole('agent');

            if(!empty($request->get('vendors')))
            {
                $agent->vendors()->sync($request->get('vendors'));
            }

            DB::commit();

            return redirect()->back()->with(['success' => 'Agent has been added successfully']);
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try
        {
            $agent = Agent::find($id);
            $agent->fill($request->get('agent'));
            $agent->save();

            $user = $request->get('user');
            if(empty($user['password']))
            {
                unset($user['password']);
            }
            $agent->user->fill($user);
            $agent->user->save();

            if(!empty($request->get('vendors')))
            {
                $agent->vendors()->sync($request->get('vendors'));
            }

            DB::commit();

            return redirect()->back()->with(['success' => 'Agent has been updated successfully']);
        }
        catch (\Exception $exception)
        {
            DB::rollBack();
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try
        {
            Agent::destroy($id);

            return redirect()->back()->with(['success' => 'Agent has been deleted successfully']);
        }
        catch (\Exception $exception)
        {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

}