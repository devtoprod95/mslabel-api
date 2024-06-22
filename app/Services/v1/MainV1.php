<?php

namespace App\Services\v1;

use App\Abstracts\MainAbstract;
use App\Constants\MainTitleConstant;
use App\Constants\SubTitleConstant;
use App\Models\MainBanner;
use App\Models\MainSubTitle;
use App\Models\MainTitle;
use Exception;

class MainV1 extends MainAbstract
{
    private array $returnMsg;

    public function __construct()
    {
        $this->returnMsg = helpers_fail_message();
    }

    public function getMainList(): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $getMainBannerObjs = MainBanner::where([
                "is_show" => "Y",
            ])->orderBy("rank", "asc")->get([
                "id", "rank", "img_url", "img_name", "created_at", "updated_at"
            ])->toArray();
    
            $main02Result = [];
            $getMain02SectionObjs = MainTitle::where([
                "section" => MainTitleConstant::MAIN_02
            ])->get([
                "section", "type", "title", "img_url", "link", "created_at", "updated_at"
            ])->toArray();
    
            $getSubTitle02Objs = MainSubTitle::whereIn("sub_title_type", SubTitleConstant::MAIN_02_LIST)
            ->orderBy("sub_title_type", "asc")
            ->orderBy("rank", "asc")
            ->get([
                "sub_title_type", "title", "rank", "created_at", "updated_at"
            ]);
            $subTitle02 = [];
            foreach($getSubTitle02Objs as $getSubTitle02Obj){
                $subTitle02[$getSubTitle02Obj->sub_title_type][] = $getSubTitle02Obj->toArray();
            }
            $main02Result = [
                "title"     => $getMain02SectionObjs,
                "sub_title" => $subTitle02
            ];
    
            $main03Result = [];
            $getMain03SectionObjs = MainTitle::where([
                "section" => MainTitleConstant::MAIN_03
            ])->get([
                "section", "type", "title", "img_url", "link", "created_at", "updated_at"
            ])->toArray();
    
            $getSubTitle03Objs = MainSubTitle::whereIn("sub_title_type", SubTitleConstant::MAIN_03_LIST)
            ->orderBy("sub_title_type", "asc")
            ->orderBy("rank", "asc")
            ->get([
                "sub_title_type", "title", "rank", "created_at", "updated_at"
            ]);
            $subTitle03 = [];
            foreach($getSubTitle03Objs as $getSubTitle03Obj){
                $subTitle03[$getSubTitle03Obj->sub_title_type][] = $getSubTitle03Obj->toArray();
            }
            $main03Result = [
                "title"     => $getMain03SectionObjs,
                "sub_title" => $subTitle03
            ];
    
            $result = [
                "main_banners"  => $getMainBannerObjs,
                "main_title_02" => $main02Result,
                "main_title_03" => $main03Result,
            ];

            $returnMsg = helpers_success_message($result);
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }
}
