<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use App\Constants\HttpConstant;
use App\Constants\MenuConstant;
use App\Constants\MenuErrorMessageConstant;
use App\Http\Controllers\Controller;
use App\Services\Admin\MenuService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    private Request $request;
    private MenuService $menuService;

    function __construct(Request $request, MenuService $menuService)
    {
        $this->request     = $request;
        $this->menuService = $menuService;
    }

    function mainList(): JsonResponse
    {
        $result = $this->menuService->mainList();
        if( $result["isSuccess"] == true ){
            return helpers_json_response(HttpConstant::OK, $result);
        } else {
            return helpers_json_response(HttpConstant::BAD_REQUEST, [], $result["msg"]);
        }
    }

    function mainEdit(int $id): JsonResponse
    {
        try {
            $validator = Validator::make($this->request->all(), [
                'title' => 'required|string',
            ], [
                'title.required' => MenuErrorMessageConstant::getNotHaveErrorMessage("TITLE"),
            ]);
            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            $title = $this->request->post("title");

            $params = [
                "id"    => $id,
                "title" => $title,
            ];

            $result = $this->menuService->mainEdit($params);
            if( $result["isSuccess"] == true ){
                return helpers_json_response(HttpConstant::OK, $result);
            } else {
                return helpers_json_response(HttpConstant::BAD_REQUEST, [], $result["msg"]);
            }
        } catch (Exception $e) {
            return helpers_json_response(HttpConstant::BAD_REQUEST, [], $e->getMessage());
        }
    }

    function subList(): JsonResponse
    {
        try {
            $validator = Validator::make($this->request->all(), [
                'page'      => 'required|int',
                'page_size' => 'required|string',
            ], [
                'page.required'      => MenuErrorMessageConstant::getNotHaveErrorMessage("PAGE"),
                'page_size.required' => MenuErrorMessageConstant::getNotHaveErrorMessage("PAGE_SIZE"),
            ]);
            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            $page      = $this->request->get("page", 1);
            $pageSize  = $this->request->get("page_size", 50);
            $groupId   = $this->request->get("group_id", "") ?? "";
            $searchCls = $this->request->get("search_cls", "") ?? "";
            $keyword   = $this->request->get("keyword", "") ?? "";
            $sort      = $this->request->get("sort", "rank|asc") ?? "rank|asc";

            if( $pageSize > 50 ) $pageSize = 50;

            $params = [
                "page"      => $page,
                "pageSize"  => $pageSize,
                "groupId"   => $groupId,
                "searchCls" => $searchCls,
                "keyword"   => $keyword,
                "sort"      => $sort,
            ];
            $result = $this->menuService->subList($params);

            return helpers_json_response(HttpConstant::OK, $result);
        } catch (Exception $e) {
            return helpers_json_response(HttpConstant::BAD_REQUEST, [], $e->getMessage());
        }
    }

    function subMenuCreate(): JsonResponse
    {
        try {
            $validator = Validator::make($this->request->all(), [
                'group_id' => 'required|int',
                'title'    => 'required|string',
                'type'     => 'required|string',
            ], [
                'group_id.required' => MenuErrorMessageConstant::getNotHaveErrorMessage("GROUP_ID"),
                'title.required'    => MenuErrorMessageConstant::getNotHaveErrorMessage("SUB_TITLE"),
                'type.required'     => MenuErrorMessageConstant::getNotHaveErrorMessage("SUB_TYPE"),
            ]);
            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }
            
            $groupId = $this->request->post("group_id");
            $title   = $this->request->post("title");
            $type    = $this->request->post("type");

            if( !in_array($type, MenuConstant::SUB_TYPE_LIST) ){
                throw new Exception(MenuErrorMessageConstant::getFitErrorMessage("SUB_TYPE"));
            }

            $params = [
                "groupId" => $groupId,
                "title"   => $title,
                "type"    => $type,
            ];

            $result = $this->menuService->subMenuCreate($params);
            if( $result["isSuccess"] == true ){
                return helpers_json_response(HttpConstant::OK, $result);
            } else {
                return helpers_json_response(HttpConstant::BAD_REQUEST, [], $result["msg"]);
            }
        } catch (Exception $e) {
            return helpers_json_response(HttpConstant::BAD_REQUEST, [], $e->getMessage());
        }
    }

    function subEdit(int $id): JsonResponse
    {
        try {
            $validator = Validator::make($this->request->all(), [
                'group_id' => 'required|int',
                'title'    => 'required|string',
                'rank'     => 'required|int',
            ], [
                'group_id.required' => MenuErrorMessageConstant::getNotHaveErrorMessage("GROUP_ID"),
                'title.required'    => MenuErrorMessageConstant::getNotHaveErrorMessage("SUB_TITLE"),
                'rank.required'     => MenuErrorMessageConstant::getNotHaveErrorMessage("SUB_RANK"),
            ]);
            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }
            
            $groupId = $this->request->post("group_id");
            $title   = $this->request->post("title");
            $rank    = $this->request->post("rank");

            $params = [
                "id"      => $id,
                "groupId" => $groupId,
                "title"   => $title,
                "rank"    => $rank,
            ];

            $result = $this->menuService->subEdit($params);
            if( $result["isSuccess"] == true ){
                return helpers_json_response(HttpConstant::OK, $result);
            } else {
                return helpers_json_response(HttpConstant::BAD_REQUEST, [], $result["msg"]);
            }
        } catch (Exception $e) {
            return helpers_json_response(HttpConstant::BAD_REQUEST, [], $e->getMessage());
        }
    }

    function subDelete(int $id): JsonResponse
    {
        try {
            $result = $this->menuService->subDelete($id);
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
