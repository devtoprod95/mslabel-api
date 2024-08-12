<?php

namespace App\Http\Controllers\Admin;

use App\Constants\BoardErrorMessageConstant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Constants\HttpConstant;
use App\Constants\MenuConstant;
use App\Http\Controllers\Controller;
use App\Services\Admin\BoardService;
use App\Validators\BoardBoardListValidator;
use App\Validators\BoardBoardValidator;
use App\Validators\BoardEditorListValidator;
use App\Validators\BoardEditorValidator;
use App\Validators\BoardProductListValidator;
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

    function list(string $type): JsonResponse
    {
        try {
            if( $type == MenuConstant::SUB_TYPE_PRODUCT ){
                $validator = new BoardProductListValidator($this->request);
                $validator->validate();
            } else if( $type == MenuConstant::SUB_TYPE_BOARD ){
                $validator = new BoardBoardListValidator($this->request);
                $validator->validate();
            } else if( $type == MenuConstant::SUB_TYPE_EDITOR ){
                $validator = new BoardEditorListValidator($this->request);
                $validator->validate();
            } else {
                throw new Exception(BoardErrorMessageConstant::getFitErrorMessage("TYPE"));
            }

            $result = $this->boardService->list($type, $this->request);
            if( $result["isSuccess"] == true ){
                return helpers_json_response(HttpConstant::OK, $result);
            } else {
                return helpers_json_response(HttpConstant::BAD_REQUEST, [], $result["msg"]);
            }
        } catch (Exception $e) {
            return helpers_json_response(HttpConstant::BAD_REQUEST, [], $e->getMessage());
        }
    }

    function detail(string $type, int $id): JsonResponse
    {
        try {
            $result = $this->boardService->detail($type, $id);
            if( $result["isSuccess"] == true ){
                return helpers_json_response(HttpConstant::OK, $result);
            } else {
                return helpers_json_response(HttpConstant::BAD_REQUEST, [], $result["msg"]);
            }
        } catch (Exception $e) {
            return helpers_json_response(HttpConstant::BAD_REQUEST, [], $e->getMessage());
        }
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

    function reply(int $id): JsonResponse
    {
        try {
            $validator = Validator::make($this->request->all(), [
                'reply_type' => 'required|int',
                'desc'       => 'required|string',
            ], [
                'reply_type.required' => BoardErrorMessageConstant::getNotHaveErrorMessage("REPLY_TYPE"),
                'desc.required'       => BoardErrorMessageConstant::getNotHaveErrorMessage("DESC"),
            ]);
    
            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            $result = $this->boardService->reply($id, $this->request);
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
