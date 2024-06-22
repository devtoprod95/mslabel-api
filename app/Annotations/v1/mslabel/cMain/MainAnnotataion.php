<?php

namespace App\Annotations\v1\mslabel\cMain;

/**
 * 
 * 
 * @OA\Get(
 *     path="/api/v1/main",
 *     summary="메인 페이지 데이터",
 *     tags={"메인"},
 *     security={{"BearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=false,
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

class MainAnnotataion{
}
