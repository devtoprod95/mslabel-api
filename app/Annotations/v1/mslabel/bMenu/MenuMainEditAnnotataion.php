<?php

namespace App\Annotations\v1\mslabel\bMenu;

/**
 * @OA\Schema(
 *     schema="MenuMainEditSchema",
 *     required={"title"},
 *     description="대표 메뉴 수정 스키마",
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="한국 인쇄",
 *         description="대표 메뉴 제목"
 *     )
 * )
 * 
 * @OA\Patch(
 *     path="/api/v1/admin/menu/main/edit/{id}",
 *     summary="대표 메뉴 수정",
 *     description="대표 메뉴 수정 endPoint",
 *     tags={"메뉴"},
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="대표 메뉴 ID",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/MenuMainEditSchema")
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

class MenuMainEditAnnotataion{
}
