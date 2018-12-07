<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Agent;
use App\Models\DeliveryPerson;
use App\Models\Image;
use App\Models\Vendor;
use App\Notifications\Notify;
use function dd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function customers(Request $request)
    {

        $image = '';

        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $name = time().rand(100,999).".".$file->guessExtension();
            if($file->move('uploads/',$name))
            {
                $image = Image::create([
                    'filename' => $name,
                    'original' => $file->getClientOriginalName(),
                    'mime' => $file->getClientMimeType(),
                ]);

                $image = url('api/v1/images/' . $image->id);
            }
        }

        $customers = Customer::all();

        $notify = [];
        foreach ($customers as $customer)
        {
//            if (!isset($customer->user->fcm_token))
//                continue;

            $data['notification'] = [
                'tag' => 'NOTIFY',
                'title' => $request->get('title'),
                'content' => $request->get('content'),
                'image' => $image
            ];

            if(!empty($customer->user->fcm_token)) {
                $data['fcm_token'] = $customer->user->fcm_token;
                $notify[] = Notify::sendPushNotification($data);
            }

            if(!empty($customer->user->expo_token)) {
                $data['expo_token'] = $customer->user->expo_token;
                try {
                    Notify::sendExpoPushNotification($data, $customer->user->id);
                } catch (\Exception $exception) {
                    Log::debug('Expo error details: ' . $exception->getMessage() );
                    Log::debug('Expo error details: ' . $exception->getTraceAsString() );
                }
            }
        }

        return redirect()->back();

    }

    public function vendors(Request $request)
    {
        $image = '';

        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $name = time().rand(100,999).".".$file->guessExtension();
            if($file->move('uploads/',$name))
            {
                $image = Image::create([
                    'filename' => $name,
                    'original' => $file->getClientOriginalName(),
                    'mime' => $file->getClientMimeType(),
                ]);

                $image = url('api/v1/images/' . $image->id);
            }
        }

        $vendors = Vendor::all(); //DeliveryPerson::all();

        $notify = [];
        foreach ($vendors as $vendor)
        {
            if (!isset($vendor->user->fcm_token))
                continue;

            $data['fcm_token'] = $vendor->user->fcm_token;
            $data['notification'] = [
                'tag' => 'NOTIFY',
                'title' => $request->get('title'),
                'content' => $request->get('content'),
                'image' => $image
            ];

            $notify[] = Notify::sendPushNotification($data);
        }

        return redirect()->back();
    }

    public function agents(Request $request)
    {
        $image = '';

        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $name = time().rand(100,999).".".$file->guessExtension();
            if($file->move('uploads/',$name))
            {
                $image = Image::create([
                    'filename' => $name,
                    'original' => $file->getClientOriginalName(),
                    'mime' => $file->getClientMimeType(),
                ]);

                $image = url('api/v1/images/' . $image->id);
            }
        }

        $agents = Agent::all(); //DeliveryPerson::all();

        $notify = [];
        foreach ($agents as $agent)
        {
            if (!isset($agent->user->fcm_token))
                continue;

            $data['fcm_token'] = $agent->user->fcm_token;
            $data['notification'] = [
                'tag' => 'NOTIFY',
                'title' => $request->get('title'),
                'content' => $request->get('content'),
                'image' => $image
            ];

            $notify[] = Notify::sendPushNotification($data);
        }

//        dd($notify);
        return redirect()->back();
    }
}
