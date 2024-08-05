<?php

namespace App\Annotations\v1\mslabel\cMain;

/**
 * 
 * @OA\Schema(
 *     schema="MainIntro2EditSchema",
 *     required={"title", "is_show", "thumbnail"},
 *     description="메인 소개2 생성 스키마",
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="메인 소개2 테스트1",
 *         description="메인 소개2 제목"
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
 *         description="이미지 파일 (사이즈 293 x 581(px), 2MB 이하, 이미지 형식만 등록 가능)"
 *     )
 * )
 * 
 * 
 * @OA\Patch(
 *     path="/api/v1/admin/main/intro2/edit/{id}",
 *     summary="메인 소개2 수정",
 *     description="메인 소개2 수정 endPoint",
 *     tags={"메인"},
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="메인 소개2 ID",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(ref="#/components/schemas/MainIntro2EditSchema")
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

class IcMainIntro2EditAnnotataion{
}
