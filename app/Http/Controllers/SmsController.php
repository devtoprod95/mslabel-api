<?php

namespace App\Http\Controllers;

use App\Constants\HttpConstant;
use App\Http\Controllers\Controller;
use App\Packages\Kakao;
use Carbon\Carbon;
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
        $userType   = $this->request->input('userType');
        $userName   = $this->request->input('userName');
        $sourceIP   = $this->request->input('sourceIP');
        $eventTime  = $this->request->input('eventTime');
        $mfaUsed    = $this->request->input('mfaUsed');
        $region     = $this->request->input('region');
        $koreanTime = Carbon::parse($eventTime)->setTimezone('Asia/Seoul')->format('Y-m-d H:i:s');

        try {
            $kakao = new Kakao();

            // $t1 = $kakao->getAuthUrl();
            // $t1 = $kakao->getAccessToken();
            $msg  = "🔔 AWS 로그인 알림\n";
            $msg .= "━━━━━━━━━━━━━━━━━━━━\n";
            $msg .= "👤 사용자: " . $userName . "\n";
            $msg .= "🔑 유형: " . $userType . "\n";
            $msg .= "🌐 IP: " . $sourceIP . "\n";
            $msg .= "⏰ 시간: " . $koreanTime . "\n";
            $msg .= "🔒 MFA: " . ($mfaUsed ? '사용됨' : '사용안됨') . "\n";
            $msg .= "📍 지역: " . $region;

            $kakao->sendMessageFriends($msg);
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
