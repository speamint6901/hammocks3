<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Twilio\Rest\Client;
use App\Http\Controllers\BaseApiController;

class SmsController extends BaseApiController
{

    // SMS送信
    public function sendSmsPhoneNo(Request $request) {

        $phone = $request->input("phone"); 

        $config = \Config::get('services.twilio');

        $account_sid = $config['account_sid'];
        $auth_token = $config['auth_token'];

        $client = new Client($account_sid,$auth_token);

        $sms = $client->account->messages->create(
            $phone,
            ["from" => $config['phone_number'], "body" => "test"]
        );
    }
}
