<?php

use App\Constants\HttpConstant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Psr\Log\LogLevel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('helpers_curl')) {
    /**
	 * helpers_curl
	 *
	 * @param  mixed $method (GET, POST)
	 * @param  mixed $url
	 * @param  mixed $data
     * @param  mixed $header
	 * @return array
	 */
	function helpers_curl($method, $url, $header, $data = '') : array
	{

		$curl = curl_init();
		$method = strtoupper($method);
		if($method == 'GET') {
			$queryString = (($data)? http_build_query( $data ) : '');
			curl_setopt_array($curl, array(
				CURLOPT_URL            => $url.(($queryString)? '?'.$queryString : ''),
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_MAXREDIRS      => 10,
				CURLOPT_TIMEOUT        => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST  => $method,
				CURLOPT_HTTPHEADER     => $header
			));
		} else if($method == 'POST'){
			curl_setopt_array($curl, array(
				CURLOPT_URL            => $url,
				CURLOPT_POST           => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_CUSTOMREQUEST  => $method,
				CURLOPT_POSTFIELDS     => json_encode($data),
				CURLOPT_HTTPHEADER     => $header
			));
		}
		$result = curl_exec($curl);
		curl_close($curl);
		$result = json_decode($result, JSON_UNESCAPED_UNICODE);
		if(is_array($result)){
			return $result;
		} else {
			return array();
		}
	}
}

if (!function_exists("microtime_float")) {
	function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$sec + (float)$usec);
	}
}

if (!function_exists("debug_log")) {
	global $debug_time;
	$debug_time = microtime_float();

    function debug_log($str, $dirname, $filename ,string $level = LogLevel::DEBUG)
	{
		global $debug_time;

		$new_time   = microtime(true); // Laravel에서는 이 함수를 직접 사용할 수 있습니다.
        $time_gap   = $new_time - $debug_time;
        $debug_time = $new_time;
        $time_str   = ($time_gap > 1000000000) ? "-.---" : number_format($time_gap, 3);

        $logStr = "[excuteTime: $time_str] $str";
        $cliLog = "[".date('Y-m-d H:i:s')."][excuteTime: $time_str] $str";

        // 경로와 파일 이름을 사용하여 로그 채널 동적으로 생성
        $logChannel = Log::build([
            'driver' => 'single',
            'path'   => storage_path('logs/'.$dirname.'/'.$filename.date('Ymd').'.log'),
        ]);

        switch ($level) {
            case LogLevel::DEBUG:
                $logChannel->debug($logStr);
                break;
            case LogLevel::NOTICE:
                $logChannel->notice($logStr);
                break;
            case LogLevel::WARNING:
                $logChannel->warning($logStr);
                break;
            case LogLevel::ERROR:
                $logChannel->error($logStr);
                break;
            case LogLevel::INFO:
            default:
                $logChannel->info($logStr);
        }
        echo $cliLog . PHP_EOL;
    }
}

if (!function_exists("helpers_default_message")) {
    function helpers_default_message(bool $isSuccess = false, string $message = "잘못 된 접근입니다.", array $data = []): array
    {
        return [
            "isSuccess" => $isSuccess,
            "msg"       => $message,
            "data"      => $data,
        ];
    }
}

if (!function_exists("helpers_fail_message")) {
    function helpers_fail_message(string $message = "변경 사항이 없거나 처리가 실패하였습니다. 관리자에 문의 바랍니다.", array $data = []): array
    {
        return [
            "isSuccess" => false,
            "msg"       => $message,
            "data"      => $data,
        ];
    }
}

if (!function_exists("helpers_success_message")) {
    function helpers_success_message(array $data = [], int $affectRows = 0, string $message = "정상 처리 되었습니다."): array
    {
        if( $affectRows > 0){
            return [
                "isSuccess" => true,
                "msg"       => $message." 반영 수 :".$affectRows,
                "data"      => $data,
            ];
        }else{
            return [
                "isSuccess" => true,
                "msg"       => $message,
                "data"      => $data,
            ];
        }
    }
}

if (!function_exists("helpers_json_response")) {
    function helpers_json_response(int $status, array $params = [], string $message = ""): JsonResponse
    {
        $routeParts = explode(".", Route::currentRouteName());
        $apiVersion = empty($routeParts[0]) ? "v1" : $routeParts[0];

        $result = [
            "status" => $status,
            "meta" => [
                "timestamp"  => Carbon::now()->format('Y-m-d H:i:s'),
                "api_version" => $apiVersion
            ]
        ];
        if( $status == HttpConstant::OK ){
            unset($params["isSuccess"]);
            $result = array_merge($result, $params);
            if( trim($message) != "" ){
                $result["message"] = $message;
            }
        }else{
            $error = [
                "error" => [
                    "code"    => $status,
                    "message" => trim($message) != "" ? $message : "잘못 된 접근입니다.",
                ]
            ];
            $result = array_merge($result, $error);
        }

        return response()->json($result, $status);
    }
}

if (!function_exists("helpers_format_YmdHis")) {
    function helpers_format_YmdHis($isoString = null) {
        $date = $isoString ? Carbon::parse($isoString, 'UTC') : Carbon::now('Asia/Seoul');
        return $date->setTimezone('Asia/Seoul')->format('Y-m-d H:i:s');
    }
}

if (!function_exists("helpersGetOnlyNumbers")) {
    function helpersGetOnlyNumbers(string $string = ""): string
    {
        return preg_replace('/[^0-9]/', '', $string);
    }
}

if (!function_exists("printQuery")) {
    function printQuery($model)
    {
        $sql = $model->toSql();
        $bindings = $model->getBindings();

        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }

        dd($sql);
    }
}

if (!function_exists('saveLocalImage')) {
    /**
     * 이미지 파일을 저장하는 함수
     *
     * @param string $path 저장 경로
     * @param \Illuminate\Http\UploadedFile $file 업로드된 파일
     * @param string $addFileName 저장할 파일명
     * @throws \Exception
     */
    function saveLocalImage(UploadedFile $file, string $path, string $addFileName = ""): string
    {
        try {
            // 디렉토리가 존재하지 않으면 생성
            if (!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }

            // 타임스탬프와 랜덤 문자열을 결합한 고유한 파일명 생성
            $uniqueFilename = time() . '_' . Str::random(10);

            // 파일 확장자 추출
            $extension = $file->getClientOriginalExtension();
            if( $addFileName != "" ){
                $uniqueFilename = $addFileName . "_" . $uniqueFilename;
            }

            $filePath  = $path . '/' . $uniqueFilename . '.' . $extension;

            // 파일 저장
            $file->storeAs($path, $uniqueFilename . '.' . $extension, 'public');

            // 서버 도메인을 포함한 전체 URL 생성
            $fullUrl = config('app.url') . '/storage/' . $filePath;

            return $fullUrl;
        } catch (Exception $e) {
            throw new Exception('이미지 저장 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }
}

if (!function_exists('deleteLocalFile')) {
    /**
     * 로컬 파일을 삭제하는 함수
     *
     * @param string $path 파일 경로
     * @return bool 파일 삭제 성공 여부
     * @throws Exception
     */
    function deleteLocalFile(string $path): bool
    {
        
        try {
            $appUrl = env("APP_URL") . "/storage/";
            $path   = str_replace($appUrl, '', $path);

            // 파일이 존재하면 삭제
            if (Storage::disk('public')->exists($path)) {
                return Storage::disk('public')->delete($path);
            }
            return false;
        } catch (Exception $e) {
            throw new Exception('파일 삭제 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }
}

if (!function_exists('saveLocalFile')) {
    /**
     * 파일을 저장하는 함수
     *
     * @param string $path 저장 경로
     * @param \Illuminate\Http\UploadedFile $file 업로드된 파일
     * @param string $addFileName 저장할 파일명
     * @throws \Exception
     */
    function saveLocalFile(UploadedFile $file, string $path, string $addFileName = ""): string
    {
        try {
            // 디렉토리가 존재하지 않으면 생성
            if (!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }

            // 타임스탬프와 랜덤 문자열을 결합한 고유한 파일명 생성
            $uniqueFilename = time() . '_' . Str::random(10);

            // 파일 확장자 추출
            $extension = $file->getClientOriginalExtension();
            if ($addFileName != "") {
                $uniqueFilename = $addFileName . "_" . $uniqueFilename;
            }

            $filePath = $path . '/' . $uniqueFilename . '.' . $extension;

            // 파일 저장
            $file->storeAs($path, $uniqueFilename . '.' . $extension, 'public');

            // 서버 도메인을 포함한 전체 URL 생성
            $fullUrl = config('app.url') . '/storage/' . $filePath;

            return $fullUrl;
        } catch (Exception $e) {
            throw new Exception('파일 저장 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }
}

if (!function_exists("channelLog")) {
    /**
     * 커스텀 채널 로거
     * 
     * 지정된 채널과 파일명으로 로그를 기록하며, 실행 시간과 호출 위치 정보를 자동으로 추가합니다.
     * Laravel의 daily 드라이버를 사용하여 날짜별로 로그 파일을 생성합니다.
     * 
     * @param Throwable $message 로그 인스턴스
     * @param string $channel 로그 채널명 (폴더명으로도 사용됨)
     * @param string|null $filename 로그 파일명 (null일 경우 채널명 사용, 실제 파일은 filename-yyyy-mm-dd.log 형태로 저장)
     * @param string $level 로그 레벨 (emergency, alert, critical, error, warning, notice, info, debug)
     * @param int $days 로그 파일 보관 일수 (기본: 30일)
     * 
     * @example channelLog('시작', 'apple') → logs/apple/apple-2025-06-02.log
     * @example channelLog('에러', 'apple', 'error_log', 'error') → logs/apple/error_log-2025-06-02.log
     * @example channelLog('디버그', 'apple', null, 'debug') → logs/apple/apple-2025-06-02.log
     * 
     * @return void
     */
    function channelLog(Throwable $message, string $channel, ?string $filename = null, string $level = 'info', int $days = 30)
    {
        // 전역 디버그 타임 변수 (처음 호출 시 초기화)
        global $debugTime;
        if (!isset($debugTime)) {
            $debugTime = microtime_float();
        }
        
        // 파일명 결정 (지정되지 않으면 채널명 사용)
        $logFilename = $filename ?: $channel;
        
        // 채널명을 파일명에 따라 고유하게 생성
        $uniqueChannelName = $channel . '_' . $logFilename;
        
        // 채널 구성이 없으면 생성
        if (!config()->has('logging.channels.'.$uniqueChannelName)) {
            config(['logging.channels.'.$uniqueChannelName => [
                'driver'     => 'daily',
                'path'       => storage_path("logs/{$channel}/{$logFilename}.log"),
                'level'      => env('LOG_LEVEL', 'debug'),
                'days'       => $days,
                'permission' => 0777,
            ]]);
        }
        
        // 실행 시간 계산
        $newTime     = microtime_float();
        $timeGap     = $newTime - $debugTime;
        $runningTime = number_format($timeGap, 3);
        
        // Exception 객체인지 확인해서 위치 정보 추출
        if ($message instanceof Throwable) {
            // Exception 객체인 경우 실제 에러 발생 위치 사용
            $runFile     = basename($message->getFile());
            $location    = "{$runFile}:{$message->getLine()}";
            $messageText = $message->getMessage();
        } else {
            // 일반 문자열인 경우 호출한 위치 사용
            $backtrace   = debug_backtrace();
            $caller      = $backtrace[0];
            $runFile     = basename($caller['file']);
            $location    = "{$runFile}:{$caller['line']}";
            $messageText = $message;
        }
        
        // 메시지에 추가 정보 붙이기
        $prefixedMessage = sprintf(
            "[runningTime: %ss][location: %s] %s",
            $runningTime,
            $location,
            $messageText
        );
        
        // 고유한 채널명으로 로거 가져오기
        $logger = \Illuminate\Support\Facades\Log::channel($uniqueChannelName);
        
        // 유효한 로그 레벨인지 확인
        $validLevels = ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'];
        if (!in_array(strtolower($level), $validLevels)) {
            $level = 'info'; // 기본값으로 설정
        }
        
        // 로깅 실행
        $logger->{$level}($prefixedMessage);
    }
}