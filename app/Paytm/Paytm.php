<?php
namespace App\Paytm;

class Paytm
{
    use ChecksumUtility;

    public function __construct()
    {
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");
    }

    public function generateChecksum($data)
    {
        $checkSum = "";

        $paramList = $data;

//        $paramList["REQUEST_TYPE"] = env('PAYTM_REQUEST_TYPE');
//        $paramList["MID"] = env('PAYTM_MERCHANT_ID'); //Provided by Paytm
//        $paramList["ORDER_ID"] = $data['order_id']; //unique OrderId for every request
//        $paramList["CUST_ID"] = $data['customer_id']; // unique customer identifier
//        $paramList["INDUSTRY_TYPE_ID"] = env('PAYTM_INDUSTRY_TYPE_ID'); //Provided by Paytm
//        $paramList["CHANNEL_ID"] = env('PAYTM_CHANNEL_ID'); //Provided by Paytm
//        $paramList["TXN_AMOUNT"] = $data['total']; // transaction amount
//        $paramList["WEBSITE"] = env('PAYTM_WEBSITE');//Provided by Paytm
//        $paramList["CALLBACK_URL"] = env('PAYTM_CALLBACK_URL');//Provided by Paytm
//        $paramList["EMAIL"] = $data['email']; // customer email id
//        $paramList["MOBILE_NO"] = $data['mobile']; // customer 10 digit mobile no.
//        $paramList["payt_STATUS"] = 1; // customer 10 digit mobile no.

        $checkSum = $this->getChecksumFromArray($paramList, '6Y!xlqpgwtP6dyu@');
        $paramList["CHECKSUMHASH"] = $checkSum;

        return json_encode($paramList);
    }

    public function verifyChecksum($data)
    {
        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = FALSE;

        $paramList = $data;// Array having paytm response

        $paytmChecksum = isset($paramList["CHECKSUMHASH"]) ? $paramList["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//        $isValidChecksum = $this->verifychecksum_e($paramList, env('PAYTM_MERCHANT_KEY', '6Y!xlqpgwtP6dyu@'), $paytmChecksum); //will return TRUE or FALSE string.
        $isValidChecksum = $this->verifychecksum_e($paramList, '6Y!xlqpgwtP6dyu@', $paytmChecksum); //will return TRUE or FALSE string.

        return  $isValidChecksum;
    }

    public function getTxnStatus($data)
    {
        $ORDER_ID = "";
        $requestParamList = array();
        $responseParamList = array();

//        $requestParamList = array("MID" => 'Pazatt78411395573442' , "ORDERID" => "PZODR1519643205230");
        $requestParamList = array("MID" => $data['MID'] , "ORDERID" => $data['ORDER_ID']);
        if (isset($data['CHECKSUMHASH']))
            unset($data['CHECKSUMHASH']);

        $checkSum = $this->getChecksumFromArray($requestParamList,'6Y!xlqpgwtP6dyu@');
        $requestParamList['CHECKSUMHASH'] = urlencode($checkSum);

        $data_string = "JsonData=".json_encode($requestParamList);
        echo $data_string;


        $ch = curl_init();                    // initiate curl
//        $url = "https://pguat.paytm.com/oltp/HANDLER_INTERNAL/getTxnStatus?"; // Staging server where you want to post data
        $url = "https://secure.paytm.in/oltp/HANDLER_INTERNAL/getTxnStatus?"; //Live server where you want to post data

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);  // tell curl you want to post something
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string); // define what you want to post
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $output = curl_exec($ch); // execute
        $info = curl_getinfo($ch);

//echo "kkk".$output;
        $data = json_decode($output, true);
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}