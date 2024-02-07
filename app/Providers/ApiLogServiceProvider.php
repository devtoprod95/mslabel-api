<?php

namespace App\Providers;

use App\Models\ApiDetailLog;
use App\Models\ApiLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class ApiLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 요청과 응답을 기록하는 로직
        Request::macro('captureApiLog', function ($response) {
            $request  = request(); // 현재 요청 인스턴스를 가져옵니다.
            $fullUrl  = $request->fullUrl();
            $endPoint = parse_url($fullUrl, PHP_URL_PATH);

            ApiLog::updateOrCreate(
                ['endpoint' => $endPoint],
                ['count'    => DB::raw('count + 1')]
            );

            // 응답 내용을 JSON 디코딩
            $decodedResponse = json_decode($response->getContent(), JSON_UNESCAPED_UNICODE);
            ApiDetailLog::create([
                'endpoint' => $endPoint,
                'status'   => $response->status(),
                'method'   => $request->method(),
                'header'   => json_encode($request->header(), JSON_UNESCAPED_UNICODE),
                'request'  => json_encode($request->all(), JSON_UNESCAPED_UNICODE),
                'response' => json_encode($decodedResponse, JSON_UNESCAPED_UNICODE),
                'ip'       => $request->ip(),
            ]);
        });
    }
}
