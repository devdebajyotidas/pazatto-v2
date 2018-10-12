<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Image;
use App\Models\Service;
use App\Models\User;
use App\Models\Vendor;
use function dd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use function implode;

class VendorController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        try
        {
            if(session('role') != 'admin' && !isset(Auth::user()->account))
            {
                return redirect('/logout');
            }

            $data['page'] = 'vendors';
            $data['role'] = session('role');
            $data['prefix']  = session('role');

            $data['vendors'] = Vendor::withTrashed()->with(['user','service'])->get();
            $data['services'] = Service::withCount('vendors')->get();
//        dd($data);

            return view('vendors.index', $data);
        }
        catch (\Exception $exception)
        {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    public function create()
    {
        try
        {
            $data['page'] = 'vendors';
            $data['role'] = session('role');
            $data['services'] = Service::with(['groups'])->get();

            return view('vendors.create', $data);

        }
        catch (\Exception $exception)
        {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }

    }

    public function store(Request $request)
    {
//        dd($request->header('referer'));
//        dd($request->all());

        try
        {
            DB::beginTransaction();

            $data['vendor'] = $request->get('vendor');
            $data['user'] = $request->get('user');
            $data['address'] = $request->get('address');

            $vendorRules = [
                'name' => 'required',
                'contact_person' => 'required',
                'contact_phone' => 'required',
                'contact_email' => 'required',
                'service_id' => 'required',
                'highlights' => 'required',
                ];

            $userRules =[
                'email' => 'required|unique:users',
                'mobile' => 'required|unique:users',
                'password' => 'required',
            ];

            $addressRules = [
                '0.formatted_address' => 'required',
                '0.latitude' => 'required',
                '0.longitude' => 'required',
            ];

            $validation = Validator::make($data['vendor'], $vendorRules);
            if($validation->fails())
            {
                return redirect()->back()->withInput($request->all())->withErrors( $validation->errors());
            }

            $validation = Validator::make($data['user'], $userRules);
            if($validation->fails())
            {
                return redirect()->back()->withInput($request->all())->withErrors($validation->errors());
            }

            $validation = Validator::make($data['address'], $addressRules);
            if($validation->fails())
            {
                return redirect()->back()->withInput($request->all())->withErrors($validation->errors());
            }


            if ($request->hasFile('vendor.featured_image'))
            {
                $file = $request->file('vendor.featured_image');
                $name = time().rand(100,999).".".$file->getClientOriginalExtension();
                if($file->move('uploads/',$name))
                {
                    $image = Image::create([
                        'filename' => $name,
                        'original' => $file->getClientOriginalName(),
                        'mime' => $file->getClientMimeType(),
                    ]);

                    $data['vendor']['featured_image'] = url('api/v1/images/' . $image->id);
                }
                else
                {
                    $data['vendor']['featured_image'] = null;
                }
            }

            $vendor = Vendor::create($data['vendor']);
//        $user = User::make();
            $user = new User($data['user']);
            $user->api_token = str_random('60');
            $vendor->user()->save($user);
            $user->attachRole('vendor');

            foreach ($data['address'] as $address)
            {
                $vendor->locations()->save(Address::make($address));
            }

            DB::commit();

            return redirect()->back();
        }
        catch (\Exception $exception)
        {
            DB::rollback();
            return redirect()->back()->withInput($request->all())->withErrors([$exception->getMessage()]);
        }

    }

    public function show($id)
    {
        try
        {
            $data['page'] = 'vendors';
            $data['profile'] = 'vendors';
            $data['role'] = session('role');
            $data['prefix']  = session('role');

            $data['vendor'] = Vendor::with(['user','service'])->find($id);
            $data['services'] = Service::withCount('vendors')->get();
//        dd($data);

            return view('vendors.profile', $data);
        }
        catch (\Exception $exception)
        {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try
        {
            DB::beginTransaction();

            $data['vendor'] = $request->get('vendor');
            $data['user'] = $request->get('user');
            $data['address'] = $request->get('address');


            $data['vendor'] = $request->get('vendor');
            $data['user'] = $request->get('user');
            $data['address'] = $request->get('address');

            $vendorRules = [
                'name' => 'required',
                'contact_person' => 'required',
                'contact_phone' => 'required',
                'contact_email' => 'required',
                'service_id' => 'required',
                'highlights' => 'required',
            ];

            $userRules =[
                'email' => 'required',
                'mobile' => 'required',
            ];

            $addressRules = [
                '0.formatted_address' => 'required',
                '0.latitude' => 'required',
                '0.longitude' => 'required',
            ];

            $validation = Validator::make($data['vendor'], $vendorRules);
            if($validation->fails())
            {
                return redirect()->back()->withInput($request->all())->withErrors( $validation->errors());
            }

            $validation = Validator::make($data['user'], $userRules);
            if($validation->fails())
            {
                return redirect()->back()->withInput($request->all())->withErrors($validation->errors());
            }

            $validation = Validator::make($data['address'], $addressRules);
            if($validation->fails())
            {
                return redirect()->back()->withInput($request->all())->withErrors($validation->errors());
            }

            if ($request->hasFile('vendor.featured_image'))
            {
                $file = $request->file('vendor.featured_image');
                $name = time().rand(100,999).".".$file->getClientOriginalExtension();
                if($file->move('uploads/',$name))
                {
                    $image = Image::create([
                        'filename' => $name,
                        'original' => $file->getClientOriginalName(),
                        'mime' => $file->getClientMimeType(),
                    ]);

                    $data['vendor']['featured_image'] = url('api/v1/images/' . $image->id);
                }
                else
                {
                    $data['vendor']['featured_image'] = null;
                }
            }

            $vendor = Vendor::find($id);
            $vendor->fill($data['vendor']);
            $vendor->save();

            if(empty($data['user']['password']))
                unset($data['user']['password']);

            if(isset($vendor->user))
            {
                $vendor->user->fill($data['user']);
                $vendor->user->save();
            }
            else
            {
                $user = new User($data['user']);
                $user->api_token = str_random('60');
                $vendor->user()->save($user);
                $user->attachRole('vendor');
            }


            $vendor->locations()->delete();

            foreach ($data['address'] as $address)
            {
                if(empty($address['formatted_address']) || empty($address['latitude']) || empty($address['longitude']))
                    continue;

                $vendor->locations()->save(Address::make($address));
            }

            DB::commit();
            return redirect()->back();
        }
        catch (\Exception $exception)
        {
            DB::rollback();
            return redirect()->back()->withInput($request->all())->withErrors([$exception->getMessage()]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try
        {
            Vendor::destroy($id);
            return redirect()->back();
        }
        catch (\Exception $exception)
        {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }

    public function takeOrders(Request $request, $id)
    {
        try
        {
            $data = $request->get('vendor');
            $vendor = Vendor::find($id);
            $vendor->fill($data);
            $vendor->save();
//            dd($vendor->is_taking_orders);
            return redirect()->back();
        }
        catch (\Exception $exception)
        {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
}
