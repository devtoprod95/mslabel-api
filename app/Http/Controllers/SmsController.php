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
        $req     = $this->request->headers->all();
        $headers = $this->request->all();

        $logData = [
            'request_data' => $req,
            'headers'      => $headers,
            'method'       => $this->request->getMethod(),
            'url'          => $this->request->fullUrl()
        ];
        channelLog(json_encode($logData, JSON_UNESCAPED_UNICODE), 'login');

        return helpers_json_response(HttpConstant::OK);
    }
   
}
