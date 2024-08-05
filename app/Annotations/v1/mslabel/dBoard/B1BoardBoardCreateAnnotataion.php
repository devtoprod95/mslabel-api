<?php

namespace App\Annotations\v1\mslabel\dBoard;

/**
 * 
 * @OA\Schema(
 *     schema="BoardBoardCreateSchema",
 *     required={"sub_id", "company", "title", "contact_name", "contact_email", "contact_phone", "password", "mapping_categories", "size", "purpose", "material", "shape", "quantity", "desc", "etc_file"},
 *     description="게시판 유형 생성 스키마",
 *     @OA\Property(
 *         property="sub_id",
 *         type="integer",
 *         example=12,
 *         description="서브 메뉴 id"
 *     ),
 *     @OA\Property(
 *         property="company",
 *         type="string",
 *         example="유니클로",
 *         description="회사명"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="테스트 제목",
 *         description="제목"
 *     ),
 *     @OA\Property(
 *         property="contact_name",
 *         type="string",
 *         example="홍길동",
 *         description="담당자 성명"
 *     ),
 *     @OA\Property(
 *         property="contact_email",
 *         type="string",
 *         example="devtoproduction@gmail.com",
 *         description="담당자 이메일"
 *     ),
 *     @OA\Property(
 *         property="contact_phone",
 *         type="string",
 *         example="010-1234-5678",
 *         description="담당자 번호"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         example="1234",
 *         description="비밀번호"
 *     ),
 *     @OA\Property(
 *         property="mapping_categories",
 *         type="string",
 *         example="1,2,3",
 *         description="카테고리 분류 1: 라벨 인쇄, 2: 디지털 인쇄, 3: 파우치 인쇄, 4: 상담 후 결정"
 *     ),
 *     @OA\Property(
 *         property="size",
 *         type="string",
 *         example="100mm x 100mm x 100mm",
 *         description="제품 규격"
 *     ),
 *     @OA\Property(
 *         property="purpose",
 *         type="string",
 *         example="화장품 부착 라벨",
 *         description="제품 용도"
 *     ),
 *     @OA\Property(
 *         property="material",
 *         type="string",
 *         example="유포지",
 *         description="원단 및 코딩 여부"
 *     ),
 *     @OA\Property(
 *         property="shape",
 *         type="string",
 *         example="롤",
 *         description="가공 형태"
 *     ),
 *     @OA\Property(
 *         property="quantity",
 *         type="string",
 *         example="10만",
 *         description="수량"
 *     ),
 *     @OA\Property(
 *         property="desc",
 *         type="string",
 *         example="테스트 기타 사항",
 *         description="기타 문의사항"
 *     ),
 *     @OA\Property(
 *         property="etc_file",
 *         type="file",
 *         example="",
 *         description="파일 5MB 이하"
 *     )
 * )
 * 
 * 
 * @OA\Post(
 *     path="/api/v1/admin/board/board/create",
 *     summary="게시판 유형 생성",
 *     description="게시판 유형 생성 endPoint",
 *     tags={"게시판"},
 *     security={{"BearerAuth": {}}},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(ref="#/components/schemas/BoardBoardCreateSchema")
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

class B1BoardBoardCreateAnnotataion{
}
