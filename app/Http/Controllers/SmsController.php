<?php

namespace App\Http\Controllers;

use App\Constants\HttpConstant;
use App\Http\Controllers\Controller;
use App\Packages\Kakao;
use Exception;
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
        $userType  = $this->request->input('userType');
        $userName  = $this->request->input('userName');
        $sourceIP  = $this->request->input('sourceIP');
        $eventTime = $this->request->input('eventTime');
        $mfaUsed   = $this->request->input('mfaUsed');
        $region    = $this->request->input('region');

        try {
            $kakao = app(Kakao::class);

            $t1 = $kakao->getAuthUrl();
            // $t1 = $kakao->getAccessToken();
            // $t1 = $kakao->getFriends();
            // $t1 = $kakao->sendMemoToMe('안녕하세요');
            return print($t1);
        } catch (Exception $th) {
            channelLog($th->getMessage(), 'kakao', '', 'error');
        }

        return helpers_json_response(HttpConstant::OK);
    }

    public function kakaoCallback()
    {
        return helpers_json_response(HttpConstant::OK);
    }
   
}
