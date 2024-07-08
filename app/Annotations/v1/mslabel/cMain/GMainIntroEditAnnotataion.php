<?php

namespace App\Annotations\v1\mslabel\cMain;

/**
 * 
 * @OA\Schema(
 *     schema="MainIntroEditSchema",
 *     required={"title", "is_show", "desc", "thumbnail"},
 *     description="메인 소개 생성 스키마",
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="메인 소개 테스트1",
 *         description="메인 소개 제목"
 *     ),
 *     @OA\Property(
 *         property="desc",
 *         type="string",
 *         example="메인 소개 테스트1 내용",
 *         description="내용"
 *     ),
 *     @OA\Property(
 *         property="is_show",
 *         type="string",
 *         example="Y",
 *         description="노출 여부 Y: 노출, N: 비노출"
 *     ),
 *     @OA\Property(
 *         property="thumbnail",
 *         type="file",
 *         example="",
 *         description="이미지 파일 (사이즈 1920x 560(px), 2MB 이하, 이미지 형식만 등록 가능)"
 *     )
 * )
 * 
 * 
 * @OA\Post(
 *     path="/api/v1/admin/main/intro/edit/{id}",
 *     summary="메인 소개 수정",
 *     description="메인 소개 수정 endPoint",
 *     tags={"메인"},
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="메인 소개 ID",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(ref="#/components/schemas/MainIntroEditSchema")
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

class GMainIntroEditAnnotataion{
}
