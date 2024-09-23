<?php

namespace App\Annotations\v1\mslabel\dBoard;

/**
 * 
 * @OA\Get(
 *     path="/api/v1/admin/board/board",
 *     summary="게시판 유형 리스트",
 *     description="게시판 유형 리스트 endPoint",
 *     tags={"게시판"},
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="group_id",
 *         in="query",
 *         required=true,
 *         description="대표 메뉴 ID",
 *         @OA\Schema(
 *             type="integer",
 *             example=5
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="sub_id",
 *         in="query",
 *         required=true,
 *         description="서브 메뉴 ID (여러 개 검색 필요 시 ,콤마로 구분 9,12,13)",
 *         @OA\Schema(
 *             type="string",
 *             example="12"
 *         )
 *     ),
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
 *         description="페이징 사이즈 Max 20",
 *         @OA\Schema(
 *             type="integer",
 *             example=20
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="sort",
 *         in="query",
 *         required=true,
 *         description="정렬 created_at: 생성일, updated_at: 수정일 / desc: 내림차순, asc: 오름차순",
 *         @OA\Schema(
 *             type="string",
 *             example="created_at|desc"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="is_reply",
 *         in="query",
 *         required=false,
 *         description="답변 여부 Y: 답변완료, N: 답변미완료",
 *         @OA\Schema(
 *             type="string",
 *             example=""
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="is_reply",
 *         in="query",
 *         required=false,
 *         description="답변 여부 Y: 답변완료, N: 답변미완료",
 *         @OA\Schema(
 *             type="string",
 *             example=""
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="categories",
 *         in="query",
 *         required=false,
 *         description="카테고리 분류 1: 라벨 인쇄, 2: 디지털 인쇄, 3: 파우치 인쇄, 4: 상담 후 결정 ( 콤마로 여러 검색가능 ex: 1,2,3 )",
 *         @OA\Schema(
 *             type="string",
 *             example=""
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="search_cls",
 *         in="query",
 *         required=false,
 *         description="검색 분류 title: 제목, desc: 상세",
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

class B0BoardBoardListAnnotataion{
}
