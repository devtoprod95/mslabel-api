<?php

namespace App\Http\Controllers;

use App\Constants\HttpConstant;
use App\Services\MainService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    private Request $request;
    private MainService $mainService;

    function __construct(Request $request, MainService $mainService)
    {
        $this->request     = $request;
        $this->mainService = $mainService;
    }

    function list()
    {
        $result = $this->mainService->getMainList();
        if( $result["isSuccess"] == true ){
            return helpers_json_response(HttpConstant::OK, $result);
        } else {
            return helpers_json_response(HttpConstant::BAD_REQUEST, [], $result["msg"]);
        }
    }

}
