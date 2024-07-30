<?php

namespace App\Http\Controllers\Admin;

use App\Constants\BoardErrorMessageConstant;
use Illuminate\Http\JsonResponse;
use App\Constants\HttpConstant;
use App\Constants\MenuConstant;
use App\Http\Controllers\Controller;
use App\Services\Admin\BoardService;
use App\Validators\BoardBoardValidator;
use App\Validators\BoardEditorValidator;
use App\Validators\BoardProductValidator;
use Exception;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    private Request $request;
    private BoardService $boardService;

    function __construct(Request $request, BoardService $boardService)
    {
        $this->request     = $request;
        $this->boardService = $boardService;
    }

    function create(string $type): JsonResponse
    {
        try {
            if( $type == MenuConstant::SUB_TYPE_PRODUCT ){
                $validator = new BoardProductValidator($this->request);
                $validator->validate();
            } else if( $type == MenuConstant::SUB_TYPE_BOARD ){
                $validator = new BoardBoardValidator($this->request);
                $validator->validate();
            } else if( $type == MenuConstant::SUB_TYPE_EDITOR ){
                $validator = new BoardEditorValidator($this->request);
                $validator->validate();
            } else {
                throw new Exception(BoardErrorMessageConstant::getFitErrorMessage("TYPE"));
            }

            $result = $this->boardService->create($type, $this->request);
            if( $result["isSuccess"] == true ){
                return helpers_json_response(HttpConstant::OK, $result);
            } else {
                return helpers_json_response(HttpConstant::BAD_REQUEST, [], $result["msg"]);
            }
        } catch (Exception $e) {
            return helpers_json_response(HttpConstant::BAD_REQUEST, [], $e->getMessage());
        }
    }

    function edit(string $type, int $id): JsonResponse
    {
        try {
            if( $type == MenuConstant::SUB_TYPE_PRODUCT ){
                $validator = new BoardProductValidator($this->request);
                $validator->validate();
            } else if( $type == MenuConstant::SUB_TYPE_BOARD ){
                $validator = new BoardBoardValidator($this->request);
                $validator->validate();
            } else if( $type == MenuConstant::SUB_TYPE_EDITOR ){
                $validator = new BoardEditorValidator($this->request);
                $validator->validate();
            } else {
                throw new Exception(BoardErrorMessageConstant::getFitErrorMessage("TYPE"));
            }

            $result = $this->boardService->edit($type, $id, $this->request);
            if( $result["isSuccess"] == true ){
                return helpers_json_response(HttpConstant::OK, $result);
            } else {
                return helpers_json_response(HttpConstant::BAD_REQUEST, [], $result["msg"]);
            }
        } catch (Exception $e) {
            return helpers_json_response(HttpConstant::BAD_REQUEST, [], $e->getMessage());
        }
    }
}
