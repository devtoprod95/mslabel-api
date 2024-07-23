<?php

namespace App\Abstracts\Admin;

use App\Constants\BoardErrorMessageConstant;
use App\Constants\MenuConstant;
use App\DTOs\Board\BoardProductDto;
use App\Models\BoardProductData;
use App\Models\NoticeSubData;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

abstract class BoardAbstract
{
    protected array $returnMsg;

    public function __construct()
    {
        $this->returnMsg = helpers_fail_message();
    }

    /**
     * @func create
     * @description '게시판 생성'
     * @param string $type
     * @param Request $request
     * @return array
     */
    public function create(string $type, Request $request): array
    {
        $returnMsg = $this->returnMsg;

        try {
            if( $type == MenuConstant::SUB_TYPE_PRODUCT ){
                $result = $this->createProduct($request);
            }

            if( $result["isSuccess"] !== true ){
                throw new Exception($result["msg"]);
            }

            $returnMsg = helpers_success_message();
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }

    protected function createProduct(Request $request): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $sub_id       = $request->post('sub_id');
            $title        = $request->post('title');
            $is_show      = $request->post('is_show');
            $desc         = $request->post('desc');
            $main_file    = $request->file('main_img');
            $bottom_file1 = $request->file('bottom_img1');
            $bottom_file2 = $request->file("bottom_img2");
            $bottom_file3 = $request->file("bottom_img3");
            $bottom_file4 = $request->file("bottom_img4");
            $bottom_file5 = $request->file("bottom_img5");
            $material     = $request->post('material');
            $size         = $request->post('size');
            $shape        = $request->post('shape');
            $keywords     = $request->post('keywords');

            $obj = NoticeSubData::where("id", $sub_id)->first();
            if( $obj == null ){
                throw new Exception(BoardErrorMessageConstant::getNotHaveErrorMessage("SUB_MENU"));
            }

            $group_id  = $obj->group_id;
            $date_name = Carbon::now()->format("Y/m/d");

            $path            = "board/product/main_{$date_name}";
            $main_saved_path = saveLocalImage($main_file, $path, "main");
            $main_img        = $main_saved_path;

            $path                    = "board/product/{$date_name}";
            $bottom_file1_saved_path = saveLocalImage($bottom_file1, $path, "bottom1");
            $bottom_img1             = $bottom_file1_saved_path;

            $bottom_img2 = "";
            if ($bottom_file2 && $bottom_file2->isValid()) {
                $path                    = "board/product/{$date_name}";
                $bottom_file2_saved_path = saveLocalImage($bottom_file2, $path, "bottom2");
                $bottom_img2             = $bottom_file2_saved_path;
            }

            $bottom_img3 = "";
            if ($bottom_file3 && $bottom_file3->isValid()) {
                $path                    = "board/product/{$date_name}";
                $bottom_file3_saved_path = saveLocalImage($bottom_file3, $path, "bottom3");
                $bottom_img3             = $bottom_file3_saved_path;
            }

            $bottom_img4 = "";
            if ($bottom_file4 && $bottom_file4->isValid()) {
                $path                    = "board/product/{$date_name}";
                $bottom_file4_saved_path = saveLocalImage($bottom_file4, $path, "bottom4");
                $bottom_img4             = $bottom_file4_saved_path;
            }

            $bottom_img5 = "";
            if ($bottom_file5 && $bottom_file5->isValid()) {
                $path                    = "board/product/{$date_name}";
                $bottom_file5_saved_path = saveLocalImage($bottom_file5, $path, "bottom5");
                $bottom_img5             = $bottom_file5_saved_path;
            }

            $bindParam = [
                'group_id'    => $group_id,
                'sub_id'      => $sub_id,
                'title'       => $title,
                'is_show'     => $is_show,
                'desc'        => $desc,
                'main_img'    => $main_img,
                'bottom_img1' => $bottom_img1,
                'bottom_img2' => $bottom_img2,
                'bottom_img3' => $bottom_img3,
                'bottom_img4' => $bottom_img4,
                'bottom_img5' => $bottom_img5,
                'material'    => $material,
                'size'        => $size,
                'shape'       => $shape,
                'keywords'    => $keywords,
            ];

            $boardProductDto = new BoardProductDto();
            $boardProductDto->bind($bindParam);

            BoardProductData::create($boardProductDto->getAllProperties());
            
            $returnMsg = helpers_success_message();
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }
}
