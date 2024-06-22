<?php

namespace App\Annotations\v1\mslabel\bMenu;

/**
 * 
 * 
 * @OA\Get(
 *     path="/api/v1/menu/sub",
 *     summary="서브 메뉴 리스트",
 *     description="서브 메뉴 리스트 endPoint",
 *     tags={"메뉴"},
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         required=true,
 *         description="페이지 수",
 *         @OA\Schema(
 *             type="integer",
 *             example=1
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="page_size",
 *         in="query",
 *         required=true,
 *         description="페이징 사이즈",
 *         @OA\Schema(
 *             type="integer",
 *             example=50
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="group_id",
 *         in="query",
 *         required=false,
 *         description="메인 메뉴 검색 ID",
 *         @OA\Schema(
 *             type="integer",
 *             example=""
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="search_cls",
 *         in="query",
 *         required=false,
 *         description="검색 분류 sub_title: 서브 메뉴 제목",
 *         @OA\Schema(
 *             type="string",
 *             example=""
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="keyword",
 *         in="query",
 *         required=false,
 *         description="검색어",
 *         @OA\Schema(
 *             type="string",
 *             example=""
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Authorization Error",
 *         @OA\JsonContent(ref="#/components/schemas/401ErrorResponse")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input",
 *         @OA\JsonContent(ref="#/components/schemas/400ErrorResponse")
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal Server Error",
 *         @OA\JsonContent(ref="#/components/schemas/500ErrorResponse")
 *     )
 * )
*/

class MenuSubAnnotataion{
}
