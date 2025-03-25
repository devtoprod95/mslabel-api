<?php

namespace App\Http\Controllers\OneToFifty;

use Illuminate\Http\JsonResponse;
use App\Constants\HttpConstant;
use App\Http\Controllers\Controller;
use App\Models\OneToFiftyScore;
use Exception;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    private Request $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    function create(): JsonResponse
    {
        try {
            $nickname = $this->request->nickname;
            $time     = $this->request->time;
            $date     = $this->request->date;

            $oneToFifty = new OneToFiftyScore();
            $oneToFifty->nickname = $nickname;
            $oneToFifty->time = $time;
            $oneToFifty->date = $date;
            $oneToFifty->save();

            return helpers_json_response(HttpConstant::OK);
        } catch (Exception $e) {
            return helpers_json_response(HttpConstant::BAD_REQUEST, [], $e->getMessage());
        }
    }
}
