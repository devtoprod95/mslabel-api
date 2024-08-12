<?php

namespace App\Annotations\v1\mslabel\dBoard;

/**
 * 
 * @OA\Schema(
 *     schema="BoardReplyCreateSchema",
 *     required={"reply_type", "desc"},
 *     description="에디터 유형 생성 스키마",
 *     @OA\Property(
 *         property="reply_type",
 *         type="integer",
 *         example=1,
 *         description="답변 유형"
 *     ),
 *     @OA\Property(
 *         property="desc",
 *         type="string",
 *         example="별도의 후가공 없이도 처리가 되어보이는...",
 *         description="내용"
 *     )
 * )
 * 
 * 
 * @OA\Post(
 *     path="/api/v1/admin/board/reply/{id}",
 *     summary="게시판 유형 답글 등록",
 *     description="게시판 유형 답글 등록 endPoint",
 *     tags={"게시판"},
 *     security={{"BearerAuth": {}}},
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
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/BoardReplyCreateSchema")
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

class B2BoardReplyCreateAnnotataion{
}
