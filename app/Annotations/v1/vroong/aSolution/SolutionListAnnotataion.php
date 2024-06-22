<?php

namespace App\Annotations\v1\vroong\aSolution;

/**
 * 
 * 
 * @OA\Schema(
 *     schema="SolutionListSchema",
 *     required={"userLifeStyleTags"},
 *     @OA\Property(property="type", type="string", example="DIET", description="DIET 또는 FITNESS 입력"),
 *     @OA\Property(
 *            property="userLifeStyleTags", 
 *            type="array",
 *            @OA\Items(type="string"),
 *            example={"enough_money", "enough_time", "strong_will"},
 *            description="라이프스타일 목록 enough_time, strong_will, enough_money"
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="SolutionListSuccessResponse",
 *     @OA\Property(property="status", type="integer", example=200),
 *     @OA\Property(
 *         property="meta", 
 *         type="object",
 *         @OA\Property(property="timestamp", type="string", example="2023-12-19 17:45:50"),
 *         @OA\Property(property="api_version", type="string", example="v1")
 *     ),
 *     @OA\Property(property="msg", type="string", example="정상 처리 되었습니다."),
 *     @OA\Property(
 *         property="data", 
 *         type="object",
 *         description="추천 솔루션 및 태그 포함 수 전달",
 *         @OA\Property(
 *             property="recomSolutionRank", 
 *             type="array",
 *             description="전달한 라이프스타일 태그로 분석해 추천 솔루션을 내림차순으로 전달",
 *             @OA\Items(
 *                  type="string"
 *             ),
 *             example={"Intermittent Fasting", "LCHF"}
 *         ),
 *         @OA\Property(
 *             property="includeTagCount", 
 *             type="object",
 *             description="솔루션에 포함된 라이프스타일 태그 수",
 *             @OA\Property(property="Intermittent Fasting", type="integer", example=2),
 *             @OA\Property(property="LCHF", type="integer", example=1),
 *         )
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/v1/how-to-lose-weight",
 *     summary="솔루션 추천 리스트",
 *     tags={"사전과제"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/SolutionListSchema")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(ref="#/components/schemas/SolutionListSuccessResponse")
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

class SolutionListAnnotataion
{
}
