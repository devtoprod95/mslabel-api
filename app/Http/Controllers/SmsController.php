<?php

namespace App\Http\Controllers;

use App\Constants\HttpConstant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;    
    }

    public function login()
    {
        $req     = $this->request->all();
        $headers = $this->request->headers->all();
        $rawBody = $this->request->getContent();    // 이게 중요!

        $logData = [
            'request_data' => $req,
            'headers'      => $headers,
            'parsed_body'  => json_decode($rawBody, true)  // JSON 파싱
        ];

        channelLog(json_encode($logData, JSON_UNESCAPED_UNICODE), 'login');

        return helpers_json_response(HttpConstant::OK);
    }
   
}
