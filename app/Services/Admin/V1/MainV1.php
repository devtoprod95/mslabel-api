<?php

namespace App\Services\Admin\V1;

use App\Abstracts\Admin\MainAbstract;
use App\Constants\MainErrorMessageConstant;
use App\Models\MainTopBanner;
use Carbon\Carbon;
use Exception;

class MainV1 extends MainAbstract
{
    private array $returnMsg;

    public function __construct()
    {
        $this->returnMsg = helpers_fail_message();
    }

    /**
     * @func topBannersList
     * @description '메인 상단 배너 리스트'
     * @param array $params
     * @return array
     */
    public function topBannersList(array $params): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $page      = $params["page"];
            $pageSize  = $params["pageSize"];
            $isShow    = $params["isShow"];
            $searchCls = $params["searchCls"];
            $keyword   = $params["keyword"];
            $sortArr   = explode("|", $params["sort"]);

            $builder = MainTopBanner::select([
                "main_top_banners.*"
            ])->with([
                'admin_user' => function ($query) {
                    $query->select(['user_id', 'user_name', 'email']);
                }
            ]);
            $builder->orderBy($sortArr[0], $sortArr[1]);

            if( isset($isShow) && $isShow ){
                $builder->where("is_show", $isShow);
            }

            if( !empty($keyword) ){
                if( $searchCls == "title"){
                    $builder->where("main_top_banners." . "title", "like", "%" . $keyword . "%");
                }
            }

            $lists        = $builder->paginate($pageSize, ['*'], 'page', $page);
            $totalRecords = $lists->total();
            $lastPage     = $lists->lastPage();
            $objs         = $lists->items();

            $result = [
                "total_records" => $totalRecords,
                "last_page"     => $lastPage,
                "records"       => $objs,
                "page"          => (int)$page,
                "page_size"     => (int)$pageSize
            ];

            $returnMsg = helpers_success_message($result);
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }

    /**
     * @func topBannerCreate
     * @description '메인 상단 배너 등록'
     * @param array $params
     * @return array
     */
    public function topBannerCreate(array $params): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $userObj       = session("admin_user")->sub->user;
            $title         = $params['title'];
            $userId        = $userObj->user_id;
            $isAlwaysShow  = $params['isAlwaysShow'];
            $showStartedAt = $params['showStartedAt'];
            $showEndedAt   = $params['showEndedAt'];
            $isShow        = $params['isShow'];
            $thumbnail     = $params['thumbnail'];

            $dateName  = Carbon::now()->format("Y/m/d");
            $path      = "main/topBanners/{$dateName}";
            $savedPath = saveLocalImage($thumbnail, $path);

            MainTopBanner::create([
                'title'           => $title,
                'user_id'         => $userId,
                'img_url'         => $savedPath,
                'is_show'         => $isShow,
                'is_always_show'  => $isAlwaysShow,
                'show_started_at' => $showStartedAt,
                'show_ended_at'   => $showEndedAt,
            ]);

            $returnMsg = helpers_success_message();
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }

    /**
     * @func topBannerEdit
     * @description '메인 상단 배너 수정'
     * @param int $id
     * @param array $params
     * @return array
     */
    public function topBannerEdit(int $id, array $params): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $userObj       = session("admin_user")->sub->user;
            $title         = $params['title'];
            $userId        = $userObj->user_id;
            $isAlwaysShow  = $params['isAlwaysShow'];
            $showStartedAt = $params['showStartedAt'];
            $showEndedAt   = $params['showEndedAt'];
            $isShow        = $params['isShow'];
            $thumbnail     = $params['thumbnail'];

            $obj = MainTopBanner::where("id", $id)->first();

            if( $obj == null ){
                throw new Exception(MainErrorMessageConstant::getNotHaveErrorMessage("MAIN_TOP_BANNER"));
            }

            deleteLocalFile($obj->img_url);

            $dateName  = Carbon::now()->format("Y/m/d");
            $path      = "main/topBanners/{$dateName}";
            $savedPath = saveLocalImage($thumbnail, $path);

            MainTopBanner::where("id", $id)->update([
                'title'           => $title,
                'user_id'         => $userId,
                'img_url'         => $savedPath,
                'is_show'         => $isShow,
                'is_always_show'  => $isAlwaysShow,
                'show_started_at' => $showStartedAt,
                'show_ended_at'   => $showEndedAt,
            ]);

            $returnMsg = helpers_success_message();
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }

    /**
     * @func topBannerDelete
     * @description '메인 상단 배너 삭제'
     * @param int $id
     * @return array
     */
    public function topBannerDelete(int $id): array
    {
        $returnMsg = $this->returnMsg;

        try {
            $obj = MainTopBanner::where("id", $id)->first();

            if( $obj == null ){
                throw new Exception(MainErrorMessageConstant::getNotHaveErrorMessage("MAIN_TOP_BANNER"));
            }

            deleteLocalFile($obj->img_url);
            MainTopBanner::where("id", $id)->delete();

            $returnMsg = helpers_success_message();
        } catch (Exception $e) {
            $returnMsg = helpers_fail_message($e->getMessage());
        }

        return $returnMsg;
    }
}
