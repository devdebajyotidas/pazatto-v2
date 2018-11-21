<?php
namespace App\Notifications;

use App\Models\Customer;
use App\Models\Agent;
use App\Models\Order;
use App\Models\Vendor;
use function count;
use ExponentPhpSDK\Expo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use function sprintf;

class Notify
{
    private static $fcmURL = 'https://fcm.googleapis.com/fcm/send';
    private static $fcmKey = 'AIzaSyCBB1hN3Jk8ekX62fQJXsLmBcRQLyejNBk';

//    private static $orderTemplate = [
//        -1 => [
//            'tag' => 'ORDER_CANCELLED',
//            'title' => 'Pazatto - Order Cancelled',
//            'content' => "Order of Rs. %d has been cancelled"
//        ],
//        1 => [
//            'tag' => 'ORDER_PLACED',
//            'title' => 'Pazatto - Order Placed',
//            'content' => "Order of Rs. %d has been placed."
//        ],
//        2 => [
//            'tag' => 'ORDER_CONFIRMED',
//            'title' => 'Pazatto - Order Confirmed',
//            'content' => "Order of Rs. %d has been confirmed."
//        ],
//        3 => [
//            'tag' => 'ORDER_PREPARING',
//            'title' => 'Pazatto - Order Preparing',
//            'content' => "Order of Rs. %d is being prepared."
//        ],
//        4 => [
//            'tag' => 'ORDER_DISPATCHED',
//            'title' => 'Pazatto - Order Dispatched',
//            'content' => "Order of Rs. %d has been dispatched."
//        ],
//        5 => [
//            'tag' => 'ORDER_DELIVERED',
//            'title' => 'Pazatto - Order Delivered',
//            'content' => "Order of Rs. %d has been delivered."
//        ],
//    ];

    private static $orderTemplate = [
        -1 => [
            'tag' => 'ORDER_CANCELLED',
            'title' => 'Pazatto - Order Cancelled',
            'content' => "Order of Rs. %d has been cancelled"
        ],
        1 => [
            'tag' => 'ORDER_PLACED',
            'title' => 'Pazatto - Order Placed',
            'content' => 'Roger that !! Your order of Rs. %d has been placed. Waiting for confirmation.
#neverstayhangry'
        ],
        2 => [
            'tag' => 'ORDER_CONFIRMED',
            'title' => 'Pazatto - Order Confirmed',
            'content' => 'Guess what!!. Order of Rs. %d has been confirmed. #neverstayhangry'
        ],
        3 => [
            'tag' => 'ORDER_PREPARING',
            'title' => 'Pazatto - Order Preparing',
            'content' => 'Challenge accepted!! Order of Rs. %d is being Prepared. #neverstayhangry'
        ],
        4 => [
            'tag' => 'ORDER_DISPATCHED',
            'title' => 'Pazatto - Order Dispatched',
            'content' => 'MARK MY WORDS, we are on our way. Order of Rs. %d has been dispatched. #neverstayhangry'
        ],
        5 => [
            'tag' => 'ORDER_DELIVERED',
            'title' => 'Pazatto - Order Delivered',
            'content' => "Hurray! Order of Rs. %d has been delivered. Enjoy your meal."
        ],
    ];

    private $stockTemplate = [
        0 => [
            'tag' => 'OUT_OF_STOCK',
            'title' => 'Pazatto - Out of Stock',
            'content' => "%s has run out of stock.",
        ],
        1 => [
            'tag' => 'BACK_IN_STOCK',
            'title' => 'Pazatto - Back in Stock',
            'content' => "%s is back in stock.",
        ]
    ];

    public static function sendOrderNotification(Order $order)
    {
        $customer = Customer::with(['user'])->find($order->customer_id);
        $vendor = Vendor::with(['user', 'agents'])->find($order->vendor_id);

        $order['customer'] = $customer;

        $notify = [];
        $data['notification'] = [
            'tag' => self::$orderTemplate[$order->status]['tag'],
            'title' => self::$orderTemplate[$order->status]['title'],
            'content' => sprintf(self::$orderTemplate[$order->status]['content'], $order->total),
//            'data' => $order
        ];

        if($customer->user->fcm_token) {
            $data['fcm_token'] = $customer->user->fcm_token;
            $notify['fcm'][] = self::sendPushNotification($data, $customer->user->id);
        }

        if($customer->user->expo_token) {
            $data['expo_token'] = $customer->user->expo_token;
            $notify['fcm'][] = self::sendExpoPushNotification($data, $customer->user->id);;
        }

        $data['fcm_token'] = $vendor->user->fcm_token;
        $notify['fcm'][] = self::sendPushNotification($data, $vendor->user->id);

//        if($order->isDirty('status'))
//        {
            if($order->status == 1 || $order->status == -1)
            {
                $notify['sms'][] = self::sendSMS($vendor->user->mobile,$data['notification']['content']);
            }

            if($order->status == 1 || $order->status == 2 || $order->status == 4)
            {
                $notify['sms'][] = self::sendSMS($customer->user->mobile,$data['notification']['content']);
            }

            if($order->status == 2)
            {
                $agents = $vendor->agents;

                foreach ($agents as $agent)
                {
                    $data['fcm_token'] = $agent->user->fcm_token;
                    $notify[] = Notify::sendPushNotification($data, $agent->user->id);
                }
            }

            if($order->status == 2 || $order->status == 5)
            {
                self::sendInvoice($order);
            }
//        }

        return $notify;
    }

    public static function sendStockNotification($item)
    {
        $customers = Customer::all();

        foreach ($customers as $customer)
        {
            $data['fcm_token'] = $customer->user->fcm_token;
            $data['notification'] = [
                'tag' => self::$stockTemplate[$item->in_stock]['tag'],
                'title' => self::$stockTemplate[$item->in_stock]['title'],
                'content' => self::$stockTemplate[$item->in_stock]['content'],
                'data' => $item
            ];
        }
    }


    public static function sendExpoPushNotification($data, $userId){
        $interestDetails = [(string)$userId, $data['expo_token']];

        // Build the notification data
        $notification = ['title' => $data['notification']['title'] , 'body' =>  $data['notification']['content'], 'sound' => 'default'];

        // You can quickly bootup an expo instance
        $expo = Expo::normalSetup();

        try {
            // Notify an interest with a notification
            $expo->notify($interestDetails[0], $notification);
        }catch (\Exception $exception) {
            // Subscribe the recipient to the server
            $expo->subscribe($interestDetails[0], $interestDetails[1]);

            // Notify an interest with a notification
            $expo->notify($interestDetails[0], $notification);
        }
    }


    public static function sendPushNotification($data){

        $fcm_token= $data['fcm_token'];

        $notification = $data['notification'];

        $fields = array(
            'to'           => $fcm_token,
            'data' => $notification
        );
        $headers = array(
            'Authorization: key=' . self::$fcmKey,
            'Content-Type: application/json'
        );


        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt( $ch, CURLOPT_URL, self::$fcmURL );

        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Avoids problem with https certificate
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute post
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);

        return $result;
        // }


    }

    public static function sendSMS($to,$message)
    {
        // Authorisation details.
        $username = "zakaria.aw@googlemail.com";
        $hash = "dd02e27ee7b65761966fc4fea72156221ae99fc5851ee33ebdbc4b9e3a2b71ea";

        // Config variables. Consult http://api.textlocal.in/docs for more info.
        $test = "0";

        // Data for text message. This is the text message data.
        $sender = "PZATTO"; // This is who the message appears to be from.
        $numbers = '91'.$to; //"910000000000"; // A single number or a comma-seperated list of numbers
        $message = $message; //"This is a test message from the PHP API script.";
        // 612 chars or less
        // A single number or a comma-seperated list of numbers
        $message = urlencode($message);
        $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
        $ch = curl_init('http://api.textlocal.in/send/?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); // This is the result from the API
        curl_close($ch);

        return $result;
    }

    public static function sendOTP($to)
    {
        $otp = rand(1111,9999);
//        $message = "Your OTP is $otp";
        $message = sprintf('CONGRATS on joining our family. %d is your login OTP. Do not share your OTP with anyone as it gives full access to your account.
#neverstayhangry', $otp);

        self::sendSMS($to,$message);

        return $otp;
    }

    public static function sendInvoice($order)
    {
        $recipient  = [];

        $for = "CUSTOMER";
        $recipient['email'] = $order->customer->user->email;
        $recipient['name'] = $order->customer->first_name . ' ' . $order->customer->last_name;

        $customerOrder = $order;

        Mail::send('emails.invoice', ['order' => $order, 'for' => $for, 'recipient' => $recipient], function ($message) use ($order, $recipient)
        {
            $message->from('sales@pazatto.com', 'Pazatto Sales');
            $message->subject(config('constants.order.title')[$order->status]);
            $message->bcc('testmyprojects2017@gmail.com', 'Test Email');
            $message->bcc('admin@pazatto.com', 'CEO Pazatto');
            $message->bcc('zakaria.aw@gmail.com', 'Zakaria Wahid');
            $message->to($recipient['email'], $recipient['name']);
        });

        $for = "VENDOR";
        $recipient['email'] = $order->vendor->user->email;
        $recipient['name'] = $order->vendor->name;

        $vendorOrder = $order;


        Mail::send('emails.invoice', ['order' => $order, 'for' => $for, 'recipient' => $recipient], function ($message) use ($order, $recipient)
        {
            $message->from('sales@pazatto.com', 'Pazatto Sales');
            $message->subject(config('constants.order.title')[$order->status]);
            $message->bcc('testmyprojects2017@gmail.com', 'Test Email');
            $message->bcc('admin@pazatto.com', 'CEO Pazatto');
            $message->bcc('zakaria.aw@gmail.com', 'Zakaria Wahid');
            $message->to($recipient['email'], $recipient['name']);
        });

        /*Mail::to('info.debajyotidas@gmail.com')
            ->from('no-reply@gmail.com', 'Dev Das')
            ->cc('dev.debajyotidas@gmail.com')
            ->bcc('debajyotidas93@gmail.com')
            ->send('emails.invoice', ['order' => $order]);*/

    }

    public static function sendSalesReport($vendor, $date)
    {
        if(!$vendor instanceof Vendor)
        {
            $vendor = Vendor::find($vendor);
        }

        $data['for'] = "VENDOR";
        $data['vendor'] = $vendor;
        $data['date'] = $date;
        $data['email'] = $vendor->user->email;
        $data['name'] = $vendor->name;


        $query = Order::with(['lines', 'lines.item', 'vendor'])->where('status', '=', 5)->whereDate('created_at', '=', $date);

        $query = $query->where("vendor_id", "=" ,  $data['vendor']->id);

        $data['orders'] = $query->get();


        if(count($data['orders']) > 0)
        {
            Mail::send('emails.report', $data, function ($message) use ($vendor)
            {
                $message->from('sales@pazatto.com', 'Pazatto Sales');
                $message->subject("Sales Report");
            $message->bcc('testmyprojects2017@gmail.com', 'Test Email');
            $message->bcc('admin@pazatto.com', 'CEO Pazatto');
            $message->bcc('zakaria.aw@gmail.com', 'Zakaria Wahid');
            $message->to($vendor->user->email, $vendor->name);
//                $message->to('testmyprojects2017@gmail.com', $vendor->name);
            });
        }
    }
}