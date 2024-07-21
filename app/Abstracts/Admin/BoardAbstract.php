<?php

namespace App\Abstracts\Admin;

use App\Constants\MenuConstant;
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
                $this->createProduct($request);
            }
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }

    protected function createProduct(Request $request): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $group_id    = $request['group_id'];
            $sub_id      = $request['sub_id'];
            $title       = $request['title'];
            $is_show     = $request['is_show'];
            $desc        = $request['desc'];
            $main_img    = $request['main_img'];
            $bottom_img1 = $request['bottom_img1'];
            $material    = $request['material'];
            $size        = $request['size'];
            $shape       = $request['shape'];
            $keywords    = $request['keywords'];

            
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }
}
