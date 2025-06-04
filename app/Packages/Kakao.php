<?php

namespace App\Packages;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;

class Kakao
{
    private string $restApiKey;
    private string $redirectUri;
    private string $accessToken;
    private string $code;
    private Client $client;

    public function __construct()
    {
        $this->restApiKey  = env('KAKAO_REST_API_KEY');
        $this->redirectUri = url('/api/v1/kakao/callback');
        // $this->redirectUri = 'http://3.38.197.138:8090/api/v1/kakao/callback';
        if( $this->restApiKey == null ){
            throw new Exception("KAKAO_REST_API_KEY 없음");
        }
        $this->code   = env('KAKAO_CODE');
        $this->client = app(Client::class);
        $this->loadToken();
    }

    public function getAuthUrl()
    {
        $params = http_build_query([
            'client_id'     => $this->restApiKey,
            'redirect_uri'  => $this->redirectUri,
            'response_type' => 'code',
            'scope'         => 'friends,talk_message'
        ]);

        return 'https://kauth.kakao.com/oauth/authorize?' . $params;
    }

    public function getAccessToken(): void
    {
        $response = $this->client->post('https://kauth.kakao.com/oauth/token', [
            'form_params' => [
                'grant_type'   => 'authorization_code',
                'client_id'    => $this->restApiKey,
                'redirect_uri' => $this->redirectUri,
                'code'         => $this->code,
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        if (isset($data['access_token'])) {
            $this->accessToken = $data['access_token'];

            $now                 = Carbon::now();
            $accessTokenExpires  = $now->copy()->addSeconds($data['expires_in']);
            $refreshTokenExpires = $now->copy()->addSeconds($data['refresh_token_expires_in']);
            
            $data['access_token_expires_at']  = $accessTokenExpires->format('Y-m-d H:i:s');
            $data['refresh_token_expires_at'] = $refreshTokenExpires->format('Y-m-d H:i:s');
            $data['created_at']               = $now->format('Y-m-d H:i:s');
            
            $this->saveTokenToFile($data);
        } else {
            throw new Exception('토큰 발급 실패');
        }
    }

    private function loadToken(): void
    {
        $tokenFile = public_path('kakao/token.json');
        
        if (file_exists($tokenFile)) {
            $tokenData = json_decode(file_get_contents($tokenFile), true);
            
            if ($tokenData && isset($tokenData['access_token_expires_at'])) {
                // 현재 시간과 만료 시간 비교
                $now       = Carbon::now();
                $expiresAt = Carbon::parse($tokenData['access_token_expires_at']);
                
                // 만료 2시간 전인지 확인
                $twoHoursBefore = $expiresAt->copy()->subHours(2);

                if ($now->gte($twoHoursBefore)) {
                    // 토큰 갱신 시도
                    $this->refreshAccessToken($tokenData['refresh_token']);
                } else {
                    $this->accessToken = $tokenData['access_token'];
                }
            } else {
                throw new Exception('empty $tokenData');    
            }
        } else {
            throw new Exception('empty 토큰 파일');
        }
    }

    private function refreshAccessToken(string $refreshToken): void
    {
        $data = [
            'grant_type'    => 'refresh_token',
            'client_id'     => $this->restApiKey,
            'refresh_token' => $refreshToken
        ];
        $response = $this->client->post('https://kauth.kakao.com/oauth/token', [
            'form_params' => $data
        ]);

        $data = json_decode($response->getBody(), true);
        
        if (isset($data['access_token'])) {
            $this->accessToken = $data['access_token'];

            $now                 = Carbon::now();
            $accessTokenExpires  = $now->copy()->addSeconds($data['expires_in']);
            $refreshTokenExpires = $now->copy()->addSeconds($data['refresh_token_expires_in']);
            
            $data['access_token_expires_at']  = $accessTokenExpires->format('Y-m-d H:i:s');
            $data['refresh_token_expires_at'] = $refreshTokenExpires->format('Y-m-d H:i:s');
            $data['created_at']               = $now->format('Y-m-d H:i:s');
            
            $this->saveTokenToFile($data);
        } else {
            throw new Exception('리프레쉬 토큰 발급 실패');
        }
    }

    private function saveTokenToFile(array $tokenData): void
    {
        $filePath = public_path('kakao/token.json');
        File::put($filePath, json_encode($tokenData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function getFriends(): array
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        
        $response = $this->client->get('https://kapi.kakao.com/v1/api/talk/friends', [
            'headers' => $headers
            // 쿼리 파라미터는 기본적으로 필요없음
        ]);
    
        $data = json_decode($response->getBody(), true);

        return $data;
    }

    public function sendMessageToMe($message): bool 
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        
        $templateObject = [
            'object_type' => 'text',
            'text'        => $message,
            'link'        => [
                'web_url'        => '',
                'mobile_web_url' => ''
            ]
        ];
        
        $response = $this->client->post('https://kapi.kakao.com/v2/api/talk/memo/default/send', [
            'headers' => $headers,
            'form_params' => [
                'template_object' => json_encode($templateObject, JSON_UNESCAPED_UNICODE)
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        if( !isset($data['result_code']) || $data['result_code'] !== 0 ){
            return false;
        }

        return true;
    }

    public function sendMessageFriends($message): bool 
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $friendUuid = explode(',', env('KAKAO_UUID'));
        
        $templateObject = [
            'object_type'    => 'text',
            'text'           => $message,
            'link'           => [
                'web_url'        => '',
                'mobile_web_url' => ''
            ]
        ];
        
        $response = $this->client->post('https://kapi.kakao.com/v1/api/talk/friends/message/default/send', [
            'headers' => $headers,
            'form_params' => [
                'receiver_uuids'  => json_encode($friendUuid),
                'template_object' => json_encode($templateObject, JSON_UNESCAPED_UNICODE)
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if( !isset($data['result_code']) || $data['result_code'] !== 0 ){
            return false;
        }

        return true;
    }
}