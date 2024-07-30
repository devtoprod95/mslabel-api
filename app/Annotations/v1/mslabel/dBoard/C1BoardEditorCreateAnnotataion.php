<?php

namespace App\Annotations\v1\mslabel\dBoard;

/**
 * 
 * @OA\Schema(
 *     schema="BoardEditorCreateSchema",
 *     required={"sub_id", "title", "is_show", "desc", "image", "show_started_at", "show_ended_at"},
 *     description="에디터 유형 생성 스키마",
 *     @OA\Property(
 *         property="sub_id",
 *         type="integer",
 *         example=9,
 *         description="서브 메뉴 id"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="화장품 라벨",
 *         description="제목"
 *     ),
 *     @OA\Property(
 *         property="is_show",
 *         type="string",
 *         example="Y",
 *         description="노출 여부 Y: 노출, N: 비노출"
 *     ),
 *     @OA\Property(
 *         property="desc",
 *         type="string",
 *         example="별도의 후가공 없이도 처리가 되어보이는...",
 *         description="내용"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         type="file",
 *         example="",
 *         description="이미지 파일 (사이즈 600 x 600(px), 2MB 이하, 이미지 형식만 등록 가능)"
 *     ),
 *     @OA\Property(
 *         property="show_started_at",
 *         type="string",
 *         example="2024-01-01",
 *         description="노출 시작일"
 *     ),
 *     @OA\Property(
 *         property="show_ended_at",
 *         type="string",
 *         example="2024-07-31",
 *         description="노출 종료일"
 *     )
 * )
 * 
 * 
 * @OA\Post(
 *     path="/api/v1/admin/board/editor/create",
 *     summary="에디터 유형 생성",
 *     description="에디터 유형 생성 endPoint",
 *     tags={"게시판"},
 *     security={{"BearerAuth": {}}},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(ref="#/components/schemas/BoardEditorCreateSchema")
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

class C1BoardEditorCreateAnnotataion{
}
