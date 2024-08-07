<?php

namespace App\Annotations\v1\mslabel\dBoard;

/**
 * 
 * @OA\Schema(
 *     schema="BoardProductEditSchema",
 *     required={"sub_id", "title", "is_show", "desc", "main_img", "bottom_img1", "material", "size", "shape", "keywords"},
 *     description="상품 유형 수정 스키마",
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
 *         property="main_img",
 *         type="file",
 *         example="",
 *         description="이미지 파일 (사이즈 606 x 606(px), 2MB 이하, 이미지 형식만 등록 가능)"
 *     ),
 *     @OA\Property(
 *         property="bottom_img1",
 *         type="file",
 *         example="",
 *         description="이미지 파일 (사이즈 606 x 606(px), 5MB 이하, 이미지 형식만 등록 가능)"
 *     ),
 *     @OA\Property(
 *         property="bottom_img2",
 *         type="file",
 *         example="",
 *         description="이미지 파일 (사이즈 606 x 606(px), 5MB 이하, 이미지 형식만 등록 가능)"
 *     ),
 *     @OA\Property(
 *         property="bottom_img3",
 *         type="file",
 *         example="",
 *         description="이미지 파일 (사이즈 606 x 606(px), 5MB 이하, 이미지 형식만 등록 가능)"
 *     ),
 *     @OA\Property(
 *         property="bottom_img4",
 *         type="file",
 *         example="",
 *         description="이미지 파일 (사이즈 606 x 606(px), 5MB 이하, 이미지 형식만 등록 가능)"
 *     ),
 *     @OA\Property(
 *         property="bottom_img5",
 *         type="file",
 *         example="",
 *         description="이미지 파일 (사이즈 606 x 606(px), 5MB 이하, 이미지 형식만 등록 가능)"
 *     ),
 *     @OA\Property(
 *         property="material",
 *         type="string",
 *         example="강철소재",
 *         description="원단"
 *     ),
 *     @OA\Property(
 *         property="size",
 *         type="string",
 *         example="300x200",
 *         description="사이즈"
 *     ),
 *     @OA\Property(
 *         property="shape",
 *         type="string",
 *         example="동그라미",
 *         description="형태"
 *     ),
 *     @OA\Property(
 *         property="keywords",
 *         type="string",
 *         example="#화장품#매우 가벼움#키워드",
 *         description="#OOO#OOO 형식입력"
 *     )
 * )
 * 
 * 
 * @OA\Post(
 *     path="/api/v1/admin/board/product/edit/{id}",
 *     summary="상품 유형 수정",
 *     description="상품 유형 수정 endPoint",
 *     tags={"게시판"},
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="게시판 ID",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(ref="#/components/schemas/BoardProductEditSchema")
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

class A2BoardProductEditAnnotataion{
}
