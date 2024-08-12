<?php

namespace App\Annotations\v1\mslabel\dBoard;

/**
 * 
 * @OA\Get(
 *     path="/api/v1/admin/board/{type}/{id}",
 *     summary="게시판 상세 조회",
 *     description="게시판 상세 조회 endPoint",
 *     tags={"게시판"},
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="type",
 *         in="path",
 *         required=true,
 *         description="게시판 유형 image: 이미지, product: 상품, board: 게시판, editor: 에디터",
 *         @OA\Schema(
 *             type="string",
 *             example="product"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="게시판 ID",
 *         @OA\Schema(
 *             type="integer",
 *             example=1
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

class D0BoardDetailAnnotataion{
}
