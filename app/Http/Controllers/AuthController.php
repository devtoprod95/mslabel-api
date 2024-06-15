<?php

namespace App\Http\Controllers;

use App\Constants\HttpConstant;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;
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
                'name'     => 'required',
                'password' => 'required',
            ], [
                'name.required'     => '아이디를 입력하세요.',
                'password.required' => '비밀번호를 입력하세요.',
            ]);
    
            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }
    
            $credentials = $this->request->only(["name", "password"]);
            $user        = User::where('name', $credentials['name'])->first();
            if (!$user) {
                return helpers_json_response(HttpConstant::BAD_REQUEST, [], "없는 아이디입니다.");
            }

            if (!Hash::check($credentials['password'], $user->password)) {
                return helpers_json_response(HttpConstant::BAD_REQUEST, [], "비밀번호를 다시 확인해주세요.");
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
    private function createToken(User $user): array
    {
        $expirationTime = time() + 7200;      // 2시간 후 만료
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
