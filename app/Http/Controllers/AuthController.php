<?php

namespace App\Http\Controllers;

use App\Constants\HttpConstant;
use App\Constants\UserErrorMessageConstant;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\AdminData;
use Carbon\Carbon;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;    
    }

    public function tokenCreate()
    {
        try {
            $validator = Validator::make($this->request->all(), [
                'user_id'  => 'required',
                'password' => 'required',
            ], [
                'user_id.required'  => UserErrorMessageConstant::getNotHaveErrorMessage("USER_ID"),
                'password.required' => UserErrorMessageConstant::getNotHaveErrorMessage("PASSWORD"),
            ]);
    
            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }
    
            $credentials = $this->request->only(["user_id", "password"]);
            $user        = AdminData::where('user_id', $credentials['user_id'])->first();
            if (!$user) {
                return helpers_json_response(HttpConstant::BAD_REQUEST, [], UserErrorMessageConstant::getNotHaveErrorMessage("USER"));
            }

            if (!Hash::check($credentials['password'], $user->password)) {
                return helpers_json_response(HttpConstant::BAD_REQUEST, [], UserErrorMessageConstant::getFitErrorMessage("PASSWORD"));
            }

            $result = $this->createToken($user);
            return helpers_json_response(HttpConstant::OK, $result);

        } catch (Exception $e) {
            return helpers_json_response(HttpConstant::BAD_REQUEST, [], $e->getMessage());
        }
    }

    /**
     * 토큰 생성
     */
    private function createToken(AdminData $user): array
    {
        if( env("APP_ENV") == "production" ){
            $expirationTime = time() + ( 3600 * 3 ); // 3시간 후 만료
        } else {
            $expirationTime = time() + ( 3600 * 30 ); // 30시간 후 만료
        }

        $data           = ["user" => $user];
        $payload        = [
            'iss' => Route::currentRouteName(), // 발행자
            'iat' => time(), // 발행 시간
            'exp' => $expirationTime, // 만료 시간
            'sub' => $data // 사용자 정의 데이터
        ];

        return [
            'token'      => JWT::encode($payload, (string)env('JWT_SECRET'), 'HS256'),
            'expires_at' => Carbon::createFromTimestamp($expirationTime)->format('Y-m-d H:i:s')
        ];
    }
}
